<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Quản lý danh mục</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f6fb;
            color: #333;
        }

        .container {
            width: 100%;
            min-height: 100vh;
            padding: 40px 50px;
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #222;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .btn-add {
            width: 55px;
            height: 45px;
            border: none;
            border-radius: 8px;
            background: #5751b8;
            color: white;
            font-size: 28px;
            cursor: pointer;
            text-decoration: none;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-add:hover {
            background: #46419d;
        }

        .search-box {
            display: flex;
            gap: 8px;
        }

        .search-box input {
            width: 260px;
            height: 42px;
            border: 1px solid #aaa;
            border-radius: 8px;
            padding: 0 15px;
            font-size: 14px;
            outline: none;
        }

        .search-box input:focus {
            border-color: #5751b8;
        }

        .btn-search {
            width: 48px;
            height: 42px;
            border: none;
            border-radius: 8px;
            background: #ddd;
            cursor: pointer;
            font-size: 18px;
        }

        .table-box {
            background: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f0f1f7;
        }

        th {
            padding: 17px 15px;
            text-align: left;
            font-size: 14px;
            color: #333;
            font-weight: 600;
        }

        td {
            padding: 15px;
            border-top: 1px solid #e5e5e5;
            font-size: 14px;
        }

        tr:hover {
            background: #fafafa;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 15px;
            background: #d9f5df;
            color: #218838;
            font-size: 13px;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .actions form {
            margin: 0;
        }

        .btn-edit,
        .btn-delete {
            width: 45px;
            height: 36px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-edit {
            background: #ffc107;
            color: #222;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-delete {
            background: #ff6258;
            color: white;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #888;
        }

        .alert-success {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 8px;
            background: #d9f5df;
            color: #218838;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="title">
        QUẢN LÝ DANH MỤC
    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="top-bar">

        <a href="{{ route('admin.danhmuc.create') }}" class="btn-add">
            +
        </a>

        <form action="{{ route('admin.danhmuc.index') }}" method="GET" class="search-box">

            <input
                type="text"
                name="search"
                placeholder="Nhập tên danh mục..."
                value="{{ request('search') }}"
            >

            <button type="submit" class="btn-search">
                🔍
            </button>

        </form>

    </div>

    <div class="table-box">

        <table>

            <thead>
                <tr>
                    <th style="width: 80px;">STT</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th style="width: 150px;">Tùy chỉnh</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($danhMucs as $index => $danhMuc)

                    <tr>

                        <td>
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $danhMuc->tenDanhMuc }}
                        </td>

                        <td>
                            {{ $danhMuc->moTa }}
                        </td>

                        <td>

                            @if ($danhMuc->isActive)
                                <span class="status">
                                    Hoạt động
                                </span>
                            @else
                                <span class="status" style="background:#eee;color:#777;">
                                    Ngừng hoạt động
                                </span>
                            @endif

                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route('admin.danhmuc.edit', $danhMuc) }}"
                                    class="btn-edit">
                                    ✏️
                                </a>

                                <form
                                    action="{{ route('admin.danhmuc.destroy', $danhMuc) }}"
                                    method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-delete">
                                        🗑️
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="empty">
                            Chưa có danh mục nào.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</body>
</html>
