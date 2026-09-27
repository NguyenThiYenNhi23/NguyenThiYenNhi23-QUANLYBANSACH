@extends('quantri.layouts.quantri_layout')

@section('title', 'Thống kê')
@section('header-title', 'Thống kê')

@section('content')

<div class="stats-page">

    {{-- =====================================================
         TIÊU ĐỀ
    ====================================================== --}}

    <div class="stats-header">
        <h1>Thống kê hệ thống</h1>

        <p>
            Tổng quan nhanh về sản phẩm, đơn hàng và doanh thu.
        </p>
    </div>


    {{-- =====================================================
         4 Ô THÔNG TIN NHANH
    ====================================================== --}}

    <div class="quick-grid">


        {{-- SẢN PHẨM SẮP HẾT --}}

        <div class="quick-card quick-warning">

            <div class="quick-icon">
                📦
            </div>

            <div class="quick-content">

                <span>Sản phẩm sắp hết</span>

                <strong>
                    {{ number_format($sanPhamSapHet, 0, ',', '.') }}
                </strong>

                <small>
                    Sản phẩm cần nhập thêm
                </small>

            </div>

        </div>


        {{-- SÁCH BÁN CHẠY --}}

        <div class="quick-card quick-book">

            <div class="quick-icon">
                📚
            </div>

            <div class="quick-content">

                <span>Sách bán chạy</span>

                @if($sachBanChay->count() > 0)

                    <strong class="book-name">
                        {{ $sachBanChay->first()->tenSach }}
                    </strong>

                    <small>
                        {{ number_format($sachBanChay->first()->tongDaBan, 0, ',', '.') }}
                        cuốn đã bán
                    </small>

                @else

                    <strong>
                        Chưa có
                    </strong>

                    <small>
                        Chưa có dữ liệu bán hàng
                    </small>

                @endif

            </div>

        </div>


        {{-- ĐƠN HÀNG HÔM NAY --}}

        <div class="quick-card quick-order">

            <div class="quick-icon">
                🛒
            </div>

            <div class="quick-content">

                <span>Đơn hàng hôm nay</span>

                <strong>
                    {{ number_format($donHangHomNay, 0, ',', '.') }}
                </strong>

                <small>
                    Đơn hàng trong ngày
                </small>

            </div>

        </div>


        {{-- DOANH THU THÁNG NÀY --}}

        <div class="quick-card quick-revenue">

            <div class="quick-icon">
                📈
            </div>

            <div class="quick-content">

                <span>Doanh thu tháng này</span>

                <strong>
                    {{ number_format($doanhThuThangNay, 0, ',', '.') }} ₫
                </strong>

                <small>
                    {{ now()->format('m/Y') }}
                </small>

            </div>

        </div>

    </div>

