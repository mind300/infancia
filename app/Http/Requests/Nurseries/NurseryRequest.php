<?php

namespace App\Http\Requests\Nurseries;

use Illuminate\Foundation\Http\FormRequest;

class NurseryRequest extends FormRequest
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
        $nursery_id = $this->route('nurseries.id');
        return [
            // Validations Nursery
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email,' .  $nursery_id,
            'phone' => 'required|string|unique:users,phone,' .  $nursery_id,
            'country' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'about' => 'nullable|string',
            'branches_number' => 'nullable|integer',
            'generate_branch' => 'nullable|boolean',
            'services' => 'nullable|array',
            'services.*.id' => 'nullable|integer',
            'services.*.content' => 'required|string',
            'contacts' => 'nullable|array',
            'contacts.*.id' => 'nullable|integer',
            'contacts.*.link' => $this->type == 'social' ? 'require|url' : 'required|string',
            'contacts.*.type' => 'required|string|in:email,phone,social',
            'contacts.*.icon' => 'required|string',
        ];
    }
}
