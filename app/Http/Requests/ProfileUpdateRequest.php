<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            'phone' => ['nullable', 'numeric', 'max:20'],
            'gender' => ['nullable', 'in:pria,wanita'],
            'birth_date' => ['nullable', 'date'],
            'birth_place' => ['nullable', 'string'],
            'address_ktp' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'district' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'province' => ['nullable', 'string'],
            'nationality' => ['nullable', 'string'],
            'marital_status' => ['nullable', 'string'],
            'religion' => ['nullable', 'string'],
        ];
    }
}
