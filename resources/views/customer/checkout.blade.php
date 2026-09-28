<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - Kim Đồng</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            color: #222;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            background: #c90016;
            color: #fff;
            padding: 18px 0;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .12);
        }

        .header-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 28px;
            font-weight: 900;
            letter-spacing: 1px;
        }

        .checkout-title {
            font-size: 26px;
            font-weight: 700;
        }

        /* =========================
           PAGE
        ========================= */

        .page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 25px 20px 50px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #c90016;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .back-link:hover {
            color: #9f0012;
            text-decoration: underline;
        }

        /* =========================
           ALERT
        ========================= */

        .note {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 18px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #047857;
            font-size: 14px;
        }

        .error-note {
            background: #fef2f2;
            border-color: #fecaca;
            color: #b91c1c;
        }

        /* =========================
           LAYOUT
        ========================= */

        .checkout-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(320px, .9fr);
            gap: 24px;
            align-items: start;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .06);
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff0f2;
            color: #c90016;
            font-size: 18px;
        }

        .card-header h2 {
            margin: 0;
            font-size: 20px;
            color: #222;
        }

        .card-body {
            padding: 24px;
        }

        /* =========================
           FORM
        ========================= */

        .form-group {
            margin-bottom: 24px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        label {
            display: block;
            margin-bottom: 9px;
            color: #333;
            font-size: 14px;
            font-weight: 700;
        }

        /* =========================
           ADDRESS
        ========================= */

        .address-box {
            position: relative;
            border: 1.5px solid #d8d8d8;
            border-radius: 12px;
            background: #fff;
            padding: 15px 48px 15px 16px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .address-box:hover,
        .address-box:focus {
            border-color: #c90016;
            box-shadow: 0 0 0 3px rgba(201, 0, 22, .08);
            outline: none;
        }

        .address-box::after {
            content: "›";
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #c90016;
            font-size: 28px;
            font-weight: 400;
        }

        .address-title {
            margin-bottom: 6px;
            color: #c90016;
            font-size: 15px;
            font-weight: 700;
        }

        .address-detail-main {
            color: #555;
            font-size: 14px;
            line-height: 1.5;
        }

        /* =========================
           PAYMENT
        ========================= */

        select {
            width: 100%;
            height: 48px;
            border: 1px solid #d5d5d5;
            border-radius: 10px;
            padding: 0 14px;
            font-size: 14px;
            color: #333;
            background: #fff;
            cursor: pointer;
        }

        select:focus {
            outline: none;
            border-color: #c90016;
            box-shadow: 0 0 0 3px rgba(201, 0, 22, .08);
        }

        /* =========================
           PRODUCT
        ========================= */

        .section-title {
            margin: 0 0 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            color: #222;
        }

        .section-title::before {
            content: "";
            width: 4px;
            height: 23px;
            border-radius: 3px;
            background: #c90016;
        }

        .items {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .item-row {
            display: grid;
            grid-template-columns: 76px minmax(0, 1fr) auto;
            gap: 16px;
            align-items: center;
            padding: 14px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #fff;
            transition: all .2s ease;
        }

        .item-row:hover {
            border-color: #f0a0aa;
            box-shadow: 0 4px 12px rgba(201, 0, 22, .06);
        }

        .item-image {
            width: 76px;
            height: 92px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #eee;
            background: #f5f5f5;
        }

        .item-name {
            margin-bottom: 8px;
            color: #222;
            font-size: 15px;
            font-weight: 700;
        }

        .item-quantity {
            color: #666;
            font-size: 14px;
        }

        .price {
            color: #c90016;
            font-size: 15px;
            font-weight: 700;
            white-space: nowrap;
        }

        .summary-card {
            position: sticky;
            top: 20px;
        }

        .summary-header {
            padding: 20px 22px;
            border-bottom: 1px solid #eee;
            font-size: 20px;
            font-weight: 700;
            color: #222;
        }

        .summary-body {
            padding: 20px 22px;
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 8px 0;
            color: #555;
            font-size: 14px;
        }

        .summary-line span:last-child {
            color: #333;
            font-weight: 600;
            white-space: nowrap;
        }

        .summary-line.total {
            margin-top: 12px;
            padding-top: 18px;
            border-top: 1px dashed #d5d5d5;
        }

        .summary-line.total span:first-child {
            color: #222;
            font-size: 16px;
            font-weight: 700;
        }

        .summary-line.total span:last-child {
            color: #c90016;
            font-size: 22px;
            font-weight: 800;
        }

        .shipping-note {
            margin-top: 15px;
            padding: 11px 12px;
            border-radius: 8px;
            background: #fff5f6;
            color: #9f0012;
            font-size: 13px;
            line-height: 1.5;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 10px;
            margin-top: 18px;
            background: #c90016;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s ease;
        }

        .btn:hover {
            background: #a90013;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(201, 0, 22, .2);
        }

        .btn:disabled {
            background: #999;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .secure-note {
            margin-top: 14px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }

        /* =========================
           MODAL
        ========================= */

        .address-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            inset: 0;
            padding: 20px;
            background: rgba(0, 0, 0, .5);
            align-items: center;
            justify-content: center;
        }

        .address-modal.open {
            display: flex;
        }

        .address-modal-content {
            width: 100%;
            max-width: 620px;
            max-height: 85vh;
            overflow-y: auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .25);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid #eee;
        }

        .modal-header h3 {
            margin: 0;
            color: #222;
            font-size: 19px;
        }

        .close-modal {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 50%;
            background: #f5f5f5;
            color: #555;
            font-size: 23px;
            line-height: 1;
            cursor: pointer;
        }

        .close-modal:hover {
            background: #fff0f2;
            color: #c90016;
        }

        .modal-body {
            padding: 20px 24px 24px;
        }

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
            border: 1px solid #ddd;
            border-radius: 11px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .address-item:hover {
            border-color: #c90016;
            background: #fff8f9;
        }

        .address-item input[type="radio"] {
            margin-top: 4px;
            transform: scale(1.15);
            accent-color: #c90016;
            cursor: pointer;
        }

        .address-info {
            flex: 1;
        }

        .address-name {
            margin-bottom: 5px;
            color: #222;
            font-size: 14px;
            font-weight: 700;
        }

        .address-detail {
            color: #555;
            font-size: 14px;
            line-height: 1.5;
        }

        .default-label {
            display: inline-block;
            margin-top: 7px;
            padding: 4px 8px;
            border-radius: 5px;
            background: #fff0f2;
            color: #c90016;
            font-size: 12px;
            font-weight: 700;
        }

        .add-new-address-btn {
            width: 100%;
            margin-top: 16px;
            padding: 13px;
            border: 1px dashed #c90016;
            border-radius: 10px;
            background: #fff8f9;
            color: #c90016;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }

        .add-new-address-btn:hover {
            background: #fff0f2;
        }

        /* =========================
           ADD ADDRESS MODAL
        ========================= */

        .add-address-modal-content {
            width: 100%;
            max-width: 500px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .25);
        }

        .modal-form {
            padding: 20px 24px 24px;
        }

        .modal-form-group {
            margin-bottom: 16px;
        }

        .modal-form-group label {
            margin-bottom: 7px;
        }

        .modal-form-group input[type="text"] {
            width: 100%;
            height: 45px;
            border: 1px solid #d5d5d5;
            border-radius: 9px;
            padding: 0 12px;
            font-size: 14px;
        }

        .modal-form-group input[type="text"]:focus {
            outline: none;
            border-color: #c90016;
            box-shadow: 0 0 0 3px rgba(201, 0, 22, .08);
        }

        /* =========================
           VALIDATION ERROR
        ========================= */

        .field-error {
            color: #c90016;
            font-size: 13px;
            margin-top: 6px;
            line-height: 1.4;
        }

        .input-error {
            border-color: #c90016 !important;
            background: #fff8f9;
        }

        .default-checkbox {
            display: flex !important;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .default-checkbox input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #c90016;
            cursor: pointer;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {
            .checkout-layout {
                grid-template-columns: 1fr;
            }

            .summary-card {
                position: static;
            }
        }

        @media (max-width: 600px) {
            .header-inner {
                padding: 0 14px;
            }

            .logo {
                font-size: 22px;
            }

            .checkout-title {
                font-size: 20px;
            }

            .page {
                padding: 18px 12px 40px;
            }

            .card-body {
                padding: 18px;
            }

            .item-row {
                grid-template-columns: 62px minmax(0, 1fr);
                gap: 12px;
            }

            .item-image {
                width: 62px;
                height: 78px;
            }

            .item-row .price {
                grid-column: 2;
            }

            .card-header {
                padding: 17px 18px;
            }

            .summary-body {
                padding: 18px;
            }

            .modal-header {
                padding: 17px 18px;
            }

            .modal-body,
            .modal-form {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<header class="header">
    <div class="header-inner">
        <div class="logo">
            KIM ĐỒNG
        </div>

        <div class="checkout-title">
            Thanh toán
        </div>
    </div>
</header>

<div class="page">

    @php
        $lastViewedBookId = session('last_viewed_book_id');
    @endphp

    @if($lastViewedBookId)

        <a
            href="{{ route('customer.book.show', $lastViewedBookId) }}"
            class="back-link"
        >
            ← Quay lại
        </a>

    @else

        <a
            href="{{ route('customer.home') }}"
            class="back-link"
        >
            ← Quay lại
        </a>

    @endif

    {{-- THÔNG BÁO LỖI --}}
    @if(session('error'))
        <div class="note error-note">
            {{ session('error') }}
        </div>
    @endif

    {{-- THÔNG BÁO THÀNH CÔNG --}}
    @if(session('success'))
        <div class="note">
            {{ session('success') }}
        </div>
    @endif

    {{-- THÔNG BÁO VALIDATION --}}
    @if($errors->any())
        <div class="note error-note">
            Vui lòng kiểm tra lại thông tin địa chỉ.
        </div>
    @endif

    @php
        $defaultAddress = $addresses->firstWhere('isDefault', true) ?? $addresses->first();
        $shippingFee = 30000;
        $grandTotal = $total + $shippingFee;
    @endphp

    <div class="checkout-layout">

        <div class="card">

            <div class="card-header">

                <div class="card-header-icon">
                    📦
                </div>

                <h2>
                    Thông tin giao hàng
                </h2>

            </div>

            <div class="card-body">

                <form
                    action="{{ route('customer.checkout.order') }}"
                    method="POST"
                    id="checkoutForm"
                >

                    @csrf

                    {{-- ĐỊA CHỈ --}}
                    <div class="form-group">

                        <label for="maDiaChi">
                            Địa chỉ nhận hàng
                        </label>

                        <div
                            id="addressBox"
                            class="address-box"
                            tabindex="0"
                            role="button"
                            aria-expanded="false"
                        >

                            @if($defaultAddress)

                                <div class="address-title">
                                    {{ $defaultAddress->hoTenNguoiNhan }}
                                </div>

                                <div class="address-detail-main">
                                    {{ $defaultAddress->diaChiChiTiet }}
                                    -
                                    {{ $defaultAddress->sdt }}
                                </div>

                            @else

                                <div class="address-detail-main">
                                    Chưa có địa chỉ nhận hàng.
                                    Nhấn để chọn hoặc thêm địa chỉ.
                                </div>

                            @endif

                        </div>

                        <input
                            type="hidden"
                            name="maDiaChi"
                            id="maDiaChi"
                            value="{{ $defaultAddress?->maDiaChi }}"
                        >

                    </div>

                    {{-- PHƯƠNG THỨC THANH TOÁN --}}
                    <div class="form-group">

                        <label for="maPTTT">
                            Phương thức thanh toán
                        </label>

                        <select
                            name="maPTTT"
                            id="maPTTT"
                            required
                        >

                            @php
                                $hasPaymentMethod = false;
                            @endphp

                            @foreach($paymentMethods as $paymentMethod)

                                @php

                                    $paymentName = mb_strtolower(
                                        $paymentMethod->tenPhuongThuc ?? ''
                                    );

                                    $isCod =
                                        str_contains($paymentName, 'cod') ||
                                        str_contains($paymentName, 'nhận hàng');

                                    $isVnpay =
                                        str_contains($paymentName, 'vnpay') ||
                                        str_contains($paymentName, 'ví điện tử');

                                @endphp

                                @if($isCod)

                                    @php
                                        $hasPaymentMethod = true;
                                    @endphp

                                    <option
                                        value="{{ $paymentMethod->maPTTT }}"
                                        data-payment="cod"
                                    >
                                        Thanh toán khi nhận hàng (COD)
                                    </option>

                                @elseif($isVnpay)

                                    @php
                                        $hasPaymentMethod = true;
                                    @endphp

                                    <option
                                        value="{{ $paymentMethod->maPTTT }}"
                                        data-payment="vnpay"
                                    >
                                        Ví điện tử VNPay
                                    </option>

                                @endif

                            @endforeach

                            @if(!$hasPaymentMethod)

                                <option
                                    value=""
                                    selected
                                    disabled
                                >
                                    Chưa có phương thức thanh toán
                                </option>

                            @endif

                        </select>

                    </div>

                    {{-- SẢN PHẨM --}}
                    <h2 class="section-title">
                        Sản phẩm
                    </h2>

                    <div class="items">

                        @foreach($items as $item)

                            <div class="item-row">

                                <div>

                                    @if(!empty($item['hinhAnh']))

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
                                                color:#999;
                                                font-size:11px;
                                            "
                                        >
                                            No image
                                        </div>

                                    @endif

                                </div>

                                <div>

                                    <div class="item-name">
                                        {{ $item['tenSach'] }}
                                    </div>

                                    <div class="item-quantity">
                                        Số lượng:
                                        {{ $item['soLuong'] }}
                                    </div>

                                </div>

                                <div class="price">

                                    {{ number_format(
                                        (float)$item['giaBan'] *
                                        (int)$item['soLuong'],
                                        0,
                                        ',',
                                        '.'
                                    ) }} đ

                                </div>

                            </div>

                        @endforeach

                    </div>

                </form>

            </div>

        </div>

        {{-- TỔNG ĐƠN HÀNG --}}
        <div class="card summary-card">

            <div class="summary-header">
                Đơn hàng của bạn
            </div>

            <div class="summary-body">

                <div class="summary-line">

                    <span>
                        Tạm tính
                    </span>

                    <span>
                        {{ number_format($total, 0, ',', '.') }} đ
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
                        {{ number_format($grandTotal, 0, ',', '.') }} đ
                    </span>

                </div>

                <div class="shipping-note">
                    Phí vận chuyển cố định 30.000 đ cho đơn hàng.
                </div>

                <button
                    type="submit"
                    form="checkoutForm"
                    class="btn"
                    id="orderButton"
                >
                    Xác nhận đặt hàng
                </button>

                <div class="secure-note">
                    🔒 Thông tin đơn hàng của bạn được bảo mật
                </div>

            </div>

        </div>

    </div>

</div>

{{-- =========================
     MODAL CHỌN ĐỊA CHỈ
========================= --}}

<div
    id="addressModal"
    class="address-modal"
>

    <div class="address-modal-content">

        <div class="modal-header">

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

        <div class="modal-body">

            <div class="address-list">

                @forelse($addresses as $diaChi)

                    <label class="address-item">

                        <input
                            type="radio"
                            name="selectedAddress"
                            value="{{ $diaChi->maDiaChi }}"
                            data-name="{{ $diaChi->hoTenNguoiNhan }}"
                            data-phone="{{ $diaChi->sdt }}"
                            data-address="{{ $diaChi->diaChiChiTiet }}"
                            {{ $defaultAddress && $defaultAddress->maDiaChi == $diaChi->maDiaChi ? 'checked' : '' }}
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

                            @if($diaChi->isDefault)

                                <div class="default-label">
                                    Địa chỉ mặc định
                                </div>

                            @endif

                        </div>

                    </label>

                @empty

                    <div
                        style="
                            padding:20px;
                            text-align:center;
                            color:#777;
                        "
                    >
                        Bạn chưa có địa chỉ nào.
                    </div>

                @endforelse

            </div>

            <button
                type="button"
                id="openAddAddressModal"
                class="add-new-address-btn"
            >
                ＋ Thêm địa chỉ mới
            </button>

        </div>

    </div>

</div>

{{-- =========================
     MODAL THÊM ĐỊA CHỈ
========================= --}}

<div
    id="addAddressModal"
    class="address-modal"
>

    <div class="add-address-modal-content">

        <div class="modal-header">

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
            class="modal-form"
        >

            @csrf

            {{-- HỌ TÊN --}}
            <div class="modal-form-group">

                <label for="hoTenNguoiNhan">
                    Họ tên người nhận
                </label>

                <input
                    type="text"
                    name="hoTenNguoiNhan"
                    id="hoTenNguoiNhan"
                    maxlength="100"
                    value="{{ old('hoTenNguoiNhan') }}"
                    class="@error('hoTenNguoiNhan') input-error @enderror"
                    required
                >

                @error('hoTenNguoiNhan')
                    <div class="field-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- SỐ ĐIỆN THOẠI --}}
            <div class="modal-form-group">

                <label for="sdt">
                    Số điện thoại
                </label>

                <input
                    type="text"
                    name="sdt"
                    id="sdt"
                    maxlength="15"
                    inputmode="numeric"
                    pattern="[0-9]+"
                    value="{{ old('sdt') }}"
                    class="@error('sdt') input-error @enderror"
                    required
                >

                @error('sdt')
                    <div class="field-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- ĐỊA CHỈ CHI TIẾT --}}
            <div class="modal-form-group">

                <label for="diaChiChiTiet">
                    Địa chỉ chi tiết
                </label>

                <input
                    type="text"
                    name="diaChiChiTiet"
                    id="diaChiChiTiet"
                    maxlength="255"
                    value="{{ old('diaChiChiTiet') }}"
                    class="@error('diaChiChiTiet') input-error @enderror"
                    required
                >

                @error('diaChiChiTiet')
                    <div class="field-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- ĐỊA CHỈ MẶC ĐỊNH --}}
            <div class="modal-form-group">

                <label class="default-checkbox">

                    <input
                        type="checkbox"
                        name="isDefault"
                        value="1"
                        {{ old('isDefault') ? 'checked' : '' }}
                    >

                    Đặt làm địa chỉ mặc định

                </label>

                @error('isDefault')
                    <div class="field-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <button
                type="submit"
                class="btn"
                style="margin-top:0"
            >
                Lưu địa chỉ
            </button>

        </form>

    </div>

</div>

{{-- =========================
     JAVASCRIPT
========================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const checkoutForm = document.getElementById('checkoutForm');

    const orderButton = document.getElementById('orderButton');

    const addressBox = document.getElementById('addressBox');

    const addressModal = document.getElementById('addressModal');

    const addAddressModal = document.getElementById('addAddressModal');

    const closeAddressModal =
        document.getElementById('closeAddressModal');

    const closeAddAddressModal =
        document.getElementById('closeAddAddressModal');

    const openAddAddressModal =
        document.getElementById('openAddAddressModal');

    const maDiaChi =
        document.getElementById('maDiaChi');

    const paymentSelect =
        document.getElementById('maPTTT');


    if (!checkoutForm) {
        return;
    }


    /* =========================
       MỞ MODAL CHỌN ĐỊA CHỈ
    ========================= */

    if (addressBox && addressModal) {

        addressBox.addEventListener('click', function () {

            addressModal.classList.add('open');

            addressBox.setAttribute(
                'aria-expanded',
                'true'
            );

        });


        addressBox.addEventListener('keydown', function (event) {

            if (
                event.key === 'Enter' ||
                event.key === ' '
            ) {

                event.preventDefault();

                addressBox.click();

            }

        });

    }


    /* =========================
       KIỂM TRA ĐẶT HÀNG
    ========================= */

    checkoutForm.addEventListener('submit', function (event) {

        if (
            !maDiaChi ||
            !maDiaChi.value ||
            maDiaChi.value.trim() === ''
        ) {

            event.preventDefault();

            if (addressModal) {

                addressModal.classList.add('open');

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


        if (
            !paymentSelect ||
            !paymentSelect.value
        ) {

            event.preventDefault();

            alert(
                'Vui lòng chọn phương thức thanh toán.'
            );

            return;

        }


        const selectedOption =
            paymentSelect.options[
                paymentSelect.selectedIndex
            ];


        const paymentType =
            selectedOption?.dataset?.payment || 'cod';


        if (paymentType === 'cod') {

            if (orderButton) {

                orderButton.disabled = true;

                orderButton.textContent =
                    'Đang xử lý...';

            }

            return;

        }


        if (paymentType === 'vnpay') {

            if (orderButton) {

                orderButton.disabled = true;

                orderButton.textContent =
                    'Đang chuyển đến VNPay...';

            }

            return;

        }

    });


    /* =========================
       ĐÓNG MODAL CHỌN ĐỊA CHỈ
    ========================= */

    if (
        closeAddressModal &&
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


    /* =========================
       CHỌN ĐỊA CHỈ
    ========================= */

    document
        .querySelectorAll(
            'input[name="selectedAddress"]'
        )
        .forEach(function (radio) {

            radio.addEventListener(
                'change',
                function () {

                    const selectedId =
                        this.value;

                    const selectedName =
                        this.dataset.name || '';

                    const selectedPhone =
                        this.dataset.phone || '';

                    const selectedAddress =
                        this.dataset.address || '';


                    if (maDiaChi) {

                        maDiaChi.value =
                            selectedId;

                    }


                    if (addressBox) {

                        addressBox.innerHTML =

                            '<div class="address-title">' +

                            escapeHtml(
                                selectedName
                            ) +

                            '</div>' +

                            '<div class="address-detail-main">' +

                            escapeHtml(
                                selectedAddress
                            ) +

                            ' - ' +

                            escapeHtml(
                                selectedPhone
                            ) +

                            '</div>';

                    }


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

        });


    /* =========================
       MỞ MODAL THÊM ĐỊA CHỈ
    ========================= */

    if (
        openAddAddressModal &&
        addressModal &&
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


    /* =========================
       ĐÓNG MODAL THÊM ĐỊA CHỈ
    ========================= */

    if (
        closeAddAddressModal &&
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
    if (addressModal) {
        addressModal.addEventListener(
            'click',
            function (event) {
                if (event.target === addressModal) {
                    addressModal.classList.remove('open');
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
    if (addAddressModal) {
        addAddressModal.addEventListener(
            'click',
            function (event) {
                if (event.target === addAddressModal) {
                    addAddressModal.classList.remove('open');
                }
            }
        );
    }
    function escapeHtml(value) {
        const div =document.createElement('div');
        div.textContent =value ?? '';
        return div.innerHTML;
    }
});

</script>
@if($errors->any())
<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {
        const addAddressModal =document.getElementById('addAddressModal');
        const addressModal =document.getElementById('addressModal');
        if (addressModal) {
            addressModal.classList.remove('open');
        }
        if (addAddressModal) {
            addAddressModal.classList.add('open');
        }
    }
);

</script>
@endif
</body>
</html>