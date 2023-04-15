<?php

namespace App\Http\Controllers\Admin\Voucher;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoucherRequest;
use App\Services\VoucherService;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    protected $voucherService;
    protected $data = [];

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    /**
     * Hiển thị danh sách voucher(đã gồm sắp xếp và lọc)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vouchers = $this->voucherService->getVouchersOnIndex($request);
        return view(
            'clients.admin.vouchers.index',
            [
                'title' => 'Danh sách Voucher'
            ],
            compact('vouchers')
        );
    }

    /**
     * Hiển thị trang thêm voucher
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(
            'clients.admin.vouchers.create',
            [
                'title' => 'Thêm voucher'
            ],
        );
    }

    /**
     * Thêm voucher vào database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VoucherRequest $request)
    {
        $data = $request->all();
        $this->data = $this->voucherService->getDataCreate($data);
        $this->voucherService->create($this->data);
        return redirect(route('admin.voucher.index'))->with('msg', 'Thêm Voucher thành công');
    }

    /**
     * Hiển thị trang khách hàng đã nhận voucher theo id của voucher
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $voucher = $this->voucherService->find($id);
        return view('clients.admin.vouchers.customer', [
            'title' => 'Khách hàng đã nhận',
            'voucher' => $voucher,
            'customers' => $this->voucherService->getCustomers($voucher->id),
        ]);
    }

    /**
     * Hiển thị trang sửa voucher
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        session()->put('id', $id);
        $voucher = $this->voucherService->find($id);
        return view('clients.admin.vouchers.edit', [
            'title' => 'Sửa Voucher'
        ], compact('voucher'));
    }

    /**
     * cập nhập voucher vào database
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VoucherRequest $request, $id)
    {
        $data = $request->except('_token', '_method');
        $this->data = $this->voucherService->getDataUpdate($data);
        $this->voucherService->update($this->data, $id);
        return redirect(route('admin.voucher.edit',$id))->with('msg', 'Sửa Voucher thành công');
    }

    /**
     * Xóa voucher trong database
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->voucherService->delete($id);
        return redirect(route('admin.voucher.index'))->with('success', 'Xóa Voucher thành công');
    }
}
