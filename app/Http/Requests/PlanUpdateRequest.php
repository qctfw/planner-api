<?php

namespace App\Http\Requests;

use App\Enums\PlanStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PlanUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'status' => ['required', new Enum(PlanStatus::class)],
            'description' => ['nullable', 'string'],
            'deadline_at' => ['nullable', 'date']
        ];
    }
}
