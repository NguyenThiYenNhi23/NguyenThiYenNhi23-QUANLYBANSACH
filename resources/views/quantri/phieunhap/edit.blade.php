@extends('quantri.layouts.quantri_layout')

@section('title', 'Sửa phiếu nhập')

@section('header-title', 'Sửa phiếu nhập')

@section('content')

<style>
    .form-page {
        padding: 30px 35px;
        font-family: Arial, sans-serif;
    }

    .form-title {
        text-align: center;
        color: #2f5f98;
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 28px;
    }

    .form-card {
        background: #fff;
        border: 1px solid #d7e3ef;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 5px 18px rgba(47, 95, 152, .08);
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
        border: 1px solid #b8cbe0;
        border-radius: 10px;
        padding: 0 13px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
        background: #fff;
    }

    .form-control:focus {
        border-color: #4f81bd;
        box-shadow: 0 0 0 3px rgba(79, 129, 189, .12);
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
        margin-bottom: 15px;
    }

    .detail-table th {
        background: #4f81bd;
        color: #fff;
        padding: 12px;
        font-size: 13px;
        text-align: center;
    }

    .detail-table td {
        padding: 9px;
        border-bottom: 1px solid #e3ebf4;
        text-align: center;
        vertical-align: top;
    }

    .detail-table select,
    .detail-table input {
        width: 100%;
        height: 40px;
        border: 1px solid #b8cbe0;
        border-radius: 8px;
        padding: 0 10px;
        font-family: Arial, sans-serif;
        box-sizing: border-box;
    }

    .detail-table select:focus,
    .detail-table input:focus {
        outline: none;
        border-color: #4f81bd;
    }

    /* Giá bán chỉ hiển thị, không cho sửa */
    .gia-ban-display {
        background: #f1f5f9 !important;
        color: #555;
        cursor: not-allowed;
    }

    .input-error {
        border-color: #d9534f !important;
        background: #fff5f5 !important;
    }

    .price-error,
    .book-error {
        display: none;
        color: #c0392b;
        font-size: 12px;
        font-weight: 600;
        margin-top: 5px;
        text-align: left;
        line-height: 1.4;
    }

    .server-error {
        display: block;
    }

    .btn-remove {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 8px;
        background: #e5eef7;
        color: #2f5f98;
        font-size: 18px;
        cursor: pointer;
    }

    .btn-remove:hover {
        background: #d3e2f0;
    }

    .btn-add-row {
        border: 1px solid #4f81bd;
        background: #fff;
        color: #2f5f98;
        border-radius: 9px;
        padding: 9px 15px;
        font-family: Arial, sans-serif;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-add-row:hover {
        background: #edf5fc;
    }

    .total-box {
        text-align: right;
        margin-top: 20px;
        font-size: 17px;
        font-weight: 700;
    }

    .total-box span {
        color: #2f5f98;
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
        background: #4f81bd;
        color: #fff;
        border: none;
    }

    .btn-save:hover {
        background: #3f6fa8;
    }

    .btn-back {
        background: #fff;
        color: #2f5f98;
        border: 1px solid #4f81bd;
    }

    .btn-back:hover {
        background: #edf5fc;
    }

    .error {
        color: #c0392b;
        font-size: 13px;
        margin-bottom: 15px;
    }

    .error div {
        margin-bottom: 4px;
    }

    @media (max-width: 768px) {
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
            min-width: 900px;
        }
    }
