@extends('layout.admin')

@section('title', 'Chi tiết phiếu nhập')

@push('styles')
<style>
    .show-page {
        padding: 30px 35px;
        font-family: Arial, sans-serif;
    }

    .show-title {
        text-align: center;
        color: #b5121b;
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 28px;
    }

    .show-card {
        background: #fff;
        border: 1px solid #f0d8da;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 5px 18px rgba(130, 20, 30, .06);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    .info-item {
        background: #fffafa;
        border: 1px solid #f1dddd;
        border-radius: 11px;
        padding: 15px;
    }

    .info-label {
        color: #777;
        font-size: 13px;
        margin-bottom: 7px;
    }

    .info-value {
        color: #333;
        font-size: 15px;
        font-weight: 700;
    }

    .ma-phieu {
        color: #b5121b;
    }

    .status {
        display: inline-block;
        padding: 6px 13px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-done {
        color: #0d7438;
        background: #e8f7ee;
    }

    .status-cancel {
        color: #a30f18;
        background: #ffe5e7;
    }

    .detail-title {
        color: #b5121b;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
    }

    .detail-table th {
        background: #c91422;
        color: #fff;
        padding: 13px;
        text-align: center;
        font-size: 14px;
    }

    .detail-table td {
        padding: 13px;
        border-bottom: 1px solid #eee;
        text-align: center;
        font-size: 14px;
    }

    .total {
        text-align: right;
        margin-top: 20px;
        font-size: 18px;
        font-weight: 700;
    }

    .total span {
        color: #b5121b;
        font-size: 21px;
    }

    .actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 25px;
    }

    .btn-back {
        min-width: 125px;
        height: 44px;
        border-radius: 10px;
        border: 1px solid #c91422;
        color: #b5121b;
        background: #fff;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    @media(max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .show-page {
            padding: 20px;
        }

        .show-card {
            overflow-x: auto;
        }

        .detail-table {
            min-width: 700px;
        }
    }
</style>
@endpush


@section('content')

<div class="show-page">

    <h1 class="show-title">
        Chi tiết phiếu nhập
    </h1>


    <div class="show-card">

        <div class="info-grid">

            <div class="info-item">

                <div class="info-label">
                    Mã phiếu
                </div>

                <div class="info-value ma-phieu">
                    PN{{ str_pad($phieuNhap->maPN, 3, '0', STR_PAD_LEFT) }}
                </div>

            </div>


            <div class="info-item">

                <div class="info-label">
                    Nhân viên lập
                </div>

                <div class="info-value">
                    {{ $phieuNhap->nhanVien->hoTen ?? 'Không xác định' }}
                </div>

            </div>


            <div class="info-item">

                <div class="info-label">
                    Ngày nhập
                </div>

                <div class="info-value">
                    {{ $phieuNhap->ngayNhap?->format('d/m/Y H:i') }}
                </div>

            </div>


            <div class="info-item">

                <div class="info-label">
                    Trạng thái
                </div>

                <div class="info-value">

                    @if($phieuNhap->trangThai === 'DaHuy')

                        <span class="status status-cancel">
                            Đã hủy
                        </span>

                    @else

                        <span class="status status-done">
                            Đã nhập
                        </span>

                    @endif

                </div>

            </div>

        </div>


        <div class="detail-title">
            Chi tiết sách nhập
        </div>


        <table class="detail-table">

            <thead>

                <tr>
                    <th>STT</th>
                    <th>Mã sách</th>
                    <th>Tên sách</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>

            </thead>


            <tbody>

            @forelse($phieuNhap->chiTiet as $index => $chiTiet)

                <tr>

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $chiTiet->maSach }}
                    </td>

                    <td>
                        {{ $chiTiet->sach->tenSach ?? 'Không xác định' }}
                    </td>

                    <td>
                        {{ number_format($chiTiet->soLuong) }}
                    </td>

                    <td>
                        {{ number_format($chiTiet->donGia, 0, ',', '.') }} đ
                    </td>

                    <td>
                        {{ number_format($chiTiet->thanhTien, 0, ',', '.') }} đ
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6">
                        Phiếu chưa có chi tiết.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>


        <div class="total">
            Tổng tiền:
            <span>
                {{ number_format($phieuNhap->tongTien, 0, ',', '.') }} đ
            </span>
        </div>


        <div class="actions">

            <a
                href="{{ route('phieunhap.index') }}"
                class="btn-back"
            >
                Quay lại
            </a>

        </div>

    </div>

</div>

@endsection