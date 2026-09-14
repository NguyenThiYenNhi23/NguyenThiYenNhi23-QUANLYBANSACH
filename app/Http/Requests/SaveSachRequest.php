<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveSachRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maDanhMuc' => [
                'required',
                'integer',
                'exists:danh_mucs,maDanhMuc',
            ],

            'tenSach' => [
                'required',
                'string',
                'max:255',
            ],

            'giaBan' => [
                'required',
                'numeric',
                'min:0',
            ],

            'moTa' => [
                'nullable',
                'string',
            ],

            'hinhAnh' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'trangThai' => [
                'required',
                'in:Đang kinh doanh,Hết hàng,Ngừng kinh doanh',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'maDanhMuc.required' => 'Vui lòng chọn danh mục.',

            'maDanhMuc.exists' => 'Danh mục không tồn tại.',

            'tenSach.required' => 'Vui lòng nhập tên sách.',

            'tenSach.max' => 'Tên sách không được vượt quá 255 ký tự.',

            'giaBan.required' => 'Vui lòng nhập giá bán.',

            'giaBan.numeric' => 'Giá bán phải là số.',

            'giaBan.min' => 'Giá bán không được nhỏ hơn 0.',

            'trangThai.required' => 'Vui lòng chọn trạng thái.',

            'trangThai.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}