</style>
<div class="form-page">

    <h1 class="form-title">
        Sửa phiếu nhập
    </h1>

    {{-- Thông báo lỗi tổng quát --}}
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>
                    {{ $error }}
                </div>
            @endforeach
        </div>
    @endif

    @if (session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    <div class="form-card">

        <form
            id="phieuNhapForm"
            method="POST"
            action="{{ route('phieunhap.update', $phieuNhap->maPN) }}"
        >
            @csrf
            @method('PUT')

            <div class="form-grid">

                {{-- MÃ PHIẾU --}}
                <div class="form-group">
                    <label>
                        Mã phiếu
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="PN{{ str_pad(
                            $phieuNhap->maPN,
                            3,
                            '0',
                            STR_PAD_LEFT
                        ) }}"
                        readonly
                    >
                </div>

                {{-- NHÂN VIÊN LẬP --}}
                <div class="form-group">
                    <label>
                        Nhân viên lập
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{
                            $phieuNhap->maNV === null
                                ? 'Admin'
                                : 'Nhân viên: ' .
                                    ($phieuNhap->nhanVien->hoTen ?? 'Không xác định')
                        }}"
                        readonly
                    >
                </div>

                {{-- NGÀY NHẬP --}}
                <div class="form-group">
                    <label>
                        Ngày nhập
                    </label>

                    <input
                        type="datetime-local"
                        name="ngayNhap"
                        class="form-control"
                        value="{{
                            old(
                                'ngayNhap',
                                $phieuNhap->ngayNhap?->format('Y-m-d\TH\:i')
                            )
                        }}"
                        required
                    >

                    @error('ngayNhap')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <div class="detail-title">
                Chi tiết phiếu nhập
            </div>

            <table class="detail-table">

                <thead>
                    <tr>

                        <th style="width: 34%;">
                            Sách
                        </th>

                        <th style="width: 14%;">
                            Số lượng
                        </th>

                        <th style="width: 18%;">
                            Giá nhập
                        </th>

                        <th style="width: 18%;">
                            Giá bán
                        </th>

                        <th style="width: 13%;">
                            Thành tiền
                        </th>

                        <th style="width: 3%;">
                        </th>

                    </tr>
                </thead>

                <tbody id="detailBody">

                    @forelse (
                        old(
                            'maSach',
                            $phieuNhap->chiTiet
                                ->pluck('maSach')
                                ->toArray()
                        ) as $i => $maSachCu
                    )

                        @php

                            $chiTietCu =
                                $phieuNhap->chiTiet[$i]
                                ?? null;

                            $soLuongCu =
                                old(
                                    'soLuong.' . $i,
                                    $chiTietCu?->soLuong ?? 1
                                );

                            $donGiaCu =
                                old(
                                    'donGia.' . $i,
                                    $chiTietCu?->donGia ?? 0
                                );

                            /*
                             * Lấy sách hiện tại từ bảng sachs
                             * để lấy giá bán mới nhất.
                             */
                            $sachCu =
                                $sachs->firstWhere(
                                    'maSach',
                                    $maSachCu
                                );

                            $giaBanHienTai =
                                $sachCu?->giaBan ?? 0;

                        @endphp

                        <tr class="detail-row">

                            {{-- SÁCH --}}
                            <td>

                                <select
                                    name="maSach[]"
                                    required
                                    onchange="handleBookChange(this)"
                                >

                                    <option value="">
                                        -- Chọn sách --
                                    </option>

                                    @foreach ($sachs as $sach)

                                        <option
                                            value="{{ $sach->maSach }}"
                                            data-gia-ban="{{ $sach->giaBan }}"
                                            {{ (string) $maSachCu === (string) $sach->maSach ? 'selected' : '' }}
                                        >
                                            {{ $sach->maSach }}
                                            -
                                            {{ $sach->tenSach }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('maSach.' . $i)
                                    <div class="book-error server-error">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="book-error js-book-error">
                                    Sách này đã được chọn trong phiếu.
                                </div>

                            </td>

                            {{-- SỐ LƯỢNG --}}
                            <td>

                                <input
                                    type="number"
                                    name="soLuong[]"
                                    min="1"
                                    value="{{ $soLuongCu }}"
                                    oninput="calculateTotal()"
                                    required
                                >

                                @error('soLuong.' . $i)
                                    <div class="book-error server-error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </td>

                            {{-- GIÁ NHẬP --}}
                            <td>

                                <input
                                    type="number"
                                    name="donGia[]"
                                    min="0"
                                    step="0.01"
                                    value="{{ $donGiaCu }}"
                                    oninput="calculateTotal(); validatePrices()"
                                    required
                                >

                                @error('donGia.' . $i)
                                    <div class="price-error server-error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </td>

                            {{-- GIÁ BÁN --}}
                            <td>

                                <input
                                    type="text"
                                    class="gia-ban-display"
                                    value="{{
                                        $giaBanHienTai > 0
                                            ? number_format(
                                                $giaBanHienTai,
                                                0,
                                                ',',
                                                '.'
                                            )
                                            : ''
                                    }}"
                                    readonly
                                    tabindex="-1"
                                >

                                <div class="price-error js-price-error">
                                    Giá nhập phải &lt; giá bán.
                                </div>

                            </td>

                            {{-- THÀNH TIỀN --}}
                            <td class="thanh-tien">
                                0
                            </td>

                            {{-- XÓA --}}
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

                    @empty

                        <tr class="detail-row">

                            {{-- SÁCH --}}
                            <td>

                                <select
                                    name="maSach[]"
                                    required
                                    onchange="handleBookChange(this)"
                                >

                                    <option value="">
                                        -- Chọn sách --
                                    </option>

                                    @foreach ($sachs as $sach)

                                        <option
                                            value="{{ $sach->maSach }}"
                                            data-gia-ban="{{ $sach->giaBan }}"
                                        >
                                            {{ $sach->maSach }}
                                            -
                                            {{ $sach->tenSach }}
                                        </option>

                                    @endforeach

                                </select>

                                <div class="book-error js-book-error">
                                    Sách này đã được chọn trong phiếu.
                                </div>

                            </td>

                            {{-- SỐ LƯỢNG --}}
                            <td>

                                <input
                                    type="number"
                                    name="soLuong[]"
                                    min="1"
                                    value="1"
                                    oninput="calculateTotal()"
                                    required
                                >

                            </td>

                            {{-- GIÁ NHẬP --}}
                            <td>

                                <input
                                    type="number"
                                    name="donGia[]"
                                    min="0"
                                    step="0.01"
                                    value="0"
                                    oninput="calculateTotal(); validatePrices()"
                                    required
                                >

                            </td>

                            {{-- GIÁ BÁN --}}
                            <td>

                                <input
                                    type="text"
                                    class="gia-ban-display"
                                    value=""
                                    readonly
                                    tabindex="-1"
                                >

                                <div class="price-error js-price-error">
                                    Giá nhập phải &lt; giá bán.
                                </div>

                            </td>

                            {{-- THÀNH TIỀN --}}
                            <td class="thanh-tien">
                                0
                            </td>

                            {{-- XÓA --}}
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

                    @endforelse

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
                <span id="totalMoney">
                    0
                </span>
                đ
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

