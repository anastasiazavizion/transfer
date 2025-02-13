<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculateFormRequest extends FormRequest
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
            'address_from'=>'required|string',
            'address_to'=>'required|string',
            'children'=>'required|integer|min:0|max:3',
            'adults'=>'required|integer|min:1|max:4',
            'meeting_date'=>'required|date',
            'meeting_time'=>'required|date_format:H:i',
            'suitcases'=>'required|integer|min:0|max:3',
            'addRoadBack'=>'required|boolean',
        ];
    }
}
