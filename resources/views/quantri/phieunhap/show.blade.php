@extends('quantri.layouts.quantri_layout')

@section('title', 'Chi tiết phiếu nhập')

@section('header-title', 'Chi tiết phiếu nhập')

@section('content')

<style>

    .show-page {
        padding: 30px 35px;
        font-family: Arial, sans-serif;
    }

    .show-title {
        text-align: center;
        color: #2f5f98;
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 28px;
    }

    .show-card {
        background: #fff;
        border: 1px solid #d7e3ef;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 5px 18px rgba(47, 95, 152, .08);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    .info-item {
        background: #f8fbfe;
        border: 1px solid #dfe9f3;
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
        color: #2f5f98;
    }

    .status {
        display: inline-block;
        padding: 6px 13px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    /* Chưa xác nhận */
    .status-waiting {
        color: #8a6800;
        background: #fff4cc;
    }

    /* Hoàn thành */
    .status-done {
        color: #18713c;
        background: #e8f7ee;
    }

    /* Đã hủy */
    .status-cancel {
        color: #a30f18;
        background: #ffe5e7;
    }

    .detail-title {
        color: #2f5f98;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
    }

    .detail-table th {
        background: #4f81bd;
        color: #fff;
        padding: 13px;
        text-align: center;
        font-size: 14px;
    }

    .detail-table td {
        padding: 13px;
        border-bottom: 1px solid #e3ebf4;
        text-align: center;
        font-size: 14px;
    }

    .detail-table tbody tr:hover {
        background: #f5f9fd;
    }

    .total {
        text-align: right;
        margin-top: 20px;
        font-size: 18px;
        font-weight: 700;
    }

    .total span {
        color: #2f5f98;
        font-size: 21px;
    }

    /*
     * Khu vực nút
     */

    .actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 25px;
    }

    /*
     * Nút quay lại
     */

    .btn-back {
        min-width: 125px;
        height: 44px;
        border-radius: 10px;
        border: 1px solid #4f81bd;
        color: #2f5f98;
        background: #fff;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        cursor: pointer;
        box-sizing: border-box;
    }

    .btn-back:hover {
        background: #4f81bd;
        color: #fff;
    }

    /*
     * Nút xác nhận
     */

    .btn-confirm {
        min-width: 180px;
        height: 44px;
        border-radius: 10px;
        border: none;
        color: #fff;
        background: #198754;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-confirm:hover {
        background: #157347;
    }

    .confirm-form {
        margin: 0;
    }

    /*
     * Thông báo
     */

    .alert {
        padding: 13px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .alert-success {
        color: #18713c;
        background: #e8f7ee;
        border: 1px solid #b7e4c7;
    }

    .alert-error {
        color: #a30f18;
        background: #ffe5e7;
        border: 1px solid #f3b7bc;
    }

    @media (max-width: 768px) {

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
            min-width: 900px;
        }

        .actions {
            justify-content: center;
            flex-wrap: wrap;
        }

    }

</style>

