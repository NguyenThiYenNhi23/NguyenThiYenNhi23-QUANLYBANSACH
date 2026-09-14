@extends('quantri.layouts.quantri_layout')

@section('title', 'Quản lý đơn hàng')
@section('header-title', 'Quản lý đơn hàng')

@section('content')
<style>
    .page-header, .filters, .order-table, .pagination { margin-bottom: 20px; }
    .page-header { display: flex; justify-content: space-between; align-items: center; }
    .filters { background: #fff; padding: 18px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
    .filter-form { display: flex; gap: 10px; flex-wrap: wrap; }
    .filter-form input, .filter-form select, .filter-form button { padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
    .filter-form input { flex: 1; min-width: 220px; }
    .filter-form button, .detail-link { background: #2563eb; color: #fff; border: 0; cursor: pointer; text-decoration: none; }
    .order-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
    .order-table th, .order-table td { padding: 14px 16px; border-bottom: 1px solid #eee; text-align: left; }
    .order-table th { background: #f5f6f8; }
    .detail-link { display: inline-block; padding: 7px 11px; border-radius: 6px; font-size: 13px; }
    .status { display: inline-block; padding: 5px 10px; border-radius: 20px; background: #fff4df; color: #a66300; font-size: 12px; }
    .empty-message { text-align: center; padding: 30px; color: #777; }
    @media (max-width: 800px) { .order-table { display: block; overflow-x: auto; white-space: nowrap; } }
</style>

<div class="page-header"><h2>Danh sách đơn hàng</h2></div>

@if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

<div class="filters">
    <form action="{{ route('quantri.donhang.index') }}" method="GET" class="filter-form">
        <input type="search" name="keyword" value="{{ $keyword }}" placeholder="Mã đơn, tên, email hoặc số điện thoại..."><select name="trangThai">
            <option value="">Tất cả trạng thái</option>
            @foreach ($statuses as $value => $label)
                <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
            @endforeach
        </select><button type="submit">Lọc đơn hàng</button>
    </form>
</div>

<table class="order-table">
    <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th><th></th></tr></thead>
    <tbody>
    @forelse ($donHangs as $donHang)
        <tr>
            <td>#{{ $donHang->maDH }}</td>
            <td>{{ $donHang->khachHang?->hoTen ?? 'Không xác định' }}</td>
            <td>{{ $donHang->ngayDat?->format('d/m/Y H:i') }}</td>
            <td>{{ number_format($donHang->tongTien, 0, ',', '.') }} đ</td>
            <td><span class="status">{{ $statuses[$donHang->trangThai] ?? $donHang->trangThai }}</span></td>
            <td><a class="detail-link" href="{{ route('quantri.donhang.show', $donHang) }}">Xem chi tiết</a></td>
        </tr>
    @empty
        <tr><td colspan="6" class="empty-message">Không tìm thấy đơn hàng.</td></tr>
    @endforelse
    </tbody>
</table>

<div class="pagination">{{ $donHangs->links() }}</div>
@endsection