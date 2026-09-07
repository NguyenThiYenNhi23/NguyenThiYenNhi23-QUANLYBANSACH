<?php

namespace App\Http\Requests;

use App\Models\DanhMuc;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveDanhMucRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var DanhMuc|null $danhMuc */
        $danhMuc = $this->route('danhMuc');

        return [
            'tenDanhMuc' => [
                'required',
                'string',
                'max:150',
                Rule::unique('danh_mucs', 'tenDanhMuc')
                    ->ignore($danhMuc?->getKey(), 'maDanhMuc'),
            ],
            'moTa' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'tenDanhMuc.required' => 'Vui lòng nhập tên danh mục.',
            'tenDanhMuc.unique' => 'Tên danh mục đã tồn tại.',
            'moTa.required' => 'Vui lòng nhập mô tả danh mục.',
        ];
    }
}