<div class="show-page">

    <h1 class="show-title">
        Chi tiết phiếu nhập
    </h1>


    {{-- ================= THÔNG BÁO ================= --}}

    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if (session('error'))

        <div class="alert alert-error">
            {{ session('error') }}
        </div>

    @endif


    <div class="show-card">


        {{-- ================= THÔNG TIN PHIẾU ================= --}}

        <div class="info-grid">


            {{-- Mã phiếu --}}

            <div class="info-item">

                <div class="info-label">
                    Mã phiếu
                </div>

                <div class="info-value ma-phieu">

                    PN{{ str_pad(
                        $phieuNhap->maPN,
                        3,
                        '0',
                        STR_PAD_LEFT
                    ) }}

                </div>

            </div>


            {{-- Nhân viên lập --}}

            <div class="info-item">

                <div class="info-label">
                    Nhân viên lập
                </div>

                <div class="info-value">

                    @if ($phieuNhap->maNV === null)

                        Admin

                    @else

                        Nhân viên:
                        {{ $phieuNhap->nhanVien->hoTen
                            ?? 'Không xác định' }}

                    @endif

                </div>

            </div>


            {{-- Ngày nhập --}}

            <div class="info-item">

                <div class="info-label">
                    Ngày nhập
                </div>

                <div class="info-value">

                    {{ $phieuNhap->ngayNhap?->format(
                        'd/m/Y H:i'
                    ) }}

                </div>

            </div>


            {{-- Trạng thái --}}

            <div class="info-item">

                <div class="info-label">
                    Trạng thái
                </div>

                <div class="info-value">

                    @if ($phieuNhap->trangThai === 'ChoXacNhan')

                        <span class="status status-waiting">
                            Chưa xác nhận
                        </span>

                    @elseif ($phieuNhap->trangThai === 'HoanThanh')

                        <span class="status status-done">
                            Hoàn thành
                        </span>

                    @elseif ($phieuNhap->trangThai === 'DaHuy')

                        <span class="status status-cancel">
                            Đã hủy
                        </span>

                    @else

                        <span class="status status-waiting">
                            {{ $phieuNhap->trangThai }}
                        </span>

                    @endif

                </div>

            </div>


        </div>


        {{-- ================= CHI TIẾT SÁCH ================= --}}

        <div class="detail-title">
            Chi tiết sách nhập
        </div>


        <table class="detail-table">

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
                        Số lượng
                    </th>

                    <th>
                        Giá nhập
                    </th>

                    <th>
                        Giá bán
                    </th>

                    <th>
                        Thành tiền
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse (
                    $phieuNhap->chiTiet
                    as $index => $chiTiet
                )

                    <tr>

                        {{-- STT --}}

                        <td>
                            {{ $index + 1 }}
                        </td>


                        {{-- Mã sách --}}

                        <td>
                            {{ $chiTiet->maSach }}
                        </td>


                        {{-- Tên sách --}}

                        <td>
                            {{ $chiTiet->sach->tenSach
                                ?? 'Không xác định' }}
                        </td>


                        {{-- Số lượng --}}

                        <td>
                            {{ number_format(
                                $chiTiet->soLuong
                            ) }}
                        </td>


                        {{-- Giá nhập --}}

                        <td>

                            {{ number_format(
                                $chiTiet->donGia,
                                0,
                                ',',
                                '.'
                            ) }}

                            đ

                        </td>


                        {{-- Giá bán --}}

                        <td>

                            @if (
                                $chiTiet->sach
                                && $chiTiet->sach->giaBan !== null
                                && $chiTiet->sach->giaBan > 0
                            )

                                {{ number_format(
                                    $chiTiet->sach->giaBan,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                                đ

                            @else

                                -

                            @endif

                        </td>


                        {{-- Thành tiền --}}

                        <td>

                            {{ number_format(
                                $chiTiet->thanhTien,
                                0,
                                ',',
                                '.'
                            ) }}

                            đ

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7">
                            Phiếu chưa có chi tiết.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>


        {{-- ================= TỔNG TIỀN ================= --}}

        <div class="total">

            Tổng tiền:

            <span>

                {{ number_format(
                    $phieuNhap->tongTien,
                    0,
                    ',',
                    '.'
                ) }}

                đ

            </span>

        </div>


        {{-- ================= NÚT ================= --}}

        <div class="actions">


            {{-- XÁC NHẬN CHỈ ADMIN MỚI ĐƯỢC THẤY --}}

            @if (
                $phieuNhap->trangThai === 'ChoXacNhan'
                && Auth::check()
                && strtolower(trim(Auth::user()->role ?? '')) === 'admin'
            )

                <form
                    action="{{ route(
                        'phieunhap.confirm',
                        $phieuNhap->maPN
                    ) }}"
                    method="POST"
                    class="confirm-form"
                >

                    @csrf

                    @method('PATCH')

                    <button
                        type="submit"
                        class="btn-confirm"
                        onclick="return confirm(
                            'Bạn có chắc chắn muốn xác nhận phiếu nhập này không?'
                        )"
                    >
                        ✓ Xác nhận phiếu nhập
                    </button>

                </form>

            @endif


            {{-- QUAY LẠI --}}

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