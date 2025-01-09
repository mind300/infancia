<?php

namespace App\Http\Requests\KidPaymentBills;

use Illuminate\Foundation\Http\FormRequest;

class StoreKidPaymentRequest extends FormRequest
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
            'kid_payment_bill_id' => 'required|integer|exists:kid_payment_bills,id',
            'status' => 'required_without:media|string|in:rejected',
        ];
    }
}
