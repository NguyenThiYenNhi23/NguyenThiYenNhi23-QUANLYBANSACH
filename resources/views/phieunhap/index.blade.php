@extends('layout.admin')

@section('title', 'Quản lý phiếu nhập')

@push('styles')

<style>
    /* 1. Chỉ ẩn thanh menu dọc bên trái (sidebar) */
    .sidebar, 
    #sidebar, 
    nav.sidebar, 
    .sidebar-offcanvas {
        display: none !important;
    }

    /* 2. Mở rộng khung chứa nội dung ra hết chiều ngang màn hình */
    .main-panel, 
    .content-wrapper, 
    .page-body-wrapper {
        width: 100% !important;
        margin-left: 0 !important;
        padding-left: 0 !important;
    }

    /* 3. Đảm bảo thanh menu chính (Navbar trên cùng) luôn hiển thị đầy đủ */
    .navbar, 
    #navbar, 
    header.navbar, 
    .navbar-menu-wrapper {
        display: flex !important;
        width: 100% !important;
        left: 0 !important;
    }


    /* =========================
       TRANG PHIẾU NHẬP
    ========================= */
    .phieu-page {
        padding: 30px 35px;
        font-family: Arial, sans-serif;
    }

    /* =========================
       TIÊU ĐỀ
    ========================= */
    .phieu-title {
        text-align: center;
        margin: 0 0 30px 0;
        color: #b5121b;
        font-family: Arial, sans-serif;
        font-size: 30px;
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: 0;
    }

    /* =========================
       THANH TÌM KIẾM + LẬP PHIẾU
    ========================= */
    .toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 28px;
    }

    .search-box {
        width: 430px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        height: 46px;
        border: 1px solid #e2b9bd;
        border-radius: 12px;
        padding: 0 18px 0 45px;
        outline: none;
        font-family: Arial, sans-serif;
        font-size: 15px;
        background: #fff;
        box-sizing: border-box;
    }

    .search-box input:focus {
        border-color: #c91422;
        box-shadow: 0 0 0 3px rgba(201, 20, 34, .10);
    }

    .search-icon {
        position: absolute;
        left: 17px;
        top: 50%;
        transform: translateY(-50%);
        color: #b5121b;
        font-size: 18px;
    }

    /* =========================
       BUTTON CHUNG
    ========================= */
    .btn {
        border: none;
        border-radius: 11px;
        min-height: 44px;
        padding: 0 20px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
        text-decoration: none;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        box-sizing: border-box;
        white-space: nowrap;
    }

    /* =========================
       NÚT LẬP PHIẾU
    ========================= */
    .btn-add {
        background: #c91422;
        color: #fff;

        width: 150px;
        height: 46px;

        padding: 0 18px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        border-radius: 11px;

        font-family: Arial, sans-serif;
        font-size: 15px;
        font-weight: 700;
        line-height: 1;
    }

    .btn-add:hover {
        background: #a90e19;
        color: #fff;
    }

    .btn-add .plus {
        font-size: 21px;
        font-weight: 400;
        line-height: 1;
    }

    /* =========================
       BẢNG
    ========================= */
    .table-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f0d8da;
        overflow: hidden;
        box-shadow: 0 5px 18px rgba(130, 20, 30, .06);
    }

    .table-header {
        padding: 18px 22px;
        color: #9f1018;
        font-family: Arial, sans-serif;
        font-size: 17px;
        font-weight: 700;
        border-bottom: 1px solid #f1dddd;
        background: #fffafa;
    }

    .phieu-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .phieu-table th {
        background: #c91422;
        color: #fff;
        padding: 14px 12px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-weight: 700;
        text-align: center;
    }

    .phieu-table td {
        padding: 15px 12px;
        border-bottom: 1px solid #f2e5e5;
        color: #333;
        font-family: Arial, sans-serif;
        font-size: 14px;
        text-align: center;
    }

    .phieu-row {
        cursor: pointer;
        transition: .15s;
    }

    .phieu-row:hover {
        background: #fff7f7;
    }

    .phieu-row.selected {
        background: #ffe8ea;
        box-shadow: inset 4px 0 0 #c91422;
    }

    .ma-phieu {
        color: #b5121b !important;
        font-weight: 700;
    }

    /* =========================
       TRẠNG THÁI
    ========================= */
    .status {
        display: inline-block;
        padding: 6px 13px;
        border-radius: 20px;
        font-family: Arial, sans-serif;
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

    .empty {
        padding: 45px 20px !important;
        color: #999 !important;
    }

    /* =========================
       3 NÚT THAO TÁC
    ========================= */
    .action-bar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 18px;
    }

    .action-bar .btn {
        min-width: 125px;
        height: 44px;
    }

    .btn-detail {
        background: #fff;
        border: 1px solid #c91422;
        color: #b5121b;
    }

    .btn-detail:hover:not(.btn-disabled) {
        background: #fff3f4;
    }

    .btn-edit {
        background: #b5121b;
        color: #fff;
    }

    .btn-edit:hover:not(.btn-disabled) {
        background: #970d15;
    }

    .btn-delete {
        background: #8e0d15;
        color: #fff;
    }

    .btn-delete:hover:not(.btn-disabled) {
        background: #720a10;
    }

    .btn-cancel {
        background: #d97706;
        color: #fff;
    }

    .btn-cancel:hover:not(.btn-disabled) {
        background: #b85f04;
    }

    /* Khi chưa chọn phiếu */
    .btn-disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    /* =========================
       THÔNG BÁO
    ========================= */
    .alert {
        padding: 13px 18px;
        border-radius: 10px;
        margin-bottom: 18px;
        font-family: Arial, sans-serif;
    }

    .alert-success {
        background: #eaf8ef;
        color: #18713c;
        border: 1px solid #c9ebd5;
    }

    .alert-danger {
        background: #fff0f1;
        color: #a3141d;
        border: 1px solid #f2c8cb;
    }

    /* =========================
       RESPONSIVE
    ========================= */
    @media (max-width: 768px) {
        .phieu-page {
            padding: 20px;
        }

        .toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            width: 100%;
        }

        .btn-add {
            width: 100%;
        }

        .phieu-title {
            font-size: 25px;
        }

        .table-card {
            overflow-x: auto;
        }

        .phieu-table {
            min-width: 750px;
        }

        .action-bar {
            justify-content: stretch;
            flex-wrap: wrap;
        }

        .action-bar .btn {
            flex: 1;
        }
    }
