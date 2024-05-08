<?php

namespace App\Modules\Transaction\Http\Requests\Budget;

use App\Modules\Transaction\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'budget' => ['required'],
        ];
    }
}
