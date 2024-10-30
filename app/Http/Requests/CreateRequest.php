<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'account.Account_Name' => 'required|string|max:255',
            'account.Account_Website' => 'nullable|url',
            'account.Account_Phone' => 'nullable|string|max:20',
            'deal.Deal_Name' => 'required|string|max:255',
            'deal.Stage' => 'required|string|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'account.Account_Name' => 'Account name',
            'account.Account_Website' => 'Account website',
            'account.Account_Phone' => 'Account phone',
            'deal.Deal_Name' => 'Deal name',
            'deal.Stage' => 'Stage',
        ];
    }
}
