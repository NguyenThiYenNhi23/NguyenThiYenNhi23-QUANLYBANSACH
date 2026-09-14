@extends('layout.admin')

@section('title', 'Sửa phiếu nhập')

@push('styles')
<style>
    .form-page {
        padding: 30px 35px;
        font-family: Arial, sans-serif;
    }

    .form-title {
        text-align: center;
        color: #b5121b;
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 28px;
    }

    .form-card {
        background: #fff;
        border: 1px solid #f0d8da;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 5px 18px rgba(130, 20, 30, .06);
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #444;
        font-size: 14px;
        font-weight: 700;
    }

    .form-control {
        width: 100%;
        height: 44px;
        border: 1px solid #dfc3c6;
        border-radius: 10px;
        padding: 0 13px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #c91422;
        box-shadow: 0 0 0 3px rgba(201, 20, 34, .08);
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
        margin-bottom: 15px;
    }

    .detail-table th {
        background: #c91422;
        color: #fff;
        padding: 12px;
        font-size: 13px;
    }

    .detail-table td {
        padding: 9px;
        border-bottom: 1px solid #eee;
    }

    .detail-table select,
    .detail-table input {
        width: 100%;
        height: 40px;
        border: 1px solid #dfc3c6;
        border-radius: 8px;
        padding: 0 10px;
        font-family: Arial, sans-serif;
        box-sizing: border-box;
    }

    .btn-remove {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 8px;
        background: #ffe5e7;
        color: #b5121b;
        font-size: 18px;
        cursor: pointer;
    }

    .btn-add-row {
        border: 1px solid #c91422;
        background: #fff;
        color: #b5121b;
        border-radius: 9px;
        padding: 9px 15px;
        font-family: Arial, sans-serif;
        font-weight: 700;
        cursor: pointer;
    }

    .total-box {
        text-align: right;
        margin-top: 20px;
        font-size: 17px;
        font-weight: 700;
    }

    .total-box span {
        color: #b5121b;
        font-size: 20px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        min-width: 125px;
        height: 44px;
        border-radius: 10px;
        padding: 0 20px;
        font-family: Arial, sans-serif;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-sizing: border-box;
    }

    .btn-save {
        background: #c91422;
        color: #fff;
        border: none;
    }

    .btn-back {
        background: #fff;
        color: #b5121b;
        border: 1px solid #c91422;
    }

    .error {
        color: #b5121b;
        font-size: 13px;
        margin-bottom: 15px;
    }

    @media(max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-page {
            padding: 20px;
        }

        .form-card {
            overflow-x: auto;
        }

        .detail-table {
            min-width: 800px;
        }
    }
</style>
@endpush


@section('content')

<div class="form-page">

    <h1 class="form-title">
        Sửa phiếu nhập
    </h1>


    @if($errors->any())

        <div class="error">

            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach

        </div>

    @endif


    <div class="form-card">

        <form
            method="POST"
            action="{{ route('phieunhap.update', $phieuNhap->maPN) }}"
        >

            @csrf

            @method('PUT')


            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Mã phiếu
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="PN{{ str_pad($phieuNhap->maPN, 3, '0', STR_PAD_LEFT) }}"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>
                        Nhân viên lập
                    </label>

                    <select
                        name="maNV"
                        class="form-control"
                        required
                    >

                        @foreach($nhanViens as $nhanVien)

                            <option
                                value="{{ $nhanVien->maNV }}"
                                {{ $phieuNhap->maNV == $nhanVien->maNV ? 'selected' : '' }}
                            >
                                {{ $nhanVien->hoTen }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Ngày nhập
                    </label>

                    <input
                        type="datetime-local"
                        name="ngayNhap"
                        class="form-control"
                        value="{{ $phieuNhap->ngayNhap?->format('Y-m-d\TH:i') }}"
                        required
                    >

                </div>

            </div>


            <div class="detail-title">
                Chi tiết phiếu nhập
            </div>


            <table class="detail-table">

                <thead>

                    <tr>
                        <th style="width: 40%;">Sách</th>
                        <th style="width: 18%;">Số lượng</th>
                        <th style="width: 22%;">Đơn giá</th>
                        <th style="width: 15%;">Thành tiền</th>
                        <th style="width: 5%;"></th>
                    </tr>

                </thead>


                <tbody id="detailBody">

                @foreach($phieuNhap->chiTiet as $chiTiet)

                    <tr class="detail-row">

                        <td>

                            <select
                                name="maSach[]"
                                required
                            >

                                @foreach($sachs as $sach)

                                    <option
                                        value="{{ $sach->maSach }}"
                                        {{ $chiTiet->maSach == $sach->maSach ? 'selected' : '' }}
                                    >
                                        {{ $sach->maSach }} -
                                        {{ $sach->tenSach }}
                                    </option>

                                @endforeach

                            </select>

                        </td>


                        <td>

                            <input
                                type="number"
                                name="soLuong[]"
                                min="1"
                                value="{{ $chiTiet->soLuong }}"
                                oninput="calculateTotal()"
                                required
                            >

                        </td>


                        <td>

                            <input
                                type="number"
                                name="donGia[]"
                                min="0"
                                step="0.01"
                                value="{{ $chiTiet->donGia }}"
                                oninput="calculateTotal()"
                                required
                            >

                        </td>


                        <td class="thanh-tien">
                            {{ number_format($chiTiet->thanhTien, 0, ',', '.') }}
                        </td>


                        <td>

                            <button
                                type="button"
                                class="btn-remove"
                                onclick="removeRow(this)"
                            >
                                ×
                            </button>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>


            <button
                type="button"
                class="btn-add-row"
                onclick="addRow()"
            >
                ＋ Thêm sách
            </button>


            <div class="total-box">
                Tổng tiền:
                <span id="totalMoney">0</span> đ
            </div>


            <div class="form-actions">

                <a
                    href="{{ route('phieunhap.index') }}"
                    class="btn btn-back"
                >
                    Quay lại
                </a>

                <button
                    type="submit"
                    class="btn btn-save"
                >
                    Lưu thay đổi
                </button>

            </div>

        </form>

    </div>

</div>


<script>

function addRow() {

    const body =
        document.getElementById('detailBody');

    const firstRow =
        body.querySelector('.detail-row');

    const newRow =
        firstRow.cloneNode(true);


    newRow.querySelector('select').value = '';

    newRow.querySelectorAll('input')
        .forEach(function(input) {

            if (input.name === 'soLuong[]') {
                input.value = 1;
            }

            if (input.name === 'donGia[]') {
                input.value = 0;
            }
        });


    newRow.querySelector('.thanh-tien')
        .textContent = '0';


    body.appendChild(newRow);

    calculateTotal();
}


function removeRow(button) {

    const rows =
        document.querySelectorAll('.detail-row');


    if (rows.length === 1) {

        alert(
            'Phiếu nhập phải có ít nhất một sách.'
        );

        return;
    }


    button.closest('.detail-row').remove();

    calculateTotal();
}


function calculateTotal() {

    let total = 0;


    document.querySelectorAll('.detail-row')
        .forEach(function(row) {

            const quantity =
                Number(
                    row.querySelector(
                        'input[name="soLuong[]"]'
                    ).value
                ) || 0;


            const price =
                Number(
                    row.querySelector(
                        'input[name="donGia[]"]'
                    ).value
                ) || 0;


            const money =
                quantity * price;


            row.querySelector('.thanh-tien')
                .textContent =
                money.toLocaleString('vi-VN');


            total += money;
        });


    document.getElementById('totalMoney')
        .textContent =
        total.toLocaleString('vi-VN');
}


calculateTotal();

</script>

@endsection