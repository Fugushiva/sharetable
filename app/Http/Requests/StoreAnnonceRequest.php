<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnonceRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:8', 'max:50'], // title must be between 8 and 50 characters
            'description' => ['required', 'string', 'min:50', 'max:1500'], // description must be between 50 and 1500 characters
            'schedule' => ['required', 'date', 'after:today'], // schedule must be a date in the future
            'price' => ['required', 'numeric', 'min:0.01'], // price must be a positive number
            'cuisine' => ['required', 'string', 'exists:countries,name'], // cuisine must be a valid country name
            'max_guest' => ['required', 'numeric', 'min:1', 'max:8'], // max 8 guests
            'pictures.*' => ['image', 'mimes:jpeg,jpg,png', 'max:2048'], // max 2MB per picture
            'pictures' => ['required', 'array', 'max:6'] // max 6 pictures
        ];
    }
}
