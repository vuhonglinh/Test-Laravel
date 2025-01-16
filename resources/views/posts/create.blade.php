@extends('main')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Thêm mới bài viết</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('post.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            value="{{ old('title') }}" name="title">
                        @error('title')
                            <div class="invalid-feedback @error('title') d-block @enderror">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nội dung</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback @error('content') d-block @enderror">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="views" class="form-label">Lượt xem</label>
                        <input type="number" class="form-control @error('views') is-invalid @enderror" id="views"
                            value="{{ old('views') }}" name="views">
                        @error('views')
                            <div class="invalid-feedback @error('views') d-block @enderror">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="categories" class="form-label">Danh mục</label>
                        <select name="categories[]" id="categories" multiple
                            class="form-control @error('name') is-invalid @enderror">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('categories')
                            <div class="invalid-feedback @error('categories') d-block @enderror">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <a href="{{ route('post.index') }}" class="btn btn-warning">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
@endsection