</style>
@endpush


@section('content')

<div class="phieu-page">

    {{-- TIÊU ĐỀ --}}
    <h1 class="phieu-title">
        Quản lý phiếu nhập
    </h1>


    {{-- THÔNG BÁO --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    {{-- TÌM KIẾM + LẬP PHIẾU --}} 
    <div class="toolbar"> 
        <div class="search-box">
            <span class="search-icon">🔍</span>

            <input
                type="text"
                id="searchInput"
                placeholder="Tìm kiếm theo mã phiếu, nhân viên..."
                autocomplete="off"
            >
        </div>
     
        <a 
            href="{{ route('phieunhap.create') }}" 
            class="btn btn-add" 
        > 
            <span class="plus">＋</span> 
            <span>Lập phiếu</span> 
        </a> 
    </div>


    {{-- BẢNG DANH SÁCH --}}
    <div class="table-card">

        <div class="table-header">
            Danh sách phiếu nhập
        </div>


        <table class="phieu-table">

            <colgroup>
                <col style="width: 8%;">
                <col style="width: 16%;">
                <col style="width: 28%;">
                <col style="width: 18%;">
                <col style="width: 30%;">
            </colgroup>


            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã phiếu</th>
                    <th>Nhân viên lập</th>
                    <th>Ngày nhập</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>


            <tbody>

            @forelse($phieuNhaps as $index => $phieu)

                <tr
                    class="phieu-row"
                    data-id="{{ $phieu->maPN }}"
                    data-status="{{ $phieu->trangThai }}"
                    data-detail="{{ $phieu->chiTiet->count() }}"
                    onclick="selectPhieu(this)"
                >

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td class="ma-phieu">
                        PN{{ str_pad($phieu->maPN, 3, '0', STR_PAD_LEFT) }}
                    </td>

                    <td>
                        {{ $phieu->nhanVien->hoTen ?? 'Không xác định' }}
                    </td>

                    <td>
                        {{ $phieu->ngayNhap?->format('d/m/Y') }}
                    </td>

                    <td>

                        @if($phieu->trangThai === 'DaHuy')

                            <span class="status status-cancel">
                                Đã hủy
                            </span>

                        @else

                            <span class="status status-done">
                                Đã nhập
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="empty">
                        Chưa có phiếu nhập nào.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>


    {{-- 3 NÚT LUÔN HIỂN THỊ --}}
    <div class="action-bar">

        <a
            href="#"
            id="btnDetail"
            class="btn btn-detail btn-disabled"
        >
            Xem chi tiết
        </a>


        <a
            href="#"
            id="btnEdit"
            class="btn btn-edit btn-disabled"
        >
            Sửa
        </a>


        <button
            type="button"
            id="btnAction"
            class="btn btn-delete btn-disabled"
            onclick="handleAction()"
        >
            Xóa
        </button>

    </div>

</div>


<script>

let selectedId = null;
let selectedStatus = null;
let selectedHasDetail = false;


/*
|--------------------------------------------------------------------------
| Chọn phiếu
|--------------------------------------------------------------------------
*/
function selectPhieu(row) {

    document.querySelectorAll('.phieu-row').forEach(function(item) {
        item.classList.remove('selected');
    });

    row.classList.add('selected');

    selectedId = row.dataset.id;
    selectedStatus = row.dataset.status;
    selectedHasDetail = Number(row.dataset.detail) > 0;

    const detailButton = document.getElementById('btnDetail');
    const editButton = document.getElementById('btnEdit');
    const actionButton = document.getElementById('btnAction');

    detailButton.href =
        "{{ url('/phieunhap') }}/" + selectedId;

    detailButton.classList.remove('btn-disabled');

    
    if (selectedStatus === 'DaHuy') {

        editButton.classList.add('btn-disabled');
        actionButton.classList.add('btn-disabled');

        return;
    }

    editButton.href =
        "{{ url('/phieunhap') }}/" + selectedId + "/sua";

    editButton.classList.remove('btn-disabled');

    actionButton.classList.remove('btn-disabled');


    if (selectedHasDetail) {

        actionButton.textContent = 'Hủy';

        actionButton.classList.remove('btn-delete');
        actionButton.classList.add('btn-cancel');

    } else {

        actionButton.textContent = 'Xóa';

        actionButton.classList.remove('btn-cancel');
        actionButton.classList.add('btn-delete');
    }
}

function handleAction() {

    if (!selectedId) {
        return;
    }

    if (selectedHasDetail) {

        if (!confirm('Bạn có chắc muốn hủy phiếu nhập này không?')) {
            return;
        }


        const form = document.createElement('form');

        form.method = 'POST';

        form.action =
            "{{ url('/phieunhap') }}/" + selectedId + "/huy";


        form.innerHTML = `
            @csrf
            @method('PUT')
        `;


        document.body.appendChild(form);

        form.submit();

        return;
    }

    if (!confirm('Bạn có chắc muốn xóa phiếu nhập này không?')) {
        return;
    }


    const form = document.createElement('form');

    form.method = 'POST';

    form.action =
        "{{ url('/phieunhap') }}/" + selectedId;


    form.innerHTML = `
        @csrf
        @method('DELETE')
    `;


    document.body.appendChild(form);

    form.submit();
}

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('.phieu-row');

    searchInput.addEventListener('input', function () {

        const keyword = this.value.trim().toLowerCase();

        rows.forEach(function (row) {

            const maPhieu = row.querySelector('.ma-phieu')
                ?.textContent
                .trim()
                .toLowerCase() || '';

            const nhanVien = row.cells[2]
                ?.textContent
                .trim()
                .toLowerCase() || '';

            if (
                keyword === '' ||
                maPhieu.includes(keyword) ||
                nhanVien.includes(keyword)
            ) {

                row.style.display = '';

            } else {

                row.style.display = 'none';

            }

        });

    });

});

</script>

@endsection