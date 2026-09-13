<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            color: #222;
        }
        a { text-decoration: none; }
        .page {
            max-width: 1180px;
            margin: 0 auto;
            padding: 10px 18px 24px;
        }
        .cart-header {
            color: #1d1d1d;
            font-weight: 700;
            font-size: 1.45rem;
            letter-spacing: -0.02em;
            margin: 0 0 14px;
            line-height: 1.3;
        }
        .cart-table {
            background: #fff;
            border: 1px solid #e2e2e2;
            border-radius: 0;
            overflow: hidden;
            box-shadow: none;
        }
        .cart-row-header,
        .cart-item {
            display: grid;
            grid-template-columns: 36px minmax(0, 2.6fr) 0.9fr 0.8fr 0.9fr 54px;
            align-items: center;
            gap: 10px;
            padding: 0;
        }
        .cart-row-header {
            background: #f6f6f6;
            border-bottom: 1px solid #d8d8d8;
            min-height: 62px;
        }
        .header-cell {
            padding: 12px 10px;
            font-weight: 700;
            color: #2a2a2a;
            font-size: 0.95rem;
            text-align: center;
        }
        .header-cell.product-col {
            text-align: left;
            padding-left: 12px;
        }
        .select-cell {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-left: 0;
        }
        .select-cell input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #e53935;
            cursor: pointer;
        }
        .cart-item {
            min-height: 150px;
            border-bottom: 1px solid #e5e5e5;
            padding: 12px 0;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .product-panel {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-left: 12px;
        }
        .product-select {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .product-select input[type="checkbox"] {
            width: 22px;
            height: 22px;
            accent-color: #e53935;
            cursor: pointer;
        }
        .product-thumb {
            width: 88px;
            height: 95px;
            background: #f8f8f8;
            border: 1px solid #ececec;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }
        .product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .product-thumb.placeholder {
            font-size: 0.8rem;
            color: #999;
            text-align: center;
            padding: 8px;
        }
        .product-name {
            font-size: 1rem;
            line-height: 1.4;
            color: #222;
            font-weight: 500;
        }
        .price-cell,
        .qty-cell,
        .total-cell,
        .delete-cell {
            text-align: center;
        }
        .price-box {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 52px;
        }
        .current-price {
            color: #e53935;
            font-size: 1rem;
            font-weight: 700;
        }
        .qty-switch {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            width: fit-content;
            margin: 0 auto;
            border: 1px solid #d5d5d5;
            background: #fff;
        }
        .qty-btn {
            width: 30px;
            height: 30px;
            border: none;
            background: transparent;
            font-size: 1.3rem;
            color: #333;
            cursor: pointer;
            line-height: 1;
            font-weight: 400;
        }
        .qty-value {
            width: 36px;
            height: 30px;
            border: none;
            border-left: 1px solid #d5d5d5;
            border-right: 1px solid #d5d5d5;
            text-align: center;
            font-size: 0.95rem;
            font-weight: 700;
            background: #fff;
            color: #222;
        }
        .total-price {
            color: #111;
            font-size: 1.04rem;
            font-weight: 800;
        }
        .delete-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #d6d6d6;
            background: #f5f5f5;
            cursor: pointer;
            border-radius: 4px;
            color: #444;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        .summary-wrap {
            display: flex;
            justify-content: flex-end;
            margin-top: 12px;
        }
        .summary-box {
            width: 360px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 12px 14px 0;
            border: 1px solid #e2e2e2;
            background: #fafafa;
        }
        .summary-total {
            text-align: right;
            color: #111;
            font-size: 0.94rem;
            font-weight: 700;
            line-height: 1.7;
        }
        .summary-total strong {
            color: #111;
            font-size: 0.98rem;
        }
        .checkout-btn {
            display: block;
            width: 100%;
            border: none;
            background: linear-gradient(180deg, #ef3d3d 0%, #e73434 100%);
            color: #fff;
            font-weight: 700;
            font-size: 0.98rem;
            padding: 12px 16px;
            cursor: pointer;
            border-radius: 6px;
            margin-top: 8px;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 0.01em;
            box-shadow: 0 4px 10px rgba(229, 57, 53, 0.18);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .checkout-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(229, 57, 53, 0.22);
        }
        .checkout-btn.disabled {
            pointer-events: none;
            opacity: 0.5;
            cursor: not-allowed;
        }
        .continue-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 18px;
            color: #222;
            font-weight: 700;
            font-size: 1.05rem;
        }
        .continue-link .arrow {
            font-size: 1.2rem;
        }
        .empty-state {
            background: #fff;
            border: 1px solid #e3e3e3;
            padding: 40px 20px;
            text-align: center;
            color: #444;
        }
        .empty-state a {
            display: inline-block;
            margin-top: 16px;
            background: #e53935;
            color: #fff;
            padding: 12px 18px;
            font-weight: 700;
        }
        @media (max-width: 980px) {
            .cart-row-header {
                display: none;
            }
            .cart-item {
                grid-template-columns: 1fr;
                padding: 18px;
            }
            .product-panel {
                padding-left: 0;
            }
            .price-cell, .qty-cell, .total-cell, .delete-cell {
                text-align: left;
                padding-left: 0;
            }
        }
    </style>
</head>

<body>
    @php
        $cartItems = session('cart', []);
        $cartCount = collect($cartItems)->sum(fn ($item) => (int) ($item['soLuong'] ?? 0));
    @endphp

    <main class="page">
        <h1 class="cart-header">Giỏ hàng của bạn (đang có {{ $cartCount }} sản phẩm)</h1>

        @if (empty($items))
            <div class="empty-state">
                <h2>Giỏ hàng của bạn đang trống.</h2>
                <a href="{{ route('customer.home') }}">Tiếp tục mua sắm</a>
            </div>
        @else
            <div class="cart-table">
                <div class="cart-row-header">
                    <div class="header-cell select-cell">
                        <input type="checkbox" id="select-all-items" aria-label="Chọn tất cả sản phẩm">
                    </div>
                    <div class="header-cell product-col">Thông tin sản phẩm</div>
                    <div class="header-cell">Đơn giá</div>
                    <div class="header-cell">Số lượng</div>
                    <div class="header-cell">Thành tiền</div>
                    <div class="header-cell"></div>
                </div>

                @foreach ($items as $item)
                    <div class="cart-item" data-ma-sach="{{ $item['maSach'] }}" data-price="{{ $item['giaBan'] }}">
                        <div class="product-select">
                            <input type="checkbox" class="item-select" data-ma-sach="{{ $item['maSach'] }}" checked>
                        </div>

                        <div class="product-panel">
                            <div class="product-thumb">
                                @if (!empty($item['hinhAnh']))
                                    <img src="{{ asset('storage/' . $item['hinhAnh']) }}" alt="{{ $item['tenSach'] }}">
                                @else
                                    <div class="product-thumb placeholder">No image</div>
                                @endif
                            </div>
                            <div class="product-name">{{ $item['tenSach'] }}</div>
                        </div>

                        <div class="price-cell">
                            <div class="price-box">
                                <span class="current-price">{{ number_format((float) $item['giaBan'], 0, ',', '.') }}₫</span>
                            </div>
                        </div>

                        <div class="qty-cell">
                            <div class="qty-switch">
                                <button type="button" class="qty-btn qty-minus" data-action="minus" data-key="{{ $item['maSach'] }}">−</button>
                                <input class="qty-value" type="number" value="{{ $item['soLuong'] }}" min="1" readonly>
                                <button type="button" class="qty-btn qty-plus" data-action="plus" data-key="{{ $item['maSach'] }}">＋</button>
                            </div>
                        </div>

                        <div class="total-cell">
                            <span class="total-price">{{ number_format((int) $item['soLuong'] * (float) $item['giaBan'], 0, ',', '.') }}₫</span>
                        </div>

                        <div class="delete-cell">
                            <button type="button" class="delete-btn" data-action="remove" data-key="{{ $item['maSach'] }}" aria-label="Xóa sản phẩm">🗑</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="summary-wrap">
                <div class="summary-box">
                    <div class="summary-total">
                        <div><strong id="selected-total-display">{{ number_format($total, 0, ',', '.') }}₫</strong></div>
                    </div>
                    <a href="{{ route('customer.checkout') }}" id="checkout-selected-btn" class="checkout-btn">Thanh toán</a>
                </div>
            </div>

            <a href="{{ route('customer.home') }}" class="continue-link"><span class="arrow">←</span> Tiếp tục mua hàng</a>
        @endif
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formatVND = value => new Intl.NumberFormat('vi-VN').format(value) + '₫';

            function updateTotals() {
                const rows = document.querySelectorAll('.cart-item');
                let count = 0;
                let selectedTotal = 0;

                rows.forEach((row) => {
                    const price = Number(row.dataset.price || 0);
                    const qty = Number(row.querySelector('.qty-value')?.value || 0);
                    const lineTotal = price * qty;
                    const checkbox = row.querySelector('.item-select');

                    row.querySelector('.total-price').textContent = formatVND(lineTotal);
                    count += qty;

                    if (checkbox && checkbox.checked) {
                        selectedTotal += lineTotal;
                    }
                });

                const header = document.querySelector('.cart-header');
                if (header) {
                    header.textContent = `Giỏ hàng của bạn (đang có ${count} sản phẩm)`;
                }

                const selectedTotalDisplay = document.getElementById('selected-total-display');
                if (selectedTotalDisplay) {
                    selectedTotalDisplay.textContent = formatVND(selectedTotal);
                }

                const badge = document.querySelector('.cart-badge');
                if (badge) {
                    badge.textContent = count;
                }
            }

            const selectAllCheckbox = document.getElementById('select-all-items');
            const checkoutButton = document.getElementById('checkout-selected-btn');

            function updateCheckoutLink() {
                const selected = [...document.querySelectorAll('.item-select:checked')].map((checkbox) => checkbox.dataset.maSach);
                const checkoutUrl = new URL('{{ route('customer.checkout') }}', window.location.origin);

                if (selected.length > 0) {
                    selected.forEach((maSach) => checkoutUrl.searchParams.append('selected[]', maSach));
                    checkoutButton.href = checkoutUrl.toString();
                    checkoutButton.classList.remove('disabled');
                    checkoutButton.setAttribute('aria-disabled', 'false');
                } else {
                    checkoutButton.href = '#';
                    checkoutButton.classList.add('disabled');
                    checkoutButton.setAttribute('aria-disabled', 'true');
                }
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function () {
                    document.querySelectorAll('.item-select').forEach((checkbox) => {
                        checkbox.checked = this.checked;
                    });
                    updateTotals();
                    updateCheckoutLink();
                });
            }

            document.querySelectorAll('.item-select').forEach((checkbox) => {
                checkbox.addEventListener('change', function () {
                    const totalSelected = document.querySelectorAll('.item-select:checked').length;
                    const totalBoxes = document.querySelectorAll('.item-select').length;
                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked = totalSelected === totalBoxes && totalBoxes > 0;
                    }
                    updateTotals();
                    updateCheckoutLink();
                });
            });

            const handleCartAction = async (row, action) => {
                const maSach = row.dataset.maSach;

                try {
                    const response = await fetch('{{ route('customer.cart.update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ maSach, action })
                    });

                    const data = await response.json();
                    if (!data.success) {
                        alert(data.message || 'Không thể cập nhật giỏ hàng.');
                        return;
                    }

                    if (action === 'remove') {
                        row.remove();
                    } else {
                        const qtyInput = row.querySelector('.qty-value');
                        const current = Number(qtyInput.value || 0);
                        const next = action === 'plus' ? current + 1 : current - 1;

                        if (next <= 0) {
                            row.remove();
                        } else {
                            qtyInput.value = next;
                        }
                    }

                    const remaining = document.querySelectorAll('.cart-item');
                    if (remaining.length === 0) {
                        window.location.reload();
                        return;
                    }

                    updateTotals();
                    updateCheckoutLink();
                    const badge = document.querySelector('.cart-badge');
                    if (badge && data.cartCount !== undefined) {
                        badge.textContent = data.cartCount;
                    }
                } catch (error) {
                    console.error(error);
                    alert('Không thể cập nhật giỏ hàng.');
                }
            };

            document.querySelectorAll('[data-action]').forEach((button) => {
                button.addEventListener('click', async function () {
                    const row = button.closest('.cart-item');
                    if (!row) return;
                    await handleCartAction(row, this.dataset.action);
                });
            });

            document.querySelectorAll('.item-select').forEach((checkbox) => {
                checkbox.checked = true;
            });

            updateTotals();
            updateCheckoutLink();
        });
    </script>
</body>
</html>