/*
|--------------------------------------------------------------------------
| Lấy giá bán từ option của sách
|--------------------------------------------------------------------------
*/
function getGiaBanFromBook(select) {

    const option =
        select.options[select.selectedIndex];

    if (!option) {
        return 0;
    }

    return Number(
        option.getAttribute('data-gia-ban')
    ) || 0;
}


/*
|--------------------------------------------------------------------------
| Cập nhật giá bán khi chọn sách
|--------------------------------------------------------------------------
*/
function updateGiaBan(select) {

    const row =
        select.closest('.detail-row');

    const giaBanInput =
        row.querySelector('.gia-ban-display');

    const giaBan =
        getGiaBanFromBook(select);

    if (giaBan > 0) {

        giaBanInput.value =
            giaBan.toLocaleString('vi-VN');

    } else {

        giaBanInput.value = '';

    }

    validatePrices();
}


/*
|--------------------------------------------------------------------------
| Khi thay đổi sách
|--------------------------------------------------------------------------
*/
function handleBookChange(select) {

    updateGiaBan(select);

    updateBookOptions();

    calculateTotal();

    validatePrices();
}


/*
|--------------------------------------------------------------------------
| Thêm dòng mới
|--------------------------------------------------------------------------
*/
function addRow() {

    const body =
        document.getElementById('detailBody');

    const firstRow =
        body.querySelector('.detail-row');

    if (!firstRow) {
        return;
    }

    const newRow =
        firstRow.cloneNode(true);

    /*
     * Reset sách
     */
    const select =
        newRow.querySelector(
            'select[name="maSach[]"]'
        );

    if (select) {

        select.value = '';

        select.classList.remove(
            'input-error'
        );

    }

    /*
     * Reset số lượng
     */
    const soLuong =
        newRow.querySelector(
            'input[name="soLuong[]"]'
        );

    if (soLuong) {
        soLuong.value = 1;
    }

    /*
     * Reset giá nhập
     */
    const donGia =
        newRow.querySelector(
            'input[name="donGia[]"]'
        );

    if (donGia) {
        donGia.value = 0;
    }

    /*
     * Reset giá bán
     */
    const giaBan =
        newRow.querySelector(
            '.gia-ban-display'
        );

    if (giaBan) {

        giaBan.value = '';

        giaBan.classList.remove(
            'input-error'
        );

    }

    /*
     * Xóa lỗi server của dòng clone
     */
    newRow
        .querySelectorAll('.server-error')
        .forEach(function(error) {

            error.remove();

        });

    /*
     * Reset lỗi giá
     */
    const priceError =
        newRow.querySelector(
            '.js-price-error'
        );

    if (priceError) {

        priceError.style.display =
            'none';

    }

    /*
     * Reset lỗi trùng sách
     */
    const bookError =
        newRow.querySelector(
            '.js-book-error'
        );

    if (bookError) {

        bookError.style.display =
            'none';

    }

    /*
     * Reset thành tiền
     */
    const thanhTien =
        newRow.querySelector(
            '.thanh-tien'
        );

    if (thanhTien) {

        thanhTien.textContent =
            '0';

    }

    body.appendChild(newRow);

    updateBookOptions();

    calculateTotal();

    validatePrices();
}


