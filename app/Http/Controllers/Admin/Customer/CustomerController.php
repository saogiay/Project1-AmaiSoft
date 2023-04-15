<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Models\Customer;
use App\Http\Requests\CustomerRequest;
use App\Services\SendVoucherService;

class CustomerController extends Controller
{
    protected $customerService;
    protected $data = [];
    protected $sendVoucherService;

    public function __construct(CustomerService $customerService, SendVoucherService $sendVoucherService)
    {
        $this->customerService = $customerService;
        $this->sendVoucherService = $sendVoucherService;
    }
    /**
     * Trang chủ hiện danh sách thông tin khách hàng.
     *
     * @param  $request bộ lọc tìm kiếm, sắp xếp 
     * @return $data thông tin khách hàng 
     */
    public function index(Request $request)
    {

        return view('clients.admin.customer.list', [
            'title' => 'Danh sách khách hàng',
            'customers' =>  $this->customerService->getCustomersOnIndex($request),
        ]);
    }
    public function create()
    {
        return view('clients.admin.customer.add', [
            'title' => 'Thêm thông tin khách hàng'
        ]);
    }
    /**
     *Lưu dữ liệu khách hàng mới 
     *
     * @param  $data dữ liệu thông tin khách hàng mới
     * 
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->all();
        $this->data = $this->customerService->getDataCreate($data);
        $this->customerService->create( $this->data);
        return redirect(route('admin.customer.index'))->with('msg', 'Thêm khách hàng thành công');
    }

    /**
     * Hiện danh sách các mã voucher khách hàng đã nhận và có thể nhận thêm
     *
     * @param $customer->id 
     * @return App\Model\Voucher danh sách các mã voucher đã nhận 
     * @return App\Model\Voucher danh sách các mã voucher có thể tặng thêm
     */
    public function show(Customer $customer)
    {
        return view('clients.admin.customer.voucher',[
            'title' => 'Mã giảm giá đã nhận',
            'customer' => $customer,
            'vouchers' => $this->customerService->hasVouchers($customer->id),
            'coupons' => $this->sendVoucherService->getAvailableVouchers($customer->id)
        ]);
    }

    /**
     * Hiển thị form cập nhật thông tin cá nhân của khách hàng 
     *
     * @param  \App\Models\Customer  $customer->id
     * 
     */
    public function edit(Customer $customer )
    {
    
        return view('clients.admin.customer.edit', [
            'title' => 'Cập nhật thông tin khách hàng',
            'customer' => $customer
        ]);
    }

    /**
     *Cập nhật thông tin khách hàng
     *
     * @param $request thông tin cập nhật 
     * @param  $customer->id khách hàng muốn cập nhật thông tin
     *
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $data = $request->except('_method', '_token');
        $this->data = $this->customerService->getDataUpdate($data);
        $this->customerService->update($this->data, $customer->id);
        return redirect(route('admin.customer.edit', $customer->id))->with('msg', 'Cập nhật thông tin khách hàng thành công');
    }

    /**
     * Xóa thông tin khách hàng(soft delete)
     *
     * @param  $id mã khách hàng muốn xóa
     *
     */
    public function destroy($id)
    {
        $this->customerService->delete($id);
        return redirect(route('admin.customer.index'))->with('success', 'Xóa khách hàng thành công');
    }
}
