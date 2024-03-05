<?php

namespace App\Modules\User\Http\Requests;

use App\Modules\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'image' => ['nullable'],
            'role' => ['required'],
            'email' => ['required', 'email', Rule::unique(User::class, 'email')],
            'password' => ['required'],
            'login_type' => ['nullable'],
            'status' => ['nullable'],
        ];
    }
}
