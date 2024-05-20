<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHostRequest extends FormRequest
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
            //'user_id' => ['required', 'exists:users,id', 'unique:hosts,user_id'],
            'city_id' => ['required', 'exists:cities,id'],
            'bio' => ['required', 'string', 'min:50'],
            'birthdate' => ['required', 'date'],
            'profile_picture' => ['image','mimes:jpeg,png,jpg','max:2048'],
        ];
    }
}
