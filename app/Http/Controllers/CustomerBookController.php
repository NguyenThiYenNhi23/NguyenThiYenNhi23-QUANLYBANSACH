<?php
namespace App\Http\Controllers;
use App\Models\CTDonHang;
use App\Models\DiaChi;
use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\PhuongThucThanhToan;
use App\Models\Sach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\ThanhToan;
class CustomerBookController extends Controller
{
    public function show(Sach $sach): View
    {$sach->load(['danhMuc','tonKho']);
        session()->put('last_viewed_book_id',$sach->maSach);
        return view('customer.book-detail',compact('sach'));
    }
public function addToCart(Request $request)
{
    if (!Auth::check()) {

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thêm sách vào giỏ hàng.',
                'redirect' => route('login'),
            ], 401);
        }

        return redirect()
            ->route('login')
            ->with('error', 'Vui lòng đăng nhập để thêm sách vào giỏ hàng.');
    }

    $request->validate([
        'maSach' => [
            'required',
            'integer',
            'exists:sachs,maSach'
        ],

        'soLuong' => [
            'required',
            'integer',
            'min:1'
        ],
    ]);

    $sach = Sach::with('tonKho')->findOrFail($request->maSach);

    $soLuongTon = (int) ($sach->tonKho->soLuongTon ?? 0);

    if ($soLuongTon <= 0) {

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Sách đã hết hàng.'
            ], 422);
        }

        return back()->with('error', 'Sách đã hết hàng.');
    }

    $soLuongThem = (int) $request->soLuong;

    $cart = session()->get('cart', []);

    $soLuongHienTai = isset($cart[$sach->maSach])
        ? (int) $cart[$sach->maSach]['soLuong']
        : 0;

    $soLuongSauKhiThem = $soLuongHienTai + $soLuongThem;

    if ($soLuongSauKhiThem > $soLuongTon) {

        $message = "Số lượng sách trong giỏ không được vượt quá tồn kho hiện tại ({$soLuongTon} quyển).";

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], 422);
        }

        return back()->with('error', $message);
    }

    $cart[$sach->maSach] = [
        'maSach' => $sach->maSach,
        'tenSach' => $sach->tenSach,
        'giaBan' => $sach->giaBan,
        'hinhAnh' => $sach->hinhAnh,
        'soLuong' => $soLuongSauKhiThem,
    ];

    session()->put('cart', $cart);

    /*
    |--------------------------------------------------------------------------
    | Nếu gọi bằng AJAX → trả JSON
    |--------------------------------------------------------------------------
    */

    if ($request->expectsJson()) {

        return response()->json([
            'success' => true,

            'message' => 'Đã thêm sản phẩm vào giỏ hàng.',

            'cartCount' => collect($cart)->sum(
                fn ($item) => (int) ($item['soLuong'] ?? 0)
            ),

            'cartItems' => array_values($cart),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Nếu gọi bình thường → vẫn giữ cách cũ
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('customer.book.show', $sach->maSach)
        ->with('success', 'Đã thêm sách vào giỏ hàng.');
}
    public function buyNow(Request $request)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error','Vui lòng đăng nhập để tiếp tục mua hàng.');
        }
        $request->validate([
            'maSach' => [
                'required',
                'integer',
                'exists:sachs,maSach'
            ],
            'soLuong' => [
                'required',
                'integer',
                'min:1'
            ],
        ]);
        $sach = Sach::with('tonKho')->findOrFail($request->maSach);
        $soLuongMua = (int) $request->soLuong;
        $soLuongTon = (int) ($sach->tonKho->soLuongTon ?? 1);
        if ($soLuongTon <= 0) {
            return back()
                ->with('error','Sách đã hết hàng.');
        }
        if ($soLuongMua > $soLuongTon) {
            return back()
                ->with('error',"Số lượng mua không được vượt quá tồn kho ({$soLuongTon} quyển).");
        }
        $buyNowItem = [
            $sach->maSach => [
                'maSach' => $sach->maSach,
                'tenSach' => $sach->tenSach,
                'giaBan' => $sach->giaBan,
                'hinhAnh' => $sach->hinhAnh,
                'soLuong' => $soLuongMua,
            ],
        ];
        session()->put('buy_now',$buyNowItem);
        session()->forget('checkout_selected');
        session()->put('checkout_source','buy_now');
        session()->put('last_viewed_book_id',$sach->maSach);

        return redirect()->route('customer.checkout');
    }
    public function cart(): View
    {
        $cart = session()->get('cart',[]);
        $items = array_values($cart);
        $total = collect($items)->sum(
            function ($item) {
                return(float) $item['giaBan']*(int) $item['soLuong'];}
        );
        return view('customer.cart', compact('items','total'));
    }
    public function updateCart(Request $request)
    {
        $request->validate([
            'maSach' => ['required', 'integer', 'exists:sachs,maSach'],
            'action' => ['required', 'in:plus,minus,remove'],
        ]);
        $maSach = (int) $request->maSach;
        $cart = session()->get('cart', []);
        if (! isset($cart[$maSach])) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không có trong giỏ hàng.',
            ], 404);
        }
        $sach = Sach::with('tonKho')->findOrFail($maSach);
        $soLuongTon = (int) ($sach->tonKho->soLuongTon ?? 1);
        $soLuongHienTai = (int) $cart[$maSach]['soLuong'];

        if ($request->action === 'plus') {
            if ($soLuongHienTai >= $soLuongTon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đã đạt giới hạn tồn kho.',
                ], 422);
            }

            $cart[$maSach]['soLuong'] = $soLuongHienTai + 1;
        } elseif ($request->action === 'minus') {
            if ($soLuongHienTai <= 1) {
                unset($cart[$maSach]);
            } else {
                $cart[$maSach]['soLuong'] = $soLuongHienTai - 1;
            }
        } else {
            unset($cart[$maSach]);
        }
        session()->put('cart', $cart);

        $cartItems = array_values($cart);

        $totalItems = collect($cartItems)->sum(
            fn ($item) => (int) ($item['soLuong'] ?? 0)
        );

        $cartTotal = collect($cartItems)->sum(
            fn ($item) =>
                (float) ($item['giaBan'] ?? 0) *
                (int) ($item['soLuong'] ?? 0)
        );

        return response()->json([
            'success' => true,
            'cartCount' => $totalItems,
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'message' => 'Cập nhật giỏ hàng thành công.',
        ]);
    }
    public function checkout(Request $request): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error','Vui lòng đăng nhập để tiếp tục thanh toán.');
        }

        /*
         * checkout_source là nguồn duy nhất quyết định checkout lấy dữ liệu nào.
         * - buy_now: chỉ dùng session buy_now
         * - cart: chỉ dùng session cart
         *
         * Không được tự động ưu tiên buy_now chỉ vì session buy_now còn dữ liệu cũ.
         */
        $source = $request->query(
            'source',
            session()->get('checkout_source', 'cart')
        );

        if ($source === 'buy_now') {
            $items = session()->get('buy_now', []);

            session()->put('checkout_source', 'buy_now');
            session()->forget('checkout_selected');
        } else {
            $source = 'cart';
            session()->put('checkout_source', 'cart');

            $items = session()->get('cart', []);

            $selected = $request->query('selected', []);
            $selectedIds = array_map('intval', (array) $selected);

            if (!empty($selectedIds)) {
                $items = array_filter(
                    $items,
                    fn ($item) =>
                        in_array(
                            (int) ($item['maSach'] ?? 0),
                            $selectedIds,
                            true
                        )
                );

                session()->put('checkout_selected', $selectedIds);
            } else {
                session()->forget('checkout_selected');
            }
        }

        if (empty($items)) {
            return redirect()
                ->route('customer.home')
                ->with('error','Chưa có sản phẩm nào để thanh toán.');
        }

        $khachHang = $this->getCurrentKhachHang();

        $addresses = DiaChi::query()
            ->where('maKH',$khachHang->maKH)
            ->orderByDesc('isDefault')
            ->get();

        $paymentMethods = PhuongThucThanhToan::query()
            ->where('trangThai',true)
            ->get()
            ->filter(function ($paymentMethod) {
                $name = mb_strtolower(trim($paymentMethod->tenPhuongThuc));

                return
                    str_contains($name,'cod') ||
                    str_contains($name,'nhận hàng') ||
                    str_contains($name,'vnpay') ||
                    str_contains($name,'ví điện tử');
            })
            ->values();

        $items = array_values($items);

        $total = collect($items)->sum(function ($item) {
            return
                (float) $item['giaBan'] *
                (int) $item['soLuong'];
        });

        $shippingFee = 30000;
        $grandTotal = $total + $shippingFee;

        return view(
            'customer.checkout',
            compact(
                'items',
                'khachHang',
                'addresses',
                'paymentMethods',
                'total',
                'shippingFee',
                'grandTotal',
            )
        );
    }

    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error','Vui lòng đăng nhập để đặt hàng.');
        }
        $request->validate([
            'maDiaChi' => ['required','integer','exists:dia_chis,maDiaChi'],
            'maPTTT' => ['required','integer','exists:phuong_thuc_thanh_toans,maPTTT' ],
        ]);
        $khachHang =$this->getCurrentKhachHang();
        $diaChi = DiaChi::query()
                ->where('maDiaChi',$request->maDiaChi
                )
                ->where('maKH',$khachHang->maKH
                )
                ->first();
        if (!$diaChi) {
            return back()
                ->with( 'error','Địa chỉ giao hàng không hợp lệ.'
                );
        }
        $paymentMethod =
            PhuongThucThanhToan::query()
                ->where('maPTTT',$request->maPTTT)
                ->where('trangThai',true)
                ->first();

        if (!$paymentMethod) {
            return back()->with( 'error','Phương thức thanh toán không hợp lệ.');
        }
        $paymentName = mb_strtolower( trim($paymentMethod->tenPhuongThuc ));
        $isVnpay = str_contains( $paymentName, 'vnpay' );
        $isCod = str_contains( $paymentName, 'cod')||str_contains($paymentName,'nhận hàng');
        if (!$isVnpay && !$isCod) {
            return back()
                ->with('error','Phương thức thanh toán không được hỗ trợ.');
        }
        $checkoutSource = session()->get('checkout_source', 'cart');

        if ($checkoutSource === 'buy_now') {
            $buyNow = session()->get('buy_now', []);

            if (empty($buyNow)) {
                return redirect()
                    ->route('customer.home')
                    ->with('error','Không có sản phẩm mua ngay để đặt hàng.');
            }

            $items = array_values($buyNow);
            $isBuyNow = true;

            session()->forget('checkout_selected');
        } else {
            $cart = session()->get('cart', []);

            if (empty($cart)) {
                return redirect()
                    ->route('customer.home')
                    ->with('error','Không có sản phẩm nào để đặt hàng.');
            }

            $selected = session()->get('checkout_selected', []);

            if (!empty($selected)) {
                $selectedIds = array_map('intval', $selected);

                $cart = array_filter(
                    $cart,
                    fn ($item) =>
                        in_array(
                            (int) ($item['maSach'] ?? 0),
                            $selectedIds,
                            true
                        )
                );
            }

            if (empty($cart)) {
                return redirect()
                    ->route('customer.home')
                    ->with('error', 'Không có sản phẩm nào được chọn để đặt hàng.');
            }

            $items = array_values($cart);
            $isBuyNow = false;
        }
