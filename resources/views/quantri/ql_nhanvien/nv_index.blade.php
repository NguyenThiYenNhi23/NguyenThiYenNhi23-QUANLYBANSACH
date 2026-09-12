@extends('quantri.layouts.quantri_layout')

@section('title', 'Quản lý nhân viên')

@section('header-title', 'Quản lý nhân viên')

@section('content')

<style>
    .container {
        width: 95%;
        margin: 30px auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-header h1 {
        margin: 0;
    }

    .btn {
        display: inline-block;
        padding: 9px 14px;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-add {
        background: #198754;
        color: white;
    }

    .btn-edit {
        background: #ffc107;
        color: #000;
    }

    .btn-status {
        background: #6c757d;
        color: white;
    }

    .btn-search {
        background: #0d6efd;
        color: white;
    }

    .search-box {
        background: white;
        padding: 18px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .search-box form {
        display: flex;
        gap: 10px;
    }

    .search-box input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    .table-box {
        background: white;
        border-radius: 8px;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 13px 12px;
        border-bottom: 1px solid #eee;
        text-align: left;
    }

    th {
        background: #f1f3f5;
    }

    .actions {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .status-active {
        color: #198754;
        font-weight: bold;
    }

    .status-locked {
        color: #dc3545;
        font-weight: bold;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        background: #d1e7dd;
        color: #0f5132;
    }

    .alert-error {
        background: #f8d7da;
        color: #842029;
    }

    .pagination {
        padding: 20px;
    }
</style>


<div class="container">

    <div class="page-header">
        <h1>👨‍💼 Quản lý nhân viên</h1>

        <a href="{{ route('quantri.nhanvien.create') }}"
           class="btn btn-add">
            + Thêm nhân viên
        </a>
    </div>


    {{-- THÔNG BÁO --}}
    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif


    {{-- TÌM KIẾM --}}
    <div class="search-box">

        <form method="GET"
              action="{{ route('quantri.nhanvien.index') }}">

            <input
                type="text"
                name="keyword"
                value="{{ $keyword }}"
                placeholder="Tìm theo họ tên, số điện thoại hoặc email..."
            >

            <button type="submit"
                    class="btn btn-search">
                🔍 Tìm kiếm
            </button>
        </form>

    </div>


    {{-- DANH SÁCH NHÂN VIÊN --}}
    <div class="table-box">

        <table>

            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>

            @forelse($nhanViens as $nhanVien)

                <tr>

                    <td>
                        {{ $nhanVien->maNV }}
                    </td>

                    <td>
                        {{ $nhanVien->hoTen }}
                    </td>

                    <td>
                        {{ $nhanVien->email }}
                    </td>

                    <td>
                        {{ $nhanVien->sdt ?? '—' }}
                    </td>

                    <td>
                        {{ $nhanVien->diaChi ?? '—' }}
                    </td>

                    <td>

                        @if($nhanVien->user && $nhanVien->user->trang_thai)

                            <span class="status-active">
                                Đang hoạt động
                            </span>

                        @else

                            <span class="status-locked">
                                Đã khóa
                            </span>

                        @endif

                    </td>

                    <td>

                        <div class="actions">

                            {{-- SỬA --}}
                            <a href="{{ route('quantri.nhanvien.edit', $nhanVien->maNV) }}"
                               class="btn btn-edit">
                                Sửa
                            </a>


                            {{-- KHÓA / MỞ KHÓA --}}
                            <form
                                action="{{ route('quantri.nhanvien.status', $nhanVien->maNV) }}"
                                method="POST"
                                style="display:inline;"
                            >

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="btn btn-status">

                                    @if($nhanVien->user && $nhanVien->user->trang_thai)
                                        Khóa
                                    @else
                                        Mở khóa
                                    @endif

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" style="text-align:center;">
                        Chưa có nhân viên nào.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>


        {{-- PHÂN TRANG --}}
        <div class="pagination">
            {{ $nhanViens->links() }}
        </div>

    </div>

</div>

@endsection