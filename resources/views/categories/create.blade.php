@extends('main')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Thêm mới danh mục</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            value="{{ old('name') }}" name="name">
                        @error('name')
                            <div class="invalid-feedback @error('name') d-block @enderror">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <a href="{{ route('category.index') }}" class="btn btn-warning">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
@endsection
