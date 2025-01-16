<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
            'categories' => 'array|required',
            'views' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề không được để trống!',
            'content.required' => 'Nội dung không được để trống!',
            'categories.required' => 'Danh mục không được để trống!',
            'categories.array' => 'Danh mục không được để trống!',
            'views.required' => 'Số lượt xem không được để trống!',
            'views.integer' => 'Số lượt xem phải là một số nguyên!',
            'views.min' => 'Số lượt xem phải lớn hơn hoặc bằng 1!',
        ];
    }
}
