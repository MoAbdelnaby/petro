<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class PeopleRequest extends FormRequest
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
            'user_model_branch_id' => 'required|exists:user_model_branches,id',
            'setting_id' => 'required|exists:people_settings,id',
            'date' => 'required|date',
            'time' => 'required|min:4',
            'count' => 'required|integer|min:0',
            'screenshot' => 'nullable|image',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException( response()->json([
            'success' => false,
            'message' => 'Validation error',
            'error' => $errors,
         ], 400));
    }


}
