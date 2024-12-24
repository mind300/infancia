<?php

namespace App\Http\Requests\Nurseries;

use Illuminate\Foundation\Http\FormRequest;

class NurseryStatusRequest extends FormRequest
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
            'status' => 'required|array',
            'status.*.state' => 'required|string|in:pending,approved,recjected',
        ];
    }
}
