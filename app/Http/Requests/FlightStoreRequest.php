<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightStoreRequest extends FormRequest
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
   public function rules(): array {
    return [
        'flight_number' => ['required','string','unique:flights,flight_number'],
        'airline_id'    => ['required','exists:airlines,id'],
        'departure_id'  => ['required','different:arrival_id','exists:destinations,id'],
        'arrival_id'    => ['required','exists:destinations,id'],
        'departure_time'=> ['required','date'],
        'arrival_time'  => ['required','date','after:departure_time'],
        'base_price'    => ['required','numeric','min:0'],
        'class'         => ['required','in:economy,business,first'],
    ];
}

}
