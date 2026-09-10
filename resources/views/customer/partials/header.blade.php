<header class="site-header">
    <div class="container site-header__main">
        <form action="{{ route('customer.search') }}" method="GET" class="site-header__search">
            <input type="text" name="q" placeholder="Tìm kiếm sản phẩm" value="{{ request('q') }}">
            <button type="submit" aria-label="Tìm kiếm">⌕</button>
        </form>

        <a href="{{ route('customer.home') }}" class="site-header__logo">KIM ĐỒNG</a>

        <div class="site-header__actions">
            @auth
                <a href="{{ route('customer.account') }}">⇥ {{ auth()->user()->name }}</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Đăng xuất</button>
                </form>
            @else
                <a href="{{ route('login') }}">Đăng nhập</a>
            @endauth
            <a href="#">🛒 Giỏ hàng</a>
        </div>
    </div>

    <nav class="site-header__nav">
        <div class="container">
            <a href="{{ route('customer.home') }}">Trang chủ</a>
            <a href="{{ route('customer.danhmuc') }}">Danh mục</a>
            <a href="{{ route('customer.gioithieu') }}">Giới thiệu</a>
        </div>
    </nav>
</header>
