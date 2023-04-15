<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SendVoucherService;
use Illuminate\Http\Request;
use App\Models\Customer;

class SendVoucherController extends Controller
{
    private $sendVoucherService;
    protected $data = [];
    public function __construct(SendVoucherService $sendVoucherService)
    {
        $this->sendVoucherService = $sendVoucherService;
    }

    /**
     * Hiển thị danh sách khách hàng thỏa mãn điều kiện nhận mã voucher
     *  @param $request thông tin voucher
     *  @return  App\Models\Customer danh sách khách hàng có thể nhận mã voucher
     *
     */
    public function getCustomers(Request $request)
    {
        if ($request->available == 0) return response()->json([
            'error' => true,
            'message' => "Voucher chưa được kích hoạt!!",
        ]);
        $customers = $this->sendVoucherService->getAvailableCustomers($request);
        if ($customers->isEmpty()) return response()->json([
            'error' => true,
            'message' => "Không tồn tại khách hàng phù hợp",
        ]);
        return response()->json([
            'error' => false,
            'customers' => $customers
        ]);
    }
    /**
     * Gửi tặng voucher cho danh sách khách hàng được chọn
     * @param $request->voucher_id voucher được chọn
     *  @param $request->checked danh sách id khách hàng được tặng voucher
     */
    public function giveVoucherByUser(Request $request)
    {
        $message = $this->sendVoucherService->sendVoucherToUser($request->voucher_id, $request->checked);
        if (!$message) $message = "Tặng voucher thành công!";
        return response()->json([
            'message' => $message,
        ]);
    }
    /**
     * Gửi tặng danh sách voucher cho khách hàng được chọn
     * @param $request danh sách các voucher được chọn
     *  @param App\Models\Customer khách hàng được tặng voucher
     */
    public function giveVoucherByVoucher(Customer $customer, Request $request)
    {

        $data = $request->list_voucher;
        $this->data = $this->sendVoucherService->sendVoucher($data, $customer);
        return redirect()->back();
    }
}
