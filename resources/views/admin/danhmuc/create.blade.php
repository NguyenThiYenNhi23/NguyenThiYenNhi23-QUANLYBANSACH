@extends('layout.form')

@section('title', 'Thêm danh mục')

@section('content')

<h1 class="page-title">THÊM DANH MỤC</h1>

<div class="form-card">

    <form
        action="{{ route('admin.danhmuc.store') }}"
        method="POST">

        @csrf

        <div class="form-group">

            <label class="form-label">
                Tên danh mục <span style="color:red">*</span>
            </label>

            <input
                type="text"
                name="tenDanhMuc"
                class="form-control"
                value="{{ old('tenDanhMuc') }}"
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
                placeholder="Nhập mô tả danh mục">{{ old('moTa') }}</textarea>

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
                Lưu danh mục
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
