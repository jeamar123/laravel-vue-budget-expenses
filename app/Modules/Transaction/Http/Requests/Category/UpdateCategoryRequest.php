<?php

namespace App\Modules\Transaction\Http\Requests\Category;

use App\Modules\Transaction\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required'],
            'budget' => ['required'],
        ];
    }
}
