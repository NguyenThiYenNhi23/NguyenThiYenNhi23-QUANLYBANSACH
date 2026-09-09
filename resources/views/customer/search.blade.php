<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tìm kiếm sách - Kim Đồng</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff;
            color: #333;
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
            gap: 35px;
            height: 50px;
            align-items: center;
        }

        .menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .menu a:hover {
            color: #d71920;
        }

        /* SEARCH RESULT */
        .search-result {
            padding: 40px 0;
        }

        .search-result h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .result-info {
            color: #666;
            margin-bottom: 30px;
        }

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
            transition: 0.2s;
        }

        .book-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .book-image {
            height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f7f7f7;
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
            margin-bottom: 10px;
            min-height: 40px;
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
            color: #777;
            border: 1px solid #eee;
            border-radius: 8px;
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
                    value="{{ $keyword }}"
                    placeholder="Tìm kiếm sách..."
                >

                <button type="submit">
                    🔍
                </button>

            </form>

            <div class="header-actions">
                <a href="#">
                    Đăng nhập
                </a>

                <a href="#">
                    Đăng xuất
                </a>

                <a href="#">
                    🛒 Giỏ hàng
                </a>
            </div>

        </div>

        <nav class="menu">
            <a href="{{ route('customer.home') }}">
                Trang chủ
            </a>

            <a href="#">
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

        <section class="search-result">

            <h1>
                Tìm kiếm sách
            </h1>

            @if ($keyword !== '')

                <div class="result-info">
                    Kết quả tìm kiếm cho:
                    <strong>"{{ $keyword }}"</strong>
                    — {{ $sachs->count() }} sản phẩm
                </div>

            @else

                <div class="result-info">
                    Hiển thị tất cả sách
                    — {{ $sachs->count() }} sản phẩm
                </div>

            @endif


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
                                        Còn {{ $sach->tonKho->soLuongTon }} sản phẩm
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
                    Không tìm thấy sách phù hợp với từ khóa
                    <strong>"{{ $keyword }}"</strong>.
                </div>

            @endif

        </section>

    </div>
</main>

</body>
</html>