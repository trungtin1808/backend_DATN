<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CvRequest extends FormRequest
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
            'file' => 'required|file|mimes:pdf|max:5120', // tối đa 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'cv_file.required' => 'Bạn phải chọn file CV.',
            'cv_file.file' => 'File CV không hợp lệ.',
            'cv_file.mimes' => 'File CV phải có định dạng PDF.',
            'cv_file.max' => 'File CV không được lớn hơn 5MB.',
        ];
    }
}
