<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Campo e-mail é obrigatório!',
            'email.email' => 'Formato de email inválido!',
            'email.exists' => 'Endereço e-mail não cadastrado!',
            'password.required' => 'Campo senha é obrigatório!',
            'password.min' => 'Campo senha precisa ter no mínimo :min caracteres!',
        ];
    }
}

