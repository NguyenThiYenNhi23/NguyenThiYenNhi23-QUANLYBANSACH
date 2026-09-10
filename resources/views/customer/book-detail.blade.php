<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sach->tenSach }}</title>
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

        .container {
            width: 1200px;
            max-width: 96%;
            margin: 0 auto;
        }

        .page {
            padding: 32px 0 60px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 18px;
            color: #1f4e79;
            font-weight: 700;
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
        }

        .price {
            font-size: 24px;
            font-weight: 800;
            color: #d71920;
            margin-bottom: 10px;
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
            margin-top: 12px;
            padding: 12px 14px;
            border: 1px solid #edf2f7;
            border-radius: 12px;
            background: #fafcff;
            font-size: 15px;
            line-height: 1.6;
            color: #374151;
            white-space: pre-line;
        }

        .section-title {
            margin: 0 0 6px;
            font-size: 20px;
            font-weight: 800;
            color: #111827;
        }

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

        /* Nút hết hàng */
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
            border-radius: 0;
            padding: 0;
            box-shadow: none;
        }

        .site-contact h2 {
            margin-bottom: 15px;
            font-family: Arial, sans-serif;
        }

        .site-contact p {
            line-height: 1.8;
            color: #666;
            font-family: Arial, sans-serif;
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

        @media (max-width: 900px) {
            .product-layout {
                grid-template-columns: 1fr;
            }

            .main-image {
                min-height: 360px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="page">
        <div class="container">

            <a href="{{ route('customer.home') }}" class="back-link">
                ← Quay lại trang chủ
            </a>

            @if (session('success'))
                <div class="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="product-layout">

                <!-- HÌNH ẢNH -->
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


                <!-- THÔNG TIN SÁCH -->
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


                    <!-- KHU VỰC MUA HÀNG -->
                    <div class="purchase-row">

                        @if ($soLuongTon > 0)

                            <!-- CHỌN SỐ LƯỢNG -->
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


                            <!-- CÁC NÚT -->
                            <div class="action-group">

                                <!-- THÊM VÀO GIỎ -->
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


                                <!-- MUA NGAY -->
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

                            <!-- HẾT HÀNG -->
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


                    <!-- THÔNG BÁO TỒN KHO -->
                    @if ($soLuongTon > 0)

                        <div
                            id="stock-message"
                            class="stock-message"
                        >
                        </div>

                    @endif

                </div>

            </div>


            <!-- MÔ TẢ -->
            <div class="description-box">

                <div class="section-title">
                    Thông tin mô tả
                </div>

                {{ $sach->moTa ?: 'Chưa có thông tin mô tả chi tiết cho sách này.' }}

            </div>

        </div>
    </div>


    <!-- LIÊN HỆ -->
    <section class="site-contact">

        <div class="container">

            <div class="site-contact-grid">

                <div>

                    <h2>
                        Nhà xuất bản Kim Đồng
                    </h2>

                    <p>
                        Nhà xuất bản chuyên cung cấp các đầu sách dành cho thiếu nhi,
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


    <!-- FOOTER -->
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


    <!-- JAVASCRIPT -->
    <script>

        const quantity = document.getElementById('quantity');
        const minusBtn = document.getElementById('btn-minus');
        const plusBtn = document.getElementById('btn-plus');

        const maxStock = quantity
            ? Number(quantity.max)
            : 0;

        const hiddenInputs = document.querySelectorAll('.qty-hidden');

        const stockMessage = document.getElementById('stock-message');


        // Cập nhật số lượng vào form
        function updateQuantity() {

            if (!quantity) {
                return;
            }

            const value = Number(quantity.value);


            // Đồng bộ số lượng cho:
            // - Thêm vào giỏ hàng
            // - Mua ngay
            hiddenInputs.forEach(function (input) {

                input.value = value;

            });


            // Không cho giảm dưới 1
            if (value <= 1) {

                minusBtn.disabled = true;

            } else {

                minusBtn.disabled = false;

            }


            // Không cho tăng vượt tồn kho
            if (value >= maxStock) {

                plusBtn.disabled = true;

            } else {

                plusBtn.disabled = false;

            }

        }


        // Nút giảm
        minusBtn?.addEventListener('click', function () {

            let value = Number(quantity.value);

            if (value > 1) {

                quantity.value = value - 1;

                updateQuantity();

            }

        });


        // Nút tăng
        plusBtn?.addEventListener('click', function () {

            let value = Number(quantity.value);


            if (value < maxStock) {

                quantity.value = value + 1;

                updateQuantity();

            } else {

                if (stockMessage) {

                    stockMessage.textContent =
                        'Không đủ số lượng sản phẩm trong kho.';

                    stockMessage.style.display = 'block';

                }

            }

        });


        // Khởi tạo
        updateQuantity();

    </script>

</body>
</html>