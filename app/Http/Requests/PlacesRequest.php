<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class PlacesRequest extends FormRequest
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
            'setting_id' => 'required|exists:place_maintenance_settings,id',
            'date' => 'required|date',
            'area' => 'required|integer|in:1,2,3,4,5,6,7,8,9',
            'status' => 'required|integer|in:0,1',
            'time' => 'required|min:4',
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
