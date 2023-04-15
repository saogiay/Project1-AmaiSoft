<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = '';
        if(!empty(session('id'))){
            $id = session('id');
        }
        return [
            'name' => 'required',
            'code' => 'required|unique:vouchers,code,'.$id,
            'quantity' => 'required|numeric',
            'description' => 'required',
            'discount' => 'required|numeric',
            'start_day' => 'required|date|before:exp',
            'exp' => 'required|date|after_or_equal:today',
            'allow_multi' => ''
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên voucher',
            'code' => 'Mã giảm giá',
            'quantity' => 'Số lượng',
            'description' => 'Mô tả',
            'discount' => 'Giảm giá(theo %)',
            'start_day' => 'Ngày áp dụng',
            'exp' => 'Ngày hết hạn',
            'allow_multi' => ''
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được bỏ trống',
            'unique' => ':attribute đã tồn tại trên hệ thống',
            'numeric' => ':attribute chỉ được nhập chữ số',
            'date' => ':attribute chỉ được nhập dạng ngày/tháng/năm',
            'after_or_equal' => ':attribute chưa hợp lệ',
            'before' => ':attribute phải nhỏ hơn ngày hết hạn'
        ];
    }
}
