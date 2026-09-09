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

                <a href="{{ route('login') }}">
                    Đăng nhập
                </a>

                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:#1f2937;padding:0;font:inherit;cursor:pointer;">
                        Đăng xuất
                    </button>
                </form>
                <a href="#">
                    🛒 Giỏ hàng
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



<main>


<!-- =========================
     GIỚI THIỆU
========================= -->

<section
    class="intro"
    id="gioi-thieu"
>

    <div class="container">

        <h1>
            Chào mừng đến với Nhà xuất bản Kim Đồng
        </h1>

        <p>
            Khám phá những cuốn sách hay dành cho
            thiếu nhi, thanh thiếu niên và độc giả
            yêu thích sách.
        </p>

    </div>

</section>



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


</body>

</html>