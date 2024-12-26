<?php

namespace App\Http\Requests\PaymentBills;

use Illuminate\Foundation\Http\FormRequest;

class PaiedRequest extends FormRequest
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
            //
            'media' => 'nullable|image',
            'payment_bill_id' => 'required|integer|exists:payment_bills,id',
        ];
    }
}
