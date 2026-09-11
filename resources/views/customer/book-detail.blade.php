<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $sach->tenSach }} - Nhà xuất bản Kim Đồng</title>

    @php
        $soLuongTon = $sach->tonKho->soLuongTon ?? 0;
    @endphp

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* =========================
        HEADER - ĐỒNG BỘ TRANG CHỦ
        ========================= */

        .site-header {
            background: #ffffff;
            border-bottom: 1px solid #ddd;
        }

        .header-container {
            width: 1200px;
            max-width: 95%;
            margin: auto;
        }

        .header-top {
            height: 80px;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #d71920;
            white-space: nowrap;
        }

        .search-form {
            flex: 1;
            display: flex;
            height: 42px;
        }

        .search-input {
            flex: 1;
            border: 1px solid #ddd;
            border-right: none;
            padding: 0 15px;
            font-size: 14px;
            border-radius: 5px 0 0 5px;
            outline: none;
        }

        .search-input:focus {
            border-color: #d71920;
        }

        .search-button {
            width: 50px;
            border: none;
            background: #d71920;
            color: white;
            cursor: pointer;
            border-radius: 0 5px 5px 0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 25px;
            white-space: nowrap;
        }

        .header-link {
            color: #1f2937;
            font-size: 15px;
        }

        .header-link:hover {
            color: #d71920;
        }

        .cart-link {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .cart-icon {
            font-size: 18px;
        }

        .logout-form {
            display: inline;
            margin: 0;
        }

        .logout-button {
            background: none;
            border: none;
            padding: 0;
            color: #1f2937;
            font-family: inherit;
            font-size: 15px;
            cursor: pointer;
        }

        .logout-button:hover {
            color: #d71920;
        }


        /* =========================
        MENU - GIỐNG TRANG CHỦ
        ========================= */

        .header-nav {
            border-top: 1px solid #eee;

            height: 50px;

            display: flex;
            align-items: center;

            gap: 40px;
        }

        .nav-link {
            font-size: 15px;
            font-weight: 500;
            color: #1f2937;
        }

        .nav-link:hover {
            color: #d71920;
        }


        /* =========================
           TRANG CHI TIẾT
        ========================= */

        .page {
            padding: 30px 0 60px;
        }

        .container {
            width: 1200px;
            max-width: 88%;
            margin: 0 auto;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
            font-size: 14px;
        }

        .breadcrumb a {
            color: #111827;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: #d71920;
        }

        .breadcrumb .current {
            color: #6b7280;
        }

        .alert {
            background: #ecfdf5;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .product-layout {
            display: grid;
            grid-template-columns: 0.95fr 1.2fr;
            gap: 36px;
            align-items: start;
            background: #ffffff;
            padding: 28px;
            border-radius: 24px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        }

        .gallery-panel {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .main-image {
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            border: 1px solid #dfe7f5;
            border-radius: 20px;
            min-height: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 8px;
        }

        .main-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 16px;
        }

        .no-image {
            font-size: 18px;
            color: #6b7280;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 7px 12px;
            border-radius: 999px;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 10px;
        }

        .product-title {
            margin: 0 0 10px;
            font-size: 34px;
            line-height: 1.25;
            font-weight: 800;
            color: #111827;
        }

        .price {
            font-size: 24px;
            font-weight: 800;
            color: #d71920;
            margin-bottom: 18px;
        }

        .summary-line {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 8px 0;
            border-top: 1px solid #edf2f7;
            border-bottom: 1px solid #edf2f7;
            margin-bottom: 10px;
            color: #374151;
            font-size: 12px;
        }

        .summary-line strong {
            color: #111827;
        }

        .description {
            margin: 0;
            font-size: 15px;
            line-height: 1.8;
            color: #4b5563;
            white-space: pre-line;
        }

        .description-box {
            margin-top: 18px;
            padding: 22px 24px;
            border: 1px solid #edf2f7;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
            font-size: 15px;
            line-height: 1.7;
            color: #374151;
            white-space: pre-line;
        }

        .section-title {
            margin: 0 0 12px;
            font-size: 20px;
            font-weight: 800;
            color: #111827;
        }


        /* =========================
           MUA HÀNG
        ========================= */

        .purchase-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 26px;
            flex-wrap: wrap;
        }

        .quantity-box {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 8px 12px;
            background: #fff;
        }

        .quantity-label {
            font-weight: 700;
            font-size: 13px;
            color: #374151;
        }

        .qty-btn {
            width: 26px;
            height: 26px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f9fafb;
            font-size: 16px;
            line-height: 1;
            cursor: pointer;
            color: #374151;
        }

        .qty-btn:hover:not(:disabled) {
            background: #f3f4f6;
        }

        .qty-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .qty-input {
            width: 42px;
            border: none;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            background: transparent;
        }

        .qty-input:focus {
            outline: none;
        }

        .action-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn:hover:not(:disabled) {
            transform: translateY(-1px);
        }

        .btn-cart {
            background: #f59e0b;
            color: #fff;
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.22);
        }

        .btn-buy {
            background: linear-gradient(135deg, #1e88e5, #0d6ad7);
            color: #fff;
            box-shadow: 0 10px 20px rgba(30, 136, 229, 0.22);
        }

        .btn-disabled {
            background: #9ca3af;
            color: #fff;
            cursor: not-allowed;
            opacity: 0.75;
            box-shadow: none;
            min-width: 120px;
        }

        .btn-disabled:hover {
            transform: none;
        }

        .stock-message {
            margin-top: 10px;
            color: #dc2626;
            font-size: 14px;
            font-weight: 600;
            display: none;
        }


        /* =========================
           LIÊN HỆ + FOOTER
        ========================= */

        .site-contact {
            background: #f8f8f8;
            padding: 50px 0;
            margin-top: 30px;
        }

        .site-contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .site-contact-grid > div {
            background: transparent;
            border: none;
            padding: 0;
        }

        .site-contact h2 {
            margin: 0 0 15px;
            font-family: Arial, sans-serif;
        }

        .site-contact p {
            line-height: 1.8;
            color: #666;
            font-family: Arial, sans-serif;
            margin: 6px 0;
        }

        .site-footer {
            background: #222;
            color: white;
            padding: 30px 0;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .site-footer p {
            margin-top: 8px;
            color: #ccc;
            font-family: Arial, sans-serif;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1000px) {

            .header-top {
                flex-wrap: wrap;
            }

            .search-form {
                order: 3;
                width: 100%;
                flex-basis: 100%;
            }

            .header-actions {
                margin-left: auto;
            }

            .product-layout {
                grid-template-columns: 1fr;
            }

            .main-image {
                min-height: 360px;
            }
        }

        @media (max-width: 700px) {

            .header-container,
            .container {
                max-width: 92%;
            }

            .header-top {
                gap: 15px;
            }

            .header-actions {
                gap: 12px;
            }

            .header-link {
                font-size: 13px;
            }

            .header-nav {
                gap: 20px;
                overflow-x: auto;
            }

            .product-layout {
                padding: 20px;
                border-radius: 16px;
            }

            .product-title {
                font-size: 28px;
            }

            .site-contact-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .purchase-row {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>


{{-- =========================
     HEADER - GIỐNG TRANG CHỦ
========================= --}}

<header class="site-header">

    <div class="header-container">

        {{-- HÀNG TRÊN --}}
        <div class="header-top">

            {{-- LOGO --}}
            <a
                href="{{ route('customer.home') }}"
                class="logo"
            >
                KIM ĐỒNG
            </a>


            {{-- TÌM KIẾM --}}
            <form
                action="{{ route('customer.search') }}"
                method="GET"
                class="search-form"
            >

                <input
                    type="text"
                    name="q"
                    class="search-input"
                    placeholder="Tìm kiếm sách..."
                >

                <button
                    type="submit"
                    class="search-button"
                >
                    🔍
                </button>

            </form>


            {{-- TÀI KHOẢN / ĐĂNG NHẬP / ĐĂNG XUẤT / GIỎ HÀNG --}}
            <div class="header-actions">

                @auth

                    <a
                        href="{{ route('customer.account') }}"
                        class="header-link"
                    >
                        {{ auth()->user()->name }}
                    </a>

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                        class="logout-form"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="logout-button"
                        >
                            Đăng xuất
                        </button>
                    </form>

                @else

                    <a
                        href="{{ route('login') }}"
                        class="header-link"
                    >
                        Đăng nhập
                    </a>

                @endauth


                {{-- GIỎ HÀNG --}}
                <a
                    href="{{ route('customer.cart') }}"
                    class="header-link cart-link"
                >
                    <span class="cart-icon">🛒</span>
                    <span>Giỏ hàng</span>
                </a>

            </div>

        </div>


        {{-- MENU --}}
        <nav class="header-nav">

            <a
                href="{{ route('customer.home') }}"
                class="nav-link"
            >
                Trang chủ
            </a>

            <a
                href="{{ route('customer.danhmuc') }}"
                class="nav-link"
            >
                Danh mục
            </a>

            <a
                href="{{ route('customer.gioithieu') }}"
                class="nav-link"
            >
                Giới thiệu
            </a>

        </nav>

    </div>

</header>



    {{-- =========================
         NỘI DUNG CHI TIẾT SÁCH
    ========================= --}}

    <div class="page">

        <div class="container">

        <div class="breadcrumb">
            <a href="{{ route('customer.home') }}">Trang chủ</a>
            <span>/</span>
            <span class="current">{{ $sach->tenSach }}</span>
        </div>


            {{-- THÔNG BÁO --}}
            @if (session('success'))

                <div class="alert">
                    {{ session('success') }}
                </div>

            @endif


            <div class="product-layout">


                {{-- =========================
                     HÌNH ẢNH
                ========================= --}}

                <div class="gallery-panel">

                    <div class="main-image">

                        @if ($sach->hinhAnh)

                            <img
                                src="{{ asset('storage/' . $sach->hinhAnh) }}"
                                alt="{{ $sach->tenSach }}"
                            >

                        @else

                            <span class="no-image">
                                Chưa có hình ảnh
                            </span>

                        @endif

                    </div>

                </div>



                {{-- =========================
                     THÔNG TIN SÁCH
                ========================= --}}

                <div class="product-content">

                    <div class="badge">
                        Sách mới
                    </div>

                    <h1 class="product-title">
                        {{ $sach->tenSach }}
                    </h1>

                    <div class="price">
                        {{ number_format($sach->giaBan, 0, ',', '.') }} đ
                    </div>

                    <p class="description">
                        {{ $sach->moTa ?: 'Không có mô tả cho sách này.' }}
                    </p>


                    {{-- =========================
                         KHU VỰC MUA HÀNG
                    ========================= --}}

                    <div class="purchase-row">

                        @if ($soLuongTon > 0)

                            {{-- CHỌN SỐ LƯỢNG --}}
                            <div class="quantity-box">

                                <span class="quantity-label">
                                    Số lượng
                                </span>

                                <button
                                    type="button"
                                    class="qty-btn"
                                    id="btn-minus"
                                >
                                    −
                                </button>

                                <input
                                    class="qty-input"
                                    id="quantity"
                                    type="number"
                                    value="1"
                                    min="1"
                                    max="{{ $soLuongTon }}"
                                    readonly
                                >

                                <button
                                    type="button"
                                    class="qty-btn"
                                    id="btn-plus"
                                >
                                    ＋
                                </button>

                            </div>


                            {{-- NÚT --}}
                            <div class="action-group">

                                {{-- THÊM VÀO GIỎ --}}
                                <form
                                    action="{{ route('customer.cart.add') }}"
                                    method="POST"
                                    style="display:inline;"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="maSach"
                                        value="{{ $sach->maSach }}"
                                    >

                                    <input
                                        type="hidden"
                                        class="qty-hidden"
                                        name="soLuong"
                                        value="1"
                                    >

                                    <button
                                        type="submit"
                                        class="btn btn-cart"
                                    >
                                        Thêm vào giỏ hàng
                                    </button>

                                </form>


                                {{-- MUA NGAY --}}
                                <form
                                    action="{{ route('customer.cart.buyNow') }}"
                                    method="POST"
                                    style="display:inline;"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="maSach"
                                        value="{{ $sach->maSach }}"
                                    >

                                    <input
                                        type="hidden"
                                        class="qty-hidden"
                                        name="soLuong"
                                        value="1"
                                    >

                                    <button
                                        type="submit"
                                        class="btn btn-buy"
                                    >
                                        Mua ngay
                                    </button>

                                </form>

                            </div>

                        @else

                            {{-- HẾT HÀNG --}}
                            <div class="action-group">

                                <button
                                    type="button"
                                    class="btn btn-disabled"
                                    disabled
                                >
                                    Hết hàng
                                </button>

                            </div>

                        @endif

                    </div>


                    {{-- THÔNG BÁO TỒN KHO --}}
                    @if ($soLuongTon > 0)

                        <div
                            id="stock-message"
                            class="stock-message"
                        >
                        </div>

                    @endif

                </div>

            </div>



            {{-- =========================
                 MÔ TẢ CHI TIẾT
            ========================= --}}

            <div class="description-box">

                <div class="section-title">
                    Thông tin mô tả
                </div>

                {{ $sach->moTa ?: 'Chưa có thông tin mô tả chi tiết cho sách này.' }}

            </div>

        </div>

    </div>



    {{-- =========================
         LIÊN HỆ
    ========================= --}}

    <section class="site-contact">

        <div class="container">

            <div class="site-contact-grid">

                <div>

                    <h2>
                        Nhà xuất bản Kim Đồng
                    </h2>

                    <p>
                        Nhà xuất bản chuyên cung cấp các đầu sách dành cho
                        thiếu nhi, thanh thiếu niên và độc giả yêu sách.
                    </p>

                </div>


                <div>

                    <h2>
                        Thông tin liên hệ
                    </h2>

                    <p>
                        Email: lienhe@kimdong.vn
                    </p>

                    <p>
                        Điện thoại: 024 3943 4730
                    </p>

                </div>

            </div>

        </div>

    </section>



    {{-- =========================
         FOOTER
    ========================= --}}

    <footer class="site-footer">

        <div class="container">

            <strong>
                NHÀ XUẤT BẢN KIM ĐỒNG
            </strong>

            <p>
                © 2026. All rights reserved.
            </p>

        </div>

    </footer>



    {{-- =========================
         JAVASCRIPT
    ========================= --}}

    <script>

        const quantity = document.getElementById('quantity');
        const minusBtn = document.getElementById('btn-minus');
        const plusBtn = document.getElementById('btn-plus');

        const maxStock = quantity
            ? Number(quantity.max)
            : 0;

        const hiddenInputs =
            document.querySelectorAll('.qty-hidden');

        const stockMessage =
            document.getElementById('stock-message');


        // Cập nhật số lượng
        function updateQuantity() {

            if (!quantity) {
                return;
            }

            let value = Number(quantity.value);


            // Không nhỏ hơn 1
            if (value < 1) {
                value = 1;
                quantity.value = 1;
            }


            // Không vượt tồn kho
            if (value > maxStock) {
                value = maxStock;
                quantity.value = maxStock;
            }


            // Đồng bộ số lượng cho các form
            hiddenInputs.forEach(function(input) {

                input.value = value;

            });


            // Nút giảm
            if (value <= 1) {

                minusBtn.disabled = true;

            } else {

                minusBtn.disabled = false;

            }


            // Nút tăng
            if (value >= maxStock) {

                plusBtn.disabled = true;

            } else {

                plusBtn.disabled = false;

            }

        }


        // GIẢM SỐ LƯỢNG
        minusBtn?.addEventListener(
            'click',
            function() {

                let value =
                    Number(quantity.value);

                if (value > 1) {

                    quantity.value =
                        value - 1;

                    updateQuantity();

                }

            }
        );


        // TĂNG SỐ LƯỢNG
        plusBtn?.addEventListener(
            'click',
            function() {

                let value =
                    Number(quantity.value);

                if (value < maxStock) {

                    quantity.value =
                        value + 1;

                    updateQuantity();

                } else {

                    if (stockMessage) {

                        stockMessage.textContent =
                            'Không đủ số lượng sản phẩm trong kho.';

                        stockMessage.style.display =
                            'block';

                    }

                }

            }
        );


        // Khởi tạo
        updateQuantity();

    </script>

</body>

</html>