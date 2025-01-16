<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $category = request()->category;
        return [
            'name' => $category ? 'required|unique:categories,name,' . $category->id : 'required|unique:categories,name',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục không được để trống!',
            'name.unique' => 'Tên danh mục đã tồn tại!'
        ];
    }
}
