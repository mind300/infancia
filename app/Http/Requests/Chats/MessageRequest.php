<?php

namespace App\Http\Requests\Chats;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'message' => 'required|string',
            'sender_id' => 'required|integer',
            'sender_type' => 'required|in:branch,parent',
            'branch_id' => 'required|exists:branches,id',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
