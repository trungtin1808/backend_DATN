<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateForJobSeekerProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gender' => 'in:male,female,other',
            'date_of_birth' => 'date|after:1900-01-01',
            'image' => 'image|mimes:png,jpg,jpeg|max:5120',
            'street_address' => 'string|max:255',
            'state' => 'string|max:255',
            'city' => 'string|max:255,'
        ];
    }

    public function messages(): array
    {
    return [
        'name.string'   => 'Tên phải là chuỗi ký tự.',
        'name.max'      => 'Tên không được vượt quá 255 ký tự.',
        'name.min'      => 'Tên phải có ít nhất 6 ký tự.',

        'gender.in'     => 'Giới tính chỉ được chọn trong: male, female hoặc other.',

        'date_of_birth.date'  => 'Ngày sinh phải đúng định dạng ngày.',
        'date_of_birth.after' => 'Ngày sinh phải sau ngày 01-01-1900.',

        'image.image'   => 'Tệp tải lên phải là hình ảnh.',
        'image.mimes'   => 'Ảnh phải thuộc các định dạng: png, jpg, jpeg hoặc gif.',
        'image.max'     => 'Ảnh không được lớn hơn 2MB.',

        'street_address.string' => 'Địa chỉ phải là chuỗi ký tự.',
        'street_address.max'    => 'Địa chỉ không được vượt quá 255 ký tự.',

        'state.string'  => 'Tiểu bang phải là chuỗi ký tự.',
        'state.max'     => 'Tiểu bang tỉnh không được vượt quá 255 ký tự.',

        'city.string'   => 'Thành phố phải là chuỗi ký tự.',
        'city.max'      => 'Thành phố không được vượt quá 255 ký tự.',
    ];
    }
}
