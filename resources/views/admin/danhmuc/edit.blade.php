@extends('layout.form')

@section('title', 'Sửa danh mục')

@section('content')

<h1 class="page-title">SỬA DANH MỤC</h1>

<div class="form-card">

    <form
        action="{{ route('admin.danhmuc.update', $danhMuc) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">

            <label class="form-label">
                Mã danh mục
            </label>

            <input
                type="text"
                class="form-control"
                value="{{ $danhMuc->maDanhMuc }}"
                disabled>

        </div>


        <div class="form-group">

            <label class="form-label">
                Tên danh mục <span style="color:red">*</span>
            </label>

            <input
                type="text"
                name="tenDanhMuc"
                class="form-control"
                value="{{ old('tenDanhMuc', $danhMuc->tenDanhMuc) }}"
                placeholder="Nhập tên danh mục">

            @error('tenDanhMuc')
                <div class="form-error">
                    {{ $message }}
                </div>
            @enderror

        </div>


        <div class="form-group">

            <label class="form-label">
                Mô tả <span style="color:red">*</span>
            </label>

            <textarea
                name="moTa"
                class="form-control"
                placeholder="Nhập mô tả">{{ old('moTa', $danhMuc->moTa) }}</textarea>

            @error('moTa')
                <div class="form-error">
                    {{ $message }}
                </div>
            @enderror

        </div>


        <div class="form-actions">

            <button
                type="submit"
                class="btn-primary">
                Lưu thay đổi
            </button>

            <a
                href="{{ route('admin.danhmuc.index') }}"
                class="btn-secondary">
                Quay lại
            </a>

        </div>

    </form>

</div>

@endsection
