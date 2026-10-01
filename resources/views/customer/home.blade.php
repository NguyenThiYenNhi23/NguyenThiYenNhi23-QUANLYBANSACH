<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nhà xuất bản Kim Đồng</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: 1200px;
            max-width: 95%;
            margin: auto;
        }


        /* =========================
           HEADER
        ========================= */

        .header {
            background: white;
            border-bottom: 1px solid #ddd;
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

        .search-box {
            flex: 1;

            display: flex;
            height: 42px;
        }

        .search-box input {
            flex: 1;

            border: 1px solid #ddd;
            border-right: none;

            padding: 0 15px;

            font-size: 14px;

            border-radius: 5px 0 0 5px;
        }

        .search-box button {
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

        .header-actions a:hover {
            color: #d71920;
        }


        /* =========================
           MENU
        ========================= */

        .menu {
            border-top: 1px solid #eee;
        }

        .menu ul {
            height: 50px;

            display: flex;
            align-items: center;

            list-style: none;

            gap: 40px;
        }

        .menu a {
            font-size: 15px;
            font-weight: 500;
        }

        .menu a:hover {
            color: #d71920;
        }


        /* =========================
           GIỚI THIỆU
        ========================= */

        .intro {
            text-align: center;

            padding: 60px 20px;
        }

        .intro h1 {
            font-size: 30px;
            margin-bottom: 15px;
        }

        .intro p {
            max-width: 750px;

            margin: auto;

            line-height: 1.7;

            color: #666;
        }

        /* =========================
           BANNER / SLIDER TRANG CHỦ
        ========================= */

        .hero-slider {
            position: relative;
            overflow: hidden;
            margin: 30px 0 10px;
            border-radius: 18px;
            background: #fff5f5;
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.08);
        }

        .hero-track {
            display: flex;
            transition: transform 0.55s ease;
        }

        .hero-slide {
            min-width: 100%;
            position: relative;
            min-height: 330px;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 45px 80px;
        }

        .hero-slide:nth-child(1) {
            background: linear-gradient(120deg, #fff4f4 0%, #ffe1e1 100%);
        }

        .hero-slide:nth-child(2) {
            background: linear-gradient(120deg, #fff9ed 0%, #ffe8c2 100%);
        }

        .hero-slide:nth-child(3) {
            background: linear-gradient(120deg, #f3f8ff 0%, #dfeeff 100%);
        }

        .hero-content {
            width: 58%;
            position: relative;
            z-index: 2;
        }

        .hero-label {
            display: inline-block;
            margin-bottom: 12px;
            padding: 7px 13px;
            border-radius: 999px;
            background: #d71920;
            color: white;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.3px;
        }

        .hero-content h1 {
            margin: 0 0 14px;
            font-size: 34px;
            line-height: 1.2;
            color: #222;
        }

        .hero-content p {
            margin: 0;
            max-width: 590px;
            color: #555;
            font-size: 16px;
            line-height: 1.7;
        }

        .hero-button {
            display: inline-block;
            margin-top: 22px;
            padding: 11px 20px;
            border-radius: 7px;
            background: #d71920;
            color: white;
            font-size: 14px;
            font-weight: bold;
            transition: 0.2s;
        }

        .hero-button:hover {
            background: #b9141a;
            transform: translateY(-2px);
        }

        /* Minh họa sách bằng CSS, không cần file ảnh riêng */
        .hero-books {
            position: absolute;
            right: 70px;
            bottom: 0;
            width: 310px;
            height: 270px;
        }

        .hero-book {
            position: absolute;
            width: 125px;
            height: 175px;
            border-radius: 7px 9px 9px 7px;
            box-shadow: 0 12px 22px rgba(0,0,0,0.16);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            color: white;
            border-left: 7px solid rgba(0,0,0,0.12);
        }

        .hero-book span {
            font-size: 18px;
            line-height: 1.25;
        }

        .hero-book.one {
            right: 125px;
            bottom: 20px;
            background: #d71920;
            transform: rotate(-10deg);
        }

        .hero-book.two {
            right: 35px;
            bottom: 28px;
            background: #2f6fb0;
            transform: rotate(8deg);
        }

        .hero-book.three {
            right: 82px;
            bottom: 72px;
            background: #f0a323;
            transform: rotate(1deg);
            z-index: 2;
        }

        .hero-dots {
            position: absolute;
            left: 50%;
            bottom: 17px;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 5;
        }

        .hero-dot {
            width: 9px;
            height: 9px;
            border: none;
            border-radius: 50%;
            padding: 0;
            background: rgba(0,0,0,0.22);
            cursor: pointer;
            transition: 0.2s;
        }

        .hero-dot.active {
            width: 24px;
            border-radius: 10px;
            background: #d71920;
        }

        .hero-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 50%;
            background: rgba(255,255,255,0.88);
            color: #333;
            font-size: 24px;
            line-height: 38px;
            cursor: pointer;
            z-index: 5;
            box-shadow: 0 3px 10px rgba(0,0,0,0.12);
            transition: 0.2s;
        }

        .hero-arrow:hover {
            background: white;
            color: #d71920;
        }

        .hero-prev {
            left: 18px;
        }

        .hero-next {
            right: 18px;
        }

        @media (max-width: 900px) {
            .hero-slide {
                min-height: 360px;
                padding: 35px 55px;
            }

            .hero-content {
                width: 70%;
            }

            .hero-content h1 {
                font-size: 28px;
            }

            .hero-books {
                right: 20px;
                opacity: 0.32;
            }
        }

        @media (max-width: 600px) {
            .hero-slide {
                min-height: 380px;
                padding: 35px 35px 55px;
            }

            .hero-content {
                width: 100%;
            }

            .hero-content h1 {
                font-size: 25px;
            }

            .hero-content p {
                font-size: 14px;
            }

            .hero-books {
                right: -55px;
                opacity: 0.18;
            }

            .hero-arrow {
                width: 32px;
                height: 32px;
                line-height: 32px;
                font-size: 19px;
            }
        }


        /* =========================
           SECTION
        ========================= */

        .section {
            padding: 35px 0;
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 25px;
        }

        .section-title h2 {
            font-size: 24px;
        }


        /* =========================
           BOOK GRID
        ========================= */

        .book-grid {
            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 25px;
        }


        /* =========================
           BOOK CARD
        ========================= */

        .book-card {
            background: white;

            border: 1px solid #eee;

            border-radius: 8px;

            overflow: hidden;

            transition: 0.2s;
        }

        .book-card-link {
            display: block;
            color: inherit;
        }

        .book-card:hover {
            transform: translateY(-3px);

            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .book-image {
            height: 270px;

            background: #f5f5f5;

            display: flex;

            justify-content: center;

            align-items: center;
        }

        .book-image img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }

        .no-image {
            color: #999;
            font-size: 14px;
        }

        .book-info {
            padding: 15px;
        }

        .book-name {
            font-size: 16px;

            font-weight: bold;

            line-height: 1.4;

            min-height: 45px;

            display: -webkit-box;

            -webkit-line-clamp: 2;

            -webkit-box-orient: vertical;

            overflow: hidden;
        }

        .book-price {
            margin-top: 10px;

            color: #d71920;

            font-size: 17px;

            font-weight: bold;
        }

        .book-stock {
            margin-top: 7px;

            font-size: 13px;

            color: #777;
        }

        .sold {
            margin-top: 5px;

            font-size: 13px;

            color: #777;
        }


        /* =========================
           CONTACT
        ========================= */

        .contact {
            background: #f8f8f8;

            padding: 50px 0;

            margin-top: 30px;
        }

        .contact-content {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 40px;
        }

        .contact h2 {
            margin-bottom: 15px;
        }

        .contact p {
            line-height: 1.8;

            color: #666;
        }


        /* =========================
           FOOTER
        ========================= */

        .footer {
            background: #222;

            color: white;

            padding: 30px 0;

            text-align: center;
        }

        .footer p {
            margin-top: 8px;

            color: #ccc;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .book-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .header-top {
                height: auto;

                padding: 15px 0;

                flex-wrap: wrap;
            }

            .search-box {
                width: 100%;
            }

        }

    </style>

</head>


<body>

@php
    $items = session('cart', []);

    $cartCount = collect($items)
        ->sum(fn ($item) => (int) ($item['soLuong'] ?? 0));

    $total = collect($items)
        ->sum(function ($item) {
            return (int) ($item['soLuong'] ?? 0)
                * (float) ($item['giaBan'] ?? 0);
        });
@endphp

<!-- =========================
     HEADER
========================= -->

<header class="header">

    <div class="container">

        <div class="header-top">

            <div class="logo">
                KIM ĐỒNG
            </div>


            <form action="{{ route('customer.search') }}"
                method="GET"
                class="search-box">

                <input
                    type="text"
                    name="q"
                    placeholder="Tìm kiếm sách..."
                >

                <button type="submit">
                    🔍
                </button>

            </form>


            <div class="header-actions">

                @auth
                    <a href="{{ route('customer.account') }}">
                        {{ auth()->user()->name }}
                    </a>
                @else
                    <a href="{{ route('login') }}">
                        Đăng nhập
                    </a>
                @endauth

                @if (Auth::check())
                    {{-- Đã đăng nhập --}}
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit"
                                style="background:none;border:none;color:#1f2937;padding:0;font:inherit;cursor:pointer;">
                            Đăng xuất
                        </button>
                    </form>
                @else
                    {{-- Chưa đăng nhập --}}
                    <a href="{{ route('register') }}"
                    style="color:#1f2937;text-decoration:none;padding:0;font:inherit;cursor:pointer;">
                        Đăng ký
                    </a>
                @endif
                <a href="javascript:void(0);" id="cartToggle">
    🛒 Giỏ hàng
    @if ($cartCount > 0)
        <span class="cart-badge">{{ $cartCount }}</span>
    @endif
</a>
            </div>

        </div>


        <!-- MENU -->

        <nav class="menu">

            <ul>

                <li>
                    <a href="{{ route('customer.home') }}">
                        Trang chủ
                    </a>
                </li>

                <li>
                    <a href="{{ route('customer.danhmuc') }}">Danh mục</a>
                </li>

                <li>
                    <a href="{{ route('customer.gioithieu') }}">Giới thiệu</a>
                </li>

            </ul>

        </nav>

    </div>

</header>

@include('customer.partials.cart-popup')

<main>


<!-- =========================
     GIỚI THIỆU
========================= -->

<section class="container">
    <div class="hero-slider" id="heroSlider">

        <div class="hero-track" id="heroTrack">

            <div class="hero-slide">
                <div class="hero-content">
                    <span class="hero-label">KIM ĐỒNG</span>
                    <h1>Khám phá thế giới sách</h1>
                    <p>
                        Những câu chuyện thú vị dành cho thiếu nhi,
                        thanh thiếu niên và những người yêu sách.
                    </p>
                    <a href="{{ route('customer.danhmuc') }}" class="hero-button">
                        Khám phá sách
                    </a>
                </div>

                <div class="hero-books" aria-hidden="true">
                    <div class="hero-book one"><span>Thế giới<br>sách</span></div>
                    <div class="hero-book two"><span>Truyện<br>hay</span></div>
                    <div class="hero-book three"><span>Kim<br>Đồng</span></div>
                </div>
            </div>

            <div class="hero-slide">
                <div class="hero-content">
                    <span class="hero-label">DÀNH CHO BẠN</span>
                    <h1>Mỗi trang sách, một câu chuyện</h1>
                    <p>
                        Tìm kiếm những cuốn sách phù hợp với sở thích
                        và khám phá thêm nhiều tác phẩm thú vị.
                    </p>
                    <a href="{{ route('customer.danhmuc') }}" class="hero-button">
                        Xem danh mục
                    </a>
                </div>

                <div class="hero-books" aria-hidden="true">
                    <div class="hero-book one"><span>Đọc<br>sách</span></div>
                    <div class="hero-book two"><span>Khám<br>phá</span></div>
                    <div class="hero-book three"><span>Cùng<br>đọc</span></div>
                </div>
            </div>

            <div class="hero-slide">
                <div class="hero-content">
                    <span class="hero-label">KIM ĐỒNG</span>
                    <h1>Đọc sách và khám phá điều mới</h1>
                    <p>
                        Chọn một cuốn sách, bắt đầu một hành trình
                        và tìm cho mình những câu chuyện đáng nhớ.
                    </p>
                    <a href="{{ route('customer.danhmuc') }}" class="hero-button">
                        Xem sách ngay
                    </a>
                </div>

                <div class="hero-books" aria-hidden="true">
                    <div class="hero-book one"><span>Ước<br>mơ</span></div>
                    <div class="hero-book two"><span>Hành<br>trình</span></div>
                    <div class="hero-book three"><span>Câu<br>chuyện</span></div>
                </div>
            </div>

        </div>

        <button type="button" class="hero-arrow hero-prev" id="heroPrev" aria-label="Slide trước">
            ‹
        </button>

        <button type="button" class="hero-arrow hero-next" id="heroNext" aria-label="Slide tiếp theo">
            ›
        </button>

        <div class="hero-dots" id="heroDots">
            <button type="button" class="hero-dot active" data-slide="0" aria-label="Slide 1"></button>
            <button type="button" class="hero-dot" data-slide="1" aria-label="Slide 2"></button>
            <button type="button" class="hero-dot" data-slide="2" aria-label="Slide 3"></button>
        </div>

    </div>
</section>

<!-- =========================
     GIỎ HÀNG HIỆN TRÊN TRANG CHỦ
========================= -->

<!-- =========================
     SÁCH NỔI BẬT
========================= -->

<section class="section">

    <div class="container">

        <div class="section-title">

            <h2>
                Sách nổi bật
            </h2>

        </div>


        <div class="book-grid">

            @forelse ($sachNoiBat as $sach)

                <a href="{{ route('customer.book.show', $sach->maSach) }}" class="book-card-link">
                    <div class="book-card">

                        <div class="book-image">

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


                        <div class="book-info">

                            <div class="book-name">
                                {{ $sach->tenSach }}
                            </div>


                            <div class="book-price">

                                {{ number_format(
                                    $sach->giaBan,
                                    0,
                                    ',',
                                    '.'
                                ) }} đ

                            </div>


                            @if ($sach->tonKho)

                                <div class="book-stock">

                                    @if ($sach->tonKho->soLuongTon > 0)

                                        Còn hàng:
                                        {{ $sach->tonKho->soLuongTon }}

                                    @else

                                        Hết hàng

                                    @endif

                                </div>

                            @endif

                        </div>

                    </div>
                </a>

            @empty

                <p>
                    Chưa có sách nổi bật.
                </p>

            @endforelse

        </div>

    </div>

</section>



<!-- =========================
     SÁCH BÁN CHẠY
========================= -->

<section class="section">

    <div class="container">

        <div class="section-title">

            <h2>
                Sách bán chạy
            </h2>

        </div>


        <div class="book-grid">

            @forelse ($sachBanChay as $sach)

                <a href="{{ route('customer.book.show', $sach->maSach) }}" class="book-card-link">
                    <div class="book-card">

                        <div class="book-image">

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


                        <div class="book-info">

                            <div class="book-name">
                                {{ $sach->tenSach }}
                            </div>


                            <div class="book-price">

                                {{ number_format(
                                    $sach->giaBan,
                                    0,
                                    ',',
                                    '.'
                                ) }} đ

                            </div>


                            <div class="sold">

                                Đã bán:
                                {{ $sach->tongDaBan }}
                                cuốn

                            </div>


                            @if ($sach->tonKho)

                                <div class="book-stock">

                                    @if ($sach->tonKho->soLuongTon > 0)

                                        Còn hàng:
                                        {{ $sach->tonKho->soLuongTon }}

                                    @else

                                        Hết hàng

                                    @endif

                                </div>

                            @endif

                        </div>

                    </div>
                </a>

            @empty

                <p>
                    Chưa có dữ liệu bán hàng.
                </p>

            @endforelse

        </div>

    </div>

</section>



<!-- =========================
     SÁCH MỚI
========================= -->

<section class="section">

    <div class="container">

        <div class="section-title">

            <h2>
                Sách mới
            </h2>

        </div>


        <div class="book-grid">

            @forelse ($sachMoi as $sach)

                <a href="{{ route('customer.book.show', $sach->maSach) }}" class="book-card-link">
                    <div class="book-card">

                        <div class="book-image">

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


                        <div class="book-info">

                            <div class="book-name">
                                {{ $sach->tenSach }}
                            </div>


                            <div class="book-price">

                                {{ number_format(
                                    $sach->giaBan,
                                    0,
                                    ',',
                                    '.'
                                ) }} đ

                            </div>


                            @if ($sach->tonKho)

                                <div class="book-stock">

                                    @if ($sach->tonKho->soLuongTon > 0)

                                        Còn hàng:
                                        {{ $sach->tonKho->soLuongTon }}

                                    @else

                                        Hết hàng

                                    @endif

                                </div>

                            @endif

                        </div>

                    </div>
                </a>

            @empty

                <p>
                    Chưa có sách mới.
                </p>

            @endforelse

        </div>

    </div>

</section>



<!-- =========================
     LIÊN HỆ
========================= -->

<section class="contact">

    <div class="container">

        <div class="contact-content">

            <div>

                <h2>
                    Nhà xuất bản Kim Đồng
                </h2>

                <p>
                    Nhà xuất bản chuyên cung cấp
                    các đầu sách dành cho thiếu nhi,
                    thanh thiếu niên và độc giả yêu sách.
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

</main>



<!-- =========================
     FOOTER
========================= -->

<footer class="footer">

    <div class="container">

        <strong>
            NHÀ XUẤT BẢN KIM ĐỒNG
        </strong>

        <p>
            © 2026. All rights reserved.
        </p>

    </div>

</footer>



<script>
/*
 * ĐỒNG BỘ SỐ LƯỢNG GIỎ HÀNG TRÊN TRANG CHỦ
 *
 * Trang chủ đôi khi được Safari lấy lại từ cache nên $cartCount
 * có thể là số cũ (ví dụ 0), trong khi session hiện tại đã là 2/4/5.
 *
 * Vì vậy khi mở trang chủ, lấy lại chính trang từ server với
 * cache: no-store rồi đọc cart-badge mới nhất.
 */
(function () {

    async function syncHomeCartBadge() {

        try {

            const url = new URL(window.location.href);

            url.searchParams.set(
                '_cart_sync',
                Date.now().toString()
            );

            const response = await fetch(
                url.toString(),
                {
                    method: 'GET',
                    cache: 'no-store',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Cache-Control': 'no-cache'
                    }
                }
            );

            if (!response.ok) {
                return;
            }

            const html = await response.text();

            const parser = new DOMParser();

            const doc = parser.parseFromString(
                html,
                'text/html'
            );

            const serverBadge =
                doc.querySelector('.cart-badge');

            const badges =
                document.querySelectorAll('.cart-badge');

            let count = 0;

            if (serverBadge) {
                count = parseInt(
                    serverBadge.textContent.trim(),
                    10
                ) || 0;
            }

            badges.forEach(function (badge) {

                badge.textContent = count;

                badge.style.display =
                    count > 0 ? '' : 'none';

            });

        } catch (error) {

            console.error(
                'Không thể đồng bộ số lượng giỏ hàng:',
                error
            );

        }

    }

    /*
     * Chạy ngay khi Trang chủ mở.
     */
    if (
        document.readyState === 'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            syncHomeCartBadge
        );

    } else {

        syncHomeCartBadge();

    }

    /*
     * Nếu Safari khôi phục Trang chủ từ bộ nhớ (bfcache),
     * đồng bộ lại lần nữa.
     */
    window.addEventListener(
        'pageshow',
        function (event) {

            if (event.persisted) {
                syncHomeCartBadge();
            }

        }
    );

})();
</script>

