<?php

namespace App\Http\Requests\Kids;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKidRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birth_date' => 'required|date',
            'has_medical_case' => 'nullable|string|in:yes,no',
            'description_medical_case' => 'required_with:has_medical_case|string',
            'classroom_id' => 'required|integer|exists:class_rooms,id',
            'branch_id' => 'required|integer|exists:branches,id',
            'nursery_id' => 'required|integer|exists:nurseries,id',
        ];
    }
}
