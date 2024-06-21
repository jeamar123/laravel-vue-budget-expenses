<?php

namespace App\Modules\Transaction\Http\Requests;

use App\Modules\Transaction\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['nullable'],
            'description' => ['nullable', 'string', 'max:255'],
            'total' => ['required'],
            'source' => ['required'],
            'category' => ['required'],
            'date' => ['required'],
        ];
    }
}
