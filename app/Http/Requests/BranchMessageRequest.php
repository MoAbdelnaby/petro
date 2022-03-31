<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class BranchMessageRequest extends FormRequest
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
            'type' => 'sometimes|nullable|required|in:xls,pdf,search',
            'branch_id' => 'sometimes|required_unless:type,search',
//            'start_date' => 'sometimes|nullable|date|date_format:Y-m-d|before:end_date',
//            'end_date' => 'sometimes|nullable|date|date_format:Y-m-d|after:start_date',
            'start_date' => 'sometimes|nullable|date|date_format:Y-m-d|before_or_equal:end_date',
            'end_date' => 'sometimes|nullable|date|date_format:Y-m-d|after_or_equal:start_date',
        ];
    }

    public function messages()
    {
        return [
            'branch_id.required_unless' => 'Branch Filed Required'
        ];
    }
}
