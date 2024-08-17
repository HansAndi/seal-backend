<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => ['nullable', new Enum(Status::class)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
}