{{-- BẢNG DOANH THU --}}
<div class="panel revenue-panel">

    <div class="panel-header chart-header">

        <div>

            <h2>📈 Doanh thu</h2>

            <p>
                Doanh thu từ
                {{ \Carbon\Carbon::parse($tuNgay)->format('d/m/Y') }}
                đến
                {{ \Carbon\Carbon::parse($denNgay)->format('d/m/Y') }}
            </p>

        </div>

    </div>


    {{-- BỘ LỌC NGÀY --}}

    <form
        method="GET"
        action="{{ route('quantri.thongke') }}"
        class="revenue-filter"
    >

        <div class="filter-group">

            <label>Từ ngày</label>

            <input
                type="date"
                name="tuNgay"
                value="{{ $tuNgay }}"
            >

        </div>


        <div class="filter-group">

            <label>Đến ngày</label>

            <input
                type="date"
                name="denNgay"
                value="{{ $denNgay }}"
            >

        </div>


        <button
            type="submit"
            class="filter-button"
        >
            🔍 Lọc doanh thu
        </button>

    </form>


    {{-- TỔNG DOANH THU --}}

    <div class="revenue-total">

        <span>
            Tổng doanh thu trong khoảng đã chọn
        </span>

        <strong>
            {{ number_format(
                $tongDoanhThuLoc,
                0,
                ',',
                '.'
            ) }} ₫
        </strong>

    </div>


    {{-- BIỂU ĐỒ --}}

    <div class="chart-container">

        <div class="chart-y-axis">

            <span>
                {{ number_format(
                    $doanhThuCaoNhat,
                    0,
                    ',',
                    '.'
                ) }}
            </span>

            <span>
                {{ number_format(
                    $doanhThuCaoNhat * 0.75,
                    0,
                    ',',
                    '.'
                ) }}
            </span>

            <span>
                {{ number_format(
                    $doanhThuCaoNhat * 0.5,
                    0,
                    ',',
                    '.'
                ) }}
            </span>

            <span>
                {{ number_format(
                    $doanhThuCaoNhat * 0.25,
                    0,
                    ',',
                    '.'
                ) }}
            </span>

            <span>0</span>

        </div>


        <div class="chart-area">

            <div class="chart-lines">

                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>

            </div>


            <div
                class="chart-columns"
                style="
                    grid-template-columns:
                    repeat({{ max(count($bieuDoDoanhThu), 1) }}, 1fr);
                "
            >

                @foreach($bieuDoDoanhThu as $item)

                    @php

                        if ($item['doanhThu'] > 0) {

                            $height =
                                ($item['doanhThu']
                                / $doanhThuCaoNhat)
                                * 100;

                            $height = max(
                                6,
                                $height
                            );

                        } else {

                            $height = 3;

                        }

                    @endphp


                    <div class="chart-column">

                        <div class="chart-number">

                            @if($item['doanhThu'] > 0)

                                {{ number_format(
                                    $item['doanhThu'],
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            @else

                                0

                            @endif

                        </div>


                        <div class="bar-wrapper">

                            <div
                                class="
                                    revenue-bar
                                    {{ $item['doanhThu'] > 0
                                        ? 'has-data'
                                        : 'no-data'
                                    }}
                                "
                                style="
                                    height: {{ $height }}%;
                                "
                                title="
                                    {{ $item['hienThi'] }}:
                                    {{ number_format(
                                        $item['doanhThu'],
                                        0,
                                        ',',
                                        '.'
                                    ) }} ₫
                                "
                            ></div>

                        </div>


                        <span class="chart-month">

                            {{ $item['hienThi'] }}

                        </span>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

{{-- =========================
     SÁCH BÁN CHẠY
========================== --}}

<div class="panel best-book-panel">

    <div class="panel-header">

        <div>
            <h2>📚 Sách bán chạy</h2>

            <p class="panel-subtitle">
                Những sách có số lượng bán cao nhất
            </p>
        </div>

    </div>


    <div class="table-wrap">

        <table>

            <thead>

                <tr>

                    <th>STT</th>

                    <th>Tên sách</th>

                    <th>Giá bán</th>

                    <th>Đã bán</th>

                </tr>

            </thead>


            <tbody>

                @forelse($sachBanChay as $index => $sach)

                    <tr>

                        <td>

                            <span class="rank-badge">
                                {{ $index + 1 }}
                            </span>

                        </td>


                        <td>

                            <strong class="book-table-name">
                                {{ $sach->tenSach }}
                            </strong>

                        </td>


                        <td>

                            {{ number_format(
                                $sach->giaBan,
                                0,
                                ',',
                                '.'
                            ) }} ₫

                        </td>


                        <td>

                            <span class="sold-badge">

                                {{ number_format(
                                    $sach->tongDaBan,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                                cuốn

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="empty-cell"
                        >
                            Chưa có dữ liệu bán hàng.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</div>



<style>

/* =========================================================
   TỔNG THỂ
========================================================= */

.stats-page {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}


/* =========================================================
   HEADER
========================================================= */

.stats-header {
    margin-bottom: 24px;
}

.stats-header h1 {
    margin: 0 0 8px;
    font-size: 30px;
    color: #2f80ed;
    font-weight: 800;
}

.stats-header p {
    margin: 0;
    color: #666;
    font-size: 15px;
}


/* =========================================================
   4 Ô THÔNG TIN NHANH
========================================================= */

.quick-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 22px;
}

.quick-card {
    min-height: 125px;

    border-radius: 14px;

    padding: 17px;

    display: flex;
    align-items: flex-start;

    gap: 13px;

    border: 1px solid transparent;

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.quick-card:hover {
    transform: translateY(-2px);

    box-shadow:
        0 6px 16px rgba(47, 128, 237, 0.10);
}

.quick-icon {
    width: 45px;
    height: 45px;

    flex: 0 0 45px;

    border-radius: 12px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: rgba(255, 255, 255, 0.85);

    font-size: 21px;
}

.quick-content {
    min-width: 0;
}

.quick-content span {
    display: block;

    font-size: 13px;

    margin-bottom: 6px;
}

.quick-content strong {
    display: block;

    font-size: 22px;

    line-height: 1.25;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;
}

.quick-content small {
    display: block;

    margin-top: 5px;

    font-size: 11px;

    opacity: 0.85;
}


/* =========================================================
   MÀU 4 Ô
========================================================= */

.quick-warning {
    background: #eef6ff;

    color: #2f80ed;

    border-color: #d7e9ff;
}

.quick-book {
    background: #f1f7ff;

    color: #2878e8;

    border-color: #dcecff;
}

.quick-order {
    background: #edf5ff;

    color: #1976d2;

    border-color: #d7e8ff;
}

.quick-revenue {
    background: #eaf3ff;

    color: #1565c0;

    border-color: #d2e5ff;
}

.book-name {
    max-width: 210px;
}


/* =========================================================
   PANEL
========================================================= */

.panel {
    background: #fff;

    border: 1px solid #dcecff;

    border-radius: 14px;

    overflow: hidden;

    box-shadow:
        0 4px 12px rgba(47, 128, 237, 0.06);
}

.panel-header {
    padding: 18px 20px;

    border-bottom: 1px solid #dcecff;

    background: #f3f8ff;
}

.panel-header h2 {
    margin: 0;

    font-size: 20px;

    color: #246fcb;

    font-weight: 750;
}

.panel-subtitle {
    margin: 5px 0 0;

    color: #7b8da6;

    font-size: 13px;
}


/* =========================================================
   BIỂU ĐỒ DOANH THU
========================================================= */

.revenue-panel {
    margin-bottom: 22px;
}

.chart-header {
    display: flex;

    align-items: center;

    justify-content: space-between;
}

.chart-header p {
    margin: 5px 0 0;

    color: #888;

    font-size: 13px;
}

.chart-year {
    padding: 8px 14px;

    border-radius: 9px;

    background: #eaf3ff;

    color: #2f80ed;

    font-weight: 700;

    font-size: 13px;
}

.chart-container {
    display: flex;

    height: 340px;

    padding: 25px 25px 15px 15px;
}

.chart-y-axis {
    width: 75px;

    display: flex;

    flex-direction: column;

    justify-content: space-between;

    padding-bottom: 31px;

    text-align: right;

    padding-right: 12px;

    color: #999;

    font-size: 10px;
}

.chart-area {
    flex: 1;

    position: relative;

    min-width: 0;
}

.chart-lines {
    position: absolute;

    left: 0;
    right: 0;

    top: 0;
    bottom: 31px;

    display: flex;

    flex-direction: column;

    justify-content: space-between;
}

.chart-lines div {
    width: 100%;

    border-top: 1px dashed #dcecff;
}

.chart-columns {
    position: absolute;

    left: 0;
    right: 0;

    top: 0;
    bottom: 0;

    display: grid;

    grid-template-columns: repeat(12, 1fr);

    gap: 9px;
}

.chart-column {
    display: grid;

    grid-template-rows: 27px 1fr 31px;

    align-items: end;

    min-width: 0;

    text-align: center;
}

.chart-number {
    font-size: 9px;

    color: #777;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;
}

.bar-wrapper {
    height: 100%;

    display: flex;

    align-items: end;

    justify-content: center;
}

.revenue-bar {
    width: 65%;

    max-width: 38px;

    min-height: 3px;

    border-radius: 8px 8px 3px 3px;

    transition:
        height 0.3s ease,
        opacity 0.2s ease;
}

.revenue-bar.has-data {
    background: linear-gradient(
        180deg,
        #2f80ed 0%,
        #67aaf3 100%
    );

    box-shadow:
        0 4px 9px rgba(47, 128, 237, 0.2);
}

.revenue-bar.no-data {
    background: #dcecff;
}

.chart-column:hover .revenue-bar.has-data {
    opacity: 0.78;
}

.chart-month {
    font-size: 12px;

    color: #666;

    font-weight: 600;

    padding-top: 8px;
}


/* =========================================================
   BẢNG TOP SÁCH
========================================================= */

.recent-panel {
    margin-bottom: 25px;
}

.table-wrap {
    overflow-x: auto;
}

table {
    width: 100%;

    border-collapse: collapse;
}

th,
td {
    padding: 14px 16px;

    text-align: left;

    border-bottom: 1px solid #e5effc;

    font-size: 14px;
}

th {
    background: #f3f8ff;

    color: #246fcb;

    font-weight: 700;
}

tbody tr {
    transition: background 0.15s ease;
}

tbody tr:hover {
    background: #f5f9ff;
}

tbody tr:last-child td {
    border-bottom: none;
}

td strong {
    color: #246fcb;
}


/* =========================================================
   XẾP HẠNG
========================================================= */

.rank-badge {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    width: 32px;
    height: 32px;

    border-radius: 9px;

    background: #eaf3ff;

    color: #2f80ed;

    font-weight: 800;
}

.book-table-name {
    color: #333;

    font-weight: 700;
}

.sold-count {
    display: inline-block;

    padding: 6px 10px;

    border-radius: 8px;

    background: #edf5ff;

    color: #1976d2;

    font-weight: 700;
}


/* ==============================
   BỘ LỌC DOANH THU
============================== */

.revenue-filter {
    display: flex !important;
    align-items: flex-end !important;
    justify-content: flex-end !important;

    gap: 22px;

    width: 100%;
    padding: 10px 32px;

    box-sizing: border-box;

    background: #f8fbff;

    border-bottom: 1px solid #e5effa;
}


/* NHÓM TỪ NGÀY / ĐẾN NGÀY */

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.filter-group label {
    font-size: 12px;
    font-weight: 700;
    color: #52708f;
}

.filter-group input {
    height: 38px;

    padding: 0 11px;

    border: 1px solid #cfe0f2;
    border-radius: 8px;

    background: #fff;
    color: #333;

    outline: none;

    box-sizing: border-box;
}

.filter-group input:focus {
    border-color: #2f80ed;

    box-shadow:
        0 0 0 3px rgba(47, 128, 237, 0.1);
}


/* NÚT LỌC */

.filter-button {
    height: 38px;

    padding: 0 17px;

    border: none;
    border-radius: 8px;

    background: #2f80ed;
    color: #fff;

    font-weight: 700;

    cursor: pointer;
}

.filter-button:hover {
    background: #246fcb;
}
/* ==============================
   TỔNG DOANH THU
============================== */

.revenue-total {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    border-bottom: 1px solid #e8f0f8;
}

.revenue-total span {
    color: #6b7f93;
    font-size: 14px;
}

.revenue-total strong {
    color: #2f80ed;
    font-size: 22px;
}


/* ==============================
   BẢNG SÁCH BÁN CHẠY
============================== */

.panel-subtitle {
    margin: 5px 0 0;
    color: #8798aa;
    font-size: 13px;
}

.rank-badge {
    width: 28px;
    height: 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #eaf3ff;
    color: #2f80ed;
    font-weight: 700;
    font-size: 13px;
}

.book-table-name {
    color: #334e68;
}

.sold-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 7px;
    background: #edf5ff;
    color: #2f80ed;
    font-weight: 700;
    font-size: 12px;
}



</style>

@endsection