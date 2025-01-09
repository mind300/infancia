<?php

namespace App\Http\Requests\Meals;

use Illuminate\Foundation\Http\FormRequest;

class MealRequest extends FormRequest
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
            'meal' => 'required|string',
            'type' => 'required|string|in:Breakfast,Lunch,Snacks',
            'branch_id' => 'required||integer|exists:branches,id',
            'nursery_id' => 'required||integer|exists:nurseries,id'
        ];
    }
}
