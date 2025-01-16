<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('posts.index', compact('categories'));
    }

    public function data(Request $request)
    {
        $filter = $request->filter;
        $posts =  Post::query();
        if (!empty($filter['categories'])) {
            $posts->whereHas('categories', function ($q) use ($filter) {
                $q->whereIn('categories.id', $filter['categories']);
            });
        }
        $posts = $posts->orderBy('created_at', 'desc')->get();
        return DataTables::of($posts)
            ->addIndexColumn()
            ->editColumn('id', function ($post) {
                return $post->id;
            })
            ->editColumn('title', function ($post) {
                return '<a href="' . route('post.edit', $post) . '">' . $post->title . '</a>';
            })
            ->editColumn('views', function ($post) {
                return $post->views;
            })
            ->editColumn('categories', function ($post) {
                $html = '<ul>';
                foreach ($post->categories as $category) {
                    $html .= '<li>' . $category->name . '</li>';
                }
                $html .= '</ul>';
                return $html;
            })
            ->editColumn('created_at', function ($post) {
                $formattedDate = Carbon::parse($post->created_at)->format('d M, Y');
                $formattedTime = Carbon::parse($post->created_at)->format('h:i A');
                return '<span>' . $formattedDate . '<small class="text-muted ms-1">' . $formattedTime . '</small></span>';
            })
            ->editColumn('action', function ($post) {
                return '<a href="' . route("post.delete", $post) . '"
                           class="btn btn-danger mt-2"
                           onclick="return confirm(\'Bạn có muốn xóa bài viết không?\')">
                           Xóa
                        </a>';
            })
            ->rawColumns(['id', 'title', 'created_at', 'categories', 'views', 'action'])
            ->toJson();
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(PostRequest $request)
    {
        try {
            $post = Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'views' => $request->views
            ]);
            $post->categories()->sync($request->categories);
            if ($post) {
                toastr()->success('Thêm mới bài viết thành công', 'Thành công');
                return redirect()->route('post.index');
            }
            toastr()->error('Thêm mới bài viết không thành công', 'Lỗi');
            return back();
        } catch (\Throwable $e) {
            toastr()->error($e->getMessage(), 'Lỗi');
            return back();
        }
    }

    public function edit(Post $post)
    {
        try {
            $categories = Category::all();
            $post = Post::findOrFail($post->id);
            if (!$post) {
                toastr()->error('Thêm mới bài viết không thành công', 'Lỗi');
                return back();
            }
            return view('posts.edit', compact('post', 'categories'));
        } catch (\Throwable $e) {
            toastr()->error($e->getMessage(), 'Lỗi');
            return back();
        }
    }

    public function update(PostRequest $request, Post $post)
    {
        try {
            if (!$post) {
                toastr()->error('Bài viết không tồn tại', 'Lỗi');
                return back();
            }
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
                'views' => $request->views
            ]);
            $post->categories()->sync($request->categories);
            toastr()->success('Cập nhật bài viết thành công', 'Thành công');
            return redirect()->route('post.index');
        } catch (\Throwable $e) {
            toastr()->error($e->getMessage(), 'Lỗi');
            return back();
        }
    }

    public function delete(Post $post)
    {
        try {
            if (!$post) {
                toastr()->error('Bài viết không tồn tại', 'Lỗi');
                return back();
            }
            $post->delete();
            $post->categories()->delete();
            toastr()->success('Xóa bài viết thành công', 'Thành công');
            return redirect()->route('post.index');
        } catch (\Throwable $e) {
            toastr()->error($e->getMessage(), 'Lỗi');
            return back();
        }
    }
}
