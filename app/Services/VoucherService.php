<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Voucher;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoucherService extends BaseService
{
    protected $data = [];
    public function getModel()
    {
        return Voucher::class;
    }

    /**
     * cập nhập data được thêm vào voucher(thêm admin_created và admin_updated)
     *
     */
    public function getDataCreate($data)
    {
        $this->data = $data;
        $data['admin_created'] = $data['admin_updated'] = Auth::user()->id;
        return $data;
    }

    /**
     * cập nhập data được thêm vào voucher(thêm admin_updated)
     *
     */
    public function getDataUpdate($data)
    {
        $this->data = $data;
        $data['admin_updated'] = Auth::user()->id;
        return $data;
    }

    /**
     * Lấy danh sách voucher đã được lọc và sắp xếp
     *
     * @param $request
     * @return $vouchers
     */
    public function getVouchersOnIndex($request)
    {
        $vouchers = new Voucher();
        $vouchers = $this->filter($vouchers, $request);
        $vouchers = $this->sortAndPagination($vouchers, $request);

        return  $vouchers;
    }

    /**
     * Sắp xếp và phân trang danh sách voucher
     *
     * @param $vouchers, $request
     * @return $vouchers
     */
    private function sortAndPagination($vouchers, $request)
    {
        $perPage = $request->show ?? 9;
        $sortBy = $request->sort_by ?? 'latest';

        switch ($sortBy) {
            case 'latest':
                $vouchers = $vouchers->orderBy('id');
                break;
            case 'oldest':
                $vouchers = $vouchers->orderByDesc('id');
                break;
            case 'name-accending':
                $vouchers = $vouchers->orderBy('name');
                break;
            case 'name-descending':
                $vouchers = $vouchers->orderByDesc('name');
                break;
            case 'code-accending':
                $vouchers = $vouchers->orderBy('code');
                break;
            case 'code-descending':
                $vouchers = $vouchers->orderByDesc('code');
                break;
            case 'quantity-accending':
                $vouchers = $vouchers->orderBy('quantity');
                break;
            case 'quantity-descending':
                $vouchers = $vouchers->orderByDesc('quantity');
                break;
            case 'exp-descending':
                $vouchers = $vouchers->orderByDesc('exp');
                break;
            case 'exp-ascending':
                $vouchers = $vouchers->orderBy('exp');
                break;
            default:
                $vouchers = $vouchers->orderBy('id');
                break;
        }

        $vouchers = $vouchers->paginate($perPage);

        $vouchers->appends(['sort_by' => $sortBy, 'show' => $perPage]);

        return $vouchers;
    }

    /**
     * lọc danh sách voucher
     *
     * @param $vouchers, $request
     * @return $vouchers
     */
    public function filter($vouchers, $request)
    {
        //Name:
        $name = $request->name ?? [];
        $vouchers = $name != null ? $vouchers->where('name', 'like', '%' . $name . '%') : $vouchers;

        //Code:
        $code = $request->code ?? [];
        $vouchers = $code != null ? $vouchers->where('code', 'like', '%' . $code . '%') : $vouchers;

        //Exp:
        $exp = $request->exp ?? [];
        $vouchers = $exp != null ? $vouchers->whereDate('exp', '=', $exp) : $vouchers;

        //Created_at:
        $created_at = $request->created_at ?? [];
        $vouchers = $created_at != null ? $vouchers->whereDate('created_at', '=', $created_at) : $vouchers;

        return $vouchers;
    }

    public function hasCustomers($id)
    {
        $hasCustomers = Customer::where('customer_voucher.voucher_id', $id)
        ->groupBy('customers.id')
        ->join('customer_voucher','customer_voucher.customer_id', '=',  'customers.id')
        ->select(DB::raw('customers.*,count(customers.id) as solan'))
        ->get();
        return $hasCustomers;

    }

    public function getCustomers($id)
    {
        $customers = new Voucher();
        $customers = $this->hasCustomers($id);
        return $customers;
    }
}
