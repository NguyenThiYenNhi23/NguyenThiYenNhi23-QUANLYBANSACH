<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #{{ $donHang->maDH }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; color: #263238; font-family: Arial, sans-serif; background: #f7f7f7; }
        a { color: inherit; text-decoration: none; }
        .container { width: 1125px; max-width: calc(100% - 40px); margin: 0 auto; }
        .site-header { background: #fff; }
        .site-header__main { display: flex; align-items: center; justify-content: space-between; gap: 25px; min-height: 95px; }
        .site-header__search { display: flex; width: 275px; height: 42px; overflow: hidden; border-radius: 22px; background: #f3f3f3; }
        .site-header__search input { width: 100%; padding: 0 20px; border: 0; outline: 0; background: transparent; font-style: italic; }
        .site-header__search button { width: 48px; border: 0; color: #e21c2a; background: transparent; font-size: 25px; cursor: pointer; }
        .site-header__logo { color: #bc1520; font-size: 23px; font-weight: 700; text-align: center; }
        .site-header__actions { display: flex; align-items: center; gap: 22px; white-space: nowrap; }
        .site-header__actions a:hover, .site-header__actions button:hover { color: #e21c2a; }
        .site-header__actions form { margin: 0; }
        .site-header__actions button { padding: 0; border: 0; color: inherit; background: transparent; cursor: pointer; }
        .site-header__nav { border-top: 1px solid #eee; border-bottom: 1px solid #eee; }
        .site-header__nav .container { display: flex; align-items: center; height: 63px; gap: 48px; }
        .site-header__nav a { font-size: 16px; }
        .site-header__nav a:hover { color: #e21c2a; }
        .account-banner { position: relative; min-height: 285px; padding: 113px 0; overflow: hidden; color: #fff; background: url('https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=1800&q=85') center/cover; }
        .account-banner::before { position: absolute; inset: 0; z-index: 0; background: rgba(0, 0, 0, .54); content: ''; }
        .account-banner .container { position: relative; z-index: 1; }
        .account-banner h1 { margin: 0 0 12px; font-size: 29px; text-shadow: 0 1px 3px rgba(0, 0, 0, .65); }
        .account-banner p { margin: 0; font-size: 16px; text-shadow: 0 1px 3px rgba(0, 0, 0, .65); }
        .account-layout { display: grid; grid-template-columns: 300px 1fr; gap: 85px; padding: 58px 0; }
        .account-sidebar h2 { margin: 0 0 10px; font-size: 22px; font-weight: 400; }
        .account-sidebar__greeting { display: block; margin-bottom: 25px; }
        .account-menu { display: flex; flex-direction: column; align-items: flex-start; }
        .account-menu a, .account-menu button { padding: 9px 0; border: 0; color: #333; background: transparent; font-size: 16px; cursor: pointer; }
        .account-menu a.active, .account-menu a:hover, .account-menu button:hover { color: #ed1c24; }
        .account-menu form { margin: 0; }
        .detail-heading { display: flex; justify-content: space-between; gap: 20px; margin-bottom: 25px; }
        .detail-heading h2 { margin: 0 0 12px; font-size: 24px; font-weight: 400; }
        .detail-date { white-space: nowrap; }
        .status-line { margin: 8px 0; }
        .status-line strong { color: #e21c2a; }
        .back-link { display: inline-block; margin-bottom: 22px; color: #e21c2a; }
        .notice { margin-bottom: 18px; padding: 12px 15px; color: #176b35; background: #e8f7ed; }
        .notice.error { color: #9b1c1c; background: #fdecec; }
        .info-grid { display: grid; grid-template-columns: 1.7fr 1fr; gap: 22px; margin-bottom: 28px; }
        .info-box { padding: 18px 20px; border: 1px solid #ddd; border-radius: 4px; }
        .info-box h3 { margin: 0 0 18px; font-size: 17px; font-weight: 400; }
        .info-box p { margin: 8px 0; line-height: 1.5; }
        .products { padding: 22px; border: 1px solid #ddd; border-radius: 4px; }
        .products h3 { margin: 0 0 22px; font-size: 18px; font-weight: 400; }
        .product-head, .product-row { display: grid; grid-template-columns: minmax(0, 1fr) 120px 75px 120px; gap: 18px; align-items: center; }
        .product-head { padding-bottom: 16px; border-bottom: 1px solid #ddd; }
        .product-row { padding: 18px 0; border-bottom: 1px solid #eee; }
        .product-name { font-weight: 600; }
        .product-code { margin-top: 6px; color: #666; font-size: 13px; }
        .product-price, .product-total { text-align: right; }
        .summary { width: 350px; margin: 22px 0 0 auto; }
        .summary-row, .summary-total { display: flex; justify-content: space-between; gap: 20px; padding: 8px 0; }
        .summary-total { padding-top: 14px; border-top: 1px solid #ddd; font-size: 18px; }
        .summary-total strong { color: #e21c2a; }
        .cancel-form { margin-top: 22px; text-align: right; }
        .cancel-button { padding: 10px 16px; border: 0; color: #fff; background: #b42318; cursor: pointer; }
        .footer-info { padding: 42px 0 55px; background: #f7f7f7; }
        .footer-info__grid { display: grid; grid-template-columns: 1fr 1fr; gap: 70px; }
        .footer-info h2 { margin: 0 0 22px; color: #202b35; font-size: 20px; }
        .footer-info p { max-width: 730px; margin: 0 0 8px; color: #526273; font-size: 15px; line-height: 1.8; }
        .footer-bottom { padding: 30px 0; color: #fff; background: #222; text-align: center; }
        .footer-bottom p { margin: 8px 0 0; color: #ccc; font-size: 18px; }
        @media (max-width: 800px) { .site-header__main { flex-wrap: wrap; padding: 16px 0; } .site-header__search { order: 3; width: 100%; } .site-header__actions { gap: 10px; font-size: 13px; } .site-header__nav .container { gap: 25px; } .account-layout { grid-template-columns: 1fr; gap: 30px; padding: 35px 0; } .detail-heading { flex-direction: column; } .info-grid { grid-template-columns: 1fr; } .footer-info__grid { grid-template-columns: 1fr; gap: 25px; } }
        @media (max-width: 620px) { .products { overflow-x: auto; } .product-head, .product-row { min-width: 620px; } .summary { width: 100%; } }
    </style>
</head>
<body>
    @include('customer.partials.header')

    <section class="account-banner">
        <div class="container">
            <h1>TRANG KHÁCH HÀNG</h1>
            <p>Quản lý thông tin tài khoản và đơn hàng của bạn</p>
        </div>
    </section>

    <main class="container account-layout">
        <aside class="account-sidebar">
            <h2>TRANG TÀI KHOẢN</h2>
            <strong class="account-sidebar__greeting">Xin chào, {{ request()->user()->name }}!</strong>
            <nav class="account-menu">
                <a href="{{ route('customer.account') }}">Thông tin tài khoản</a>
                <a class="active" href="{{ route('customer.account', ['section' => 'orders']) }}">Đơn hàng của bạn</a>
                <a href="{{ route('customer.account', ['section' => 'password']) }}">Đổi mật khẩu</a>
                <a href="{{ route('customer.account', ['section' => 'addresses']) }}">Sổ địa chỉ ({{ $addressCount }})</a>
                <form action="{{ route('customer.account.logout') }}" method="POST">
                    @csrf
                    <button type="submit">Đăng xuất</button>
                </form>
            </nav>
        </aside>

        <section class="account-content">
            <a class="back-link" href="{{ route('customer.account', ['section' => 'orders']) }}">&larr; Quay lại đơn hàng của bạn</a>
            @if (session('success')) <div class="notice">{{ session('success') }}</div> @endif
            @if (session('error')) <div class="notice error">{{ session('error') }}</div> @endif

            <div class="detail-heading">
                <div>
                    <h2>Chi tiết đơn hàng #{{ $donHang->maDH }}</h2>
                    <div class="status-line">Trạng thái đơn hàng: <strong>{{ match ($donHang->trangThai) { 'ChoXacNhan' => 'Chờ xác nhận', 'DangGiao' => 'Đang giao', 'DaGiao' => 'Đã giao', 'DaHuy' => 'Đã hủy', default => $donHang->trangThai } }}</strong></div>
                    <div class="status-line">Phương thức thanh toán: <strong>{{ $donHang->phuongThucThanhToan?->tenPhuongThuc ?? 'Chưa xác định' }}</strong></div>
                </div>
                <div class="detail-date">Ngày đặt: {{ $donHang->ngayDat?->format('d/m/Y') }}</div>
            </div>

            <div class="info-grid">
                <div class="info-box">
                    <h3>ĐỊA CHỈ GIAO HÀNG</h3>
                    <strong>{{ $donHang->diaChi?->hoTenNguoiNhan ?? 'Chưa cập nhật' }}</strong>
                    <p>Địa chỉ: {{ $donHang->diaChi?->diaChiChiTiet ?? 'Chưa cập nhật' }}</p>
                    <p>Số điện thoại: {{ $donHang->diaChi?->sdt ?? 'Chưa cập nhật' }}</p>
                </div>
                <div class="info-box">
                    <h3>THANH TOÁN</h3>
                    <p>{{ $donHang->phuongThucThanhToan?->tenPhuongThuc ?? 'Chưa xác định' }}</p>
                </div>
            </div>

            <section class="products">
                <h3>SẢN PHẨM</h3>
                <div class="product-head"><span>Sản phẩm</span><span class="product-price">Đơn giá</span><span class="product-price">Số lượng</span><span class="product-price">Tổng</span></div>
                @foreach ($donHang->chiTietDonHangs as $item)
                    <div class="product-row">
                        <div><div class="product-name">{{ $item->sach?->tenSach ?? 'Sách đã xóa' }}</div><div class="product-code">Mã sách: {{ $item->maSach }}</div></div>
                        <span class="product-price">{{ number_format($item->donGia, 0, ',', '.') }}đ</span>
                        <span class="product-price">{{ $item->soLuong }}</span>
                        <span class="product-total">{{ number_format($item->thanhTien, 0, ',', '.') }}đ</span>
                    </div>
                @endforeach
                <div class="summary">
                    <div class="summary-row"><span>Tạm tính</span><span>{{ number_format($donHang->chiTietDonHangs->sum('thanhTien'), 0, ',', '.') }}đ</span></div>
                    <div class="summary-total"><span>Tổng tiền</span><strong>{{ number_format($donHang->tongTien, 0, ',', '.') }}đ</strong></div>
                </div>
                @if ($donHang->trangThai === 'ChoXacNhan')
                    <form class="cancel-form" method="POST" action="{{ route('customer.donmua.cancel', $donHang) }}" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                        @csrf @method('PATCH')
                        <button class="cancel-button" type="submit">Hủy đơn hàng</button>
                    </form>
                @endif
            </section>
        </section>
    </main>

    <footer>
        <div class="footer-info">
            <div class="container footer-info__grid">
                <div>
                    <h2>Nhà xuất bản Kim Đồng</h2>
                    <p>Nhà xuất bản chuyên cung cấp các đầu sách dành cho thiếu nhi, thanh thiếu niên và độc giả yêu sách.</p>
                </div>
                <div>
                    <h2>Thông tin liên hệ</h2>
                    <p>Email: lienhe@kimdong.vn</p>
                    <p>Điện thoại: 024 3943 4730</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <strong>NHÀ XUẤT BẢN KIM ĐỒNG</strong>
                <p>© 2026. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
