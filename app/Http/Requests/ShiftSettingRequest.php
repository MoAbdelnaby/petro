<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * @property mixed limit
 * @property mixed offset
 * @property mixed field
 * @property mixed sort
 */
class ShiftSettingRequest extends FormRequest
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
            'start_time' => 'required',
            'end_time' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            // 'notification' => 'required',
            // 'screenshot' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        return redirect()->back()->with('danger','Validation Error');
        // return response()->json([
        //     "success" => false,
        //     "message" => 'Validation Error',
        //     "errors" =>  $errors
        // ], 403);
    }
}
