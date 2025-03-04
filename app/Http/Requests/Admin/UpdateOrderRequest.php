<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
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
        $maxAdults = env('VITE_ADULTS_AMOUNT');
        $maxSuitcases = env('VITE_BAGS_AMOUNT');
        return [
            'id' => 'required|integer|exists:orders,id',
            'client_id' => 'required|integer|exists:clients,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('clients')->ignore(request()->client_id),
            ],
            'address_from' => 'required|string|max:255',
            'address_to' => 'required|string|max:255',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|string|max:5',
            'adults' => "required|integer|min:1|max:$maxAdults",
            'suitcases' => "required|integer|min:0|max:$maxSuitcases",
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|integer|exists:statuses,id',
            'comment' => 'nullable|string',
        ];
    }

}
