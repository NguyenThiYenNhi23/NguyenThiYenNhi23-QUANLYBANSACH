<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Quản trị')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f6fa;
            color: #333;
        }

        /* ===== SIDEBAR ===== */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e5e5e5;
        }

        .logo {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid #eeeeee;
        }

        .logo h2 {
            color: #2f80ed;
            font-size: 19px;
        }

        .menu {
            padding: 18px 12px;
        }

        .menu-title {
            font-size: 12px;
            color: #999;
            padding: 10px 12px;
            text-transform: uppercase;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            margin-bottom: 4px;
            border-radius: 7px;
            text-decoration: none;
            color: #444;
            font-size: 15px;
        }

        .menu a:hover {
            background: #f0f5ff;
            color: #2f80ed;
        }

        .menu a.active {
            background: #2f80ed;
            color: white;
        }

        .menu-icon {
            width: 22px;
            text-align: center;
            font-size: 17px;
        }

        /* ===== MAIN ===== */

        .main {
            margin-left: 250px;
            min-height: 100vh;
        }

        /* ===== HEADER ===== */

        .header {
            height: 70px;
            background: white;
            border-bottom: 1px solid #e5e5e5;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 30px;
        }

        .header-title {
            font-size: 22px;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #2f80ed;
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: bold;
        }

        .user-name {
            font-weight: 600;
        }

        .user-role {
            font-size: 12px;
            color: #888;
            margin-top: 3px;
        }

        /* ===== CONTENT ===== */

        .content {
            padding: 30px;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .welcome h1 {
            font-size: 25px;
            margin-bottom: 7px;
        }

        .welcome p {
            color: #777;
        }

        /* ===== BOTTOM ===== */

        .bottom {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .box {
            background: white;
            border: 1px solid #eeeeee;
            border-radius: 10px;
            padding: 22px;
        }

        .box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .box-header h3 {
            font-size: 18px;
        }

        .view-all {
            color: #2f80ed;
            text-decoration: none;
            font-size: 14px;
        }

        /* ===== TABLE ===== */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            background: #f8f9fb;
            color: #666;
            font-size: 13px;
            padding: 13px;
        }

        td {
            padding: 14px 13px;
            border-bottom: 1px solid #eeeeee;
            font-size: 14px;
        }

        /* ===== STATUS ===== */

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .completed {
            background: #e8f7ee;
            color: #219653;
        }

        .processing {
            background: #fff4df;
            color: #f2994a;
        }

        /* ===== WARNING ===== */

        .warning {
            padding: 15px;
            border: 1px solid #eeeeee;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .warning-title {
            font-weight: 600;
            margin-bottom: 6px;
        }

        .warning-text {
            font-size: 13px;
            color: #777;
        }

        .low {
            color: #f2994a;
        }

        .out {
            color: #eb5757;
        }

        /* ===== RESPONSIVE ===== */

        @media (max-width: 1100px) {

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .bottom {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {

            .sidebar {
                width: 70px;
            }

            .logo h2,
            .menu a span:not(.menu-icon),
            .menu-title {
                display: none;
            }

            .main {
                margin-left: 70px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 20px;
            }
        }
        .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            border: none;
            background: none;
            color: inherit;
            font-size: 15px;
            cursor: pointer;
            text-align: left;
        }

        .logout-btn:hover {
            background: #f1f1f1;
        }
    </style>
</head>

<body>

    <!-- ===== SIDEBAR ===== -->

    <div class="sidebar">

        <div class="logo">
            <h2>📚 QUẢN LÝ BÁN SÁCH</h2>
        </div>

        <div class="menu">

            <div class="menu-title">
                Menu quản lý
            </div>

            <a href="{{ route('quantri.trangchu') }}"
               class="{{ request()->routeIs('quantri.trangchu') ? 'active' : '' }}">
                <span class="menu-icon">🏠</span>
                <span>Trang chủ</span>
            </a>

            <a href="#">
                <span class="menu-icon">📂</span>
                <span>Quản lý danh mục</span>
            </a>

            <a href="#">
                <span class="menu-icon">📚</span>
                <span>Quản lý sách</span>
            </a>

            <a href="#">
                <span class="menu-icon">📥</span>
                <span>Quản lý phiếu nhập</span>
            </a>

            <a href="#">
                <span class="menu-icon">🛒</span>
                <span>Quản lý đơn hàng</span>
            </a>

            <a href="{{ route('quantri.khachhang.index') }}"
            class="{{ request()->routeIs('quantri.khachhang.*') ? 'active' : '' }}">
                <span class="menu-icon">👥</span>
                <span>Quản lý khách hàng</span>
            </a>

            <a href="#">
                <span class="menu-icon">📦</span>
                <span>Quản lý tồn kho</span>
            </a>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('quantri.nhanvien.index') }}"
                   class="{{ request()->routeIs('quantri.nhanvien.*') ? 'active' : '' }}">
                    <span class="menu-icon">👨‍💼</span>
                    <span>Quản lý nhân viên</span>
                </a>
            @endif

            @if(auth()->user()->role === 'admin')
                <a href="#">
                    <span class="menu-icon">📊</span>
                    <span>Thống kê</span>
                </a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="logout-btn">
                    <span class="menu-icon">🚪</span>
                    <span>Đăng xuất</span>
                </button>
            </form>

        </div>

    </div>


    <!-- ===== MAIN ===== -->

    <div class="main">

        <!-- HEADER -->

        <div class="header">

            <div class="header-title">
                @yield('header-title', 'Trang chủ')
            </div>

            <div class="user-info">

                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div>

                    <div class="user-name">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="user-role">
                        {{ auth()->user()->role === 'admin' ? 'Quản trị viên' : 'Nhân viên' }}
                    </div>

                </div>

            </div>

        </div>


        <!-- ===== NỘI DUNG RIÊNG CỦA TỪNG TRANG ===== -->

        <div class="content">

            @yield('content')

        </div>

    </div>

</body>
</html>