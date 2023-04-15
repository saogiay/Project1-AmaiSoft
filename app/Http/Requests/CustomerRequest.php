<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
     * Get the validation rules that apply to the requestco.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->id;
        return [
            'name' => 'required',
            'email' => 'required|unique:customers,email,'.$id,
            'phone' => 'required|starts_with:0|min:100000000|max:999999999|numeric',
            'no' => 'required',
            'street' => 'required',
            'ward' => 'required',
            'district' => 'required',
            'city' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'starts_with' => ':attribute phải bắt đầu bằng số 0',
            'unique' => ':attribute đã tồn tại',
            'min' => ':attribute sai định dạng',
            'max' => ':attribute sai định dạng',

        ];
    }
    public function attributes(){
        return [
            'name' => 'Họ tên khách hàng',
            'email' => 'Hòm thư điện tử',
            'phone' => 'Số điện thoại',
            'no' => 'Số nhà',
            'street' => 'Đường/Phố/Xóm',
            'ward' => 'Xã/Phường/Thị trấn',
            'district' => 'Quận/Huyện',
            'city' => 'Tỉnh/Thành phố'
        ];
    }
}
