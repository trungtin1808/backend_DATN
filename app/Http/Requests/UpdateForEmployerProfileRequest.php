<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateForEmployerProfileRequest extends FormRequest
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
        'company_name' => 'string|max:255|min:6', // tên công ty, có thể để trống
        'profile_description' => 'string|max:1000', // mô tả công ty
        'establishment_date' => 'date|after:1900-01-01', // ngày thành lập
        'company_website_url' => 'url|max:255', // url website công ty
        'company_image' => 'image|mimes:png,jpg,jpeg,gif|max:2048', // ảnh công ty, tối đa 2MB
        'street_address' => 'string|max:255',
        'state' => 'string|max:255',
        'city' => 'string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
        'company_name.string' => 'Tên công ty phải là chuỗi ký tự.',
        'company_name.max' => 'Tên công ty không được vượt quá 255 ký tự.',
        'company_name.min' => 'Ten cong ty phai co it nhat 6 ky tu.',

        'profile_description.string' => 'Mô tả công ty phải là chuỗi ký tự.',
        'profile_description.max' => 'Mô tả công ty không được vượt quá 1000 ký tự.',

        'establishment_date.date' => 'Ngày thành lập phải đúng định dạng ngày.',
        'establishment_date.after' => 'Ngày thành lập phải sau ngày 01-01-1900.',

        'company_website_url.url' => 'Địa chỉ website không hợp lệ.',
        'company_website_url.max' => 'Địa chỉ website không được vượt quá 255 ký tự.',

        'company_image.image' => 'Tệp tải lên phải là hình ảnh.',
        'company_image.mimes' => 'Ảnh phải thuộc các định dạng: png, jpg, jpeg hoặc gif.',
        'company_image.max' => 'Ảnh không được lớn hơn 2MB.',

        'street_address.string' => 'Địa chỉ phải là chuỗi ký tự.',
        'street_address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

        'state.string' => 'Tiểu bang phải là chuỗi ký tự.',
        'state.max' => 'Tiểu bang không được vượt quá 255 ký tự.',

        'city.string' => 'Thành phố phải là chuỗi ký tự.',
        'city.max' => 'Thành phố không được vượt quá 255 ký tự.',
        ];
    }
}
