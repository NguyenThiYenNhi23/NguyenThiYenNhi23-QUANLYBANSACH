<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Thanh toán</title>

    <style>

        /* =====================================================
           CÀI ĐẶT CHUNG
        ===================================================== */

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
        }

        .page {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .back-link {
            color: #1f4e79;
            text-decoration: none;
            font-weight: 600;
        }

        .layout {
            display: block;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            padding: 24px;
        }

        h1,
        h2,
        h3 {
            margin-top: 0;
        }


        /* =====================================================
           FORM
        ===================================================== */

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        select {
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 12px;
            font-size: 1rem;
            background: #fff;
        }

        select:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.1);
        }


        /* =====================================================
           SẢN PHẨM
        ===================================================== */

        .items {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 16px;
        }

        .item-row {
            display: grid;
            grid-template-columns: 78px 1fr auto;
            gap: 16px;
            align-items: center;

            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 12px;
        }

        .item-image {
            width: 78px;
            height: 92px;
            object-fit: cover;
            border-radius: 12px;
            background: #f3f4f6;
        }

        .item-name {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .price {
            color: #d97706;
            font-weight: 700;
        }


        /* =====================================================
           TÓM TẮT ĐƠN HÀNG
        ===================================================== */

        .summary-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            margin-top: 24px;
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #374151;
            gap: 20px;
        }

        .summary-line.total {
            border-top: 1px solid #d1d5db;
            padding-top: 12px;
            margin-top: 12px;

            font-weight: 700;
            color: #111827;
            font-size: 1.15rem;
        }


        /* =====================================================
           BUTTON
        ===================================================== */

        .btn {
            width: 100%;
            border: none;
            border-radius: 10px;

            padding: 14px 18px;

            font-size: 1rem;
            font-weight: 700;

            cursor: pointer;
            margin-top: 16px;

            background: linear-gradient(
                135deg,
                #f59e0b,
                #d97706
            );

            color: #fff;
        }

        .btn:hover {
            opacity: 0.92;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }


        /* =====================================================
           THÔNG BÁO
        ===================================================== */

        .note {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;

            padding: 14px 16px;
            border-radius: 12px;

            margin-bottom: 20px;
        }


        /* =====================================================
           Ô ĐỊA CHỈ NHẬN HÀNG
        ===================================================== */

        .address-box {
            border: 1px solid #d1d5db;
            border-radius: 12px;

            background: #f8fafc;

            padding: 14px 16px;

            cursor: pointer;

            transition: all 0.2s ease;

            margin-bottom: 18px;
        }

        .address-box:hover {
            border-color: #f59e0b;

            box-shadow:
                0 0 0 2px
                rgba(245, 158, 11, 0.1);
        }

        .address-box .address-title {
            font-weight: 700;
            margin-bottom: 6px;
        }


        /* =====================================================
           POPUP CHUNG
        ===================================================== */

        .address-modal {
            display: none;

            position: fixed;

            z-index: 1000;

            inset: 0;

            background: rgba(0, 0, 0, 0.45);

            align-items: center;
            justify-content: center;

            padding: 20px;
        }

        .address-modal.open {
            display: flex;
        }


        /* =====================================================
           POPUP CHỌN ĐỊA CHỈ
        ===================================================== */

        .address-modal-content {
            width: 100%;
            max-width: 600px;

            max-height: 80vh;

            overflow-y: auto;

            background: #fff;

            border-radius: 16px;

            box-shadow:
                0 15px 40px
                rgba(0, 0, 0, 0.2);

            padding: 24px;

            box-sizing: border-box;
        }

        .address-modal-header {
            display: flex;

            justify-content: space-between;
            align-items: center;

            margin-bottom: 20px;
        }

        .address-modal-header h3 {
            margin: 0;
        }

        .close-modal {
            border: none;

            background: transparent;

            font-size: 28px;

            cursor: pointer;

            color: #6b7280;

            line-height: 1;
        }

        .close-modal:hover {
            color: #111827;
        }


        /* =====================================================
           DANH SÁCH ĐỊA CHỈ
        ===================================================== */

        .address-list {
            display: flex;

            flex-direction: column;

            gap: 12px;
        }

        .address-item {
            display: flex;

            align-items: flex-start;

            gap: 12px;

            padding: 15px;

            border: 1px solid #d1d5db;

            border-radius: 12px;

            cursor: pointer;

            transition: 0.2s;

            margin: 0;
        }

        .address-item:hover {
            border-color: #f59e0b;

            background: #fffbeb;
        }

        .address-item input[type="radio"] {
            margin-top: 4px;

            transform: scale(1.2);

            cursor: pointer;
        }

        .address-info {
            flex: 1;
        }

        .address-name {
            font-weight: 700;

            margin-bottom: 5px;
        }

        .address-detail {
            color: #4b5563;

            line-height: 1.5;
        }

        .default-label {
            display: inline-block;

            margin-top: 6px;

            color: #d97706;

            font-weight: 700;

            font-size: 13px;
        }


        /* =====================================================
           NÚT THÊM ĐỊA CHỈ
        ===================================================== */

        .add-new-address-btn {
            width: 100%;

            margin-top: 18px;

            border: 1px dashed #1f4e79;

            border-radius: 10px;

            padding: 12px;

            background: #eff6ff;

            color: #1f4e79;

            font-weight: 700;

            cursor: pointer;
        }

        .add-new-address-btn:hover {
            background: #dbeafe;
        }


        /* =====================================================
           POPUP THÊM ĐỊA CHỈ
        ===================================================== */

        .add-address-modal-content {
            width: 100%;

            max-width: 500px;

            background: #fff;

            border-radius: 16px;

            padding: 24px;

            box-shadow:
                0 15px 40px
                rgba(0, 0, 0, 0.2);

            box-sizing: border-box;
        }

        .modal-form-group {
            margin-bottom: 16px;
        }

        .modal-form-group label {
            display: block;

            margin-bottom: 7px;

            font-weight: 600;
        }

        .modal-form-group input[type="text"] {
            width: 100%;

            box-sizing: border-box;

            border: 1px solid #d1d5db;

            border-radius: 10px;

            padding: 11px 12px;

            font-size: 1rem;
        }

        .modal-form-group input[type="text"]:focus {
            outline: none;

            border-color: #f59e0b;

            box-shadow:
                0 0 0 2px
                rgba(245, 158, 11, 0.1);
        }

        .default-checkbox {
            display: flex !important;

            align-items: center;

            gap: 8px;

            cursor: pointer;
        }

        .default-checkbox input[type="checkbox"] {
            width: auto !important;

            cursor: pointer;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 600px) {

            .page {
                margin: 20px auto;
                padding: 0 12px;
            }

            .topbar {
                align-items: flex-start;
                gap: 10px;
            }

            .item-row {
                grid-template-columns: 60px 1fr;
            }

            .item-image {
                width: 60px;
                height: 75px;
            }

            .item-row .price {
                grid-column: 2;
            }

        }

    </style>
