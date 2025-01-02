<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

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
            // Nursery Register Validations
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'country' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'about' => 'nullable|string',
            'branches_number' => 'nullable|integer',
            'generate_branch' => 'nullable|boolean',
            'services' => 'nullable|array',
            'services.*.service' => 'required|string',
        ];
    }
}
