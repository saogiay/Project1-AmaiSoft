<?php

namespace App\Services;

use App\Jobs\SendEmailByUser;
use App\Jobs\SendEmailByVoucher;
use App\Jobs\SendMailByUser;
use App\Jobs\SendMailByVoucher;
use App\Mail\MailVoucher;
use App\Models\Customer;
use App\Models\Voucher;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SendVoucherService
{
    /**
    *Danh sách khách hàng có thể nhận mã voucher
    *   @param $request thông tin mã giảm giá muốn tặng
    *   @return App\Models\Customer Danh sách khách hàng thỏa mãn điều kiện nhận voucher
    */
    public function getAvailableCustomers($request)
    {
        if ($request->allow_multi == 0) {
            return Customer::whereNotExists(function ($query) {
                $query->select('*')
                    ->from('customer_voucher')
                    ->whereRaw('customer_id = customers.id and voucher_id = ' . $GLOBALS['request']->voucher_id);
            })->get();
        }
        return Customer::all();
    }
    /**
    *Gửi mã voucher cho khách hàng 
    *   @param $vocher_id id của mã voucher muốn tặng
    *   @param $customer danh sách khách hàng được tặng
    */
    public function sendVoucherToUser($voucher_id, $customers)
    {
        $voucher = Voucher::find($voucher_id);
        $new_quantity = $voucher->quantity - count($customers);
        if ($new_quantity < 0) return "Không đủ số lượng voucher!";
        if (!$voucher->available) return "Voucher chưa được kích hoạt!";

        $voucher->customers()->attach($customers, [
            'admin_created' => auth()->user()->id,
            'admin_updated' => auth()->user()->id,
        ]);
        $voucher->update([
            'quantity' => $new_quantity
        ]);

        SendMailByUser::dispatch($voucher, $customers);
        return;
    }
    /**
    *Danh sách voucher mà khách hàng có thể nhận thêm
    *   @param $customer_id ID của khách hàng muốn tặng
    *   @param $coupons danh sách voucher khách hàng có thể nhận
    */
    public function getAvailableVouchers($customer_id)
    {
        $coupons = Voucher::where('quantity', '>', '0')
            ->where('available', '1')
            ->WhereRaw('(allow_multi > 0 OR id NOT IN (SELECT `voucher_id` FROM `customer_voucher` WHERE `customer_id` =' . $customer_id . ')) ')
            ->get();
        return ($coupons);
    }
    /**
    *Tặng khách hàng các mã vouchẻ được chọn
    *   @param $customer ID của khách hàng muốn tặng
    *   @param $data danh sách voucher khách hàng có thể nhận
    */
    public function sendVoucher($data, $customer)
    {   
        if ($data != null) {
            foreach ($data as $voucher_id) {
                $voucher = Voucher::find($voucher_id);
                $new_quantity = $voucher->quantity - 1;
                $voucher->customers()->attach($customer, [
                    'admin_created' => auth()->user()->id,
                    'admin_updated' => auth()->user()->id,
                ]);
                $voucher->update([
                    'quantity' => $new_quantity
                ]);
            }
            
            SendMailByVoucher::dispatch($customer, $data);
            Session::flash('success', 'Tặng mã giảm giá thành công');
        } else {
            Session::flash('error', 'Vui lòng chọn mã giảm giá');
            return false;
        }
        return true;
    }
}
