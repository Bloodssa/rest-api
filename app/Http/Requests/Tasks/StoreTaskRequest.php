<?php

namespace App\Http\Requests\Tasks;

use App\Traits\TaskRules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    use TaskRules;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...$this->baseRules()
        ];
    }

    public function attributes(): array
    {
        return [
            'tags.*' => 'tag',
        ];
    }
}
