<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;

class EscalationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'items' => 'required|json',
        ];
    }

    /**
     * @param Validator $validator
     * @return RedirectResponse
     */
    protected function failedValidation(Validator $validator): RedirectResponse
    {
        return redirect()->back()->with(['danger' => $validator->errors()->first()]);
    }
}
