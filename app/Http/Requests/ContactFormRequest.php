<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ContactFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('phone')) {
            $this->merge([
                'phone' => trim((string) $this->input('phone')),
            ]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => [
                'required',
                'string',
                'max:25',
                'regex:/^[\+]?[0-9\s\-\(\)\.]+$/',
            ],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $phone = (string) $this->input('phone', '');
            if ($phone === '' || $validator->errors()->has('phone')) {
                return;
            }

            if (preg_match_all('/\d/', $phone) < 7) {
                $validator->errors()->add('phone', __('contact.phone_invalid'));
            }
        });
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.regex' => __('contact.phone_invalid'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'first_name' => __('contact.first_name'),
            'last_name' => __('contact.last_name'),
            'email' => __('contact.email'),
            'phone' => __('contact.phone'),
            'message' => __('contact.message'),
        ];
    }
}
