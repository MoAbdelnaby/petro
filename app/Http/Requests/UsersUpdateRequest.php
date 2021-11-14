<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * @property mixed name
 * @property mixed email
 * @property mixed type
 * @property mixed phone
 * @property mixed avatar
 * @property mixed password
 * @property mixed roles
 */
class UsersUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'nullable|email|unique:users,email,' . request()->user->id,
//            'password' => 'required|string|min:8',
            'type' => 'required|in:admin,user,supervisor',
            'avatar' => 'string',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'phone' => 'numeric',
            'roles' => 'required_if:type,admin|array',
            'roles.*' => 'array',
            'roles.*.name' => 'string|exists:roles,name',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(responseFail('Validation Error', 401, $errors));
    }
}
