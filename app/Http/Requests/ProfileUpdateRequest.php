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
    // protected function prepareForValidation(): void
    // {
    //     // Remove file from old input flash to prevent temp file error
    //     $this->request->remove('profile_image');
    // }
      public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
       // Safely get user_id from encrypted field
    //    $userId = null;
    //     try {
    //         $userId = decrypt($this->input('user_id'));
    //     } catch (\Exception $e) {
    //         $userId = auth()->id();
    //     }
        $userId = null;
        if ($this->has('user_id')) {
            try {
                $userId = decrypt($this->input('user_id'));
            } catch (\Exception $e) {
                // Fallback to current auth user if decryption fails
                $userId = auth()->id();
            }
        }
        return [
           
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($userId),
            ],
            'phone'         => ['nullable', 'string', 'max:20'],
            'country_code'  => ['nullable', 'string', 'max:10'],
            'address'       => ['nullable', 'string', 'max:500'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
        ];
    }
}
