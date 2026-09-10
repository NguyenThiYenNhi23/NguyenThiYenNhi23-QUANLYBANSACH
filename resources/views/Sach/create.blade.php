@extends('layout.form')

@section('title', 'Thêm sách')

@section('content')

<style>
    .page-title {
        margin: 0 0 10px;
        font-size: 28px;
        font-weight: 800;
        color: #111827;
    }

    .page-subtitle {
        margin-top: 8px;
        color: #64748b;
        font-size: 14px;
    }

    .form-card {
        max-width: 700px;
        margin: 0 auto;
        padding: 15px;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-grid .form-group.full {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        font-weight: 700;
        color: #374151;
    }

    .required {
        color: #dc2626;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d6dbe4;
        border-radius: 10px;
        font-size: 14px;
        background: #fff;
        color: #1f2937;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: #595dc6;
        box-shadow: 0 0 0 3px rgba(89, 93, 198, 0.12);
    }

    textarea.form-control {
        min-height: 130px;
        resize: vertical;
    }

    .helper-text {
        margin-top: 8px;
        font-size: 12px;
        color: #64748b;
    }

    .form-error {
        margin-top: 8px;
        color: #dc2626;
        font-size: 13px;
    }

    .upload-box {
        border: 1.5px dashed #c7d2fe;
        border-radius: 12px;
        padding: 18px;
        background: linear-gradient(135deg, #f8faff, #eef2ff);
    }

    .file-input {
        width: 100%;
        border-radius: 10px;
        border: 1px solid #d6dbe4;
        background: #fff;
        padding: 10px 12px;
    }

    .preview-card {
        margin-top: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px;
    }

    .preview-card img {
        max-width: 180px;
        max-height: 180px;
        object-fit: cover;
        border-radius: 10px;
        display: block;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #edf2f7;
    }

    .btn-primary,
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 140px;
        height: 44px;
        padding: 0 18px;
        border-radius: 10px;
        border: none;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #5b5fc7, #4c6ef5);
        color: #fff;
        box-shadow: 0 8px 18px rgba(89, 93, 199, 0.24);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(89, 93, 199, 0.28);
    }

    .btn-secondary {
        background: #eef2ff;
        color: #3f46ad;
    }

    .btn-secondary:hover {
        background: #e1e7ff;
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 20px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
        }
    }
</style>

<h1 class="page-title" style="text-align: center;">THÊM SÁCH</h1>

<div class="form-card">
    <form action="{{ route('sach.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            <div class="form-group full">
                <label class="form-label" for="maDanhMuc">
                    Danh mục <span class="required">*</span>
                </label>
                <select name="maDanhMuc" id="maDanhMuc" class="form-select">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($danhMucs as $danhMuc)
                        <option value="{{ $danhMuc->maDanhMuc }}" {{ old('maDanhMuc') == $danhMuc->maDanhMuc ? 'selected' : '' }}>
                            {{ $danhMuc->tenDanhMuc }}
                        </option>
                    @endforeach
                </select>
                @error('maDanhMuc')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full">
                <label class="form-label" for="tenSach">
                    Tên sách <span class="required">*</span>
                </label>
                <input
                    type="text"
                    name="tenSach"
                    id="tenSach"
                    class="form-control"
                    value="{{ old('tenSach') }}"
                    placeholder="Nhập tên sách"
                >
                @error('tenSach')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="giaBan">
                    Giá bán <span class="required">*</span>
                </label>
                <input
                    type="number"
                    name="giaBan"
                    id="giaBan"
                    class="form-control"
                    min="0"
                    step="0.01"
                    value="{{ old('giaBan') }}"
                    placeholder="0"
                >
                @error('giaBan')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="trangThai">
                    Trạng thái <span class="required">*</span>
                </label>
                <select name="trangThai" id="trangThai" class="form-select">
                    <option value="Đang kinh doanh" {{ old('trangThai', 'Đang kinh doanh') == 'Đang kinh doanh' ? 'selected' : '' }}>
                        Đang kinh doanh
                    </option>
                    <option value="Hết hàng" {{ old('trangThai') == 'Hết hàng' ? 'selected' : '' }}>
                        Hết hàng
                    </option>
                    <option value="Ngừng kinh doanh" {{ old('trangThai') == 'Ngừng kinh doanh' ? 'selected' : '' }}>
                        Ngừng kinh doanh
                    </option>
                </select>
                @error('trangThai')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full">
                <label class="form-label" for="moTa">
                    Mô tả
                </label>
                <textarea
                    name="moTa"
                    id="moTa"
                    class="form-control"
                    placeholder="Nhập mô tả chi tiết về sách"
                >{{ old('moTa') }}</textarea>
                @error('moTa')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full">
                <label class="form-label" for="hinhAnh">
                    Hình ảnh
                </label>
                <div class="upload-box">
                    <input
                        type="file"
                        name="hinhAnh"
                        id="hinhAnh"
                        class="file-input"
                        accept="image/*"
                    >
                    <div class="helper-text">Định dạng hỗ trợ: JPG, PNG, WEBP. Kích thước tối ưu dưới 2MB.</div>
                </div>
                @error('hinhAnh')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('sach.index') }}" class="btn-secondary">Hủy</a>
            <button type="submit" class="btn-primary">Lưu sách</button>
        </div>
    </form>
</div>

@endsection