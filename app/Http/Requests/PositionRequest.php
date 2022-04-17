<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;

class PositionRequest extends FormRequest
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
            'name' => "required|string|min:2|max:60|unique:positions,name," . $this->position ?? 'NULL' . ",id,deleted_at,NULL,user_id," . parentID(),
            'description' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:positions,id',
        ];
    }

    /**
     * @param Validator $validator
     * @return RedirectResponse
     */
    protected function failedValidation(Validator $validator): RedirectResponse
    {
        return redirect()->back()->withErrors($validator->errors())->withInput();
    }
}
