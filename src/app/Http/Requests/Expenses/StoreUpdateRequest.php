<?php

namespace App\Http\Requests\Expenses;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'description' => ['required','max:191'],
            'date' => ['required','date','before_or_equal:today'],
            'amount' => ['required','numeric','min:0'],
        ];

        return $rules;
    }
}
