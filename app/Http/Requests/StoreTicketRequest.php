<?php

namespace App\Http\Requests;

use App\Enums\TicketPriorityLevel;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function validationData(): array
    {
        // Inyecta resolved_category_id antes de que valide
        return array_merge($this->all(), [
            'resolved_category_id' => $this->filled('subcategory_id')
                ? (int) $this->subcategory_id
                : (int) $this->category_id,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'exists:categories,id'],
            'resolved_category_id' => ['required', 'exists:categories,id'], // ← ahora sí pasa por validated()
            'priority_level' => ['required', Rule::enum(TicketPriorityLevel::class)],
            'team_id' => ['nullable', 'exists:teams,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'due_at' => ['nullable', 'date'],
        ];
    }
}
