<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang khách hàng - Kim Đồng</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; color: #333; font-family: Arial, sans-serif; }
        a { color: inherit; text-decoration: none; }
        button, input { font: inherit; }
        .container { width: 1125px; max-width: calc(100% - 40px); margin: 0 auto; }

        .site-header { background: #fff; }
        .site-header__main { display: flex; align-items: center; justify-content: space-between; gap: 25px; min-height: 95px; }
        .site-header__search { display: flex; width: 275px; height: 42px; overflow: hidden; border-radius: 22px; background: #f3f3f3; }
        .site-header__search input { width: 100%; padding: 0 20px; border: 0; outline: 0; background: transparent; font-style: italic; }
        .site-header__search button { width: 48px; border: 0; color: #e21c2a; background: transparent; font-size: 25px; cursor: pointer; }
        .site-header__logo { color: #bc1520; font-size: 23px; font-weight: 700; text-align: center; }
        .site-header__actions { display: flex; align-items: center; gap: 22px; white-space: nowrap; }
        .site-header__actions a:hover, .site-header__actions button:hover { color: #e21c2a; }
        .site-header__actions form { margin: 0; }
        .site-header__actions button { padding: 0; border: 0; color: inherit; background: transparent; cursor: pointer; }
        .site-header__nav { border-top: 1px solid #eee; border-bottom: 1px solid #eee; }
        .site-header__nav .container { display: flex; align-items: center; height: 63px; gap: 48px; }
        .site-header__nav a { font-size: 16px; }
        .site-header__nav a:hover { color: #e21c2a; }

        .account-banner { position: relative; min-height: 285px; padding: 113px 0; overflow: hidden; color: #fff; background: url('https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=1800&q=85') center/cover; }
        .account-banner::before { position: absolute; inset: 0; z-index: 0; background: rgba(0, 0, 0, .54); content: ''; }
        .account-banner .container { position: relative; z-index: 1; }
        .account-banner h1 { margin: 0 0 12px; font-size: 29px; text-shadow: 0 1px 3px rgba(0, 0, 0, .65); }
        .account-banner p { margin: 0; font-size: 16px; text-shadow: 0 1px 3px rgba(0, 0, 0, .65); }
        .account-layout { display: grid; grid-template-columns: 300px 1fr; gap: 85px; padding: 58px 0; }
        .account-sidebar h2, .account-content h2 { margin: 0 0 10px; font-size: 22px; font-weight: 400; }
        .account-sidebar__greeting { display: block; margin-bottom: 25px; }
        .account-menu { display: flex; flex-direction: column; align-items: flex-start; }
        .account-menu a, .account-menu button { padding: 9px 0; border: 0; color: #333; background: transparent; font-size: 16px; cursor: pointer; }
        .account-menu a:hover, .account-menu a.active, .account-menu button:hover { color: #ed1c24; }
        .account-menu form { margin: 0; }
        .account-info { margin-top: 27px; font-size: 16px; line-height: 2.8; }
        .account-info strong { margin-right: 5px; }
        .account-alert { margin-top: 20px; padding: 12px 15px; color: #176b35; background: #e8f7ed; }
        .password-form { display: flex; flex-direction: column; max-width: 520px; gap: 8px; margin-top: 25px; }
        .password-form label { margin-top: 8px; font-weight: 600; }
        .password-form input { height: 42px; padding: 0 12px; border: 1px solid #d8d8d8; border-radius: 2px; outline: 0; }
        .password-form input:focus { border-color: #e21c2a; }
        .password-form button { width: fit-content; margin-top: 12px; padding: 11px 20px; border: 0; color: #fff; background: #e21c2a; cursor: pointer; }
        .password-form button:hover { background: #bd151e; }
        .form-error { color: #d71920; font-size: 14px; }
        .address-heading { display: flex; align-items: center; justify-content: space-between; gap: 20px; }
        .address-add-button, .address-form button { display: inline-block; padding: 11px 20px; border: 0; color: #fff; background: #b5121b; cursor: pointer; }
        .address-add-button { text-decoration: none; }
        .address-form { display: grid; max-width: 620px; gap: 8px; margin: 25px 0 30px; }
        .address-form label { margin-top: 8px; font-weight: 600; }
        .address-form input { height: 42px; padding: 0 12px; border: 1px solid #d8d8d8; outline: 0; }
        .address-form input:focus { border-color: #e21c2a; }
        .address-list { margin-top: 25px; }
        .address-item { position: relative; padding: 23px 145px 23px 20px; border-top: 1px solid #e2e2e2; line-height: 2.5; }
        .address-item:last-child { border-bottom: 1px solid #e2e2e2; }
        .address-item strong { margin-right: 5px; }
        .address-actions { position: absolute; top: 35px; right: 20px; display: flex; gap: 20px; }
        .address-actions button { padding: 0; border: 0; color: #e21c2a; background: transparent; cursor: pointer; }
        .address-actions .set-default { color: #198754; font-size: 13px; }
        .address-empty { margin-top: 25px; color: #666; }
        .address-modal { position: fixed; inset: 0; z-index: 10; display: none; align-items: center; justify-content: center; padding: 20px; background: rgba(0, 0, 0, .62); }
        .address-modal.is-open { display: flex; }
        .address-modal__box { width: min(890px, 100%); max-height: calc(100vh - 40px); overflow-y: auto; background: #fff; box-shadow: 0 8px 30px rgba(0, 0, 0, .25); }
        .address-modal__header { display: flex; align-items: center; justify-content: space-between; padding: 20px 40px; border-bottom: 1px solid #ddd; }
        .address-modal__header h3 { margin: 0; font-size: 20px; }
        .address-modal__close { padding: 0; border: 0; color: #777; background: transparent; font-size: 38px; font-weight: 200; line-height: 1; cursor: pointer; }
        .address-modal .address-form { max-width: none; margin: 0; padding: 22px 34px 28px; gap: 10px; }
        .address-modal .address-form label { margin-top: 4px; color: #69717a; font-size: 13px; font-weight: 700; text-transform: uppercase; }
        .address-modal .address-form input:not([type="checkbox"]) { height: 57px; padding: 0 20px; border: 1px solid #c7d0da; font-size: 16px; }
        .address-default { display: flex; align-items: center; gap: 9px; margin: 12px 0 5px !important; color: #111 !important; font-size: 16px !important; text-transform: none !important; }
        .address-default input { width: 16px; height: 16px; }
        .address-modal .address-form button { justify-self: end; margin-top: 5px; }
        .footer-info { padding: 42px 0 55px; background: #f7f7f7; }
        .footer-info__grid { display: grid; grid-template-columns: 1fr 1fr; gap: 70px; }
        .footer-info h2 { margin: 0 0 22px; color: #202b35; font-size: 20px; }
        .footer-info p { max-width: 730px; margin: 0 0 8px; color: #526273; font-size: 15px; line-height: 1.8; }
        .footer-bottom { padding: 30px 0; color: #fff; background: #222; text-align: center; }
        .footer-bottom p { margin: 8px 0 0; color: #ccc; font-size: 18px; }
        @media (max-width: 800px) {
            .site-header__main { flex-wrap: wrap; padding: 16px 0; }
            .site-header__search { order: 3; width: 100%; }
            .site-header__actions { gap: 10px; font-size: 13px; }
            .site-header__nav .container { gap: 25px; }
            .account-layout { grid-template-columns: 1fr; gap: 30px; padding: 35px 0; }
            .footer-info__grid { grid-template-columns: 1fr; gap: 25px; }
            .footer-info h2 { font-size: 24px; }
            .footer-info p { font-size: 17px; }
            .account-banner { padding: 90px 0; }
        }
    </style>
</head>
<body>
    @include('customer.partials.header')

    <section class="account-banner">
        <div class="container">
            <h1>TRANG KHÁCH HÀNG</h1>
            <p>Quản lý thông tin tài khoản và đơn hàng của bạn</p>
        </div>
    </section>

    <main class="container account-layout">
        <aside class="account-sidebar">
            <h2>TRANG TÀI KHOẢN</h2>
            <strong class="account-sidebar__greeting">Xin chào, {{ $user->name }}!</strong>

            <nav class="account-menu">
                <a class="{{ $section === 'info' ? 'active' : '' }}" href="{{ route('customer.account') }}">Thông tin tài khoản</a>
                <a href="#">Đơn hàng của bạn</a>
                <a class="{{ $section === 'password' ? 'active' : '' }}" href="{{ route('customer.account', ['section' => 'password']) }}">Đổi mật khẩu</a>
                <a class="{{ $section === 'addresses' ? 'active' : '' }}" href="{{ route('customer.account', ['section' => 'addresses']) }}">Sổ địa chỉ ({{ $addresses->count() }})</a>
                <form action="{{ route('customer.account.logout') }}" method="POST">
                    @csrf
                    <button type="submit">Đăng xuất</button>
                </form>
            </nav>
        </aside>

        <section class="account-content">
            @if ($section === 'password')
                <h2>ĐỔI MẬT KHẨU</h2>
                <form method="POST" action="{{ route('customer.account.password.update') }}" class="password-form">
                    @csrf
                    @method('PUT')

                    <label for="current_password">Mật khẩu hiện tại</label>
                    <input id="current_password" name="current_password" type="password" required>
                    @error('current_password') <span class="form-error">{{ $message }}</span> @enderror

                    <label for="password">Mật khẩu mới</label>
                    <input id="password" name="password" type="password" required>
                    @error('password') <span class="form-error">{{ $message }}</span> @enderror

                    <label for="password_confirmation">Xác nhận mật khẩu mới</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required>

                    <button type="submit">Đổi mật khẩu</button>
                </form>
            @elseif ($section === 'addresses')
                <div class="address-heading">
                    <h2>ĐỊA CHỈ CỦA BẠN</h2>
                    <button class="address-add-button" type="button" data-open-address-modal>Thêm địa chỉ</button>
                </div>

                @if ($editingAddress)
                <form id="add-address" method="POST" action="{{ route('customer.account.addresses.update', $editingAddress->maDiaChi) }}" class="address-form">
                    @csrf
                    @method('PUT')
                    @error('address')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <label for="hoTenNguoiNhan">Họ tên người nhận</label>
                    <input id="hoTenNguoiNhan" name="hoTenNguoiNhan" value="{{ old('hoTenNguoiNhan', $editingAddress->hoTenNguoiNhan ?? $user->name) }}" required>
                    @error('hoTenNguoiNhan') <span class="form-error">{{ $message }}</span> @enderror

                    <label for="sdt">Số điện thoại</label>
                    <input id="sdt" name="sdt" type="text" inputmode="numeric" value="{{ old('sdt', $editingAddress->sdt ?? $user->phone) }}" required>
                    @error('sdt') <span class="form-error">{{ $message }}</span> @enderror

                    <label for="diaChiChiTiet">Địa chỉ</label>
                    <input id="diaChiChiTiet" name="diaChiChiTiet" value="{{ old('diaChiChiTiet', $editingAddress->diaChiChiTiet ?? '') }}" required>
                    @error('diaChiChiTiet') <span class="form-error">{{ $message }}</span> @enderror

                    <label class="address-default" for="editIsDefault">
                        <input id="editIsDefault" name="isDefault" type="checkbox" value="1" @checked(old('isDefault', $editingAddress->isDefault))>
                        Đặt là địa chỉ mặc định?
                    </label>

                    <button type="submit">Cập nhật địa chỉ</button>
                </form>
                @endif

                @if ($errors->any() && ! $editingAddress)
                    <div class="account-alert">Vui lòng kiểm tra lại thông tin địa chỉ.</div>
                @endif

                @forelse ($addresses as $address)
                    <article class="address-item">
                        <div><strong>Họ tên:</strong> {{ $address->hoTenNguoiNhan }}</div>
                        <div><strong>Địa chỉ:</strong> {{ $address->diaChiChiTiet }}</div>
                        <div><strong>Số điện thoại:</strong> {{ $address->sdt }}</div>

                        <div class="address-actions">
                            <a href="{{ route('customer.account.addresses.edit', $address->maDiaChi) }}">Chỉnh sửa địa chỉ</a>
                            @if ($address->isDefault)
                                <span class="address-actions set-default">Địa chỉ mặc định</span>
                            @else
                                <form method="POST" action="{{ route('customer.account.addresses.default', $address->maDiaChi) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="set-default" type="submit">Đặt mặc định</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('customer.account.addresses.destroy', $address->maDiaChi) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Xóa</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="address-empty">Bạn chưa có địa chỉ nào.</p>
                @endforelse

                @if (! $editingAddress)
                    <div class="address-modal {{ $errors->any() ? 'is-open' : '' }}" data-address-modal>
                        <div class="address-modal__box" role="dialog" aria-modal="true" aria-labelledby="address-modal-title">
                            <div class="address-modal__header">
                                <h3 id="address-modal-title">THÊM ĐỊA CHỈ MỚI</h3>
                                <button class="address-modal__close" type="button" data-close-address-modal aria-label="Đóng">&times;</button>
                            </div>
                            <form method="POST" action="{{ route('customer.account.addresses.store') }}" class="address-form">
                                @csrf
                                @error('address') <span class="form-error">{{ $message }}</span> @enderror

                                <label for="modalHoTenNguoiNhan">Họ tên</label>
                                <input id="modalHoTenNguoiNhan" name="hoTenNguoiNhan" value="{{ old('hoTenNguoiNhan') }}" required>
                                @error('hoTenNguoiNhan') <span class="form-error">{{ $message }}</span> @enderror

                                <label for="modalSdt">Số điện thoại</label>
                                <input id="modalSdt" name="sdt" type="text" inputmode="numeric" value="{{ old('sdt') }}" required>
                                @error('sdt') <span class="form-error">{{ $message }}</span> @enderror

                                <label for="modalDiaChiChiTiet">Địa chỉ</label>
                                <input id="modalDiaChiChiTiet" name="diaChiChiTiet" value="{{ old('diaChiChiTiet') }}" required>
                                @error('diaChiChiTiet') <span class="form-error">{{ $message }}</span> @enderror

                                <label class="address-default" for="modalIsDefault">
                                    <input id="modalIsDefault" name="isDefault" type="checkbox" value="1" @checked(old('isDefault'))>
                                    Đặt là địa chỉ mặc định?
                                </label>
                                <button type="submit">Thêm địa chỉ</button>
                            </form>
                        </div>
                    </div>
                @endif
            @else
                <h2>THÔNG TIN TÀI KHOẢN</h2>
                <div class="account-info">
                    <div><strong>Họ tên:</strong> {{ $user->name ?: 'Chưa cập nhật' }}</div>
                    <div><strong>Email:</strong> {{ $user->email ?: 'Chưa cập nhật' }}</div>
                    <div><strong>Điện thoại:</strong> {{ $user->phone ?: 'Chưa cập nhật' }}</div>
                    <div><strong>Địa chỉ:</strong> {{ $defaultAddress?->diaChiChiTiet ?? 'Chưa cập nhật' }}</div>
                </div>
            @endif

            @if (session('success'))
                <div class="account-alert">{{ session('success') }}</div>
            @endif

            @if (session('address_delete_error'))
                <div class="account-alert">{{ session('address_delete_error') }}</div>
            @endif
        </section>
    </main>

    <footer>
        <div class="footer-info">
            <div class="container footer-info__grid">
                <div>
                    <h2>Nhà xuất bản Kim Đồng</h2>
                    <p>Nhà xuất bản chuyên cung cấp các đầu sách dành cho thiếu nhi, thanh thiếu niên và độc giả yêu sách.</p>
                </div>
                <div>
                    <h2>Thông tin liên hệ</h2>
                    <p>Email: lienhe@kimdong.vn</p>
                    <p>Điện thoại: 024 3943 4730</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <strong>NHÀ XUẤT BẢN KIM ĐỒNG</strong>
                <p>© 2026. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script>
        const addressModal = document.querySelector('[data-address-modal]');
        const openAddressModal = document.querySelector('[data-open-address-modal]');
        const closeAddressModal = document.querySelector('[data-close-address-modal]');

        openAddressModal?.addEventListener('click', () => {
            addressModal.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        });

        const closeModal = () => {
            addressModal?.classList.remove('is-open');
            document.body.style.overflow = '';
        };

        closeAddressModal?.addEventListener('click', closeModal);
        addressModal?.addEventListener('click', (event) => {
            if (event.target === addressModal) closeModal();
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeModal();
        });

        document.querySelectorAll('input[name="sdt"]').forEach((phoneInput) => {
            phoneInput.addEventListener('input', () => {
                phoneInput.value = phoneInput.value.replace(/\D/g, '');
            });
        });

    </script>
</body>
</html>
