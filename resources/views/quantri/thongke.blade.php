@extends('quantri.layouts.quantri_layout')

@section('title', 'Thống kê')
@section('header-title', 'Thống kê')

@section('content')
<div class="stats-page">
    <div class="stats-header">
        <h1>Thống kê hệ thống</h1>
        <p>Tổng quan nhanh về doanh thu, sản phẩm và đơn hàng.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-red">📚</div>
            <div class="stat-content">
                <span>Tổng sách</span>
                <strong>{{ number_format($tongSach, 0, ',', '.') }}</strong>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-orange">📂</div>
            <div class="stat-content">
                <span>Danh mục</span>
                <strong>{{ number_format($tongDanhMuc, 0, ',', '.') }}</strong>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-green">🛒</div>
            <div class="stat-content">
                <span>Đơn hàng</span>
                <strong>{{ number_format($tongDonHang, 0, ',', '.') }}</strong>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-blue">💰</div>
            <div class="stat-content">
                <span>Doanh thu</span>
                <strong>{{ number_format($tongDoanhThu, 0, ',', '.') }} ₫</strong>
            </div>
        </div>
    </div>

    <div class="stats-row">
        <div class="panel">
            <div class="panel-header">
                <h2>Đơn hàng gần đây</h2>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donHangGanDay as $donHang)
                            <tr>
                                <td>#{{ $donHang->maDH }}</td>
                                <td>{{ $donHang->khachHang->hoTen ?? 'Khách hàng' }}</td>
                                <td>{{ $donHang->ngayDat ? $donHang->ngayDat->format('d/m/Y H:i') : '---' }}</td>
                                <td>{{ number_format($donHang->tongTien, 0, ',', '.') }} ₫</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-cell">Chưa có đơn hàng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2>Thông tin nhanh</h2>
            </div>

            <div class="mini-boxes">
                <div class="mini-box warning">
                    <span>Sản phẩm sắp hết</span>
                    <strong>{{ number_format($sanPhamSapHet, 0, ',', '.') }}</strong>
                </div>
                <div class="mini-box info">
                    <span>Trạng thái</span>
                    <strong>Hoạt động</strong>
                </div>
                <div class="mini-box success">
                    <span>Hệ thống</span>
                    <strong>Ổn định</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stats-page {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .stats-header {
        margin-bottom: 24px;
    }

    .stats-header h1 {
        margin: 0 0 8px;
        font-size: 30px;
        color: #b71c1c;
    }

    .stats-header p {
        margin: 0;
        color: #666;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 16px;
        background: #fff;
        border-radius: 14px;
        padding: 18px 20px;
        border: 1px solid #f3d7d7;
        box-shadow: 0 4px 12px rgba(183, 28, 28, 0.05);
    }

    .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #fff;
    }

    .bg-red { background: linear-gradient(135deg, #d32f2f, #ef5350); }
    .bg-orange { background: linear-gradient(135deg, #ef6c00, #ffb74d); }
    .bg-green { background: linear-gradient(135deg, #2e7d32, #66bb6a); }
    .bg-blue { background: linear-gradient(135deg, #1976d2, #64b5f6); }

    .stat-content {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .stat-content span {
        color: #666;
        font-size: 13px;
    }

    .stat-content strong {
        color: #222;
        font-size: 26px;
        line-height: 1.2;
    }

    .stats-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .panel {
        background: #fff;
        border: 1px solid #f3d7d7;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(183, 28, 28, 0.05);
    }

    .panel-header {
        padding: 18px 20px;
        border-bottom: 1px solid #f5e5e5;
        background: #fff8f8;
    }

    .panel-header h2 {
        margin: 0;
        font-size: 20px;
        color: #b71c1c;
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid #f4ecec;
        font-size: 14px;
    }

    th {
        background: #faf3f3;
        color: #7b1e1e;
        font-weight: 700;
    }

    tbody tr:hover {
        background: #fffaf8;
    }

    .empty-cell {
        text-align: center;
        color: #888;
        padding: 20px;
    }

    .mini-boxes {
        display: flex;
        flex-direction: column;
        gap: 14px;
        padding: 20px;
    }

    .mini-box {
        border-radius: 12px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .mini-box.warning { background: #fff3e0; color: #ef6c00; }
    .mini-box.info { background: #e3f2fd; color: #1565c0; }
    .mini-box.success { background: #e8f5e9; color: #2e7d32; }

    .mini-box span {
        font-size: 13px;
    }

    .mini-box strong {
        font-size: 22px;
    }

    @media (max-width: 900px) {
        .stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
