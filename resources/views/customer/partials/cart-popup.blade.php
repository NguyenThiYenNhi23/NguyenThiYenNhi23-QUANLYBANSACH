@php
    $cartItems = session('cart', []);
    $cartCount = collect($cartItems)->sum(fn ($item) => (int) ($item['soLuong'] ?? 0));
    $cartTotal = collect($cartItems)->sum(fn ($item) => (int) ($item['soLuong'] ?? 0) * (float) ($item['giaBan'] ?? 0));
@endphp

<style>
.mini-cart-popup{position:fixed;top:82px;right:25px;width:390px;max-height:620px;background:#fff;border:1px solid #ddd;box-shadow:0 4px 18px rgba(0,0,0,.18);z-index:99999;display:none}.mini-cart-popup.show{display:block}.mini-cart-title{background:#e52323;color:#fff;padding:10px 12px;font-size:15px;font-weight:700;display:flex;justify-content:space-between;align-items:center}.mini-cart-close{background:none;border:none;color:#fff;font-size:20px;cursor:pointer}.mini-cart-body{max-height:455px;overflow-y:auto}.mini-cart-item{display:flex;gap:10px;padding:10px;border-bottom:1px solid #eee;position:relative}.mini-cart-image{width:50px;height:65px;flex-shrink:0;border:1px solid #eee;overflow:hidden}.mini-cart-image img{width:100%;height:100%;object-fit:cover}.mini-cart-info{flex:1;min-width:0;padding-right:25px}.mini-cart-name{font-size:13px;line-height:1.35;color:#333;margin-bottom:5px}.mini-cart-quantity{font-size:12px;color:#666;margin-bottom:3px}.mini-cart-price{color:#e52323;font-weight:700;font-size:13px}.mini-cart-remove{position:absolute;right:8px;top:8px;border:none;background:none;color:#e52323;font-size:18px;cursor:pointer}.mini-cart-empty{padding:35px 15px;text-align:center;color:#777;font-size:14px}.mini-cart-footer{border-top:1px solid #ddd;padding:10px;background:#fff}.mini-cart-total{display:flex;justify-content:space-between;font-weight:700;margin-bottom:10px}.mini-cart-total-price{color:#e52323}.mini-cart-buttons{display:flex;gap:8px}.mini-cart-buttons a{flex:1;text-align:center;padding:9px 5px;font-size:12px;font-weight:700;text-decoration:none;border:1px solid #e52323}.mini-cart-view{color:#e52323;background:#fff}.mini-cart-checkout{color:#fff;background:#e52323}.mini-cart-qty{display:flex;align-items:center;gap:4px;margin-top:4px}.mini-cart-qty button{width:22px;height:22px;border:1px solid #ddd;background:#fff;cursor:pointer;line-height:18px}.mini-cart-qty span{min-width:22px;text-align:center;font-size:12px}@media(max-width:600px){.mini-cart-popup{right:10px;width:calc(100% - 20px)}}
</style>

<div class="mini-cart-popup" id="miniCartPopup">
    <div class="mini-cart-title">
        <span>Giỏ hàng của tôi</span>
        <button type="button" class="mini-cart-close" id="miniCartClose">×</button>
    </div>
    <div class="mini-cart-body" id="miniCartBody"></div>
    <div class="mini-cart-footer" id="miniCartFooter"></div>
</div>

<script>
(function () {
    const popup = document.getElementById('miniCartPopup');
    const body = document.getElementById('miniCartBody');
    const footer = document.getElementById('miniCartFooter');
    const closeButton = document.getElementById('miniCartClose');
    if (!popup || !body || !footer) return;

    const checkoutUrl = @json(route('customer.checkout', ['source' => 'cart']));
    const cartUrl = @json(route('customer.cart'));
    const updateUrl = @json(route('customer.cart.update'));
    const csrf = @json(csrf_token());

    let state = {
        items: @json(array_values($cartItems)),
        count: {{ $cartCount }},
        total: {{ $cartTotal }}
    };

    function money(value) {
        return new Intl.NumberFormat('vi-VN').format(Number(value || 0)) + '₫';
    }

    function updateBadges(count) {
        document.querySelectorAll('#cart-badge, .cart-badge, [data-cart-count]').forEach(el => {
            el.textContent = count;
            if (el.classList.contains('cart-badge')) el.style.display = count > 0 ? 'inline-flex' : 'none';
        });
    }

    function render(data) {
        state.items = Array.isArray(data.items) ? data.items : [];
        state.count = Number(data.count ?? state.items.reduce((s, i) => s + Number(i.soLuong || 0), 0));
        state.total = Number(data.total ?? state.items.reduce((s, i) => s + Number(i.giaBan || 0) * Number(i.soLuong || 0), 0));
        updateBadges(state.count);

        if (!state.items.length) {
            body.innerHTML = '<div class="mini-cart-empty">Giỏ hàng của bạn đang trống.</div>';
            footer.innerHTML = '';
            return;
        }

        body.innerHTML = state.items.map(item => {
            const image = item.hinhAnh ? (String(item.hinhAnh).startsWith('http') || String(item.hinhAnh).startsWith('/') ? item.hinhAnh : '/storage/' + item.hinhAnh) : '';
            return `
                <div class="mini-cart-item" data-ma-sach="${item.maSach}">
                    <div class="mini-cart-image">${image ? `<img src="${image}" alt="">` : ''}</div>
                    <div class="mini-cart-info">
                        <div class="mini-cart-name">${item.tenSach || ''}</div>
                        <div class="mini-cart-quantity">
                            Số lượng:
                            <div class="mini-cart-qty">
                                <button type="button" data-mini-action="minus" data-ma-sach="${item.maSach}">−</button>
                                <span>${Number(item.soLuong || 0)}</span>
                                <button type="button" data-mini-action="plus" data-ma-sach="${item.maSach}">+</button>
                            </div>
                        </div>
                        <div class="mini-cart-price">${money(item.giaBan)}</div>
                    </div>
                    <button type="button" class="mini-cart-remove" data-mini-action="remove" data-ma-sach="${item.maSach}">×</button>
                </div>`;
        }).join('');

        footer.innerHTML = `
            <div class="mini-cart-total"><span>TẠM TÍNH:</span><span class="mini-cart-total-price">${money(state.total)}</span></div>
            <div class="mini-cart-buttons">
                <a href="${cartUrl}" class="mini-cart-view">XEM GIỎ HÀNG</a>
                <a href="${checkoutUrl}" class="mini-cart-checkout">THANH TOÁN</a>
            </div>`;
    }

    async function updateItem(maSach, action) {
        try {
            const response = await fetch(updateUrl, {
                method: 'POST',
                headers: {'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf,'X-Requested-With':'XMLHttpRequest'},
                body: JSON.stringify({maSach:Number(maSach), action}),
                credentials:'same-origin'
            });
            const data = await response.json();
            if (!response.ok || !data.success) throw new Error(data.message || 'Không thể cập nhật giỏ hàng.');
            const items = Array.isArray(data.cartItems) ? data.cartItems : state.items;
            const count = Number(data.cartCount ?? items.reduce((s, i) => s + Number(i.soLuong || 0), 0));
            const total = Number(data.cartTotal ?? items.reduce((s, i) => s + Number(i.giaBan || 0) * Number(i.soLuong || 0), 0));

            render({items, count, total});

            window.dispatchEvent(new CustomEvent('cart:updated', {
                detail: {
                    cartItems: items,
                    cartCount: count,
                    cartTotal: total
                }
            }));
        } catch (error) {
            console.error(error);
            alert(error.message || 'Không thể cập nhật giỏ hàng.');
        }
    }

    popup.addEventListener('click', function (event) {
        const button = event.target.closest('[data-mini-action][data-ma-sach]');
        if (!button) return;
        updateItem(button.dataset.maSach, button.dataset.miniAction);
    });

    document.querySelectorAll('#cartToggle, .cart-link, .mini-cart-trigger').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            popup.classList.toggle('show');
        });
    });

    closeButton.addEventListener('click', () => popup.classList.remove('show'));

    document.addEventListener('click', function (event) {
        const clickedCart = event.target.closest('#cartToggle, .cart-link, .mini-cart-trigger');
        if (!popup.contains(event.target) && !clickedCart) popup.classList.remove('show');
    });

    window.addEventListener('cart:updated', function (event) {
        const d = event.detail || {};
        render({
            items: Array.isArray(d.cartItems) ? d.cartItems : [],
            count: Number(d.cartCount ?? 0),
            total: Number(d.cartTotal ?? 0)
        });
    });

    /*
     * Khi chuyển giữa Trang chủ / Danh mục / Chi tiết,
     * luôn lấy lại trạng thái cart từ server.
     *
     * Như vậy badge ở header không thể còn số cũ của trang trước.
     */
    async function syncFromServer() {
        try {
            const response = await fetch(cartUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'text/html'
                },
                credentials: 'same-origin',
                cache: 'no-store'
            });

            if (!response.ok) return;

            const html = await response.text();
            const doc = new DOMParser().parseFromString(html, 'text/html');

            /*
             * Trang giỏ hàng luôn render cart-header theo session('cart').
             * Đọc con số này làm nguồn sự thật cho badge.
             */
            const cartHeader = doc.querySelector('.cart-header');
            const match = cartHeader
                ? cartHeader.textContent.match(/(\\d+)\\s*sản phẩm/i)
                : null;

            if (!match) return;

            const count = Number(match[1]);

            updateBadges(count);

            window.dispatchEvent(new CustomEvent('cart:server-synced', {
                detail: { cartCount: count }
            }));
        } catch (error) {
            console.error('Không thể đồng bộ số lượng giỏ hàng:', error);
        }
    }

    render(state);
    syncFromServer();
})();
</script>
