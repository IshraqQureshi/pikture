<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'gallery_name' => ['required', 'max:255', 'string'],
            'max_photos' => ['nullable', 'numeric'],
            'max_users' => ['required', 'numeric'],
            'expiration_date' => ['nullable', 'date'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