</body>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const heroTrack = document.getElementById('heroTrack');
    const heroDots = document.querySelectorAll('.hero-dot');
    const heroPrev = document.getElementById('heroPrev');
    const heroNext = document.getElementById('heroNext');

    if (heroTrack && heroDots.length && heroPrev && heroNext) {

        let currentSlide = 0;
        let autoSlide;

        function showSlide(index) {
            currentSlide = (index + heroDots.length) % heroDots.length;

            heroTrack.style.transform =
                'translateX(-' + (currentSlide * 100) + '%)';

            heroDots.forEach(function (dot, i) {
                dot.classList.toggle('active', i === currentSlide);
            });
        }

        function startAutoSlide() {
            clearInterval(autoSlide);

            autoSlide = setInterval(function () {
                showSlide(currentSlide + 1);
            }, 5000);
        }

        heroNext.addEventListener('click', function () {
            showSlide(currentSlide + 1);
            startAutoSlide();
        });

        heroPrev.addEventListener('click', function () {
            showSlide(currentSlide - 1);
            startAutoSlide();
        });

        heroDots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                showSlide(Number(dot.dataset.slide));
                startAutoSlide();
            });
        });

        startAutoSlide();
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const cartToggle = document.getElementById('cartToggle');
    const cartPanel = document.getElementById('cartPanel');
    const closeCart = document.getElementById('closeCart');

    /*
     * BẤM ICON GIỎ HÀNG
     */
    if (cartToggle && cartPanel) {

        cartToggle.addEventListener('click', function () {

            cartPanel.classList.toggle('show');

            if (cartPanel.classList.contains('show')) {

                cartPanel.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

            }

        });

    }


    /*
     * TIẾP TỤC MUA HÀNG
     */
    if (closeCart && cartPanel) {

        closeCart.addEventListener('click', function () {

            cartPanel.classList.remove('show');

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

        });

    }


    /*
     * FORMAT TIỀN
     */
    const formatVND = value => {

        return new Intl.NumberFormat('vi-VN').format(value) + '₫';

    };


    /*
     * TÍNH LẠI TỔNG
     */
    function updateTotals() {

        const rows =
            document.querySelectorAll('.cart-panel-item');

        let count = 0;
        let selectedTotal = 0;


        rows.forEach(row => {

            const price =
                Number(row.dataset.price || 0);

            const qtyInput =
                row.querySelector('.qty-value');

            const qty =
                Number(qtyInput?.value || 0);

            const total =
                price * qty;

            const checkbox =
                row.querySelector('.item-select');


            const totalElement =
                row.querySelector('.total-price');

            if (totalElement) {

                totalElement.textContent =
                    formatVND(total);

            }


            count += qty;


            if (checkbox && checkbox.checked) {

                selectedTotal += total;

            }

        });


        const totalDisplay =
            document.getElementById(
                'selected-total-display'
            );

        if (totalDisplay) {

            totalDisplay.textContent =
                formatVND(selectedTotal);

        }


        const badge =
            document.querySelector('.cart-badge');

        if (badge) {

            badge.textContent = count;

        }

    }


    /*
     * CHỌN TẤT CẢ
     */
    const selectAll =
        document.getElementById(
            'select-all-items'
        );


    if (selectAll) {

        selectAll.addEventListener(
            'change',
            function () {

                document
                    .querySelectorAll('.item-select')
                    .forEach(checkbox => {

                        checkbox.checked =
                            selectAll.checked;

                    });

                updateTotals();

            }
        );

    }


    /*
     * CHỌN TỪNG SẢN PHẨM
     */
    document
        .querySelectorAll('.item-select')
        .forEach(checkbox => {

            checkbox.addEventListener(
                'change',
                function () {

                    updateTotals();

                }
            );

        });


    /*
     * TĂNG / GIẢM / XÓA
     */
    document
        .querySelectorAll(
            '.cart-panel [data-action]'
        )
        .forEach(button => {

            button.addEventListener(
                'click',
                async function () {

                    const row =
                        button.closest(
                            '.cart-panel-item'
                        );

                    if (!row) return;


                    const maSach =
                        row.dataset.maSach;

                    const action =
                        button.dataset.action;


                    try {

                        const response =
                            await fetch(
                                '{{ route('customer.cart.update') }}',
                                {
                                    method: 'POST',

                                    headers: {
                                        'Content-Type':
                                            'application/json',

                                        'Accept':
                                            'application/json',

                                        'X-CSRF-TOKEN':
                                            '{{ csrf_token() }}'
                                    },

                                    body: JSON.stringify({
                                        maSach: maSach,
                                        action: action
                                    })
                                }
                            );


                        const data =
                            await response.json();


                        if (!data.success) {

                            alert(
                                data.message ||
                                'Không thể cập nhật giỏ hàng.'
                            );

                            return;

                        }


                        /*
                         * XÓA
                         */
                        if (action === 'remove') {

                            row.remove();

                        }

                        /*
                         * TĂNG / GIẢM
                         */
                        else {

                            const input =
                                row.querySelector(
                                    '.qty-value'
                                );

                            const current =
                                Number(
                                    input.value || 0
                                );

                            const next =
                                action === 'plus'
                                    ? current + 1
                                    : current - 1;


                            if (next <= 0) {

                                row.remove();

                            } else {

                                input.value = next;

                            }

                        }


                        /*
                         * NẾU HẾT SẢN PHẨM
                         */
                        const remaining =
                            document.querySelectorAll(
                                '.cart-panel-item'
                            );


                        if (remaining.length === 0) {

                            location.reload();

                            return;

                        }


                        updateTotals();


                        /*
                         * CẬP NHẬT BADGE
                         */
                        const badge =
                            document.querySelector(
                                '.cart-badge'
                            );

                        if (
                            badge &&
                            data.cartCount !== undefined
                        ) {

                            badge.textContent =
                                data.cartCount;

                        }

                    }

                    catch (error) {

                        console.error(error);

                        alert(
                            'Không thể cập nhật giỏ hàng.'
                        );

                    }

                }
            );

        });


    /*
     * TÍNH TỔNG BAN ĐẦU
     */
    updateTotals();

});
</script>
</html>