@extends('quantri.layouts.quantri_layout')

@section('title', 'Quản lý khách hàng')

@section('header-title', 'Quản lý khách hàng')

@section('content')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header h2 {
        margin: 0;
        color: #333;
    }

    .search-box {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .search-form {
        display: flex;
        gap: 10px;
    }

    .search-form input {
        flex: 1;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    .search-form button {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        background: #2563eb;
        color: white;
        cursor: pointer;
        font-size: 14px;
    }

    .search-form button:hover {
        background: #1d4ed8;
    }

    .customer-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .customer-table th,
    .customer-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #eee;
        text-align: left;
    }

    .customer-table th {
        background: #f5f6f8;
        color: #333;
        font-weight: 600;
    }

    .customer-table tr:hover {
        background: #f9fafb;
    }

    .empty-message {
        text-align: center;
        padding: 30px;
        color: #777;
    }

    .pagination {
        margin-top: 20px;
    }
</style>

<div class="page-header">
    <h2>Danh sách khách hàng</h2>
</div>

<div class="search-box">
    <form action="{{ route('quantri.khachhang.index') }}" method="GET" class="search-form">
        <input
            type="text"
            name="keyword"
            value="{{ $keyword }}"
            placeholder="Tìm theo họ tên, số điện thoại hoặc email..."
        >

        <button type="submit">Tìm kiếm</button>
    </form>
</div>

<table class="customer-table">
    <thead>
        <tr>
            <th>Mã KH</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($khachHangs as $khachHang)
            <tr>
                <td>{{ $khachHang->maKH }}</td>
                <td>{{ $khachHang->hoTen }}</td>
                <td>{{ $khachHang->email }}</td>
                <td>{{ $khachHang->sdt ?? 'Chưa cập nhật' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="empty-message">
                    Không tìm thấy khách hàng.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination">
    {{ $khachHangs->links() }}
</div>

@endsection