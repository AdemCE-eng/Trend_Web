<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => [
                'required',
                'string',
                'max:20',
                'min:3',
                'regex:/^[a-zA-Z][a-zA-Z0-9_]*$/',
                'unique:users,name'
            ],
            "email" => [
                'required',
                'email',
                'unique:users,email',
                'max:255'
            ],
            "password" => [
                'required',
                'string',
                'max:255',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            "terms" => [
                'required',
                'accepted'
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Username is required.',
            'name.min' => 'Username must be at least 3 characters.',
            'name.max' => 'Username cannot exceed 20 characters.',
            'name.regex' => 'Username must start with a letter and contain only letters, numbers, or underscores.',
            'name.unique' => 'This username is already taken.',
            
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'email.max' => 'Email address cannot exceed 255 characters.',
            
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.max' => 'Password cannot exceed 255 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            
            'terms.required' => 'You must accept the terms and conditions.',
            'terms.accepted' => 'You must agree to the privacy policy and terms.',
        ];
    }
}
