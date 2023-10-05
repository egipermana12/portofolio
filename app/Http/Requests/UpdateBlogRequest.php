<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:blogs,slug,' . $this->blog->id],
            'content' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'title is required!',
            'slug.required' => 'slug is required', // Menambahkan 'slug.' sebelum 'required'
            'slug.unique' => 'slug sudah terdaptar',
            'content.required' => 'content is required!',
        ];
    }
}