if ($isVnpay) {
    foreach ($items as $item) {
        $sach = Sach::with('tonKho')->find($item['maSach']);
        if (!$sach) {
            return back()
                ->with( 'error','Sách không tồn tại.' );
        }
        $soLuongTon = (int) ( $sach->tonKho->soLuongTon ?? 0
        );
        if ($soLuongTon <= 0) {
            return back()
                ->with('error',"Sách '{$sach->tenSach}' đã hết hàng."
                );
        }
        if ((int) $item['soLuong'] > $soLuongTon ) {
            return back()
                ->with('error',"Sách '{$sach->tenSach}' chỉ còn {$soLuongTon} quyển.");
        }
    }
    $total = collect($items)->sum(
        function ($item) { return(float) $item['giaBan']*(int) $item['soLuong'];}
    );
    $shippingFee = 30000;
    $grandTotal =$total+ $shippingFee;
    do {
        $maGiaoDich =
            'VNP'
            . now()->format('YmdHis')
            . strtoupper(
                \Illuminate\Support\Str::random(6)
            );
    } while (
        ThanhToan::where(
            'maGiaoDich',
            $maGiaoDich
        )->exists()
    );
    $thanhToan = ThanhToan::create([
        'maDH' =>null,
        'maPTTT' => $paymentMethod->maPTTT,
        'soTien' => $grandTotal,
        'maGiaoDich' => $maGiaoDich,
        'phuongThuc' => null,
        'trangThai' =>'ChoThanhToan',
        'thoiGianThanhToan' => null,
    ]);
    session()->put(
        'pending_vnpay',
        [
            'maThanhToan' => $thanhToan->maThanhToan,
            'maGiaoDich' => $thanhToan->maGiaoDich,
            'maKH' =>$khachHang->maKH,
            'maDiaChi' => $diaChi->maDiaChi,
            'maPTTT' =>$paymentMethod->maPTTT,
            'items' =>$items,
            'isBuyNow' =>$isBuyNow,
            'total' =>$total,
            'shippingFee' =>$shippingFee,
            'grandTotal' =>$grandTotal,
        ]
    );
        return redirect()->route('customer.vnpay.show', ['maGiaoDich' => $thanhToan->maGiaoDich,]);
}
        try {
            $donHang =
                $this->createOrder(
                    $khachHang,
                    $diaChi,
                    $paymentMethod,
                    $items
                );
            if ($isBuyNow) {
                session()->forget('buy_now');
            } else {
                $selected = session()->get('checkout_selected', []);

                if (!empty($selected)) {
                    $cart = session()->get('cart', []);

                    foreach ($selected as $maSach) {
                        unset($cart[(int) $maSach]);
                    }

                    session()->put('cart', $cart);
                } else {
                    session()->forget('cart');
                }
            }

            session()->forget('checkout_source');
            session()->forget('checkout_selected');
            return redirect()
                ->route( 'customer.order.success', $donHang->maDH)
                ->with('success','Đặt hàng thành công.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error',$e->getMessage());
        }
    }
