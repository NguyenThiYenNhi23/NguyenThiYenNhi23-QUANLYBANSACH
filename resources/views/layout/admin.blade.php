<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Quản trị hệ thống')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f6f7ff;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* HEADER */
        .topbar {
            height: 72px;
            background: #ffffff;
            border-bottom: 1px solid #eeeeee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
            width: 210px;
            font-size: 22px;
            font-weight: 700;
            color: #5b5fc7;
        }

        .logo-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #5b5fc7;
            margin-right: 10px;
            position: relative;
        }

        .logo-icon::after {
            content: "";
            position: absolute;
            width: 20px;
            height: 10px;
            background: white;
            border-radius: 50%;
            left: 7px;
            top: 11px;
            transform: rotate(-25deg);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification {
            font-size: 21px;
            color: #666;
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #777;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e5e7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5559bd;
            font-weight: bold;
        }

        .logout-form {
            margin-left: 4px;
        }

        .logout-btn {
            border: none;
            border-radius: 8px;
            background: #ef4444;
            color: #fff;
            padding: 9px 14px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .logout-btn:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 72px;
            left: 0;
            bottom: 0;
            width: 220px;
            background: #ffffff;
            border-right: 1px solid #eeeeee;
            padding: 22px 14px;
            overflow-y: auto;
        }

        .menu-title {
            font-size: 11px;
            color: #aaa;
            text-transform: uppercase;
            padding: 8px 12px;
            margin-bottom: 5px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 13px;
            margin-bottom: 4px;
            border-radius: 7px;
            color: #777;
            font-size: 14px;
            transition: 0.2s;
        }

        .menu-item:hover {
            background: #f0f1ff;
            color: #575bc4;
        }

        .menu-item.active {
            background: #595dc6;
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(89, 93, 198, 0.20);
        }

        .menu-icon {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        /* CONTENT */
        .main-content {
            margin-left: 220px;
            padding: 105px 38px 40px;
            min-height: 100vh;
        }

        .page-title {
            font-size: 25px;
            font-weight: 700;
            margin: 0 0 25px;
            color: #222;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .btn-add {
            width: 54px;
            height: 38px;
            border: none;
            border-radius: 8px;
            background: #595dc6;
            color: white;
            font-size: 23px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 8px rgba(89, 93, 198, 0.20);
        }

        .btn-add:hover {
            background: #484cae;
        }

        .search-form {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .search-input {
            width: 270px;
            height: 38px;
            border: 1px solid #999;
            border-radius: 8px;
            padding: 0 15px;
            outline: none;
            background: white;
        }

        .search-input:focus {
            border-color: #595dc6;
        }

        .search-btn {
            width: 52px;
            height: 38px;
            border: 1px solid #555;
            border-radius: 8px;
            background: #d9d9d9;
            cursor: pointer;
            font-size: 17px;
        }

        .search-btn:hover {
            background: #c8c8c8;
        }

        /* TABLE */
        .table-container {
            background: #ffffff;
            border-radius: 3px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #f4f5fc;
            padding: 17px 16px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            color: #444;
            border-bottom: 1px solid #ddd;
        }

        .data-table td {
            padding: 16px;
            border-bottom: 1px solid #e5e5e5;
            font-size: 14px;
            color: #555;
        }

        .data-table tbody tr:hover {
            background: #fafaff;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #e5f7ed;
            color: #1e8b50;
        }

        .status-inactive {
            background: #ffe7e7;
            color: #d84b4b;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-edit,
        .btn-delete {
            width: 52px;
            height: 35px;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-edit {
            background: #ffc107;
        }

        .btn-edit:hover {
            background: #e5aa00;
        }

        .btn-delete {
            background: #ff625b;
        }

        .btn-delete:hover {
            background: #e84d46;
        }

        /* ALERT */
        .alert {
            padding: 13px 17px;
            border-radius: 7px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #e8f8ef;
            color: #20824b;
            border: 1px solid #bce9cd;
        }

        .alert-danger {
            background: #fff0f0;
            color: #c03939;
            border: 1px solid #f2c1c1;
        }

        /* FORM */
        .form-card {
            max-width: 700px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d4d4d4;
            border-radius: 7px;
            outline: none;
            font-size: 14px;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: #595dc6;
            box-shadow: 0 0 0 2px rgba(89,93,198,0.08);
        }

        textarea.form-control {
            min-height: 130px;
            resize: vertical;
        }

        .form-error {
            margin-top: 6px;
            color: #dc3545;
            font-size: 13px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-primary {
            border: none;
            background: #595dc6;
            color: white;
            padding: 11px 22px;
            border-radius: 7px;
            cursor: pointer;
        }

        .btn-secondary {
            background: #eee;
            color: #555;
            padding: 11px 22px;
            border-radius: 7px;
        }

        /* PAGINATION */
        .pagination-wrapper {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        /* EMPTY */
        .empty {
            text-align: center;
            padding: 45px;
            color: #999;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 190px;
            }

            .main-content {
                margin-left: 190px;
                padding-left: 20px;
                padding-right: 20px;
            }

            .search-input {
                width: 200px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<header class="topbar">
    <div class="logo">
        <div class="logo-icon"></div>
        Skydash
    </div>

    <div class="topbar-right">
        <div class="notification">🔔</div>

        @auth
            <div class="user-box">
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'QT', 0, 2)) }}</div>
                <span>{{ Auth::user()->name ?? 'Quản trị viên' }}</span>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Đăng xuất</button>
            </form>
        @endauth
    </div>
</header>


<aside class="sidebar">

    <div class="menu-title">MENU</div>

    <a href="#" class="menu-item">
        <span class="menu-icon">▦</span>
        <span>Tổng Quan</span>
    </a>

    <a href="{{ route('sach.index') }}" class="menu-item {{ request()->routeIs('sach.*') ? 'active' : '' }}">
        <span class="menu-icon">▣</span>
        <span>Quản lý sách</span>
    </a>

    <a href="#" class="menu-item">
        <span class="menu-icon">▤</span>
        <span>Quản lý thể loại</span>
    </a>

    <a href="{{ route('admin.danhmuc.index') }}"
       class="menu-item {{ request()->routeIs('admin.danhmuc.*') ? 'active' : '' }}">
        <span class="menu-icon">▦</span>
        <span>Quản lý danh mục</span>
    </a>

    <a href="#" class="menu-item">
        <span class="menu-icon">⌂</span>
        <span>Quản lý nhà cung cấp</span>
    </a>

    <a href="#" class="menu-item">
        <span class="menu-icon">▣</span>
        <span>Quản lý nhà xuất bản</span>
    </a>

    <a href="#" class="menu-item">
        <span class="menu-icon">✎</span>
        <span>Quản lý tác giả</span>
    </a>

    <a href="#" class="menu-item">
        <span class="menu-icon">↔</span>
        <span>Quản lý kích thước</span>
    </a>

    <a href="#" class="menu-item">
        <span class="menu-icon">♙</span>
        <span>Quản lý tài khoản</span>
    </a>

    <a href="#" class="menu-item">
        <span class="menu-icon">▤</span>
        <span>Quản lý đơn hàng</span>
    </a>

    <a href="#" class="menu-item">
        <span class="menu-icon">☁</span>
        <span>Quản lý bình luận</span>
    </a>

    <a href="#" class="menu-item">
        <span class="menu-icon">▤</span>
        <span>Quản lý kho</span>
    </a>

    <a href="#" class="menu-item">
        <span class="menu-icon">★</span>
        <span>Quản lý thể loại cha</span>
    </a>

    <a href="#" class="menu-item">
        <span class="menu-icon">♧</span>
        <span>Quản lý khuyến mãi sách</span>
    </a>

    <a href="#" class="menu-item">
        <span class="menu-icon">⇥</span>
        <span>Đăng xuất</span>
    </a>

</aside>


<main class="main-content">
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

    @yield('content')
</main>

@stack('scripts')

</body>
</html>