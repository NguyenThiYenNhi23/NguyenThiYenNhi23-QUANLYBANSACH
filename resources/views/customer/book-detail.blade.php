<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $sach->tenSach }} - Nhà xuất bản Kim Đồng</title>

    @php
        $soLuongTon = max(0, (int) ($sach->tonKho->soLuongTon ?? 0));
    @endphp

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f7f7f7;
            color: #222;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* =====================================================
           HEADER
        ===================================================== */

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

        .cart-badge {
            min-width: 20px;
            height: 20px;
            padding: 0 5px;
            border-radius: 50%;
            background: #d71920;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
        }

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


        /* =====================================================
           TRANG CHI TIẾT SÁCH
        ===================================================== */

        .page {
            padding: 25px 0 45px;
        }

        .container {
            width: 1200px;
            max-width: 92%;
            margin: 0 auto;
        }


        /* =========================
           BREADCRUMB
        ========================= */

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #777;
        }

        .breadcrumb a {
            color: #d71920;
            font-weight: 600;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb .current {
            color: #777;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }


        /* =========================
           THÔNG BÁO
        ========================= */

        .alert {
            background: #fff4f4;
            color: #b91c1c;
            border: 1px solid #fecaca;
            border-left: 4px solid #d71920;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }


        /* =====================================================
           KHỐI SẢN PHẨM
        ===================================================== */

        .product-layout {
            display: grid;
            grid-template-columns: 44% 56%;
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
        }


        /* =====================================================
           BÊN TRÁI - HÌNH SÁCH
        ===================================================== */

        .gallery-panel {
            padding: 20px;
            background: #fafafa;
            border-right: 1px solid #eeeeee;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-image {
            width: 100%;
            max-width: 410px;
            height: 540px;
            background: #fff;
            border: 1px solid #e6e6e6;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .main-image::before {
            content: "KIM ĐỒNG";
            position: absolute;
            top: 12px;
            left: 12px;
            background: #d71920;
            color: white;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.5px;
            z-index: 2;
        }

        .main-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .no-image {
            font-size: 15px;
            color: #999;
        }


        /* =====================================================
           BÊN PHẢI - THÔNG TIN SÁCH
        ===================================================== */

        .product-content {
            padding: 50px 42px;
        }

        .badge {
            display: inline-block;
            background: #d71920;
            color: white;
            padding: 7px 13px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .product-title {
            margin: 0 0 18px;
            font-size: 30px;
            line-height: 1.3;
            font-weight: 700;
            color: #222;
        }

        .price {
            color: #d71920;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 28px;
        }


        /* =====================================================
           MUA HÀNG
        ===================================================== */

        .purchase-row {
            margin-top: 10px;
            padding-top: 25px;
            border-top: 1px solid #eee;
        }

        .quantity-label {
            display: block;
            margin-bottom: 9px;
            font-size: 14px;
            font-weight: 700;
            color: #333;
        }

        .quantity-box {
            display: inline-flex;
            align-items: center;
            height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            background: #fff;
            margin-bottom: 18px;
            overflow: hidden;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: #f5f5f5;
            color: #333;
            font-size: 18px;
            cursor: pointer;
        }

        .qty-btn:hover:not(:disabled) {
            background: #eeeeee;
            color: #d71920;
        }

        .qty-btn:disabled {
            color: #bbb;
            cursor: not-allowed;
        }

        .qty-input {
            width: 65px;
            height: 40px;
            border: none;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            color: #333;
            background: white;
            outline: none;
        }

        .qty-input:focus {
            outline: none;
        }

        /* Bỏ mũi tên mặc định */

        .qty-input::-webkit-outer-spin-button,
        .qty-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .qty-input[type=number] {
            -moz-appearance: textfield;
        }

        .action-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            min-height: 45px;
            border: none;
            border-radius: 5px;
            padding: 0 22px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn:hover:not(:disabled) {
            transform: translateY(-1px);
        }

        .btn-cart {
            background: #fff;
            color: #d71920;
            border: 1px solid #d71920;
        }

        .btn-cart:hover {
            background: #fff4f4;
        }

        .btn-buy {
            background: #d71920;
            color: #fff;
            box-shadow: 0 4px 10px rgba(215, 25, 32, 0.2);
        }

        .btn-buy:hover {
            background: #b9151b;
        }

        .btn-disabled {
            background: #999;
            color: white;
            cursor: not-allowed;
            min-width: 120px;
        }

        .btn-disabled:hover {
            transform: none;
        }

        .stock-message {
            margin-top: 10px;
            color: #d71920;
            font-size: 13px;
            font-weight: 600;
            display: none;
        }

        .stock-note {
            margin-top: 12px;
            font-size: 13px;
            color: #777;
        }


        /* =====================================================
           THÔNG TIN MÔ TẢ PHÍA DƯỚI
        ===================================================== */

        .description-box {
            margin-top: 25px;
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 25px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .section-title {
            margin: 0 0 18px;
            padding-bottom: 10px;
            border-bottom: 2px solid #d71920;
            font-size: 19px;
            font-weight: 700;
            color: #222;
            display: inline-block;
        }

        .description {
            margin: 0;
            font-size: 15px;
            line-height: 1.8;
            color: #555;
            white-space: pre-line;
        }


        /* =====================================================
           LIÊN HỆ
        ===================================================== */

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


        /* =====================================================
           FOOTER
        ===================================================== */

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


        /* =====================================================
           RESPONSIVE
        ===================================================== */

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

            .gallery-panel {
                border-right: none;
                border-bottom: 1px solid #eee;
            }

            .main-image {
                max-width: 400px;
                height: 500px;
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

            .product-content {
                padding: 25px 20px;
            }

            .gallery-panel {
                padding: 15px;
            }

            .main-image {
                height: 420px;
            }

            .product-title {
                font-size: 25px;
            }

            .price {
                font-size: 24px;
            }

            .action-group {
                flex-direction: column;
            }

            .action-group form,
            .action-group .btn {
                width: 100%;
            }

            .btn {
                width: 100%;
            }

            .description-box {
                padding: 20px;
            }

            .site-contact-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }
        }
    </style>
</head>

<body>

@php
    $cartItems = session('cart', []);
    $cartCount = collect($cartItems)->sum(fn ($item) => (int) ($item['soLuong'] ?? 0));
@endphp


{{-- =========================================================
     HEADER
========================================================= --}}

<header class="site-header">

    <div class="header-container">

        <div class="header-top">

            <a
                href="{{ route('customer.home') }}"
                class="logo"
            >
                KIM ĐỒNG
            </a>

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

                <a
                    href="{{ route('customer.cart') }}"
                    class="header-link cart-link"
                >

                    <span class="cart-icon">🛒</span>

                    <span>Giỏ hàng</span>

                    @if ($cartCount > 0)

                        <span class="cart-badge">
                            {{ $cartCount }}
                        </span>

                    @endif

                </a>

            </div>

        </div>


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



{{-- =========================================================
     TRANG CHI TIẾT SÁCH
========================================================= --}}

<div class="page">

    <div class="container">

        {{-- BREADCRUMB --}}

        <div class="breadcrumb">

            <a href="{{ route('customer.home') }}">
                Trang chủ
            </a>

            <span>/</span>

            <span class="current">
                {{ $sach->tenSach }}
            </span>

        </div>


        {{-- THÔNG BÁO --}}

        @if (session('success'))

            <div class="alert">
                {{ session('success') }}
            </div>

        @endif


        {{-- =================================================
             THÔNG TIN SẢN PHẨM
        ================================================= --}}

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
                 THÔNG TIN
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


                {{-- =========================
                     MUA HÀNG
                ========================= --}}

                <div class="purchase-row">

                    @if ($soLuongTon > 0)

                        <span class="quantity-label">
                            Số lượng
                        </span>


                        <div class="quantity-box">

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
                                inputmode="numeric"
                            >

                            <button
                                type="button"
                                class="qty-btn"
                                id="btn-plus"
                            >
                                ＋
                            </button>

                        </div>


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
                                    🛒 Thêm vào giỏ hàng
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


                        <div class="stock-note">
                            Còn {{ $soLuongTon }} sản phẩm trong kho
                        </div>


                    @else

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


                    @if ($soLuongTon > 0)

                        <div
                            id="stock-message"
                            class="stock-message"
                        >
                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- =================================================
             THÔNG TIN MÔ TẢ PHÍA DƯỚI
        ================================================= --}}

        <div class="description-box">

            <div class="section-title">
                Thông tin mô tả
            </div>

            <p class="description">
                {{ $sach->moTa ?: 'Chưa có thông tin mô tả chi tiết cho sách này.' }}
            </p>

        </div>

    </div>

</div>



{{-- =========================================================
     LIÊN HỆ
========================================================= --}}

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



{{-- =========================================================
     FOOTER
========================================================= --}}

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



{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

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
    function updateQuantity() {

        if (!quantity) {
            return;
        }
        let value = Number(quantity.value);
        if (!Number.isFinite(value) || value < 1) {
            value = 1;
        }
        if (value > maxStock) {
            value = maxStock;
        }
        quantity.value = value;
        hiddenInputs.forEach(function(input) {
            input.value = value;
        });
        if (value <= 1) {
            minusBtn.disabled = true;
        } else {
            minusBtn.disabled = false;
        }
        if (value >= maxStock) {
            plusBtn.disabled = true;
        } else {
            plusBtn.disabled = false;
        }
        if (stockMessage) {
            if (value >= maxStock) {
                stockMessage.textContent =
                    'Đã đạt số lượng tồn kho.';
                stockMessage.style.display =
                    'block';
            } else {
                stockMessage.textContent = '';
                stockMessage.style.display =
                    'none';
            }
        }
    }
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
    plusBtn?.addEventListener(
        'click',
        function() {
            let value =
                Number(quantity.value);
            if (value < maxStock) {
                quantity.value =
                    value + 1;
                updateQuantity();
            }
        }
    );
    quantity?.addEventListener(
        'input',
        function() {
            let value = Number(this.value);
            if (value > maxStock) {
                this.value = maxStock;
            }
            else if (
                value < 1 &&
                this.value !== ''
            ) {
                this.value = 1;
            }
            updateQuantity();
        }
    );
    quantity?.addEventListener(
        'blur',
        function() {
            if (
                this.value === '' ||
                Number(this.value) < 1
            ) {
                this.value = 1;
            }
            updateQuantity();
        }
    );
    updateQuantity();
</script>
</body>
</html>