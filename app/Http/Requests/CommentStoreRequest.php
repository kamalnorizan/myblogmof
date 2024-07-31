<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
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
            'author'=>'required|exists:users,id',
            'content'=>'required|min:10'
        ];
    }

    public function messages(): array
    {
        return [
            'author.required'=>'Author is required',
            'author.exists'=>'Author is not exists',
            'content.required'=>'Content is required',
            'content.min'=>'Content must be at least 10 characters'
        ];
    }
}
