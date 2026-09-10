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

class CustomerBookController extends Controller
{
    /**
     * =========================================================
     * 1. XEM CHI TIẾT SÁCH
     * =========================================================
     */
    public function show(Sach $sach): View
    {
        $sach->load([
            'danhMuc',
            'tonKho'
        ]);

        session()->put(
            'last_viewed_book_id',
            $sach->maSach
        );

        return view(
            'customer.book-detail',
            compact('sach')
        );
    }


    /**
     * =========================================================
     * 2. THÊM SÁCH VÀO GIỎ HÀNG
     * =========================================================
     */
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Vui lòng đăng nhập để thêm sách vào giỏ hàng.'
                );
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

        $sach = Sach::with('tonKho')
            ->findOrFail($request->maSach);

        $soLuongTon = (int) (
            $sach->tonKho->soLuongTon ?? 0
        );

        if ($soLuongTon <= 0) {
            return back()
                ->with(
                    'error',
                    'Sách đã hết hàng.'
                );
        }

        $soLuongThem = (int) $request->soLuong;

        $cart = session()->get(
            'cart',
            []
        );

        $soLuongHienTai = isset($cart[$sach->maSach])
            ? (int) $cart[$sach->maSach]['soLuong']
            : 0;

        $soLuongSauKhiThem =
            $soLuongHienTai + $soLuongThem;

        if ($soLuongSauKhiThem > $soLuongTon) {
            return back()
                ->with(
                    'error',
                    "Số lượng sách trong giỏ không được vượt quá tồn kho hiện tại ({$soLuongTon} quyển)."
                );
        }

        $cart[$sach->maSach] = [
            'maSach' => $sach->maSach,
            'tenSach' => $sach->tenSach,
            'giaBan' => $sach->giaBan,
            'hinhAnh' => $sach->hinhAnh,
            'soLuong' => $soLuongSauKhiThem,
        ];

        session()->put(
            'cart',
            $cart
        );

        return redirect()
            ->route(
                'customer.book.show',
                $sach->maSach
            )
            ->with(
                'success',
                'Đã thêm sách vào giỏ hàng.'
            );
    }


    /**
     * =========================================================
     * 3. MUA NGAY
     * =========================================================
     */
    public function buyNow(Request $request)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Vui lòng đăng nhập để tiếp tục mua hàng.'
                );
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

        $sach = Sach::with('tonKho')
            ->findOrFail($request->maSach);

        $soLuongMua = (int) $request->soLuong;

        $soLuongTon = (int) (
            $sach->tonKho->soLuongTon ?? 0
        );

        if ($soLuongTon <= 0) {
            return back()
                ->with(
                    'error',
                    'Sách đã hết hàng.'
                );
        }

        if ($soLuongMua > $soLuongTon) {
            return back()
                ->with(
                    'error',
                    "Số lượng mua không được vượt quá tồn kho ({$soLuongTon} quyển)."
                );
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

        session()->put(
            'buy_now',
            $buyNowItem
        );

        session()->put(
            'last_viewed_book_id',
            $sach->maSach
        );

        return redirect()
            ->route(
                'customer.checkout'
            );
    }


    /**
     * =========================================================
     * 4. XEM GIỎ HÀNG
     * =========================================================
     */
    public function cart(): View
    {
        $cart = session()->get(
            'cart',
            []
        );

        $items = array_values($cart);

        $total = collect($items)->sum(
            function ($item) {
                return
                    (float) $item['giaBan']
                    *
                    (int) $item['soLuong'];
            }
        );

        return view(
            'customer.cart',
            compact(
                'items',
                'total'
            )
        );
    }


    /**
     * =========================================================
     * 5. HIỂN THỊ TRANG THANH TOÁN
     * =========================================================
     */
    public function checkout(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Vui lòng đăng nhập để tiếp tục thanh toán.'
                );
        }

        /*
         * Ưu tiên Buy Now.
         * Nếu không có Buy Now thì lấy Cart.
         */
        $items = session()->get(
            'buy_now',
            []
        );

        if (empty($items)) {
            $items = session()->get(
                'cart',
                []
            );
        }

        if (empty($items)) {
            return redirect()
                ->route('customer.home')
                ->with(
                    'error',
                    'Chưa có sản phẩm nào để thanh toán.'
                );
        }

        $khachHang = $this->getCurrentKhachHang();


        /*
         * =====================================================
         * LẤY ĐỊA CHỈ
         * =====================================================
         */
        $addresses = DiaChi::query()
            ->where(
                'maKH',
                $khachHang->maKH
            )
            ->orderByDesc('isDefault')
            ->get();


        /*
         * =====================================================
         * LẤY PHƯƠNG THỨC THANH TOÁN
         * =====================================================
         */
        $paymentMethods = PhuongThucThanhToan::query()
            ->where(
                'trangThai',
                true
            )
            ->get()
            ->filter(function ($paymentMethod) {

                $name = mb_strtolower(
                    trim(
                        $paymentMethod->tenPhuongThuc
                    )
                );

                return
                    str_contains(
                        $name,
                        'cod'
                    )
                    ||
                    str_contains(
                        $name,
                        'nhận hàng'
                    )
                    ||
                    str_contains(
                        $name,
                        'vnpay'
                    )
                    ||
                    str_contains(
                        $name,
                        'ví điện tử'
                    );
            })
            ->values();


        /*
         * =====================================================
         * TÍNH TIỀN
         * =====================================================
         */
        $items = array_values($items);

        $total = collect($items)->sum(function ($item) {

            return
                (float) $item['giaBan']
                *
                (int) $item['soLuong'];
        });

        $shippingFee = 30000;

        $grandTotal =
            $total
            +
            $shippingFee;


        /*
         * =====================================================
         * KIỂM TRA CÓ CẦN TỰ ĐỘNG MỞ POPUP VNPAY KHÔNG
         * =====================================================
         */
        $openVnpayPopup = session()->pull(
            'open_vnpay_popup',
            false
        );

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
                'openVnpayPopup'
            )
        );
    }


    /**
     * =========================================================
     * 6. XỬ LÝ ĐẶT HÀNG
     *
     * COD:
     *      Tạo đơn ngay.
     *
     * VNPay:
     *      Nếu popup đã thanh toán thành công:
     *          vnpay_paid = 1
     *          → tạo đơn ngay.
     *
     *      Nếu chưa:
     *          lưu pending_vnpay
     *          → quay lại checkout
     *          → mở popup.
     * =========================================================
     */
    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Vui lòng đăng nhập để đặt hàng.'
                );
        }

        $request->validate([
            'maDiaChi' => [
                'required',
                'integer',
                'exists:dia_chis,maDiaChi'
            ],

            'maPTTT' => [
                'required',
                'integer',
                'exists:phuong_thuc_thanh_toans,maPTTT'
            ],

            'vnpay_paid' => [
                'nullable',
                'boolean'
            ],
        ]);

        $khachHang =
            $this->getCurrentKhachHang();


        /*
         * =====================================================
         * KIỂM TRA ĐỊA CHỈ
         * =====================================================
         */
        $diaChi =
            DiaChi::query()
                ->where(
                    'maDiaChi',
                    $request->maDiaChi
                )
                ->where(
                    'maKH',
                    $khachHang->maKH
                )
                ->first();

        if (!$diaChi) {
            return back()
                ->with(
                    'error',
                    'Địa chỉ giao hàng không hợp lệ.'
                );
        }


        /*
         * =====================================================
         * KIỂM TRA PHƯƠNG THỨC THANH TOÁN
         * =====================================================
         */
        $paymentMethod =
            PhuongThucThanhToan::query()
                ->where(
                    'maPTTT',
                    $request->maPTTT
                )
                ->where(
                    'trangThai',
                    true
                )
                ->first();

        if (!$paymentMethod) {
            return back()
                ->with(
                    'error',
                    'Phương thức thanh toán không hợp lệ.'
                );
        }


        /*
         * =====================================================
         * XÁC ĐỊNH COD / VNPAY
         * =====================================================
         */
        $paymentName =
            mb_strtolower(
                trim(
                    $paymentMethod->tenPhuongThuc
                )
            );

        $isVnpay =
            str_contains(
                $paymentName,
                'vnpay'
            );

        $isCod =
            str_contains(
                $paymentName,
                'cod'
            )
            ||
            str_contains(
                $paymentName,
                'nhận hàng'
            );


        if (!$isVnpay && !$isCod) {
            return back()
                ->with(
                    'error',
                    'Phương thức thanh toán không được hỗ trợ.'
                );
        }


        /*
         * =====================================================
         * LẤY SẢN PHẨM
         * =====================================================
         */
        $buyNow =
            session()->get(
                'buy_now',
                []
            );

        if (!empty($buyNow)) {

            $items =
                array_values(
                    $buyNow
                );

            $isBuyNow = true;

        } else {

            $cart =
                session()->get(
                    'cart',
                    []
                );

            if (empty($cart)) {

                return redirect()
                    ->route(
                        'customer.home'
                    )
                    ->with(
                        'error',
                        'Không có sản phẩm nào để đặt hàng.'
                    );
            }

            $items =
                array_values(
                    $cart
                );

            $isBuyNow = false;
        }


        /*
         * =====================================================
         * VNPAY
         * =====================================================
         */
        if ($isVnpay) {

            /*
             * -------------------------------------------------
             * TRƯỜNG HỢP 1:
             * POPUP VNPAY ĐÃ THANH TOÁN THÀNH CÔNG
             *
             * vnpay_paid = 1
             *
             * Không cần pending_vnpay.
             * Tạo đơn trực tiếp.
             * -------------------------------------------------
             */
            if ($request->boolean('vnpay_paid')) {

                try {

                    $donHang =
                        $this->createOrder(
                            $khachHang,
                            $diaChi,
                            $paymentMethod,
                            $items
                        );


                    /*
                     * Xóa sản phẩm sau khi đặt hàng
                     */
                    if ($isBuyNow) {

                        session()->forget(
                            'buy_now'
                        );

                    } else {

                        session()->forget(
                            'cart'
                        );
                    }


                    /*
                     * Xóa các session VNPay cũ
                     */
                    session()->forget(
                        'pending_vnpay'
                    );

                    session()->forget(
                        'open_vnpay_popup'
                    );


                    /*
                     * Sang trang thành công
                     */
                    return redirect()
                        ->route(
                            'customer.order.success',
                            $donHang->maDH
                        )
                        ->with(
                            'success',
                            'Thanh toán VNPay thành công. Đặt hàng thành công!'
                        );

                } catch (\Exception $e) {

                    return back()
                        ->withInput()
                        ->with(
                            'error',
                            $e->getMessage()
                        );
                }
            }


            /*
             * -------------------------------------------------
             * TRƯỜNG HỢP 2:
             * CHƯA THANH TOÁN
             *
             * Lưu giao dịch tạm thời.
             * Sau đó quay lại checkout.
             * -------------------------------------------------
             */

            foreach ($items as $item) {

                $sach = Sach::with('tonKho')
                    ->find($item['maSach']);

                if (!$sach) {

                    return back()
                        ->with(
                            'error',
                            'Sách không tồn tại.'
                        );
                }

                $soLuongTon = (int) (
                    $sach->tonKho->soLuongTon ?? 0
                );

                if ($soLuongTon <= 0) {

                    return back()
                        ->with(
                            'error',
                            "Sách '{$sach->tenSach}' đã hết hàng."
                        );
                }

                if (
                    (int) $item['soLuong']
                    >
                    $soLuongTon
                ) {

                    return back()
                        ->with(
                            'error',
                            "Sách '{$sach->tenSach}' chỉ còn {$soLuongTon} quyển."
                        );
                }
            }


            /*
             * Tính tiền
             */
            $total = collect($items)->sum(
                function ($item) {

                    return
                        (float) $item['giaBan']
                        *
                        (int) $item['soLuong'];
                }
            );

            $shippingFee = 30000;

            $grandTotal =
                $total
                +
                $shippingFee;


            /*
             * Lưu giao dịch VNPay
             */
            session()->put(
                'pending_vnpay',
                [
                    'maKH' =>
                        $khachHang->maKH,

                    'maDiaChi' =>
                        $diaChi->maDiaChi,

                    'maPTTT' =>
                        $paymentMethod->maPTTT,

                    'items' =>
                        $items,

                    'isBuyNow' =>
                        $isBuyNow,

                    'total' =>
                        $total,

                    'shippingFee' =>
                        $shippingFee,

                    'grandTotal' =>
                        $grandTotal,
                ]
            );


            /*
             * Bật popup
             */
            session()->put(
                'open_vnpay_popup',
                true
            );


            /*
             * Quay lại checkout
             */
            return redirect()
                ->route(
                    'customer.checkout'
                );
        }


        /*
         * =====================================================
         * COD
         * =====================================================
         */
        try {

            $donHang =
                $this->createOrder(
                    $khachHang,
                    $diaChi,
                    $paymentMethod,
                    $items
                );


            /*
             * Xóa sản phẩm sau khi đặt thành công
             */
            if ($isBuyNow) {

                session()->forget(
                    'buy_now'
                );

            } else {

                session()->forget(
                    'cart'
                );
            }


            return redirect()
                ->route(
                    'customer.order.success',
                    $donHang->maDH
                )
                ->with(
                    'success',
                    'Đặt hàng thành công.'
                );

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }


    /**
     * =========================================================
     * 7. TẠO ĐƠN HÀNG
     * =========================================================
     */
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


                /*
                 * =================================================
                 * KIỂM TRA TỒN KHO
                 * =================================================
                 */
                foreach ($items as $item) {

                    $sach =
                        Sach::find(
                            $item['maSach']
                        );

                    if (!$sach) {

                        throw new \Exception(
                            'Sách không tồn tại.'
                        );
                    }


                    /*
                     * Khóa dòng tồn kho
                     */
                    $tonKho =
                        $sach->tonKho()
                            ->lockForUpdate()
                            ->first();

                    if (!$tonKho) {

                        throw new \Exception(
                            "Sách '{$sach->tenSach}' chưa có thông tin tồn kho."
                        );
                    }


                    $soLuongDat =
                        (int) $item['soLuong'];

                    $soLuongTon =
                        (int) $tonKho->soLuongTon;


                    /*
                     * Hết hàng
                     */
                    if ($soLuongTon <= 0) {

                        throw new \Exception(
                            "Sách '{$sach->tenSach}' đã hết hàng."
                        );
                    }


                    /*
                     * Không đủ hàng
                     */
                    if (
                        $soLuongDat
                        >
                        $soLuongTon
                    ) {

                        throw new \Exception(
                            "Sách '{$sach->tenSach}' chỉ còn {$soLuongTon} quyển."
                        );
                    }


                    /*
                     * Giá hiện tại
                     */
                    $donGia =
                        (float) $sach->giaBan;


                    $thanhTien =
                        $donGia
                        *
                        $soLuongDat;


                    $tongTienSach +=
                        $thanhTien;


                    $chiTiet[] = [
                        'sach' =>
                            $sach,

                        'tonKho' =>
                            $tonKho,

                        'soLuong' =>
                            $soLuongDat,

                        'donGia' =>
                            $donGia,

                        'thanhTien' =>
                            $thanhTien,
                    ];
                }


                /*
                 * =================================================
                 * PHÍ VẬN CHUYỂN
                 * =================================================
                 */
                $shippingFee = 30000;


                $tongCong =
                    $tongTienSach
                    +
                    $shippingFee;


                /*
                 * =================================================
                 * TẠO ĐƠN HÀNG
                 * =================================================
                 */
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


                /*
                 * =================================================
                 * TẠO CHI TIẾT + TRỪ KHO
                 * =================================================
                 */
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


                    /*
                     * Trừ tồn kho
                     */
                    $item['tonKho']->decrement(
                        'soLuongTon',
                        $item['soLuong']
                    );
                }


                return $donHang;
            }
        );
    }


    /**
     * =========================================================
     * 8. XỬ LÝ KẾT QUẢ THANH TOÁN VNPAY
     *
     * Luồng cũ vẫn được giữ lại để tránh lỗi nếu hệ thống
     * đang có route gọi tới hàm này.
     * =========================================================
     */
    public function vnpayPaymentResult(
        Request $request
    ) {
        if (!Auth::check()) {

            return redirect()
                ->route('login');
        }


        $request->validate([
            'result' => [
                'required',
                'in:success,failed'
            ],
        ]);


        /*
         * Nếu thanh toán thất bại
         */
        if (
            $request->result
            ===
            'failed'
        ) {

            session()->forget(
                'pending_vnpay'
            );

            session()->forget(
                'open_vnpay_popup'
            );

            return redirect()
                ->route(
                    'customer.checkout'
                )
                ->with(
                    'error',
                    'Thanh toán VNPay thất bại.'
                );
        }


        /*
         * Lấy giao dịch VNPay đang chờ
         */
        $pending =
            session()->get(
                'pending_vnpay'
            );


        /*
         * Không có giao dịch
         */
        if (!$pending) {

            /*
             * Không cố tạo đơn ở đây.
             *
             * Luồng chính hiện tại phải đi qua:
             *
             * popup
             *    ↓
             * vnpay_paid = 1
             *    ↓
             * placeOrder()
             *
             * Vì vậy nếu route cũ gọi vào đây mà không có
             * pending_vnpay thì quay về checkout.
             */
            return redirect()
                ->route(
                    'customer.checkout'
                )
                ->with(
                    'error',
                    'Giao dịch VNPay không tồn tại hoặc đã hết hạn. Vui lòng thực hiện thanh toán lại.'
                );
        }


        /*
         * =====================================================
         * THANH TOÁN THÀNH CÔNG
         * =====================================================
         */
        try {

            $khachHang =
                $this->getCurrentKhachHang();


            /*
             * Kiểm tra đúng khách hàng
             */
            if (
                $pending['maKH']
                !=
                $khachHang->maKH
            ) {

                throw new \Exception(
                    'Giao dịch không hợp lệ.'
                );
            }


            /*
             * Lấy địa chỉ
             */
            $diaChi =
                DiaChi::query()
                    ->where(
                        'maDiaChi',
                        $pending['maDiaChi']
                    )
                    ->where(
                        'maKH',
                        $khachHang->maKH
                    )
                    ->first();

            if (!$diaChi) {

                throw new \Exception(
                    'Địa chỉ giao hàng không tồn tại.'
                );
            }


            /*
             * Lấy phương thức thanh toán
             */
            $paymentMethod =
                PhuongThucThanhToan::query()
                    ->where(
                        'maPTTT',
                        $pending['maPTTT']
                    )
                    ->where(
                        'trangThai',
                        true
                    )
                    ->first();

            if (!$paymentMethod) {

                throw new \Exception(
                    'Phương thức thanh toán không tồn tại.'
                );
            }


            /*
             * Kiểm tra VNPay
             */
            $paymentName =
                mb_strtolower(
                    trim(
                        $paymentMethod->tenPhuongThuc
                    )
                );

            if (
                !str_contains(
                    $paymentName,
                    'vnpay'
                )
            ) {

                throw new \Exception(
                    'Phương thức thanh toán không hợp lệ.'
                );
            }


            /*
             * Tạo đơn hàng
             */
            $donHang =
                $this->createOrder(
                    $khachHang,
                    $diaChi,
                    $paymentMethod,
                    $pending['items']
                );


            /*
             * Xóa sản phẩm
             */
            if (
                !empty(
                    $pending['isBuyNow']
                )
            ) {

                session()->forget(
                    'buy_now'
                );

            } else {

                session()->forget(
                    'cart'
                );
            }


            /*
             * Xóa giao dịch
             */
            session()->forget(
                'pending_vnpay'
            );

            session()->forget(
                'open_vnpay_popup'
            );


            /*
             * Sang trang thành công
             */
            return redirect()
                ->route(
                    'customer.order.success',
                    $donHang->maDH
                )
                ->with(
                    'success',
                    'Thanh toán VNPay thành công. Đặt hàng thành công!'
                );


        } catch (\Exception $e) {

            session()->forget(
                'pending_vnpay'
            );

            session()->forget(
                'open_vnpay_popup'
            );

            return redirect()
                ->route(
                    'customer.checkout'
                )
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }


    /**
     * =========================================================
     * 9. TRANG ĐẶT HÀNG THÀNH CÔNG
     * =========================================================
     */
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


    /**
     * =========================================================
     * 10. THÊM ĐỊA CHỈ
     * =========================================================
     */
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


        /*
         * Nếu người dùng chọn mặc định
         * hoặc chưa có địa chỉ nào
         */
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


        /*
         * Bỏ mặc định của địa chỉ cũ
         */
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


        /*
         * Tạo địa chỉ
         */
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


    /**
     * =========================================================
     * 11. LẤY KHÁCH HÀNG HIỆN TẠI
     *
     * users
     *    ↓
     * khach_hangs.user_id
     * =========================================================
     */
    private function getCurrentKhachHang(): KhachHang
    {
        $user = Auth::user();


        $khachHang =
            KhachHang::where(
                'user_id',
                $user->id
            )->first();


        /*
         * Nếu chưa có bản ghi khách hàng
         * thì tự tạo.
         */
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