/*
|--------------------------------------------------------------------------
| Xóa dòng
|--------------------------------------------------------------------------
*/
function removeRow(button) {

    const rows =
        document.querySelectorAll(
            '.detail-row'
        );

    if (rows.length === 1) {

        alert(
            'Phiếu nhập phải có ít nhất một sách.'
        );

        return;
    }

    button
        .closest('.detail-row')
        .remove();

    updateBookOptions();

    calculateTotal();

    validatePrices();
}


/*
|--------------------------------------------------------------------------
| Tính thành tiền
|--------------------------------------------------------------------------
*/
function calculateTotal() {

    let total = 0;

    document
        .querySelectorAll('.detail-row')
        .forEach(function(row) {

            const quantityInput =
                row.querySelector(
                    'input[name="soLuong[]"]'
                );

            const priceInput =
                row.querySelector(
                    'input[name="donGia[]"]'
                );

            if (
                !quantityInput ||
                !priceInput
            ) {
                return;
            }

            const quantity =
                Number(
                    quantityInput.value
                ) || 0;

            const price =
                Number(
                    priceInput.value
                ) || 0;

            const money =
                quantity * price;

            const thanhTien =
                row.querySelector(
                    '.thanh-tien'
                );

            if (thanhTien) {

                thanhTien.textContent =
                    money.toLocaleString(
                        'vi-VN'
                    );

            }

            total += money;

        });

    document.getElementById(
        'totalMoney'
    ).textContent =
        total.toLocaleString(
            'vi-VN'
        );
}


