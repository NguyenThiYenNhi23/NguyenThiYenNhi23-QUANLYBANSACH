@extends('quantri.layouts.quantri_layout')

@section('title', 'Quản lý tồn kho')
@section('header-title', 'Quản lý tồn kho')
@section('content')

<style>
    .inventory-page {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .inventory-heading {
        text-align: center;
        margin-bottom: 25px;
    }

    .inventory-heading h1 {
        margin: 0;
        color: #c62828;
        font-size: 28px;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* THỐNG KÊ */

    .inventory-summary {
        background: #ffffff;
        border: 1px solid #f0d5d5;
        border-left: 5px solid #c62828;
        border-radius: 10px;
        padding: 15px 22px;
        margin-bottom: 22px;
    }

    .summary-line {
        padding: 5px 0;
        color: #555555;
        font-size: 15px;
    }

    .summary-line strong {
        color: #c62828;
        font-weight: 700;
    }

    /* KHUNG BẢNG */

    .inventory-card {
        background: #ffffff;
        border: 1px solid #f0d5d5;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(198, 40, 40, 0.06);
    }

    .inventory-card-header {
        padding: 18px 22px;
        background: #fffafa;
        border-bottom: 1px solid #f0dddd;
    }

    .inventory-card-header h2 {
        margin: 0 0 5px 0;
        color: #b71c1c;
        font-size: 18px;
        font-weight: 700;
    }

    .inventory-card-header p {
        margin: 0;
        color: #888888;
        font-size: 13px;
    }

    /* BẢNG */

    .inventory-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .inventory-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .inventory-table th {
        padding: 14px 12px;
        background: #c62828;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        text-align: left;
        white-space: nowrap;
    }

    .inventory-table td {
        padding: 14px 12px;
        background: #ffffff;
        color: #555555;
        font-size: 14px;
        border-bottom: 1px solid #eeeeee;
        vertical-align: middle;
    }

    /* ĐỘ RỘNG TỪNG CỘT */

    .inventory-table th:nth-child(1),
    .inventory-table td:nth-child(1) {
        width: 7%;
        text-align: center;
    }

    .inventory-table th:nth-child(2),
    .inventory-table td:nth-child(2) {
        width: 14%;
    }

    .inventory-table th:nth-child(3),
    .inventory-table td:nth-child(3) {
        width: 28%;
    }

    .inventory-table th:nth-child(4),
    .inventory-table td:nth-child(4) {
        width: 17%;
        text-align: center;
    }

    .inventory-table th:nth-child(5),
    .inventory-table td:nth-child(5) {
        width: 15%;
        text-align: center;
    }

    .inventory-table th:nth-child(6),
    .inventory-table td:nth-child(6) {
        width: 19%;
    }

    .inventory-table tbody tr:hover td {
        background: #fff8f8;
    }

    .inventory-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* MÃ SÁCH */

    .book-code {
        color: #b71c1c;
        font-weight: 600;
    }

    /* TÊN SÁCH */

    .book-name {
        display: block;
        color: #444444;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* SỐ LƯỢNG */

    .quantity {
        color: #c62828;
        font-size: 15px;
        font-weight: 700;
    }

    /* TRẠNG THÁI */

    .inventory-status {
        display: inline-block;
        min-width: 78px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
    }

    .status-good {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-low {
        background: #fff3e0;
        color: #ef6c00;
    }

    .status-out {
        background: #ffebee;
        color: #c62828;
    }

    /* KHÔNG CÓ DỮ LIỆU */

    .inventory-empty {
        padding: 50px 20px;
        text-align: center;
        color: #999999;
    }

    .inventory-empty-icon {
        margin-bottom: 10px;
        color: #e57373;
        font-size: 36px;
    }

    .inventory-empty strong {
        display: block;
        margin-bottom: 5px;
        color: #777777;
        font-size: 15px;
    }

    .inventory-empty span {
        font-size: 13px;
    }

    /* RESPONSIVE */

    @media (max-width: 900px) {

        .inventory-heading h1 {
            font-size: 24px;
        }

        .inventory-table {
            min-width: 850px;
        }
    }
</style>

@section('content')

<div class="inventory-page">

    <!-- TIÊU ĐỀ -->

    <div class="inventory-heading">

        <h1>
            QUẢN LÝ TỒN KHO
        </h1>

    </div>


    <!-- THỐNG KÊ -->

    <div class="inventory-summary">

        <div class="summary-line">

            Tổng số sách:

            <strong>
                {{ $tonKhos->count() }}
            </strong>

        </div>


        <div class="summary-line">

            Tổng tồn kho:

            <strong>
                {{ number_format($tonKhos->sum('soLuongTon'), 0, ',', '.') }}
                cuốn
            </strong>

        </div>

    </div>


    <!-- DANH SÁCH TỒN KHO -->

    <div class="inventory-card">


        <div class="inventory-card-header">

            <h2>
                Danh sách tồn kho
            </h2>

            <p>
                Thông tin số lượng sách hiện có trong kho
            </p>

        </div>


        <div class="inventory-table-wrapper">


            <table class="inventory-table">


                <thead>

                    <tr>

                        <th>
                            STT
                        </th>

                        <th>
                            Mã sách
                        </th>

                        <th>
                            Tên sách
                        </th>

                        <th>
                            Số lượng tồn
                        </th>

                        <th>
                            Trạng thái
                        </th>

                        <th>
                            Ngày cập nhật
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @forelse($tonKhos as $index => $tonKho)


                        <tr>


                            <td>
                                {{ $index + 1 }}
                            </td>


                            <td>

                                <span class="book-code">
                                    {{ $tonKho->maSach }}
                                </span>

                            </td>


                            <td>

                                <span class="book-name">
                                    {{ $tonKho->sach->tenSach ?? 'Không xác định' }}
                                </span>

                            </td>


                            <td>

                                <span class="quantity">
                                    {{ number_format($tonKho->soLuongTon, 0, ',', '.') }}
                                </span>

                            </td>


                            <td>


                                @if($tonKho->soLuongTon <= 0)

                                    <span class="inventory-status status-out">
                                        Hết hàng
                                    </span>


                                @elseif($tonKho->soLuongTon <= 10)

                                    <span class="inventory-status status-low">
                                        Sắp hết
                                    </span>


                                @else

                                    <span class="inventory-status status-good">
                                        Còn hàng
                                    </span>

                                @endif


                            </td>


                            <td>


                                @if($tonKho->ngayCapNhat)

                                    {{ $tonKho->ngayCapNhat->format('d/m/Y H:i') }}

                                @else

                                    Chưa cập nhật

                                @endif


                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td colspan="6">

                                <div class="inventory-empty">

                                    <div class="inventory-empty-icon">
                                        ▣
                                    </div>

                                    <strong>
                                        Chưa có dữ liệu tồn kho
                                    </strong>

                                    <span>
                                        Hiện tại chưa có thông tin tồn kho.
                                    </span>

                                </div>

                            </td>

                        </tr>


                    @endforelse


                </tbody>


            </table>


        </div>

    </div>

</div>

@endsection