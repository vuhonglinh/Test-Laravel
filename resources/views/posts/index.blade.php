@extends('main')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Danh sách bài viết</h4>
                    <a href="{{ route('post.create') }}" class="btn btn-primary mt-2">Thêm mới bài viết</a>
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
                        <h5 class="mb-0">Danh sách bài viết</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Danh mục</th>
                                        <th>Số view</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            window.renderedDataTable = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('post.data') }}",
                    data: function(d) {
                        d.filter = {
                            category: $('input[name="category"]:checked').val()
                        };
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'categories'
                    },
                    {
                        data: 'views'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'action'
                    }
                ],
                columnDefs: [{
                    className: 'dt-center',
                    targets: '_all'
                }],
            });

            $('input[name="category"]').on('change', function() {
                window.renderedDataTable.ajax.reload();
            });
        });
    </script>
@endpush
