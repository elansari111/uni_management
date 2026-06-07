<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreModuleRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'code' => 'required|string|min:2|max:50|unique:modules,code',
            'description' => 'nullable|string|max:1000',
            'credits' => 'nullable|integer|min:0|max:30',
            'group_id' => 'nullable|exists:groups,id',
            'teacher_id' => 'nullable|exists:users,id',
            'status' => 'nullable|in:active,inactive,archived',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 3 characters',
            'name.max' => 'Name must not exceed 255 characters',
            'code.required' => 'Code is required',
            'code.unique' => 'This module code already exists',
            'group_id.exists' => 'Group not found',
            'teacher_id.exists' => 'Teacher not found',
        ];
    }
}
