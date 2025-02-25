<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'comment' => 'nullable|string|max:500',
            'preferred_messenger_id' => 'required|integer|exists:messengers,id',
            'distance' => 'required',
            'km_to_location_1' => 'required',
            'km_to_location_2' => 'required',
            'km_to_location_3' => 'required',
            'car_id' => 'required|exists:cars,id',
            'duration' => 'required',
            'data' => 'required|array',
            'data.address_from' => 'required|string|max:255',
            'data.address_to' => 'required|string|max:255',
            'data.meeting_date' => 'required|date|date_format:Y-m-d',
            'data.meeting_time' => 'required|date_format:H:i',
            'data.adults' => 'required|integer|min:0',
            'data.children' => 'required|integer|min:0',
            'data.suitcases' => 'required|integer|min:0',
            'data.addRoadBack' => 'required|boolean',
            'data.city_from' => 'required|string|max:255',
            'data.city_to' => 'required|string|max:255',
            'total' => 'required|numeric|min:0'
        ];
    }
}
