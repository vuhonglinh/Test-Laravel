@extends('main')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Danh sách danh mục</h4>
                    <a href="{{ route('category.create') }}" class="btn btn-primary mt-2">Thêm mới danh mục</a>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-12">
                <span class="fw-bold">Chọn danh mục:</span>
                <div class="form-group">
                    @foreach ($categories as $category)
                        <div class="form-check form-check-inline">
                            <input id="category-{{ $category->id }}" class="form-check-input" type="checkbox"
                                name="category" value="{{ $category->id }}">
                            <label class="form-check-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Danh sách danh mục</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên Danh mục</th>
                                        <th>Số bài viết</th>
                                        <th>Tổng lượt xem</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>
                                                <a href="{{ route('category.edit', $category) }}">
                                                    {{ $category->name }}
                                                </a>
                                            </td>
                                            <td>{{ $category->posts->count() }}</td>
                                            <td>{{ $category->posts->sum('views') }}</td>
                                            <td><a href="{{ route('category.delete', $category) }}"
                                                    class="btn btn-danger mt-2"
                                                    onclick="return confirm('Bạn có muốn xóa danh mục không?')">
                                                    Xóa
                                                </a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        {{ $categories->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
