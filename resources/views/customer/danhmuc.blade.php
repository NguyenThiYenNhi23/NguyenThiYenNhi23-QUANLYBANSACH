<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Danh mục sách - Kim Đồng</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #333;
            background: #fff;
        }

        .container {
            width: 1200px;
            max-width: 95%;
            margin: auto;
        }

        /* HEADER */
        header {
            border-bottom: 1px solid #eee;
        }

        .header-top {
            min-height: 80px;
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

        .header-actions a {
            text-decoration: none;
            color: #333;
        }

        /* MENU */
        .menu {
            display: flex;
            align-items: center;
            gap: 35px;
            height: 50px;
        }

        .menu a {
            text-decoration: none;
            color: #333;
        }

        .menu a:hover {
            color: #d71920;
        }

        /* DANH MỤC */
        .category-page {
            padding: 40px 0;
        }

        .page-title {
            font-size: 28px;
            margin-bottom: 30px;
        }

        .category-layout {
            display: grid;
            grid-template-columns: 230px 1fr;
            gap: 35px;
        }

        /* SIDEBAR */
        .sidebar {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            height: fit-content;
        }

        .sidebar h3 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            margin-bottom: 12px;
        }

        .category-list a {
            text-decoration: none;
            color: #444;
        }

        .category-list a:hover {
            color: #d71920;
        }

        .category-list a.active {
            color: #d71920;
            font-weight: bold;
        }

        /* KẾT QUẢ */
        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .result-count {
            color: #666;
        }

        .sort-box select {
            padding: 9px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* SÁCH */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .book-card {
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }

        .book-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .book-image {
            height: 260px;
            background: #f7f7f7;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .book-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .no-image {
            color: #999;
        }

        .book-info {
            padding: 15px;
        }

        .book-name {
            font-size: 16px;
            font-weight: 600;
            min-height: 40px;
            margin-bottom: 10px;
        }

        .book-price {
            color: #d71920;
            font-weight: bold;
            font-size: 17px;
            margin-bottom: 8px;
        }

        .book-stock {
            color: #666;
            font-size: 14px;
        }

        .empty {
            padding: 50px 20px;
            text-align: center;
            border: 1px solid #eee;
            border-radius: 8px;
            color: #777;
        }
    </style>
</head>

<body>

<header>

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

        <nav class="menu">

            <a href="{{ route('customer.home') }}">
                Trang chủ
            </a>

            <a href="{{ route('customer.danhmuc') }}">
                Danh mục
            </a>

            <a href="{{ route('customer.home') }}#gioi-thieu">
                Giới thiệu
            </a>

        </nav>

    </div>

</header>


<main>

    <div class="container">

        <section class="category-page">

            <h1 class="page-title">
                Danh mục sách
            </h1>

            <div class="category-layout">

                {{-- DANH SÁCH DANH MỤC --}}
                <aside class="sidebar">

    <h3>
        Danh mục
    </h3>

    <ul class="category-list">

        {{-- Tất cả danh mục --}}
        <li>
            <a
                href="{{ route('customer.danhmuc', ['gia' => $gia]) }}"
                class="{{ !$maDanhMuc ? 'active' : '' }}"
            >
                Tất cả
            </a>
        </li>

        {{-- Các danh mục từ database --}}
        @foreach ($danhMucs as $danhMuc)

            <li>
                <a
                    href="{{ route('customer.danhmuc', [
                        'maDanhMuc' => $danhMuc->maDanhMuc,
                        'gia' => $gia
                    ]) }}"
                    class="{{ $maDanhMuc == $danhMuc->maDanhMuc ? 'active' : '' }}"
                >
                    {{ $danhMuc->tenDanhMuc }}
                </a>
            </li>

        @endforeach

    </ul>


    <h3 style="margin-top: 30px;">
        Giá
    </h3>

    <ul class="category-list">

        {{-- Tất cả giá --}}
        <li>
            <a
                href="{{ route('customer.danhmuc', ['maDanhMuc' => $maDanhMuc]) }}"
                class="{{ !$gia ? 'active' : '' }}"
            >
                Tất cả
            </a>
        </li>

        {{-- Dưới 50.000 --}}
        <li>
            <a
                href="{{ route('customer.danhmuc', [
                    'maDanhMuc' => $maDanhMuc,
                    'gia' => 'duoi-50000'
                ]) }}"
                class="{{ $gia === 'duoi-50000' ? 'active' : '' }}"
            >
                Dưới 50.000đ
            </a>
        </li>

        {{-- 50.000 - 100.000 --}}
        <li>
            <a
                href="{{ route('customer.danhmuc', [
                    'maDanhMuc' => $maDanhMuc,
                    'gia' => '50000-100000'
                ]) }}"
                class="{{ $gia === '50000-100000' ? 'active' : '' }}"
            >
                50.000đ – 100.000đ
            </a>
        </li>

        {{-- 100.000 - 200.000 --}}
        <li>
            <a
                href="{{ route('customer.danhmuc', [
                    'maDanhMuc' => $maDanhMuc,
                    'gia' => '100000-200000'
                ]) }}"
                class="{{ $gia === '100000-200000' ? 'active' : '' }}"
            >
                100.000đ – 200.000đ
            </a>
        </li>

        {{-- Trên 200.000 --}}
        <li>
            <a
                href="{{ route('customer.danhmuc', [
                    'maDanhMuc' => $maDanhMuc,
                    'gia' => 'tren-200000'
                ]) }}"
                class="{{ $gia === 'tren-200000' ? 'active' : '' }}"
            >
                Trên 200.000đ
            </a>
        </li>

    </ul>