/*
|--------------------------------------------------------------------------
| Kiểm tra Giá nhập < Giá bán
|--------------------------------------------------------------------------
*/
function validatePrices() {

    let valid = true;

    document
        .querySelectorAll('.detail-row')
        .forEach(function(row) {

            const donGiaInput =
                row.querySelector(
                    'input[name="donGia[]"]'
                );

            const select =
                row.querySelector(
                    'select[name="maSach[]"]'
                );

            const giaBanInput =
                row.querySelector(
                    '.gia-ban-display'
                );

            const error =
                row.querySelector(
                    '.js-price-error'
                );

            if (
                !donGiaInput ||
                !select ||
                !giaBanInput ||
                !error
            ) {
                return;
            }

            const donGia =
                Number(
                    donGiaInput.value
                ) || 0;

            const giaBan =
                getGiaBanFromBook(select);

            /*
             * Chưa chọn sách thì chưa báo lỗi giá
             */
            if (!select.value) {

                giaBanInput.classList.remove(
                    'input-error'
                );

                error.style.display =
                    'none';

                return;
            }

            /*
             * Giá nhập phải nhỏ hơn giá bán
             */
            if (donGia >= giaBan) {

                giaBanInput.classList.add(
                    'input-error'
                );

                error.style.display =
                    'block';

                valid = false;

            } else {

                giaBanInput.classList.remove(
                    'input-error'
                );

                error.style.display =
                    'none';

            }

        });

    return valid;
}


/*
|--------------------------------------------------------------------------
| Kiểm tra trùng sách
|--------------------------------------------------------------------------
*/
function checkDuplicateBooks() {

    let valid = true;

    const selected = {};

    const selects =
        document.querySelectorAll(
            'select[name="maSach[]"]'
        );

    /*
     * Xóa lỗi cũ
     */
    selects.forEach(function(select) {

        select.classList.remove(
            'input-error'
        );

        const row =
            select.closest('.detail-row');

        const error =
            row.querySelector(
                '.js-book-error'
            );

        if (error) {

            error.style.display =
                'none';

        }

    });

    /*
     * Kiểm tra trùng
     */
    selects.forEach(function(select) {

        if (select.value === '') {
            return;
        }

        if (selected[select.value]) {

            select.classList.add(
                'input-error'
            );

            selected[
                select.value
            ].classList.add(
                'input-error'
            );

            const currentRow =
                select.closest(
                    '.detail-row'
                );

            const oldRow =
                selected[
                    select.value
                ].closest(
                    '.detail-row'
                );

            const currentError =
                currentRow.querySelector(
                    '.js-book-error'
                );

            const oldError =
                oldRow.querySelector(
                    '.js-book-error'
                );

            if (currentError) {

                currentError.style.display =
                    'block';

            }

            if (oldError) {

                oldError.style.display =
                    'block';

            }

            valid = false;

        } else {

            selected[
                select.value
            ] = select;

        }

    });

    return valid;
}


/*
|--------------------------------------------------------------------------
| Ẩn sách đã chọn ở các dòng khác
|--------------------------------------------------------------------------
*/
function updateBookOptions() {

    const selects =
        document.querySelectorAll(
            'select[name="maSach[]"]'
        );

    const selected = [];

    selects.forEach(function(select) {

        if (select.value !== '') {

            selected.push(
                select.value
            );

        }

    });

    selects.forEach(function(select) {

        const current =
            select.value;

        select
            .querySelectorAll('option')
            .forEach(function(option) {

                option.hidden =
                    option.value !== '' &&
                    option.value !== current &&
                    selected.includes(
                        option.value
                    );

            });

    });

    checkDuplicateBooks();
}


/*
|--------------------------------------------------------------------------
| Submit form
|--------------------------------------------------------------------------
*/
document
    .getElementById('phieuNhapForm')
    .addEventListener(
        'submit',
        function(event) {

            const priceValid =
                validatePrices();

            const bookValid =
                checkDuplicateBooks();

            if (
                !priceValid ||
                !bookValid
            ) {

                event.preventDefault();

                alert(
                    'Vui lòng kiểm tra lại thông tin phiếu nhập.'
                );

            }

        }
    );


/*
|--------------------------------------------------------------------------
| Khởi tạo khi mở trang
|--------------------------------------------------------------------------
*/
document
    .querySelectorAll(
        'select[name="maSach[]"]'
    )
    .forEach(function(select) {

        updateGiaBan(select);

    });

calculateTotal();

updateBookOptions();

</script>

@endsection