<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest {
    public function authorize(): bool {
        if ($this->booking_id && $this->user()) {
            return \App\Models\Booking::where('id',$this->booking_id)
                ->where('user_id',$this->user()->id)->exists();
        }
        return true;
    }
    public function rules(): array {
        return [
            'booking_id'            => ['required','exists:bookings,id'],
            'method'                => ['required','in:credit_card,paypal,bank_transfer,cash'],
            'amount_paid'           => ['required','numeric','min:0'],
            'transaction_reference' => ['nullable','string','max:120'],
            'paid_at'               => ['nullable','date'],
        ];
    }
}
