<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'national_id_or_passport' => ['required', 'string', 'max:50'],
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'check_in_date' => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'services' => ['nullable', 'array'],
            'payment_method' => ['nullable', 'string', 'in:cash,card,khqr_transfer'],
        ];
    }

    public function messages(): array
    {
        return [
            'check_out_date.after' => 'Check-out date must be at least one day after the check-in date.',
            'check_in_date.after_or_equal' => 'Check-in date cannot be in the past.',
            'national_id_or_passport.required' => 'National ID or Passport number is required for guest registration.',
        ];
    }
}
