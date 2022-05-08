<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;

class UserRequest extends FormRequest
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
            'email' => 'required|max:70|email|regex:/^\S+@\S+\.\S+$/|unique:users,email,' . $this->customerUser ?? '',
            'name' => 'required|string|min:2|max:60',
            'phone' => 'nullable|min:6|max:13|regex:/^[0-9\-\(\)\/\+\s]*$/|unique:users,phone,' . $this->customerUser ?? '',
            'password' => $this->customerUser ? 'nullable' : 'required|min:8|confirmed',
            'position_id' => 'required|numeric|exists:positions,id',
            'type' => $this->customerUser ? 'nullable' : 'required'
        ];
    }

}