</aside>


                {{-- DANH SÁCH SÁCH --}}
                <section>

                    <div class="result-header">

                        <div class="result-count">

                            @if ($maDanhMuc)

                                @php
                                    $danhMucDangChon = $danhMucs->firstWhere(
                                        'maDanhMuc',
                                        $maDanhMuc
                                    );
                                @endphp

                                @if ($danhMucDangChon)
                                    {{ $danhMucDangChon->tenDanhMuc }}
                                @else
                                    Sách
                                @endif

                            @else

                                Tất cả sách

                            @endif

                            — {{ $sachs->count() }} sản phẩm

                        </div>


                        <div class="sort-box">

                        <form method="GET" action="{{ route('customer.danhmuc') }}">

                            {{-- Giữ lại danh mục đang chọn --}}
                            @if ($maDanhMuc)
                                <input type="hidden" name="maDanhMuc" value="{{ $maDanhMuc }}">
                            @endif

                            {{-- Giữ lại khoảng giá đang chọn --}}
                            @if ($gia)
                                <input type="hidden" name="gia" value="{{ $gia }}">
                            @endif

                            <select name="sort" onchange="this.form.submit()">

                                <option value="name-asc"
                                    {{ $sort === 'name-asc' ? 'selected' : '' }}>
                                    Tên A → Z
                                </option>

                                <option value="newest"
                                    {{ $sort === 'newest' ? 'selected' : '' }}>
                                    Mới nhất
                                </option>

                                <option value="best-selling"
                                    {{ $sort === 'best-selling' ? 'selected' : '' }}>
                                    Bán chạy nhất
                                </option>

                                <option value="price-asc"
                                    {{ $sort === 'price-asc' ? 'selected' : '' }}>
                                    Giá thấp → cao
                                </option>

                                <option value="price-desc"
                                    {{ $sort === 'price-desc' ? 'selected' : '' }}>
                                    Giá cao → thấp
                                </option>

                            </select>

                        </form>

                    </div>

                    </div>


                    @if ($sachs->count() > 0)

                        <div class="book-grid">

                            @foreach ($sachs as $sach)

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
                                            {{ number_format($sach->giaBan, 0, ',', '.') }} đ
                                        </div>

                                        <div class="book-stock">

                                            @if ($sach->tonKho)

                                                Còn
                                                {{ $sach->tonKho->soLuongTon }}
                                                sản phẩm

                                            @else

                                                Chưa có thông tin tồn kho

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="empty">
                            Chưa có sách trong danh mục này.
                        </div>

                    @endif

                </section>

            </div>

        </section>

    </div>

</main>

</body>
</html>