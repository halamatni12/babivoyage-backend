<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FlightUpdateRequest extends FormRequest
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
        $id = $this->route('flight')?->id ?? $this->route('flight');
        return [
            'flight_number' => ['sometimes','string','max:50', Rule::unique('flights','flight_number')->ignore($id)],
            'airline_id'    => ['sometimes','exists:airlines,id'],
            'departure_id'  => ['sometimes','exists:destinations,id'],
            'arrival_id'    => ['sometimes','exists:destinations,id'],
            'departure_time'=> ['sometimes','date'],
            'arrival_time'  => ['sometimes','date','after:departure_time'],
            'base_price'    => ['sometimes','numeric','min:0'],
            'class'         => ['sometimes', Rule::in(['economy','business','first'])],
        ];
    }
}
