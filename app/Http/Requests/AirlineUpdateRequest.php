<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AirlineUpdateRequest extends FormRequest
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
        $id = $this->route('airline')?->id ?? $this->route('airline');
        return [
            'name'     => ['sometimes','string','max:150'],
            'code'     => ['sometimes','string','max:10', Rule::unique('airlines','code')->ignore($id)],
            'logo_url' => ['sometimes','nullable','url'],
        ];
    }
}