public function completeVnpayOrder(ThanhToan $thanhToan)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }
        if ($thanhToan->maDH) {
        return redirect() ->route('customer.order.success',$thanhToan->maDH);
    }
    if ($thanhToan->trangThai !== 'DaThanhToan') {
        return redirect()
            ->route('customer.checkout')
            ->with('error','Giao dịch chưa được thanh toán.');
    }
    $pending = session()->get(
        'pending_vnpay'
    );
    if (!$pending) {
        return redirect()
            ->route('customer.checkout')
            ->with('error','Thông tin đặt hàng đã hết hạn.');
    }
    if (($pending['maThanhToan'] ?? null)!=$thanhToan->maThanhToan) {
        return redirect()
            ->route('customer.checkout')
            ->with('error','Giao dịch thanh toán không hợp lệ.');
    }
    try {
        $khachHang =
            $this->getCurrentKhachHang();
        if ($pending['maKH']!=$khachHang->maKH) {
            throw new \Exception('Giao dịch không thuộc tài khoản hiện tại.');
        }
        $diaChi =
            DiaChi::query()
                ->where('maDiaChi',$pending['maDiaChi'])
                ->where('maKH',$khachHang->maKH)
                ->first();
        if (!$diaChi) {
            throw new \Exception('Địa chỉ giao hàng không tồn tại.');
        }
        $paymentMethod =
            PhuongThucThanhToan::query()
                ->where('maPTTT', $pending['maPTTT'])
                ->where('trangThai',true)
                ->first();
        if (!$paymentMethod) {
            throw new \Exception('Phương thức thanh toán không tồn tại.');
        }
        $donHang =
            $this->createOrder(
                $khachHang,
                $diaChi,
                $paymentMethod,
                $pending['items']
            );
        $thanhToan->update(['maDH' => $donHang->maDH,]);
        if (!empty($pending['isBuyNow'])) {
            session()->forget('buy_now');
        } else {
            $selected =session()->get('checkout_selected',[]);
            $cart =session()->get('cart',[]);
            if (!empty($selected)) {
                foreach ($selected as $maSach) {
                    unset($cart[(int) $maSach]);
                }
                session()->put('cart',$cart);
            } else {
                session()->forget('cart');
            }
        }
        session()->forget('pending_vnpay');
        session()->forget('checkout_source');
        session()->forget('checkout_selected');
        return redirect()
            ->route('customer.order.success', $donHang->maDH)
            ->with('success','Thanh toán VNPay thành công. Đặt hàng thành công!');
    } catch (\Exception $e) {
        $thanhToan->update(['trangThai' => 'ThatBai',]);
        session()->forget('pending_vnpay');
        return redirect()
            ->route('customer.checkout')
            ->with('error', $e->getMessage());
    }
}
    private function createOrder(
        $khachHang,
        $diaChi,
        $paymentMethod,
        $items
    ) {
        return DB::transaction(
            function () use (
                $khachHang,
                $diaChi,
                $paymentMethod,
                $items
            ) {
                $tongTienSach = 0;
                $chiTiet = [];
                foreach ($items as $item) {
                    $sach = Sach::find($item['maSach'] );
                    if (!$sach) {
                        throw new \Exception('Sách không tồn tại.');
                    }
                    $tonKho = $sach->tonKho()
                            ->lockForUpdate()
                            ->first();
                    if (!$tonKho) {
                        throw new \Exception(
                            "Sách '{$sach->tenSach}' chưa có thông tin tồn kho."
                        );
                    }
                    $soLuongDat = (int) $item['soLuong'];
                    $soLuongTon = (int) $tonKho->soLuongTon;
                    if ($soLuongTon <= 0) {
                        throw new \Exception(
                            "Sách '{$sach->tenSach}' đã hết hàng."
                        );
                    }
                    if ($soLuongDat > $soLuongTon) {
                        throw new \Exception(
                            "Sách '{$sach->tenSach}' chỉ còn {$soLuongTon} quyển."
                        );
                    }
                    $donGia = (float) $sach->giaBan;
                    $thanhTien = $donGia * $soLuongDat;
                    $tongTienSach += $thanhTien;
                    $chiTiet[] = [
                        'sach' => $sach,
                        'tonKho' => $tonKho,
                        'soLuong' => $soLuongDat,
                        'donGia' => $donGia,
                        'thanhTien' => $thanhTien,
                    ];
                }
                $shippingFee = 30000;
                $tongCong =
                    $tongTienSach
                    +
                    $shippingFee;
                $donHang =
                    DonHang::create([

                        'maKH' =>
                            $khachHang->maKH,
                        'maDiaChi' =>
                            $diaChi->maDiaChi,
                        'maPTTT' =>
                            $paymentMethod->maPTTT,
                        'ngayDat' =>
                            now(),
                        'tongTien' =>
                            $tongCong,
                        'trangThai' =>
                            'ChoXacNhan',
                    ]);
                foreach ($chiTiet as $item) {
                    CTDonHang::create([
                        'maDH' =>
                            $donHang->maDH,
                        'maSach' =>
                            $item['sach']->maSach,
                        'soLuong' =>
                            $item['soLuong'],
                        'donGia' =>
                            $item['donGia'],
                        'thanhTien' =>
                            $item['thanhTien'],
                    ]);
                    $item['tonKho']->decrement(
                        'soLuongTon',
                        $item['soLuong']
                    );
                }
                return $donHang;
            }
        );
    }
    public function orderSuccess(
        DonHang $donHang
    ): View {
        $khachHang =
            $this->getCurrentKhachHang();
        abort_unless(
            $donHang->maKH
                ==
            $khachHang->maKH,
            403
        );
        $donHang->load([
            'diaChi',
            'phuongThucThanhToan',
            'chiTietDonHangs.sach'
        ]);
        return view(
            'customer.order-success',
            compact(
                'donHang'
            )
        );
    }
    public function storeAddress(
        Request $request
    ) {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Vui lòng đăng nhập để tiếp tục.'
                );
        }
        $request->validate([
            'hoTenNguoiNhan' => [
                'required',
                'string',
                'max:100'
            ],
            'sdt' => [
                'required',
                'string',
                'max:15'
            ],
            'diaChiChiTiet' => [
                'required',
                'string',
                'max:255'
            ],
            'isDefault' => [
                'nullable',
                'boolean'
            ],
        ]);
        $khachHang =
            $this->getCurrentKhachHang();
        $isDefault =
            $request->boolean(
                'isDefault'
            )
            ||
            !DiaChi::query()
                ->where(
                    'maKH',
                    $khachHang->maKH
                )
                ->exists();
        if ($isDefault) {
            DiaChi::query()
                ->where(
                    'maKH',
                    $khachHang->maKH
                )
                ->update([
                    'isDefault' => false
                ]);
        }
        DiaChi::create([
            'maKH' =>
                $khachHang->maKH,
            'hoTenNguoiNhan' =>
                $request->hoTenNguoiNhan,
            'sdt' =>
                $request->sdt,
            'diaChiChiTiet' =>
                $request->diaChiChiTiet,
            'isDefault' =>
                $isDefault,
        ]);
        return redirect()
            ->route(
                'customer.checkout'
            )
            ->with(
                'success',
                'Đã thêm địa chỉ mới thành công.'
            );
    }
    private function getCurrentKhachHang(): KhachHang
    {
        $user = Auth::user();
        $khachHang =
            KhachHang::where(
                'user_id',
                $user->id
            )->first();
        if (!$khachHang) {
            $khachHang =
                KhachHang::create([
                    'user_id' =>
                        $user->id,
                    'hoTen' =>
                        $user->name,
                    'sdt' =>
                        $user->phone,
                    'email' =>
                        $user->email,
                ]);
        }
        return $khachHang;
    }
}