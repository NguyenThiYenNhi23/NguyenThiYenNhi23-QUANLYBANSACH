<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng của tôi</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; color: #263238; font-family: Arial, sans-serif; background: #f7f7f7; }
        a { color: inherit; text-decoration: none; }
        .container { width: 1125px; max-width: calc(100% - 40px); margin: 0 auto; }
        .page { padding: 45px 0 70px; }
        .heading { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 25px; }
        h1 { margin: 0; font-size: 28px; }
        .back-link { color: #c51622; }
        .filters { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 24px; }
        .filters a { padding: 9px 16px; border: 1px solid #ddd; background: #fff; }
        .filters a.active { color: #fff; border-color: #c51622; background: #c51622; }
        .order-card { margin-bottom: 18px; padding: 22px; background: #fff; border: 1px solid #e2e2e2; }
        .order-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
        .order-code { font-weight: 700; }
        .order-date { margin-top: 7px; color: #6b7280; font-size: 14px; }
        .status { padding: 6px 10px; color: #805b00; background: #fff4cc; font-size: 14px; white-space: nowrap; }
        .items { margin: 15px 0; }
        .item { display: flex; justify-content: space-between; gap: 20px; padding: 8px 0; }
        .item-name { font-weight: 600; }
        .item-meta { color: #6b7280; font-size: 14px; }
        .order-bottom { display: flex; align-items: center; justify-content: space-between; gap: 20px; padding-top: 15px; border-top: 1px solid #eee; }
        .total strong { color: #c51622; font-size: 18px; }
        .detail-link { padding: 10px 16px; color: #fff; background: #c51622; }
        .empty { padding: 50px 20px; color: #6b7280; text-align: center; background: #fff; }
        .pagination { margin-top: 24px; }
        @media (max-width: 600px) {
            .heading, .order-top, .order-bottom { align-items: flex-start; flex-direction: column; }
            .order-bottom { gap: 14px; }
        }
    </style>
</head>
<body>
    @include('customer.partials.header')

    <main class="container page">
        <div class="heading">
            <h1>ĐƠN HÀNG CỦA TÔI</h1>
            <a class="back-link" href="{{ route('customer.home') }}">Tiếp tục mua sắm</a>
        </div>

        <nav class="filters" aria-label="Lọc trạng thái đơn hàng">
            <a class="{{ request('trangThai') ? '' : 'active' }}" href="{{ route('customer.donmua.index') }}">Tất cả</a>
            @foreach ([
                'ChoXacNhan' => 'Chờ xác nhận',
                'DangGiao' => 'Đang giao',
                'DaGiao' => 'Đã giao',
                'DaHuy' => 'Đã hủy',
            ] as $value => $label)
                <a class="{{ request('trangThai') === $value ? 'active' : '' }}" href="{{ route('customer.donmua.index', ['trangThai' => $value]) }}">{{ $label }}</a>
            @endforeach
        </nav>

        @forelse ($donHangs as $donHang)
            <article class="order-card">
                <div class="order-top">
                    <div>
                        <div class="order-code">Đơn hàng #{{ $donHang->maDH }}</div>
                        <div class="order-date">Đặt ngày {{ $donHang->ngayDat?->format('d/m/Y H:i') }}</div>
                    </div>
                    <span class="status">{{ match ($donHang->trangThai) {
                        'ChoXacNhan' => 'Chờ xác nhận',
                        'DangGiao' => 'Đang giao',
                        'DaGiao' => 'Đã giao',
                        'DaHuy' => 'Đã hủy',
                        default => $donHang->trangThai,
                    } }}</span>
                </div>

                <div class="items">
                    @foreach ($donHang->chiTietDonHangs as $item)
                        <div class="item">
                            <div>
                                <div class="item-name">{{ $item->sach->tenSach ?? 'Sách đã xóa' }}</div>
                                <div class="item-meta">Số lượng: {{ $item->soLuong }}</div>
                            </div>
                            <strong>{{ number_format($item->thanhTien, 0, ',', '.') }} đ</strong>
                        </div>
                    @endforeach
                </div>

                <div class="order-bottom">
                    <div class="total">Tổng tiền: <strong>{{ number_format($donHang->tongTien, 0, ',', '.') }} đ</strong></div>
                    <a class="detail-link" href="{{ route('customer.donmua.show', $donHang) }}">Xem chi tiết</a>
                </div>
            </article>
        @empty
            <div class="empty">Bạn chưa có đơn hàng nào.</div>
        @endforelse

        <div class="pagination">{{ $donHangs->links() }}</div>
    </main>
</body>
</html>
