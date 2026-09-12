@extends('quantri.layouts.quantri_layout')

@section('title', 'Quản lý sách')

@section('header-title', 'Quản lý sách')

@section('content')

<style>
    .book-management {
        display: flex;
        flex-direction: column;
        gap: 24px;
        max-width: 1000px;
        margin: 0 auto;
    }
    .add-book-wrapper {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1px;
    }


    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        border-radius: 10px;
        padding: 11px 18px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #5b5fc7, #4c6ef5);
        color: #fff;
        box-shadow: 0 8px 18px rgba(91, 95, 199, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(91, 95, 199, 0.3);
    }

    .btn-secondary {
        background: #eef2ff;
        color: #3f46ad;
    }

    .btn-secondary:hover {
        background: #e1e7ff;
    }

    .btn-ghost {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-ghost:hover {
        background: #e5e7eb;
    }
    .btn-edit {
        background: #fef3c7;
        color: #b45309;
        border-color: #fde68a;
    }
    .btn-edit:hover {
        background: #fde68a;
        color: #92400e;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: #fee2e2;
        color: #b91c1c;
        border-color: #fecaca;
    }
    .btn-delete:hover {
        background: #fecaca;
        color: #991b1b;
        transform: translateY(-1px);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .stat-card {
        background: #fff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
        border: 1px solid #eef2ff;
    }

    .stat-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .icon-total {
        background: #e0e7ff;
        color: #4f46e5;
    }

    .icon-active {
        background: #dcfce7;
        color: #15803d;
    }

    .icon-out {
        background: #fef3c7;
        color: #b45309;
    }

    .icon-stop {
        background: #fee2e2;
        color: #b91c1c;
    }

    .stat-number {
        font-size: 30px;
        font-weight: 800;
        color: #111827;
        margin: 0;
    }

    .stat-detail {
        margin-top: 8px;
        font-size: 13px;
        color: #64748b;
    }

    .toolbar-panel {
        background: #fff;
        border: 1px solid #eef2ff;
        border-radius: 18px;
        padding: 18px;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
    }

    .filters-form {
        display: grid;
        grid-template-columns:
            minmax(220px, 2fr)
            repeat(3, minmax(140px, 1fr))
            auto auto;
        gap: 12px;
        align-items: center;
    }

    .input-field,
    .select-field {
        width: 100%;
        height: 44px;
        border-radius: 10px;
        border: 1px solid #dbe3f0;
        padding: 0 14px;
        font-size: 14px;
        color: #1f2937;
        background: #fff;
    }

    .input-field:focus,
    .select-field:focus {
        outline: none;
        border-color: #6f6ef3;
        box-shadow: 0 0 0 3px rgba(111, 110, 243, 0.12);
    }

    .table-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
        border: 1px solid #eef2ff;
        overflow: hidden;
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border-bottom: 1px solid #edf2f7;
        background: #f8faff;
    }

    .table-header-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
    }

    .result-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        padding: 8px 12px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 12px;
        font-weight: 700;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 860px;
    }

    .data-table thead th {
        background: #f8faff;
        padding: 16px 18px;
        text-align: left;
        color: #475569;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .data-table tbody td {
        padding: 18px;
        border-top: 1px solid #edf2f7;
        vertical-align: middle;
        color: #334155;
        font-size: 14px;
    }

    .data-table tbody tr:hover {
        background: #f8fbff;
    }

    .book-cell {
        width: 32%;
    }

    .book-meta {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .book-cover {
        width: 62px;
        height: 72px;
        border-radius: 12px;
        overflow: hidden;
        background: linear-gradient(135deg, #e2e8f0, #dbeafe);
        border: 1px solid #dfe7f5;
        flex-shrink: 0;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .cover-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    }

    .book-name {
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .book-sub {
        font-size: 12px;
        color: #64748b;
    }

    .price {
        font-weight: 700;
        color: #1f2937;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid transparent;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
        border-color: #bbf7d0;
    }

    .status-out {
        background: #fef3c7;
        color: #b45309;
        border-color: #fcd34d;
    }

    .status-inactive {
        background: #fee2e2;
        color: #b91c1c;
        border-color: #fecaca;
    }

    .actions-col {
        min-width: 240px;
    }

    .action-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 70px;
        height: 36px;
        padding: 0 14px;
        border-radius: 9px;
        border: 1px solid transparent;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .empty-box {
        padding: 42px 20px;
        text-align: center;
        color: #64748b;
        font-size: 15px;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: flex-end;
        padding: 18px 20px 20px;
    }

    .pagination-wrapper nav {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pagination-wrapper a,
    .pagination-wrapper span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        color: #475569;
        text-decoration: none;
        font-size: 14px;
    }

    .pagination-wrapper .current {
        background: #5b5fc7;
        border-color: #5b5fc7;
        color: #fff;
        font-weight: 700;
    }

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .filters-form {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 720px) {

        .stats-grid,
        .filters-form {
            grid-template-columns: 1fr;
        }

        .table-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="book-management">

    <div class="add-book-wrapper">
        <a href="{{ route('sach.create') }}" class="btn btn-primary">
            <span>＋</span>
            <span>Thêm sách</span>
        </a>
    </div>

    {{-- BỘ LỌC --}}
    <div class="toolbar-panel">
        <form action="{{ route('sach.index') }}" method="GET" class="filters-form">

            {{-- Tìm kiếm --}}
            <input
                type="text"
                name="keyword"
                value="{{ $keyword }}"
                class="input-field"
                placeholder="Nhập tên sách hoặc mã sách"
            >

            {{-- Danh mục --}}
            <select name="maDanhMuc" class="select-field">
                <option value="">Tất cả danh mục</option>

                @foreach($danhMucs as $danhMuc)
                    <option
                        value="{{ $danhMuc->maDanhMuc }}"
                        {{ $maDanhMuc == $danhMuc->maDanhMuc ? 'selected' : '' }}
                    >
                        {{ $danhMuc->tenDanhMuc }}
                    </option>
                @endforeach
            </select>

            {{-- Trạng thái --}}
            <select name="trangThai" class="select-field">
                <option value="">Tất cả trạng thái</option>

                <option
                    value="Đang kinh doanh"
                    {{ $status == 'Đang kinh doanh' ? 'selected' : '' }}
                >
                    Đang kinh doanh
                </option>

                <option
                    value="Ngừng kinh doanh"
                    {{ $status == 'Ngừng kinh doanh' ? 'selected' : '' }}
                >
                    Ngừng kinh doanh
                </option>
            </select>

            {{-- Sắp xếp --}}
            <select name="sort" class="select-field">
                <option
                    value="maSach_desc"
                    {{ $sort == 'maSach_desc' ? 'selected' : '' }}
                >
                    Mới nhất
                </option>

                <option
                    value="tenSach_asc"
                    {{ $sort == 'tenSach_asc' ? 'selected' : '' }}
                >
                    Tên A → Z
                </option>

                <option
                    value="giaBan_asc"
                    {{ $sort == 'giaBan_asc' ? 'selected' : '' }}
                >
                    Giá thấp → cao
                </option>

                <option
                    value="giaBan_desc"
                    {{ $sort == 'giaBan_desc' ? 'selected' : '' }}
                >
                    Giá cao → thấp
                </option>
            </select>

            <button type="submit" class="btn btn-secondary">
                Lọc
            </button>

            @if($keyword || $maDanhMuc || $status || $sort != 'maSach_desc')
                <a href="{{ route('sach.index') }}" class="btn btn-ghost">
                    Đặt lại
                </a>
            @endif

        </form>
    </div>


    {{-- DANH SÁCH SÁCH --}}
    <div class="table-card">

        <div class="table-header">
            <div class="table-header-title">
                Danh sách sách
            </div>

            <span class="result-badge">
                {{ $sachs->total() }} kết quả
            </span>
        </div>


        @if($sachs->count())

            <div class="table-responsive">

                <table class="data-table">

                    <thead>
                        <tr>
                            <th>Sách</th>
                            <th>Danh mục</th>
                            <th>Giá bán</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($sachs as $sach)

                            @php

                                $displayStatus = (
                                    $sach->trangThai === 'Đang kinh doanh'
                                    && $sach->tonKho
                                    && $sach->tonKho->soLuongTon <= 0
                                )
                                    ? 'Hết hàng'
                                    : $sach->trangThai;


                                $statusClass = match ($displayStatus) {

                                    'Đang kinh doanh' => 'status-active',

                                    'Hết hàng' => 'status-out',

                                    'Ngừng kinh doanh' => 'status-inactive',

                                    default => 'status-inactive',

                                };

                            @endphp


                            <tr>

                                {{-- SÁCH --}}
                                <td class="book-cell">

                                    <div class="book-meta">

                                        <div class="book-cover">

                                            @if($sach->hinhAnh)

                                                <img
                                                    src="{{ asset('storage/' . $sach->hinhAnh) }}"
                                                    alt="{{ $sach->tenSach }}"
                                                >

                                            @else

                                                <div class="cover-placeholder">
                                                    NO IMG
                                                </div>

                                            @endif

                                        </div>


                                        <div>

                                            <div class="book-name">
                                                {{ $sach->tenSach }}
                                            </div>

                                            <div class="book-sub">
                                                Mã: {{ $sach->maSach }}
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- DANH MỤC --}}
                                <td>
                                    {{ $sach->danhMuc->tenDanhMuc ?? 'Không có' }}
                                </td>


                                {{-- GIÁ --}}
                                <td class="price">
                                    {{ number_format($sach->giaBan, 0, ',', '.') }} đ
                                </td>


                                {{-- TRẠNG THÁI --}}
                                <td>

                                    <span class="status-badge {{ $statusClass }}">
                                        {{ $displayStatus }}
                                    </span>

                                </td>
                                <td class="actions-col">
                                    <div class="action-group">

                                        {{-- SỬA --}}
                                        <a
                                            href="{{ route('sach.edit', $sach->maSach) }}"
                                            class="btn-action btn-edit"
                                        >
                                            Sửa
                                        </a>

                                        {{-- XÓA --}}
                                        <form
                                            action="{{ route('sach.destroy', $sach->maSach) }}"
                                            method="POST"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa sách này?');"
                                            style="margin: 0;"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn-action btn-delete"
                                            >
                                                Xóa
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- PHÂN TRANG --}}
            <div class="pagination-wrapper">
                {{ $sachs->links() }}
            </div>

        @else

            <div class="empty-box">
                Không tìm thấy sách phù hợp với bộ lọc hiện tại.
            </div>

        @endif

    </div>

</div>

@endsection