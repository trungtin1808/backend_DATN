<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255|min:6',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
            'role' => 'required|in:jobSeeker,employer',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute bắt buộc phải nhập.',
            'min' => ':attribute phải có ít nhất :min ký tự.',
            'email' => ':attribute không đúng định dạng.',
            'unique' => ':attribute đã tồn tại.',
            'confirmed' => ':attribute không khớp với xác nhận.',
            'role.in' => ':attribute phải là một trong: jobSeeker hoặc employer.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'name',
            'email' => 'Email',
            'password' => 'password',
            'role' => 'role'
        ];
    }

}