</head>


<body>

<div class="page">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="topbar">

        @php
            $lastViewedBookId = session('last_viewed_book_id');
        @endphp

        @if ($lastViewedBookId)

            <a href="{{ route('customer.book.show', $lastViewedBookId) }}"
               class="back-link">

                ← Quay lại

            </a>

        @else

            <a href="{{ route('customer.home') }}"
               class="back-link">

                ← Quay lại

            </a>

        @endif


        <h1>
            Thanh toán
        </h1>

    </div>


    <!-- =====================================================
         THÔNG BÁO LỖI
    ====================================================== -->

    @if (session('error'))

        <div class="note"
             style="
                background:#fef2f2;
                border-color:#fecaca;
                color:#991b1b;
             ">

            {{ session('error') }}

        </div>

    @endif


    <!-- =====================================================
         THÔNG BÁO THÀNH CÔNG
    ====================================================== -->

    @if (session('success'))

        <div class="note">

            {{ session('success') }}

        </div>

    @endif


    <!-- =====================================================
         LẤY ĐỊA CHỈ MẶC ĐỊNH
    ====================================================== -->

    @php

        $defaultAddress =
            $addresses->firstWhere('isDefault', true)
            ?? $addresses->first();

        $shippingFee = 30000;

        $grandTotal =
            $total
            +
            $shippingFee;

    @endphp


    <div class="layout">

        <div class="card">


            <h2>
                Thông tin giao hàng
            </h2>


            <!-- =================================================
                 FORM ĐẶT HÀNG
            ================================================== -->

            <form action="{{ route('customer.checkout.order') }}"
                  method="POST"
                  id="checkoutForm">

                @csrf


                <!-- =================================================
                     VNPAY PAID
                     
                     0 = chưa thanh toán
                     1 = popup VNPay đã thanh toán thành công
                ================================================== -->

                <input type="hidden"
                       name="vnpay_paid"
                       id="vnpayPaid"
                       value="0">


                <!-- =================================================
                     ĐỊA CHỈ NHẬN HÀNG
                ================================================== -->

                <div class="form-group">

                    <label for="maDiaChi">
                        Địa chỉ nhận hàng
                    </label>


                    <div id="addressBox"
                         class="address-box"
                         tabindex="0"
                         role="button"
                         aria-expanded="false">

                        @if ($defaultAddress)

                            <div class="address-title">

                                {{ $defaultAddress->hoTenNguoiNhan }}

                            </div>

                            <div>

                                {{ $defaultAddress->diaChiChiTiet }}

                                -

                                {{ $defaultAddress->sdt }}

                            </div>

                        @else

                            <div>

                                Chưa có địa chỉ nhận hàng.
                                Nhấn để chọn hoặc thêm địa chỉ.

                            </div>

                        @endif

                    </div>


                    <input type="hidden"
                           name="maDiaChi"
                           id="maDiaChi"
                           value="{{ $defaultAddress?->maDiaChi }}">

                </div>


                <!-- =================================================
                     PHƯƠNG THỨC THANH TOÁN
                ================================================== -->

                <div class="form-group">

                    <label for="maPTTT">

                        Phương thức thanh toán

                    </label>


                    <select name="maPTTT"
                            id="maPTTT"
                            required>

                        @php
                            $hasPaymentMethod = false;
                        @endphp


                        @foreach ($paymentMethods as $paymentMethod)

                            @php

                                $paymentName =
                                    mb_strtolower(
                                        $paymentMethod->tenPhuongThuc ?? ''
                                    );

                                $isCod =
                                    str_contains(
                                        $paymentName,
                                        'cod'
                                    )
                                    ||
                                    str_contains(
                                        $paymentName,
                                        'nhận hàng'
                                    );

                                $isVnpay =
                                    str_contains(
                                        $paymentName,
                                        'vnpay'
                                    )
                                    ||
                                    str_contains(
                                        $paymentName,
                                        'ví điện tử'
                                    );

                            @endphp


                            @if ($isCod)

                                @php
                                    $hasPaymentMethod = true;
                                @endphp

                                <option value="{{ $paymentMethod->maPTTT }}"
                                        data-payment="cod">

                                    Thanh toán khi nhận hàng (COD)

                                </option>


                            @elseif ($isVnpay)

                                @php
                                    $hasPaymentMethod = true;
                                @endphp

                                <option value="{{ $paymentMethod->maPTTT }}"
                                        data-payment="vnpay">

                                    Ví điện tử VNPay

                                </option>

                            @endif

                        @endforeach


                        @if (!$hasPaymentMethod)

                            <option value=""
                                    selected
                                    disabled>

                                Chưa có phương thức thanh toán

                            </option>

                        @endif

                    </select>

                </div>


                <!-- =================================================
                     SẢN PHẨM
                ================================================== -->

                <h2 style="margin-top: 28px;">

                    Sản phẩm

                </h2>


                <div class="items">

                    @foreach ($items as $item)

                        <div class="item-row">


                            <!-- ẢNH SÁCH -->

                            <div>

                                @if (!empty($item['hinhAnh']))

                                    <img
                                        src="{{ asset('storage/' . $item['hinhAnh']) }}"
                                        alt="{{ $item['tenSach'] }}"
                                        class="item-image"
                                    >

                                @else

                                    <div
                                        class="item-image"
                                        style="
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                            background:#e5e7eb;
                                            color:#6b7280;
                                        "
                                    >

                                        No image

                                    </div>

                                @endif

                            </div>


                            <!-- THÔNG TIN SÁCH -->

                            <div>

                                <div class="item-name">

                                    {{ $item['tenSach'] }}

                                </div>

                                <div>

                                    Số lượng:
                                    {{ $item['soLuong'] }}

                                </div>

                            </div>


                            <!-- THÀNH TIỀN -->

                            <div class="price">

                                {{
                                    number_format(
                                        (float) $item['giaBan']
                                        *
                                        (int) $item['soLuong'],
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}

                                đ

                            </div>

                        </div>

                    @endforeach

                </div>


                <!-- =================================================
                     TÓM TẮT ĐƠN HÀNG
                ================================================== -->

                <div class="summary-box">

                    <div class="summary-line">

                        <span>
                            Tạm tính
                        </span>

                        <span>

                            {{ number_format(
                                $total,
                                0,
                                ',',
                                '.'
                            ) }}

                            đ

                        </span>

                    </div>


                    <div class="summary-line">

                        <span>
                            Phí vận chuyển
                        </span>

                        <span>
                            30.000 đ
                        </span>

                    </div>


                    <div class="summary-line total">

                        <span>
                            Tổng cộng
                        </span>

                        <span>

                            {{ number_format(
                                $grandTotal,
                                0,
                                ',',
                                '.'
                            ) }}

                            đ

                        </span>

                    </div>

                </div>


                <!-- =================================================
                     POPUP THANH TOÁN VNPAY
                ================================================== -->

                <div id="vnpayModal"
                     class="address-modal">

                    <div class="add-address-modal-content">


                        <div class="address-modal-header">

                            <h3>
                                Thanh toán VNPay
                            </h3>


                            <button type="button"
                                    class="close-modal"
                                    id="closeVnpayModal">

                                ×

                            </button>

                        </div>


                        <div style="
                            text-align:center;
                            margin-bottom:20px;
                        ">

                            <div style="
                                font-size:18px;
                                font-weight:700;
                                margin-bottom:12px;
                            ">

                                Ví điện tử VNPay

                            </div>


                            <div style="
                                color:#6b7280;
                                margin-bottom:8px;
                            ">

                                Số tiền cần thanh toán

                            </div>


                            <div style="
                                font-size:28px;
                                font-weight:700;
                                color:#d97706;
                            ">

                                {{ number_format(
                                    $grandTotal,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                                đ

                            </div>

                        </div>


                        <!-- SỐ ĐIỆN THOẠI -->

                        <div class="modal-form-group">

                            <label for="vnpayPhone">

                                Số điện thoại

                            </label>

                            <input
                                type="text"
                                id="vnpayPhone"
                                placeholder="Nhập số điện thoại"
                                maxlength="15"
                                autocomplete="off"
                            >

                        </div>


                        <!-- OTP -->

                        <div class="modal-form-group">

                            <label for="vnpayOtp">

                                Mã xác nhận

                            </label>

                            <input
                                type="text"
                                id="vnpayOtp"
                                placeholder="Nhập mã xác nhận 6 số"
                                maxlength="6"
                                inputmode="numeric"
                                autocomplete="off"
                            >

                        </div>


                        <!-- NÚT THANH TOÁN -->

                        <button
                            type="button"
                            class="btn"
                            id="vnpayPayButton"
                            style="
                                margin-top:0;
                                background:#1f4e79;
                            "
                        >

                            Thanh toán

                        </button>

                    </div>

                </div>


                <!-- =================================================
                     NÚT XÁC NHẬN ĐẶT HÀNG
                ================================================== -->

                <button
                    type="submit"
                    class="btn"
                    id="orderButton"
                >

                    Xác nhận đặt hàng

                </button>


            </form>


            <!-- =================================================
                 POPUP CHỌN ĐỊA CHỈ
            ================================================== -->

            <div id="addressModal"
                 class="address-modal">

                <div class="address-modal-content">


                    <div class="address-modal-header">

                        <h3>

                            Chọn địa chỉ nhận hàng

                        </h3>


                        <button
                            type="button"
                            class="close-modal"
                            id="closeAddressModal"
                        >

                            ×

                        </button>

                    </div>


                    <div class="address-list">

                        @forelse ($addresses as $diaChi)

                            <label class="address-item">

                                <input
                                    type="radio"
                                    name="selectedAddress"
                                    value="{{ $diaChi->maDiaChi }}"

                                    data-name="{{ $diaChi->hoTenNguoiNhan }}"

                                    data-phone="{{ $diaChi->sdt }}"

                                    data-address="{{ $diaChi->diaChiChiTiet }}"

                                    {{
                                        $defaultAddress
                                        &&
                                        $defaultAddress->maDiaChi
                                        ==
                                        $diaChi->maDiaChi
                                        ? 'checked'
                                        : ''
                                    }}
                                >


                                <div class="address-info">

                                    <div class="address-name">

                                        {{ $diaChi->hoTenNguoiNhan }}

                                    </div>


                                    <div class="address-detail">

                                        {{ $diaChi->diaChiChiTiet }}

                                        <br>

                                        {{ $diaChi->sdt }}

                                    </div>


                                    @if ($diaChi->isDefault)

                                        <div class="default-label">

                                            Địa chỉ mặc định

                                        </div>

                                    @endif

                                </div>

                            </label>

                        @empty

                            <div style="
                                padding:20px;
                                text-align:center;
                                color:#6b7280;
                            ">

                                Bạn chưa có địa chỉ nào.

                            </div>

                        @endforelse

                    </div>


                    <button
                        type="button"
                        id="openAddAddressModal"
                        class="add-new-address-btn"
                    >

                        + Thêm địa chỉ mới

                    </button>


                </div>

            </div>


            <!-- =================================================
                 POPUP THÊM ĐỊA CHỈ
            ================================================== -->

            <div id="addAddressModal"
                 class="address-modal">

                <div class="add-address-modal-content">


                    <div class="address-modal-header">

                        <h3>

                            Thêm địa chỉ mới

                        </h3>


                        <button
                            type="button"
                            class="close-modal"
                            id="closeAddAddressModal"
                        >

                            ×

                        </button>

                    </div>


                    <form
                        action="{{ route('customer.checkout.address.store') }}"
                        method="POST"
                    >

                        @csrf


                        <div class="modal-form-group">

                            <label for="hoTenNguoiNhan">

                                Họ tên người nhận

                            </label>

                            <input
                                type="text"
                                name="hoTenNguoiNhan"
                                id="hoTenNguoiNhan"
                                maxlength="100"
                                required
                            >

                        </div>


                        <div class="modal-form-group">

                            <label for="sdt">

                                Số điện thoại

                            </label>

                            <input
                                type="text"
                                name="sdt"
                                id="sdt"
                                maxlength="15"
                                required
                            >

                        </div>


                        <div class="modal-form-group">

                            <label for="diaChiChiTiet">

                                Địa chỉ chi tiết

                            </label>

                            <input
                                type="text"
                                name="diaChiChiTiet"
                                id="diaChiChiTiet"
                                maxlength="255"
                                required
                            >

                        </div>


                        <div class="modal-form-group">

                            <label class="default-checkbox">

                                <input
                                    type="checkbox"
                                    name="isDefault"
                                    value="1"
                                >

                                Đặt làm địa chỉ mặc định

                            </label>

                        </div>


                        <button
                            type="submit"
                            class="btn"
                            style="
                                margin-top:0;
                                background:#1f4e79;
                            "
                        >

                            Lưu địa chỉ

                        </button>

                    </form>

                </div>

            </div>


        </div>

    </div>

</div>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /* =====================================================
           LẤY CÁC PHẦN TỬ
        ===================================================== */

        const checkoutForm =
            document.getElementById(
                'checkoutForm'
            );


        const orderButton =
            document.getElementById(
                'orderButton'
            );


        const addressBox =
            document.getElementById(
                'addressBox'
            );


        const addressModal =
            document.getElementById(
                'addressModal'
            );


        const addAddressModal =
            document.getElementById(
                'addAddressModal'
            );


        const closeAddressModal =
            document.getElementById(
                'closeAddressModal'
            );


        const closeAddAddressModal =
            document.getElementById(
                'closeAddAddressModal'
            );


        const openAddAddressModal =
            document.getElementById(
                'openAddAddressModal'
            );


        const maDiaChi =
            document.getElementById(
                'maDiaChi'
            );


        const paymentSelect =
            document.getElementById(
                'maPTTT'
            );


        const vnpayModal =
            document.getElementById(
                'vnpayModal'
            );


        const closeVnpayModal =
            document.getElementById(
                'closeVnpayModal'
            );


        const vnpayPayButton =
            document.getElementById(
                'vnpayPayButton'
            );


        const vnpayPhone =
            document.getElementById(
                'vnpayPhone'
            );


        const vnpayOtp =
            document.getElementById(
                'vnpayOtp'
            );


        const vnpayPaid =
            document.getElementById(
                'vnpayPaid'
            );


        /* =====================================================
           KIỂM TRA FORM
        ===================================================== */

        if (!checkoutForm) {

            console.error(
                'Không tìm thấy checkoutForm.'
            );

            return;
        }


        /* =====================================================
           1. MỞ POPUP CHỌN ĐỊA CHỈ
        ===================================================== */

        if (
            addressBox
            &&
            addressModal
        ) {

            addressBox.addEventListener(
                'click',
                function () {

                    addressModal.classList.add(
                        'open'
                    );

                    addressBox.setAttribute(
                        'aria-expanded',
                        'true'
                    );

                }
            );


            addressBox.addEventListener(
                'keydown',
                function (event) {

                    if (
                        event.key === 'Enter'
                        ||
                        event.key === ' '
                    ) {

                        event.preventDefault();

                        addressBox.click();

                    }

                }
            );

        }


        /* =====================================================
           2. SUBMIT FORM ĐẶT HÀNG
        ===================================================== */

        checkoutForm.addEventListener(
            'submit',
            function (event) {


                /* =============================================
                   KIỂM TRA ĐỊA CHỈ
                ============================================= */

                if (
                    !maDiaChi
                    ||
                    !maDiaChi.value
                    ||
                    maDiaChi.value.trim() === ''
                ) {

                    event.preventDefault();


                    if (addressModal) {

                        addressModal.classList.add(
                            'open'
                        );

                    }


                    if (addressBox) {

                        addressBox.setAttribute(
                            'aria-expanded',
                            'true'
                        );

                    }


                    alert(
                        'Vui lòng chọn địa chỉ nhận hàng.'
                    );

                    return;
                }


                /* =============================================
                   KIỂM TRA PHƯƠNG THỨC THANH TOÁN
                ============================================= */

                if (
                    !paymentSelect
                    ||
                    !paymentSelect.value
                ) {

                    event.preventDefault();

                    alert(
                        'Vui lòng chọn phương thức thanh toán.'
                    );

                    return;
                }


                /* =============================================
                   LẤY PHƯƠNG THỨC ĐANG CHỌN
                ============================================= */

                const selectedOption =
                    paymentSelect.options[
                        paymentSelect.selectedIndex
                    ];


                const paymentType =
                    selectedOption?.dataset?.payment
                    ||
                    'cod';


                /* =============================================
                   VNPAY
                   
                   Nếu chưa thanh toán:
                   -> Mở popup
                   
                   Nếu đã thanh toán:
                   -> Cho form submit
                ============================================= */

                if (
                    paymentType === 'vnpay'
                    &&
                    (!vnpayPaid || vnpayPaid.value !== '1')
                ) {

                    event.preventDefault();


                    if (vnpayModal) {

                        vnpayModal.classList.add(
                            'open'
                        );

                    }

                    return;
                }


                /* =============================================
                   COD
                   
                   Cho submit bình thường
                ============================================= */

                if (
                    paymentType === 'cod'
                ) {

                    if (orderButton) {

                        orderButton.disabled =
                            true;

                        orderButton.textContent =
                            'Đang xử lý...';

                    }

                    return;
                }


                /* =============================================
                   VNPAY ĐÃ THANH TOÁN
                   
                   Cho form submit về Controller
                ============================================= */

                if (
                    paymentType === 'vnpay'
                    &&
                    vnpayPaid
                    &&
                    vnpayPaid.value === '1'
                ) {

                    if (orderButton) {

                        orderButton.disabled =
                            true;

                        orderButton.textContent =
                            'Đang xử lý thanh toán...';

                    }

                    return;
                }

            }
        );


        /* =====================================================
           3. XỬ LÝ NÚT THANH TOÁN VNPAY
        ===================================================== */

        if (vnpayPayButton) {

            vnpayPayButton.addEventListener(
                'click',
                function () {


                    /* =========================================
                       LẤY SỐ ĐIỆN THOẠI
                    ========================================= */

                    const phone =
                        vnpayPhone
                            ? vnpayPhone.value.trim()
                            : '';


                    /* =========================================
                       LẤY OTP
                    ========================================= */

                    const otp =
                        vnpayOtp
                            ? vnpayOtp.value.trim()
                            : '';


                    /* =========================================
                       KIỂM TRA SỐ ĐIỆN THOẠI
                    ========================================= */

                    if (!phone) {

                        alert(
                            'Vui lòng nhập số điện thoại.'
                        );


                        if (vnpayPhone) {

                            vnpayPhone.focus();

                        }


                        return;
                    }


                    if (
                        phone.length < 10
                        ||
                        phone.length > 15
                        ||
                        !/^\d+$/.test(phone)
                    ) {

                        alert(
                            'Số điện thoại không hợp lệ.'
                        );


                        if (vnpayPhone) {

                            vnpayPhone.focus();

                        }


                        return;
                    }


                    /* =========================================
                       KIỂM TRA OTP
                    ========================================= */

                    if (!otp) {

                        alert(
                            'Vui lòng nhập mã xác nhận.'
                        );


                        if (vnpayOtp) {

                            vnpayOtp.focus();

                        }


                        return;
                    }


                    if (
                        otp.length !== 6
                        ||
                        !/^\d{6}$/.test(otp)
                    ) {

                        alert(
                            'Mã xác nhận phải gồm 6 chữ số.'
                        );


                        if (vnpayOtp) {

                            vnpayOtp.focus();

                        }


                        return;
                    }


                    /* =========================================
                       ĐÁNH DẤU ĐÃ THANH TOÁN VNPAY
                    ========================================= */

                    if (vnpayPaid) {

                        vnpayPaid.value = '1';

                    }


                    /* =========================================
                       THÔNG BÁO THANH TOÁN THÀNH CÔNG
                    ========================================= */

                    alert(
                        'Thanh toán VNPay thành công!'
                    );


                    /* =========================================
                       ĐÓNG POPUP
                    ========================================= */

                    if (vnpayModal) {

                        vnpayModal.classList.remove(
                            'open'
                        );

                    }


                    /* =========================================
                       KHÓA NÚT THANH TOÁN
                    ========================================= */

                    vnpayPayButton.disabled =
                        true;

                    vnpayPayButton.textContent =
                        'Đã thanh toán';


                    /* =========================================
                       KHÓA NÚT ĐẶT HÀNG
                    ========================================= */

                    if (orderButton) {

                        orderButton.disabled =
                            true;

                        orderButton.textContent =
                            'Đang xử lý thanh toán...';

                    }


                    /* =========================================
                       GỬI FORM ĐẶT HÀNG
                       
                       QUAN TRỌNG:
                       
                       KHÔNG tạo form mới.
                       
                       KHÔNG gửi sang:
                       customer.checkout.vnpay.result
                       
                       Mà gửi trực tiếp:
                       customer.checkout.order
                    ========================================= */

                    checkoutForm.submit();

                }
            );

        }


        /* =====================================================
           4. ĐÓNG POPUP VNPAY
        ===================================================== */

        if (
            closeVnpayModal
            &&
            vnpayModal
        ) {

            closeVnpayModal.addEventListener(
                'click',
                function () {

                    vnpayModal.classList.remove(
                        'open'
                    );

                }
            );


            vnpayModal.addEventListener(
                'click',
                function (event) {

                    if (
                        event.target ===
                        vnpayModal
                    ) {

                        vnpayModal.classList.remove(
                            'open'
                        );

                    }

                }
            );

        }


        /* =====================================================
           5. ĐÓNG POPUP CHỌN ĐỊA CHỈ
        ===================================================== */

        if (
            closeAddressModal
            &&
            addressModal
        ) {

            closeAddressModal.addEventListener(
                'click',
                function () {

                    addressModal.classList.remove(
                        'open'
                    );


                    if (addressBox) {

                        addressBox.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                    }

                }
            );

        }


        /* =====================================================
           6. CHỌN ĐỊA CHỈ
        ===================================================== */

        document
            .querySelectorAll(
                'input[name="selectedAddress"]'
            )
            .forEach(
                function (radio) {

                    radio.addEventListener(
                        'change',
                        function () {


                            const selectedId =
                                this.value;


                            const selectedName =
                                this.dataset.name
                                ||
                                '';


                            const selectedPhone =
                                this.dataset.phone
                                ||
                                '';


                            const selectedAddress =
                                this.dataset.address
                                ||
                                '';


                            /* =================================
                               GÁN MÃ ĐỊA CHỈ
                            ================================= */

                            if (maDiaChi) {

                                maDiaChi.value =
                                    selectedId;

                            }


                            /* =================================
                               HIỂN THỊ ĐỊA CHỈ
                            ================================= */

                            if (addressBox) {

                                addressBox.innerHTML =

                                    '<div class="address-title">' +
                                        escapeHtml(
                                            selectedName
                                        ) +
                                    '</div>' +

                                    '<div>' +
                                        escapeHtml(
                                            selectedAddress
                                        ) +
                                        ' - ' +
                                        escapeHtml(
                                            selectedPhone
                                        ) +
                                    '</div>';

                            }


                            /* =================================
                               ĐÓNG POPUP
                            ================================= */

                            if (addressModal) {

                                addressModal.classList.remove(
                                    'open'
                                );

                            }


                            if (addressBox) {

                                addressBox.setAttribute(
                                    'aria-expanded',
                                    'false'
                                );

                            }

                        }
                    );

                }
            );


        /* =====================================================
           7. MỞ POPUP THÊM ĐỊA CHỈ
        ===================================================== */

        if (
            openAddAddressModal
            &&
            addressModal
            &&
            addAddressModal
        ) {

            openAddAddressModal.addEventListener(
                'click',
                function () {

                    addressModal.classList.remove(
                        'open'
                    );


                    addAddressModal.classList.add(
                        'open'
                    );

                }
            );

        }


        /* =====================================================
           8. ĐÓNG POPUP THÊM ĐỊA CHỈ
        ===================================================== */

        if (
            closeAddAddressModal
            &&
            addAddressModal
        ) {

            closeAddAddressModal.addEventListener(
                'click',
                function () {

                    addAddressModal.classList.remove(
                        'open'
                    );

                }
            );

        }


        /* =====================================================
           9. CLICK RA NGOÀI POPUP CHỌN ĐỊA CHỈ
        ===================================================== */

        if (addressModal) {

            addressModal.addEventListener(
                'click',
                function (event) {

                    if (
                        event.target ===
                        addressModal
                    ) {

                        addressModal.classList.remove(
                            'open'
                        );


                        if (addressBox) {

                            addressBox.setAttribute(
                                'aria-expanded',
                                'false'
                            );

                        }

                    }

                }
            );

        }


        /* =====================================================
           10. CLICK RA NGOÀI POPUP THÊM ĐỊA CHỈ
        ===================================================== */

        if (addAddressModal) {

            addAddressModal.addEventListener(
                'click',
                function (event) {

                    if (
                        event.target ===
                        addAddressModal
                    ) {

                        addAddressModal.classList.remove(
                            'open'
                        );

                    }

                }
            );

        }


        /* =====================================================
           11. ESCAPE HTML
        ===================================================== */

        function escapeHtml(value) {

            const div =
                document.createElement(
                    'div'
                );


            div.textContent =
                value ?? '';


            return div.innerHTML;

        }


    }
);

</script>

</body>
</html>