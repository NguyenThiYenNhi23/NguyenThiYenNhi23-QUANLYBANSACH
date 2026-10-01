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
            cursor: pointer;
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
           MÔ TẢ
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
           POPUP GIỎ HÀNG
        ===================================================== */

        .cart-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(0, 0, 0, 0.55);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .cart-modal.show {
            display: flex;
        }

        .cart-modal-box {
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            background: #fff;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            animation: cartModalShow 0.2s ease;
        }

        @keyframes cartModalShow {
            from {
                opacity: 0;
                transform: translateY(-15px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .cart-modal-header {
            min-height: 70px;
            padding: 0 24px;
            background: #ed1c24;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-modal-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 500;
        }

        .cart-success-icon {
            width: 25px;
            height: 25px;
            border: 2px solid #fff;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        .cart-modal-close {
            border: none;
            background: transparent;
            color: #fff;
            font-size: 34px;
            line-height: 1;
            cursor: pointer;
            padding: 0 5px;
        }

        .cart-modal-close:hover {
            opacity: 0.75;
        }

        .cart-modal-body {
            padding: 20px 24px 25px;
        }

        .cart-message {
            font-size: 17px;
            color: #444;
            margin-bottom: 18px;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        .cart-table th {
            height: 44px;
            padding: 10px 12px;
            text-align: left;
            font-size: 14px;
            font-weight: 700;
            color: #333;
            background: #fafafa;
            border-bottom: 1px solid #ddd;
        }

        .cart-table th:not(:first-child) {
            text-align: center;
        }

        .cart-table td {
            padding: 18px 12px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .cart-table td:not(:first-child) {
            text-align: center;
        }

        .cart-product {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .cart-product-image {
            width: 70px;
            height: 90px;
            object-fit: contain;
            border: 1px solid #eee;
            background: #fff;
        }

        .cart-product-name {
            font-size: 15px;
            color: #333;
            font-weight: 500;
            line-height: 1.4;
        }

        .cart-product-remove {
            display: block;
            margin-top: 7px;
            border: none;
            background: none;
            padding: 0;
            color: #999;
            font-size: 13px;
            cursor: pointer;
        }

        .cart-product-remove:hover {
            color: #ed1c24;
        }

        .cart-price {
            color: #ed1c24;
            font-weight: 700;
            white-space: nowrap;
        }

        .cart-quantity {
            display: inline-flex;
            align-items: center;
            border: 1px solid #ddd;
        }

        .cart-quantity button {
            width: 32px;
            height: 32px;
            border: none;
            background: #fff;
            cursor: pointer;
            font-size: 16px;
        }

        .cart-quantity span {
            min-width: 38px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            font-size: 14px;
        }

        .cart-total-row {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 35px;
            margin-top: 22px;
            font-size: 17px;
        }

        .cart-total-price {
            color: #ed1c24;
            font-size: 20px;
            font-weight: 700;
        }

        .cart-modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 22px;
            gap: 20px;
        }

        .cart-continue {
            min-width: 220px;
            height: 48px;
            border: none;
            background: #666;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
        }

        .cart-continue:hover {
            background: #555;
        }

        .cart-checkout {
            min-width: 260px;
            height: 48px;
            border: none;
            background: #ed1c24;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        .cart-checkout:hover {
            background: #c9151c;
        }

        .cart-empty {
            padding: 35px;
            text-align: center;
            color: #777;
            font-size: 16px;
        }

        .cart-loading {
            padding: 45px;
            text-align: center;
            color: #777;
            font-size: 16px;
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

            .cart-modal {
                padding: 10px;
            }

            .cart-modal-box {
                max-height: 95vh;
            }

            .cart-modal-header {
                padding: 0 15px;
            }

            .cart-modal-title {
                font-size: 16px;
            }

            .cart-modal-body {
                padding: 15px;
            }

            .cart-table {
                min-width: 650px;
            }

            .cart-modal-body {
                overflow-x: auto;
            }

            .cart-modal-footer {
                flex-direction: column;
            }

            .cart-continue,
            .cart-checkout {
                width: 100%;
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


                {{-- GIỎ HÀNG --}}
                <a
    href="{{ route('customer.cart') }}"
    class="header-link cart-link"
    data-cart-popup-toggle
>
    <span class="cart-icon">🛒</span>

    <span>Giỏ hàng</span>

    <span
        class="cart-badge"
        id="cart-badge"
        style="{{ $cartCount > 0 ? '' : 'display:none;' }}"
    >
        {{ $cartCount }}
    </span>
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

        <div class="breadcrumb">

            <a href="{{ route('customer.home') }}">
                Trang chủ
            </a>

            <span>/</span>

            <span class="current">
                {{ $sach->tenSach }}
            </span>

        </div>


        @if (session('success'))

            <div class="alert">
                {{ session('success') }}
            </div>

        @endif


        <div class="product-layout">

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

                            {{-- =================================================
                                 THÊM VÀO GIỎ
                                 KHÔNG CHUYỂN TRANG
                            ================================================= --}}

                            <form
                                action="{{ route('customer.cart.add') }}"
                                method="POST"
                                id="add-to-cart-form"
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


                            {{-- =================================================
                                 MUA NGAY
                                 VẪN ĐI THANH TOÁN / GIỎ HÀNG NHƯ CŨ
                            ================================================= --}}

                            <form
                                action="{{ route('customer.cart.buyNow') }}"
                                method="POST"
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
                        ></div>

                    @endif

                </div>

            </div>

        </div>


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
     POPUP GIỎ HÀNG
========================================================= --}}

<div
    class="cart-modal"
    id="cart-modal"
>

    <div class="cart-modal-box">

        <div class="cart-modal-header">

            <div class="cart-modal-title">

                <span class="cart-success-icon">
                    ✓
                </span>

                <span id="cart-modal-message">
                    Bạn đã thêm sản phẩm vào giỏ hàng
                </span>

            </div>

            <button
                type="button"
                class="cart-modal-close"
                id="cart-modal-close"
            >
                ×
            </button>

        </div>


        <div class="cart-modal-body">

            <div class="cart-message">
                Giỏ hàng của bạn hiện có
                <strong id="modal-cart-count">0</strong>
                sản phẩm
            </div>


            <div id="cart-modal-content">

                <div class="cart-loading">
                    Đang tải giỏ hàng...
                </div>

            </div>

        </div>

    </div>

</div>



{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

<script>

    /* =====================================================
       SỐ LƯỢNG SẢN PHẨM
    ===================================================== */

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


        if (minusBtn) {

            minusBtn.disabled = value <= 1;

        }


        if (plusBtn) {

            plusBtn.disabled = value >= maxStock;

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

            let value =
                Number(this.value);

            if (value > maxStock) {

                this.value =
                    maxStock;

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



    /* =====================================================
       POPUP GIỎ HÀNG
    ===================================================== */

    const cartModal =
        document.getElementById('cart-modal');

    const cartModalClose =
        document.getElementById('cart-modal-close');

    const cartModalContent =
        document.getElementById('cart-modal-content');

    const modalCartCount =
        document.getElementById('modal-cart-count');

    const cartModalMessage =
        document.getElementById('cart-modal-message');

    const cartBadge =
        document.getElementById('cart-badge');


    function formatMoney(number) {

        return new Intl.NumberFormat(
            'vi-VN'
        ).format(number) + 'đ';

    }


    function openCartModal() {

        cartModal.classList.add('show');

        document.body.style.overflow =
            'hidden';

    }


    function closeCartModal() {

        cartModal.classList.remove('show');

        document.body.style.overflow =
            '';

    }


    cartModalClose.addEventListener(
        'click',
        closeCartModal
    );


    cartModal.addEventListener(
        'click',
        function(event) {

            if (event.target === cartModal) {

                closeCartModal();

            }

        }
    );


    document.addEventListener(
        'keydown',
        function(event) {

            if (
                event.key === 'Escape' &&
                cartModal.classList.contains('show')
            ) {

                closeCartModal();

            }

        }
    );



    /* =====================================================
       ĐỒNG BỘ TOÀN BỘ GIAO DIỆN GIỎ HÀNG
    ===================================================== */

    function syncCartState(items, cartCount) {

        const safeItems = Array.isArray(items) ? items : [];
        const count = Number.isFinite(Number(cartCount))
            ? Number(cartCount)
            : safeItems.reduce((sum, item) => sum + Number(item.soLuong || 0), 0);

        if (cartBadge) {
            cartBadge.textContent = count;
            cartBadge.style.display = count > 0 ? 'inline-flex' : 'none';
        }

        // Các badge khác trên header nếu có
        document.querySelectorAll(
            '#cart-badge, .cart-badge, [data-cart-count]'
        ).forEach(function(el) {
            el.textContent = count;
            if (el.classList.contains('cart-badge')) {
                el.style.display = count > 0 ? 'inline-flex' : 'none';
            }
        });

        // Báo cho popup giỏ hàng góc phải cập nhật cùng một session cart.
        window.dispatchEvent(new CustomEvent('cart:updated', {
            detail: {
                cartItems: safeItems,
                cartCount: count
            }
        }));
    }


    /* =====================================================
       RENDER GIỎ HÀNG
    ===================================================== */

    function renderCart(items) {

        if (!items || items.length === 0) {

            modalCartCount.textContent = '0';

            if (cartBadge) {
                cartBadge.textContent = '0';
                cartBadge.style.display = 'none';
            }

            cartModalContent.innerHTML = `
                <div class="cart-empty">
                    Giỏ hàng đang trống.
                </div>
            `;

            return;

        }


        let totalQuantity = 0;

        let totalMoney = 0;


        items.forEach(function(item) {

            totalQuantity +=
                Number(item.soLuong || 0);

            totalMoney +=
                Number(item.giaBan || 0) *
                Number(item.soLuong || 0);

        });


        modalCartCount.textContent =
            totalQuantity;


        syncCartState(items, totalQuantity);

        let rows = '';


        items.forEach(function(item) {

            const price =
                Number(item.giaBan || 0);

            const quantity =
                Number(item.soLuong || 0);

            const thanhTien =
                price * quantity;


            let image = '';

            if (item.hinhAnh) {

                if (
                    item.hinhAnh.startsWith('http') ||
                    item.hinhAnh.startsWith('/')
                ) {

                    image = item.hinhAnh;

                } else {

                    image =
                        '/storage/' +
                        item.hinhAnh;

                }

            }


            rows += `

                <tr>

                    <td>

                        <div class="cart-product">

                            ${
                                image
                                ? `
                                    <img
                                        src="${image}"
                                        class="cart-product-image"
                                        alt="${item.tenSach || ''}"
                                    >
                                  `
                                : `
                                    <div
                                        class="cart-product-image"
                                        style="
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                            color:#aaa;
                                            font-size:12px;
                                        "
                                    >
                                        Không có ảnh
                                    </div>
                                  `
                            }


                            <div>

                                <div class="cart-product-name">
                                    ${item.tenSach || ''}
                                </div>

                                <button
                                    type="button"
                                    class="cart-product-remove"
                                    data-action="remove"
                                    data-ma-sach="${item.maSach}"
                                >
                                    Xóa
                                </button>

                            </div>

                        </div>

                    </td>


                    <td>

                        <span class="cart-price">
                            ${formatMoney(price)}
                        </span>

                    </td>


                    <td>

                        <div class="cart-quantity">

                            <button
                                type="button"
                                data-action="minus"
                                data-ma-sach="${item.maSach}"
                            >
                                −
                            </button>

                            <span>
                                ${quantity}
                            </span>

                            <button
                                type="button"
                                data-action="plus"
                                data-ma-sach="${item.maSach}"
                            >
                                +
                            </button>

                        </div>

                    </td>


                    <td>

                        <span class="cart-price">
                            ${formatMoney(thanhTien)}
                        </span>

                    </td>

                </tr>

            `;

        });


        cartModalContent.innerHTML = `

            <table class="cart-table">

                <thead>

                    <tr>

                        <th>
                            Thông tin sản phẩm
                        </th>

                        <th>
                            Đơn giá
                        </th>

                        <th>
                            Số lượng
                        </th>

                        <th>
                            Thành tiền
                        </th>

                    </tr>

                </thead>

                <tbody>

                    ${rows}

                </tbody>

            </table>


            <div class="cart-total-row">

                <span>
                    Tổng tiền:
                </span>

                <strong class="cart-total-price">
                    ${formatMoney(totalMoney)}
                </strong>

            </div>


            <div class="cart-modal-footer">

                <button
                    type="button"
                    class="cart-continue"
                    id="cart-continue"
                >
                    Tiếp tục mua hàng
                </button>


                <button
                    type="button"
                    class="cart-checkout"
                    id="cart-checkout"
                >
                    Thanh toán
                </button>

            </div>

        `;


        document
            .getElementById('cart-continue')
            ?.addEventListener(
                'click',
                closeCartModal
            );


        document
            .getElementById('cart-checkout')
            ?.addEventListener(
                'click',
                function() {

                    window.location.href =
                        "{{ route('customer.checkout', ['source' => 'cart']) }}";

                }
            );

    }



    /* =====================================================
       TĂNG / GIẢM / XÓA SẢN PHẨM TRONG POPUP
    ===================================================== */

    cartModalContent.addEventListener('click', async function(event) {

        const button = event.target.closest('[data-action][data-ma-sach]');

        if (!button) {
            return;
        }

        const action = button.dataset.action;
        const maSach = button.dataset.maSach;

        if (!['plus', 'minus', 'remove'].includes(action) || !maSach) {
            return;
        }

        button.disabled = true;

        try {
            const response = await fetch(
                "{{ route('customer.cart.update') }}",
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        maSach: Number(maSach),
                        action: action
                    }),
                    credentials: 'same-origin'
                }
            );

            const result = await response.json();

            if (!response.ok || !result.success) {
                alert(result.message || 'Không thể cập nhật giỏ hàng.');
                return;
            }

            const cartItems = Array.isArray(result.cartItems)
                ? result.cartItems
                : [];

            syncCartState(cartItems, result.cartCount);
            renderCart(cartItems);

            if (cartItems.length === 0) {
                cartModalMessage.textContent = 'Giỏ hàng của bạn đang trống';
            }

        } catch (error) {
            console.error(error);
            alert('Không thể cập nhật giỏ hàng.');
        } finally {
            button.disabled = false;
        }
    });


    /* =====================================================
       ĐỌC GIỎ HÀNG TỪ TRANG HIỆN TẠI
    ===================================================== */

    function getCartFromHtml(html) {

        const parser =
            new DOMParser();

        const doc =
            parser.parseFromString(
                html,
                'text/html'
            );


        const cartData =
            doc.getElementById('cart-data');


        if (!cartData) {

            return [];

        }


        try {

            return JSON.parse(
                cartData.textContent
            );

        } catch (error) {

            return [];

        }

    }



    /* =====================================================
       THÊM VÀO GIỎ BẰNG AJAX
       KHÔNG CHUYỂN TRANG
    ===================================================== */

    const addToCartForm =
        document.getElementById(
            'add-to-cart-form'
        );


    addToCartForm?.addEventListener(
        'submit',
        async function(event) {

            event.preventDefault();


            const submitButton =
                this.querySelector(
                    'button[type="submit"]'
                );


            const oldText =
                submitButton.innerHTML;


            submitButton.disabled =
                true;

            submitButton.innerHTML =
                '⏳ Đang thêm...';


            try {

                const formData =
                    new FormData(this);


                /*
                 * Gửi request thêm sản phẩm
                 */
                const response =
                    await fetch(
                        this.action,
                        {
                            method: 'POST',

                            body: formData,

                            headers: {
                                'X-Requested-With':
                                    'XMLHttpRequest',

                                'Accept':
                                    'application/json'
                            },

                            credentials:
                                'same-origin'
                        }
                    );


                const result = await response.json();

                if (!response.ok || !result.success) {
                    if (response.status === 401 && result.redirect) {
                        window.location.href = result.redirect;
                        return;
                    }
                    throw new Error(result.message || 'Không thể thêm sản phẩm vào giỏ hàng.');
                }

                const cartItems = Array.isArray(result.cartItems)
                    ? result.cartItems
                    : [];

                syncCartState(cartItems, result.cartCount);


                /*
                 * Nếu server trả cart nhưng
                 * không đọc được dữ liệu thì
                 * vẫn hiển thị popup.
                 */
                if (
                    !Array.isArray(cartItems) ||
                    cartItems.length === 0
                ) {

                    cartModalMessage.textContent =
                        'Đã thêm sản phẩm vào giỏ hàng';

                    cartModalContent.innerHTML = `

                        <div class="cart-empty">

                            Sản phẩm đã được thêm vào giỏ hàng.

                            <br><br>

                            Bạn có thể tiếp tục mua hàng
                            hoặc vào giỏ hàng để thanh toán.

                        </div>

                        <div class="cart-modal-footer">

                            <button
                                type="button"
                                class="cart-continue"
                                id="cart-continue-empty"
                            >
                                Tiếp tục mua hàng
                            </button>

                            <button
                                type="button"
                                class="cart-checkout"
                                id="cart-checkout-empty"
                            >
                                Thanh toán
                            </button>

                        </div>

                    `;


                    document
                        .getElementById(
                            'cart-continue-empty'
                        )
                        ?.addEventListener(
                            'click',
                            closeCartModal
                        );


                    document
                        .getElementById(
                            'cart-checkout-empty'
                        )
                        ?.addEventListener(
                            'click',
                            function() {

                                window.location.href =
                                    "{{ route('customer.checkout', ['source' => 'cart']) }}";

                            }
                        );


                    openCartModal();

                    return;

                }


                /*
                 * Lấy tên sản phẩm vừa thêm
                 */
                const addedName =
                    "{{ addslashes($sach->tenSach) }}";


                cartModalMessage.textContent =
                    'Bạn đã thêm [' +
                    addedName +
                    '] vào giỏ hàng';


                renderCart(cartItems);

                openCartModal();


            } catch (error) {

                console.error(
                    'Lỗi thêm giỏ hàng:',
                    error
                );


                /*
                 * Nếu có lỗi thì cho người dùng
                 * biết thay vì chuyển trang.
                 */
                cartModalMessage.textContent =
                    'Không thể thêm sản phẩm vào giỏ hàng';


                cartModalContent.innerHTML = `

                    <div class="cart-empty">

                        Có lỗi xảy ra khi thêm sản phẩm.
                        <br>
                        Vui lòng thử lại.

                    </div>

                `;


                openCartModal();

            } finally {

                submitButton.disabled =
                    false;

                submitButton.innerHTML =
                    oldText;

            }

        }
    );



    /* =====================================================
       DỮ LIỆU GIỎ HÀNG BAN ĐẦU
       Để popup có thể đọc được session hiện tại
    ===================================================== */

</script>


{{-- =========================================================
     DỮ LIỆU GIỎ HÀNG CHO JAVASCRIPT
========================================================= --}}

<script id="cart-data" type="application/json">
@json(array_values($cartItems))
</script>


@include('customer.partials.cart-popup')

</body>
</html>