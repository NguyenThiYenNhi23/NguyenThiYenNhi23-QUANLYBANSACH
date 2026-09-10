<?php

namespace App\Http\Controllers;

use App\Models\Sach;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerBookController extends Controller
{
    public function show(Sach $sach): View
    {
        return view('customer.book', compact('sach'));
    }

    public function addToCart(Request $request): RedirectResponse
    {
        return redirect()
            ->route('customer.cart')
            ->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    public function buyNow(Request $request): RedirectResponse
    {
        return redirect()->route('customer.cart');
    }

    public function cart(): View
    {
        return view('customer.cart');
    }

    public function checkout(): RedirectResponse
    {
        return redirect()->route('customer.cart');
    }

    public function storeAddress(Request $request): RedirectResponse
    {
        return redirect()->route('customer.checkout');
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        return redirect()->route('customer.home');
    }

    public function vnpayPayment(): RedirectResponse
    {
        return redirect()->route('customer.checkout');
    }

    public function vnpayPaymentResult(): RedirectResponse
    {
        return redirect()->route('customer.home');
    }

    public function orderSuccess(int $donHang): RedirectResponse
    {
        return redirect()->route('customer.home');
    }
}
