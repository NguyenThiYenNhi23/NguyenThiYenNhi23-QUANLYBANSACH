@extends('quantri.layouts.quantri_layout')

@section('title', 'Chi tiết đơn hàng #' . $donHang->maDH)
@section('header-title', 'Chi tiết đơn hàng')

@section('content')
<style>
    .order-head, .order-section { background: #fff; border-radius: 10px; padding: 22px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
    .order-head { display: flex; justify-content: space-between; gap: 20px; align-items: flex-start; }
    .order-head h2 { margin-bottom: 8px; }
    .status { color: #a66300; background: #fff4df; padding: 6px 12px; border-radius: 20px; font-size: 13px; }
    .alert { padding: 12px 15px; border-radius: 7px; margin-bottom: 18px; }
    .alert-success { background: #e8f8ef; color: #20824b; }
    .alert-danger { background: #fff0f0; color: #c03939; }
    .order-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }
    .order-grid p { margin: 7px 0; color: #555; }
    .order-grid strong { color: #222; }
    .order-table { width: 100%; border-collapse: collapse; }
    .order-table th, .order-table td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
    .status-form { display: flex; gap: 10px; align-items: center; margin-top: 18px; }
    .status-form select, .status-form button { padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; }
    .status-form button { background: #2563eb; color: #fff; border: 0; cursor: pointer; }
    .back-link { display: inline-block; margin-bottom: 18px; color: #2563eb; }
    @media (max-width: 700px) { .order-head, .status-form { display: block; } .status-form select, .status-form button { margin-top: 10px; width: 100%; } .order-grid { grid-template-columns: 1fr; } }
</style>

<a class="back-link" href="{{ route('quantri.donhang.index') }}">← Quay lại danh sách</a>
@if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

<div class="order-head">
    <div><h2>Đơn hàng #{{ $donHang->maDH }}</h2><p>Đặt lúc {{ $donHang->ngayDat?->format('d/m/Y H:i') }}</p></div>
    <span class="status">{{ $statuses[$donHang->trangThai] ?? $donHang->trangThai }}</span>
</div>

<div class="order-section">
    <h3>Thông tin khách hàng và giao hàng</h3>
    <div class="order-grid">
        <div><p><strong>Khách hàng:</strong> {{ $donHang->khachHang?->hoTen ?? 'Không xác định' }}</p><p><strong>Email:</strong> {{ $donHang->khachHang?->email ?? 'Chưa cập nhật' }}</p><p><strong>Số điện thoại:</strong> {{ $donHang->khachHang?->sdt ?? 'Chưa cập nhật' }}</p></div>
        <div><p><strong>Người nhận:</strong> {{ $donHang->diaChi?->hoTenNguoiNhan ?? 'Chưa cập nhật' }}</p><p><strong>Điện thoại:</strong> {{ $donHang->diaChi?->sdt ?? 'Chưa cập nhật' }}</p><p><strong>Địa chỉ:</strong> {{ $donHang->diaChi?->diaChiChiTiet ?? 'Chưa cập nhật' }}</p></div>
    </div>
    @if ($allowedStatuses)
        <form action="{{ route('quantri.donhang.status', $donHang) }}" method="POST" class="status-form">
            @csrf @method('PATCH')
            <label for="trangThai"><strong>Cập nhật trạng thái:</strong></label>
            <select id="trangThai" name="trangThai" required>
                @foreach ($allowedStatuses as $value)<option value="{{ $value }}">{{ $statuses[$value] }}</option>@endforeach
            </select>
            <button type="submit">Xác nhận cập nhật</button>
        </form>
    @else
        <p style="margin-top:18px;color:#777;">Đơn hàng đã ở trạng thái cuối và không thể cập nhật thêm.</p>
    @endif
</div>

<div class="order-section">
    <h3>Sản phẩm trong đơn</h3>
    <table class="order-table"><thead><tr><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead><tbody>
    @foreach ($donHang->chiTietDonHangs as $chiTiet)<tr><td>{{ $chiTiet->sach?->tenSach ?? 'Sản phẩm không còn tồn tại' }}</td><td>{{ $chiTiet->soLuong }}</td><td>{{ number_format($chiTiet->donGia, 0, ',', '.') }} đ</td><td>{{ number_format($chiTiet->thanhTien, 0, ',', '.') }} đ</td></tr>@endforeach
    <tr><td colspan="3"><strong>Tổng tiền</strong></td><td><strong>{{ number_format($donHang->tongTien, 0, ',', '.') }} đ</strong></td></tr>
    </tbody></table>
    <p style="margin-top:14px;"><strong>Thanh toán:</strong> {{ $donHang->phuongThucThanhToan?->tenPhuongThuc ?? 'Chưa cập nhật' }}</p>
</div>
@endsection