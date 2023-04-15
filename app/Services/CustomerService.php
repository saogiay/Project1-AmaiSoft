<?php

namespace App\Services;

use App\Models\Customer;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Voucher;
class CustomerService extends BaseService
{
    protected $data = [];
    public function getModel()
    {
        return Customer::class;
    }
    /**
    *Gộp data request các trường địa chỉ khi thêm KH mới
    *   @param $data các thông tin được điền vào các trường trong form create
    *
    */
    public function getDataCreate($data)
    {
        $this->data = $data;
        $data['admin_created'] = $data['admin_updated'] = Auth::user()->id;
        $data['address'] = $data['no'] . ' - ' . $data['street'] . ' - ' . $data['ward']
            . ' - ' . $data['district'] . ' - ' . $data['city'];
        unset($data['no'], $data['street'], $data['ward'], $data['district'], $data['city']);
        return $data;
    }
        /**
    *Gộp data request các trường địa chỉ khi update thông tin khách hàng
    *   @param $data các thông tin được điền vào các trường trong form update
    */
    public function getDataUpdate($data)
    {
        $this->data = $data;
        $data['admin_updated'] = Auth::user()->id;
        $data['address'] = $data['no'] . ' - ' . $data['street'] . ' - ' . $data['ward']
            . ' - ' . $data['district'] . ' - ' . $data['city'];
        unset($data['no'], $data['street'], $data['ward'], $data['district'], $data['city']);
        return $data;
    }   
    /**
    *Bộ lọc tìm kiếm và sắp xếp trang danh sách khách hàng
    *   @param $request các yêu cầu tìm kiếm, sắp xếp theo thứ tự
    *   @return $customer danh sách thông tin khách hàng 
    */
    public function getCustomersOnIndex($request)
    {
        $customers = new Customer();
        $customers = $this->filter($customers, $request);
        $customers = $this->sortAndPagination($customers, $request);
        return  $customers;
    }
    /**
    *Sắp xếp và số lượng dòng hiển thị danh sách khách hàng
    *   @param $request các yêu cầu tìm kiếm, sắp xếp theo thứ tự
    *   @return $customer danh sách thông tin khách hàng 
    */
    private function sortAndPagination($customers, $request)
    {
        $perPage = $request->show ?? 9;
        $sortBy = $request->sort_by ?? 'latest';

        switch ($sortBy) {
            case 'latest':
                $customers = $customers->orderBy('id');
                break;
            case 'oldest':
                $customers = $customers->orderByDesc('id');
                break;
            case 'name-accending':
                $customers = $customers->orderBy('name');
                break;
            case 'name-descending':
                $customers = $customers->orderByDesc('name');
                break;
            case 'update-descending':
                $customers = $customers->orderByDesc('updated_at');
                break;
            case 'update-ascending':
                $customers = $customers->orderBy('updated_at');
                break;
            default:
                $customers = $customers->orderBy('id');
                break;
        }
        $customers = $customers->paginate($perPage);
        $customers->appends(['sort_by' => $sortBy, 'show' => $perPage]);
        return  $customers;
    }
        /**
    *Bộ lọc tìm kiếm danh sách khách hàng
    *   @param $request các yêu cầu tìm kiếm theo tên, email hoặc sdt
    *   @return $customer danh sách thông tin khách hàng 
    */
    public function filter($customers, $request)
    {
        $name = $request->name ?? [];
        $customers = $name != null ? $customers->where('name', 'like', '%' . $name . '%') : $customers;

        $contact = $request->contact ?? [];
        $customers = $contact != null ? $customers->where('phone', 'like', '%' . $contact . '%')
        ->orWhere('email', 'like', '%' . $contact . '%'): $customers;

        return $customers;
    }
    /**
    *Danh sách voucher khách hàng đang sở hữu
    *   @param $id mã khách hàng
    *   @return $hasVouchers danh sách các mã voucher khách hàng đang có
    */
    public function hasVouchers($id)
    {   
        $hasVouchers = Voucher::where('customer_voucher.customer_id',$id)
        ->groupBy('vouchers.id')
        ->join('customer_voucher','customer_voucher.voucher_id', '=',  'vouchers.id')
        ->select(DB::raw('vouchers.*,count(vouchers.id) as solan'))
        ->paginate(10);
        return $hasVouchers;
    }
}
