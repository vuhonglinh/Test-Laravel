<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('posts')
            ->withSum('posts', 'views')
            ->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            $category = Category::create([
                'name' => $request->name,
            ]);
            if ($category) {
                toastr()->success('Thêm danh mục viết thành công', 'Thành công');
                return redirect()->route('category.index');
            }
            toastr()->error('Thêm danh mục viết không thành công', 'Lỗi');
            return back();
        } catch (\Throwable $e) {
            toastr()->error($e->getMessage(), 'Lỗi');
            return back();
        }
    }

    public function edit(Category $category)
    {
        try {
            if (!$category) {
                toastr()->error('Thêm danh mục viết không thành công', 'Lỗi');
                return back();
            }
            return view('categories.edit', compact('category'));
        } catch (\Throwable $e) {
            toastr()->error($e->getMessage(), 'Lỗi');
            return back();
        }
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            if (!$category) {
                toastr()->error('Danh mục không tồn tại', 'Lỗi');
                return back();
            }
            $category->update([
                'name' => $request->name,
            ]);
            toastr()->success('Cập nhật Danh mục thành công', 'Thành công');
            return redirect()->route('category.index');
        } catch (\Throwable $e) {
            toastr()->error($e->getMessage(), 'Lỗi');
            return back();
        }
    }

    public function delete(Category $category)
    {
        try {
            if (!$category) {
                toastr()->error('Danh mục không tồn tại', 'Lỗi');
                return back();
            }
            $category->delete();
            toastr()->success('Xóa danh mục thành công', 'Thành công');
            return redirect()->route('category.index');
        } catch (\Throwable $e) {
            toastr()->error($e->getMessage(), 'Lỗi');
            return back();
        }
    }
}
