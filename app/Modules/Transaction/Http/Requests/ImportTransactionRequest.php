<?php

namespace App\Modules\Transaction\Http\Requests;

use App\Modules\Transaction\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImportTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => ['required'],
        ];
    }
}
