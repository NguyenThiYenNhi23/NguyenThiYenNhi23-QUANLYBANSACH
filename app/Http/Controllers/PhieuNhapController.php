<?php

namespace App\Http\Controllers;

use App\Models\PhieuNhap;
use App\Models\CTPhieuNhap;
use App\Models\Sach;
use App\Models\TonKho;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PhieuNhapController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DANH SÁCH PHIẾU NHẬP
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = PhieuNhap::with([
            'nhanVien',
            'chiTiet'
        ]);

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                if (is_numeric($search)) {
                    $q->where('maPN', $search);
                }

                $q->orWhereHas('nhanVien', function ($nv) use ($search) {
                    $nv->where(
                        'hoTen',
                        'like',
                        '%' . $search . '%'
                    );
                });
            });
        }

        /*
         * Sắp xếp mã phiếu tăng dần
         */
        $phieuNhaps = $query
            ->orderBy('maPN', 'asc')
            ->get();

        return view(
            'quantri.phieunhap.index',
            compact('phieuNhaps')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM LẬP PHIẾU
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $sachs = Sach::orderBy(
            'maSach',
            'asc'
        )->get();

        return view(
            'quantri.phieunhap.create',
            compact('sachs')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LẤY NHÂN VIÊN ĐANG ĐĂNG NHẬP
    |--------------------------------------------------------------------------
    */
    private function getNhanVienDangNhap()
    {
        $user = Auth::user();

        if (!$user) {
            return null;
        }

        /*
         * Admin không bắt buộc phải có mã nhân viên.
         */
        if (
            strtolower(trim($user->role ?? '')) === 'admin'
        ) {
            return null;
        }

        return NhanVien::where(
            'user_id',
            $user->id
        )->first();
    }


    /*
    |--------------------------------------------------------------------------
    | KIỂM TRA ADMIN
    |--------------------------------------------------------------------------
    */
    private function laAdmin()
    {
        $user = Auth::user();

        return $user
            && strtolower(trim($user->role ?? '')) === 'admin';
    }


    /*
    |--------------------------------------------------------------------------
    | LẬP PHIẾU
    |--------------------------------------------------------------------------
    |
    | Phiếu mới:
    | - Chưa xác nhận
    | - Chưa cộng tồn kho
    | - Giá bán lấy tự động từ bảng sachs
    |
    */
    public function store(Request $request)
    {
        /*
         * KHÔNG validate giaBan.
         *
         * Người dùng không nhập giá bán.
         * Giá bán được lấy trực tiếp từ bảng sachs.
         */
        $request->validate(
            [
                'ngayNhap' => [
                    'required',
                    'date'
                ],

                'maSach' => [
                    'required',
                    'array',
                    'min:1'
                ],

                'maSach.*' => [
                    'required',
                    'integer',
                    'exists:sachs,maSach'
                ],

                'soLuong' => [
                    'required',
                    'array',
                    'min:1'
                ],

                'soLuong.*' => [
                    'required',
                    'integer',
                    'min:1'
                ],

                'donGia' => [
                    'required',
                    'array',
                    'min:1'
                ],

                'donGia.*' => [
                    'required',
                    'numeric',
                    'gt:0'
                ],
            ],
            [
                'ngayNhap.required' =>
                    'Vui lòng chọn ngày nhập.',

                'ngayNhap.date' =>
                    'Ngày nhập không hợp lệ.',

                'maSach.required' =>
                    'Vui lòng chọn ít nhất một sách.',

                'maSach.min' =>
                    'Vui lòng chọn ít nhất một sách.',

                'maSach.*.required' =>
                    'Vui lòng chọn sách.',

                'maSach.*.exists' =>
                    'Sách không tồn tại.',

                'soLuong.required' =>
                    'Vui lòng nhập số lượng.',

                'soLuong.min' =>
                    'Vui lòng nhập số lượng.',

                'soLuong.*.required' =>
                    'Vui lòng nhập số lượng.',

                'soLuong.*.integer' =>
                    'Số lượng phải là số nguyên.',

                'soLuong.*.min' =>
                    'Số lượng phải lớn hơn 0.',

                'donGia.required' =>
                    'Vui lòng nhập giá nhập.',

                'donGia.min' =>
                    'Vui lòng nhập giá nhập.',

                'donGia.*.required' =>
                    'Vui lòng nhập giá nhập.',

                'donGia.*.numeric' =>
                    'Giá nhập phải là số.',

                'donGia.*.gt' =>
                    'Giá nhập phải lớn hơn 0.',
            ]
        );


        $maSach = $request->maSach;
        $soLuong = $request->soLuong;
        $donGia = $request->donGia;


        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA SỐ DÒNG
        |--------------------------------------------------------------------------
        */
        if (
            count($maSach) !== count($soLuong) ||
            count($maSach) !== count($donGia)
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Dữ liệu chi tiết phiếu nhập không hợp lệ.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA TRÙNG SÁCH
        |--------------------------------------------------------------------------
        */
        $daCo = [];

        foreach ($maSach as $i => $idSach) {

            if (isset($daCo[$idSach])) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'maSach.' . $i =>
                            'Sách này đã được chọn trong phiếu.'
                    ])
                    ->with(
                        'error',
                        'Không được nhập trùng sách trong cùng một phiếu.'
                    );
            }

            $daCo[$idSach] = true;
        }


        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA GIÁ
        |--------------------------------------------------------------------------
        |
        | Giá bán lấy từ bảng sachs.
        |
        */
        foreach ($maSach as $i => $idSach) {

            $sach = Sach::find($idSach);

            if (!$sach) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Sách không tồn tại.'
                    );
            }


            /*
             * Lấy giá bán hiện tại từ bảng sachs
             */
            $giaBan = (float) $sach->giaBan;


            /*
             * Nếu sách chưa có giá bán
             */
            if ($giaBan <= 0) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Sách "' . $sach->tenSach . '" chưa có giá bán.'
                    );
            }


            /*
             * Giá nhập phải nhỏ hơn giá bán
             */
            if (
                (float) $donGia[$i] >= $giaBan
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'donGia.' . $i =>
                            'Giá nhập phải < giá bán.'
                    ])
                    ->with(
                        'error',
                        'Giá nhập phải < giá bán.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | BẮT ĐẦU TRANSACTION
        |--------------------------------------------------------------------------
        */
        DB::beginTransaction();

        try {

            $nhanVien = $this->getNhanVienDangNhap();


            /*
            |--------------------------------------------------------------------------
            | TẠO PHIẾU
            |--------------------------------------------------------------------------
            |
            | Phiếu mới luôn ở trạng thái Chưa xác nhận.
            |
            */
            $phieuNhap = PhieuNhap::create([
                'maNV' =>
                    $nhanVien?->maNV,

                'ngayNhap' =>
                    $request->ngayNhap,

                'tongTien' =>
                    0,

                'trangThai' =>
                    'ChoXacNhan',
            ]);


            $tongTien = 0;


            /*
            |--------------------------------------------------------------------------
            | LƯU CHI TIẾT PHIẾU
            |--------------------------------------------------------------------------
            */
            foreach (
                $maSach as $i => $idSach
            ) {

                /*
                 * Lấy lại sách từ database
                 */
                $sach = Sach::find($idSach);

                if (!$sach) {
                    throw new \Exception(
                        'Sách không tồn tại.'
                    );
                }


                /*
                 * Giá bán tự động lấy từ bảng sachs
                 */
                $giaBan = (float) $sach->giaBan;


                if ($giaBan <= 0) {
                    throw new \Exception(
                        'Sách "' . $sach->tenSach . '" chưa có giá bán.'
                    );
                }


                /*
                 * Kiểm tra lại giá nhập
                 */
                if (
                    (float) $donGia[$i] >= $giaBan
                ) {
                    throw new \Exception(
                        'Giá nhập phải < giá bán.'
                    );
                }


                $thanhTien =
                    (float) $soLuong[$i]
                    *
                    (float) $donGia[$i];


                CTPhieuNhap::create([
                    'maPN' =>
                        $phieuNhap->maPN,

                    'maSach' =>
                        $idSach,

                    'soLuong' =>
                        $soLuong[$i],

                    'donGia' =>
                        $donGia[$i],

                    /*
                     * Không lấy giá bán từ form.
                     */
                    'giaBan' =>
                        $giaBan,

                    'thanhTien' =>
                        $thanhTien,
                ]);


                $tongTien += $thanhTien;
            }


            /*
            |--------------------------------------------------------------------------
            | CẬP NHẬT TỔNG TIỀN
            |--------------------------------------------------------------------------
            */
            $phieuNhap->tongTien = $tongTien;

            $phieuNhap->save();


            /*
            |--------------------------------------------------------------------------
            | KHÔNG CẬP NHẬT TỒN KHO
            |--------------------------------------------------------------------------
            |
            | Tồn kho chỉ tăng khi Admin xác nhận phiếu.
            |
            */


            DB::commit();


            return redirect()
                ->route('phieunhap.index')
                ->with(
                    'success',
                    'Lập phiếu nhập thành công. Phiếu đang ở trạng thái chưa xác nhận.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Không thể lưu phiếu nhập: ' .
                    $e->getMessage()
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | XEM CHI TIẾT
    |--------------------------------------------------------------------------
    */
    public function show($maPN)
    {
        $phieuNhap =
            PhieuNhap::with([
                'nhanVien',
                'chiTiet.sach'
            ])->findOrFail($maPN);


        return view(
            'quantri.phieunhap.show',
            compact('phieuNhap')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM SỬA
    |--------------------------------------------------------------------------
    */
    public function edit($maPN)
    {
        $phieuNhap =
            PhieuNhap::with('chiTiet')
                ->findOrFail($maPN);


        /*
         * Phiếu hoàn thành không được sửa
         */
        if (
            $phieuNhap->trangThai === 'HoanThanh'
        ) {

            return redirect()
                ->route('phieunhap.index')
                ->with(
                    'error',
                    'Phiếu đã hoàn thành, không thể sửa.'
                );
        }


        /*
         * Phiếu đã hủy không được sửa
         */
        if (
            $phieuNhap->trangThai === 'DaHuy'
        ) {

            return redirect()
                ->route('phieunhap.index')
                ->with(
                    'error',
                    'Phiếu đã hủy, không thể sửa.'
                );
        }


        /*
         * Chỉ phiếu chưa xác nhận mới được sửa
         */
        if (
            $phieuNhap->trangThai !== 'ChoXacNhan'
        ) {

            return redirect()
                ->route('phieunhap.index')
                ->with(
                    'error',
                    'Phiếu nhập không ở trạng thái có thể sửa.'
                );
        }


        $sachs =
            Sach::orderBy(
                'maSach',
                'asc'
            )->get();


        return view(
            'quantri.phieunhap.edit',
            compact(
                'phieuNhap',
                'sachs'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CẬP NHẬT PHIẾU
    |--------------------------------------------------------------------------
    |
    | Chỉ sửa phiếu Chưa xác nhận.
    | Không cập nhật tồn kho.
    |
    */
    public function update(
        Request $request,
        $maPN
    ) {

        $phieuNhap =
            PhieuNhap::with('chiTiet')
                ->findOrFail($maPN);


        /*
         * Không cho sửa phiếu hoàn thành
         */
        if (
            $phieuNhap->trangThai === 'HoanThanh'
        ) {

            return redirect()
                ->route('phieunhap.index')
                ->with(
                    'error',
                    'Phiếu đã hoàn thành, không thể sửa.'
                );
        }


        /*
         * Không cho sửa phiếu đã hủy
         */
        if (
            $phieuNhap->trangThai === 'DaHuy'
        ) {

            return redirect()
                ->route('phieunhap.index')
                ->with(
                    'error',
                    'Phiếu đã hủy, không thể sửa.'
                );
        }


        /*
         * Chỉ phiếu chưa xác nhận mới được sửa
         */
        if (
            $phieuNhap->trangThai !== 'ChoXacNhan'
        ) {

            return redirect()
                ->route('phieunhap.index')
                ->with(
                    'error',
                    'Phiếu nhập không ở trạng thái có thể sửa.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATE
        |--------------------------------------------------------------------------
        |
        | KHÔNG validate giaBan.
        |
        */
        $request->validate(
            [
                'ngayNhap' => [
                    'required',
                    'date'
                ],

                'maSach' => [
                    'required',
                    'array',
                    'min:1'
                ],

                'maSach.*' => [
                    'required',
                    'integer',
                    'exists:sachs,maSach'
                ],

                'soLuong' => [
                    'required',
                    'array',
                    'min:1'
                ],

                'soLuong.*' => [
                    'required',
                    'integer',
                    'min:1'
                ],

                'donGia' => [
                    'required',
                    'array',
                    'min:1'
                ],

                'donGia.*' => [
                    'required',
                    'numeric',
                    'gt:0'
                ],
            ],
            [
                'ngayNhap.required' =>
                    'Vui lòng chọn ngày nhập.',

                'ngayNhap.date' =>
                    'Ngày nhập không hợp lệ.',

                'maSach.required' =>
                    'Vui lòng chọn ít nhất một sách.',

                'maSach.min' =>
                    'Vui lòng chọn ít nhất một sách.',

                'maSach.*.required' =>
                    'Vui lòng chọn sách.',

                'maSach.*.exists' =>
                    'Sách không tồn tại.',

                'soLuong.required' =>
                    'Vui lòng nhập số lượng.',

                'soLuong.min' =>
                    'Vui lòng nhập số lượng.',

                'soLuong.*.required' =>
                    'Vui lòng nhập số lượng.',

                'soLuong.*.integer' =>
                    'Số lượng phải là số nguyên.',

                'soLuong.*.min' =>
                    'Số lượng phải lớn hơn 0.',

                'donGia.required' =>
                    'Vui lòng nhập giá nhập.',

                'donGia.min' =>
                    'Vui lòng nhập giá nhập.',

                'donGia.*.required' =>
                    'Vui lòng nhập giá nhập.',

                'donGia.*.numeric' =>
                    'Giá nhập phải là số.',

                'donGia.*.gt' =>
                    'Giá nhập phải lớn hơn 0.',
            ]
        );


        $maSach = $request->maSach;
        $soLuong = $request->soLuong;
        $donGia = $request->donGia;


        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA SỐ DÒNG
        |--------------------------------------------------------------------------
        */
        if (
            count($maSach) !== count($soLuong) ||
            count($maSach) !== count($donGia)
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Dữ liệu chi tiết phiếu nhập không hợp lệ.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA TRÙNG SÁCH
        |--------------------------------------------------------------------------
        */
        $daCo = [];

        foreach ($maSach as $i => $idSach) {

            if (isset($daCo[$idSach])) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'maSach.' . $i =>
                            'Sách này đã được chọn trong phiếu.'
                    ])
                    ->with(
                        'error',
                        'Không được nhập trùng sách trong cùng một phiếu.'
                    );
            }

            $daCo[$idSach] = true;
        }


        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA GIÁ
        |--------------------------------------------------------------------------
        |
        | Giá bán lấy trực tiếp từ bảng sachs.
        |
        */
        foreach ($maSach as $i => $idSach) {

            $sach = Sach::find($idSach);

            if (!$sach) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Sách không tồn tại.'
                    );
            }


            /*
             * Giá bán hiện tại của sách
             */
            $giaBan = (float) $sach->giaBan;


            /*
             * Sách chưa có giá bán
             */
            if ($giaBan <= 0) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Sách "' . $sach->tenSach . '" chưa có giá bán.'
                    );
            }


            /*
             * Giá nhập phải nhỏ hơn giá bán
             */
            if (
                (float) $donGia[$i] >= $giaBan
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'donGia.' . $i =>
                            'Giá nhập phải < giá bán.'
                    ])
                    ->with(
                        'error',
                        'Giá nhập phải < giá bán.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */
        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | XÓA CHI TIẾT CŨ
            |--------------------------------------------------------------------------
            |
            | Phiếu chưa xác nhận nên chưa ảnh hưởng tồn kho.
            |
            */
            CTPhieuNhap::where(
                'maPN',
                $phieuNhap->maPN
            )->delete();


            $tongTien = 0;


            /*
            |--------------------------------------------------------------------------
            | LƯU CHI TIẾT MỚI
            |--------------------------------------------------------------------------
            */
            foreach (
                $maSach as $i => $idSach
            ) {

                $sach = Sach::find($idSach);

                if (!$sach) {
                    throw new \Exception(
                        'Sách không tồn tại.'
                    );
                }


                /*
                 * Lấy giá bán từ bảng sachs
                 */
                $giaBan = (float) $sach->giaBan;


                if ($giaBan <= 0) {
                    throw new \Exception(
                        'Sách "' . $sach->tenSach . '" chưa có giá bán.'
                    );
                }


                if (
                    (float) $donGia[$i] >= $giaBan
                ) {
                    throw new \Exception(
                        'Giá nhập phải < giá bán.'
                    );
                }


                $thanhTien =
                    (float) $soLuong[$i]
                    *
                    (float) $donGia[$i];


                CTPhieuNhap::create([
                    'maPN' =>
                        $phieuNhap->maPN,

                    'maSach' =>
                        $idSach,

                    'soLuong' =>
                        $soLuong[$i],

                    'donGia' =>
                        $donGia[$i],

                    /*
                     * Giá bán lấy từ bảng sách.
                     */
                    'giaBan' =>
                        $giaBan,

                    'thanhTien' =>
                        $thanhTien,
                ]);


                $tongTien += $thanhTien;
            }


            /*
            |--------------------------------------------------------------------------
            | CẬP NHẬT PHIẾU
            |--------------------------------------------------------------------------
            */
            $phieuNhap->ngayNhap =
                $request->ngayNhap;

            $phieuNhap->tongTien =
                $tongTien;

            /*
             * Vẫn là Chưa xác nhận.
             */
            $phieuNhap->trangThai =
                'ChoXacNhan';

            $phieuNhap->save();


            /*
            |--------------------------------------------------------------------------
            | KHÔNG CẬP NHẬT TỒN KHO
            |--------------------------------------------------------------------------
            */


            DB::commit();


            return redirect()
                ->route(
                    'phieunhap.show',
                    $phieuNhap->maPN
                )
                ->with(
                    'success',
                    'Cập nhật phiếu nhập thành công.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Không thể cập nhật phiếu nhập: ' .
                    $e->getMessage()
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | XÓA PHIẾU
    |--------------------------------------------------------------------------
    |
    | Không cho xóa trực tiếp.
    | Dùng Hủy phiếu.
    |
    */
    public function destroy($maPN)
    {
        return redirect()
            ->route('phieunhap.index')
            ->with(
                'error',
                'Không thể xóa phiếu nhập. Hãy sử dụng chức năng hủy phiếu.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | XÁC NHẬN PHIẾU
    |--------------------------------------------------------------------------
    |
    | Chỉ Admin/QTV được xác nhận.
    | Khi xác nhận mới cộng tồn kho.
    |
    */
    public function confirm($maPN)
    {
        /*
         * Kiểm tra quyền Admin
         */
        if (!$this->laAdmin()) {

            return back()->with(
                'error',
                'Chỉ Quản trị viên mới có quyền xác nhận phiếu nhập.'
            );
        }


        $phieuNhap =
            PhieuNhap::with('chiTiet')
                ->findOrFail($maPN);


        /*
         * Không xác nhận phiếu đã hủy
         */
        if (
            $phieuNhap->trangThai === 'DaHuy'
        ) {

            return back()->with(
                'error',
                'Phiếu đã hủy, không thể xác nhận.'
            );
        }


        /*
         * Không xác nhận lại phiếu đã hoàn thành
         */
        if (
            $phieuNhap->trangThai === 'HoanThanh'
        ) {

            return back()->with(
                'error',
                'Phiếu nhập đã hoàn thành.'
            );
        }


        /*
         * Chỉ xác nhận phiếu Chưa xác nhận
         */
        if (
            $phieuNhap->trangThai !== 'ChoXacNhan'
        ) {

            return back()->with(
                'error',
                'Phiếu nhập không ở trạng thái chưa xác nhận.'
            );
        }


        /*
         * Phải có chi tiết
         */
        if (
            $phieuNhap->chiTiet->isEmpty()
        ) {

            return back()->with(
                'error',
                'Phiếu nhập không có chi tiết.'
            );
        }


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | CỘNG TỒN KHO
            |--------------------------------------------------------------------------
            */
            foreach (
                $phieuNhap->chiTiet as $chiTiet
            ) {

                $tonKho =
                    TonKho::firstOrCreate(
                        [
                            'maSach' =>
                                $chiTiet->maSach
                        ],
                        [
                            'soLuongTon' =>
                                0
                        ]
                    );


                /*
                 * Cộng số lượng nhập vào tồn kho
                 */
                $tonKho->soLuongTon +=
                    (int) $chiTiet->soLuong;


                /*
                 * Nếu bảng ton_khos có cột ngayCapNhat
                 * thì cập nhật thời gian.
                 */
                if (
                    isset($tonKho->ngayCapNhat)
                    || array_key_exists(
                        'ngayCapNhat',
                        $tonKho->getAttributes()
                    )
                ) {
                    $tonKho->ngayCapNhat = now();
                }


                $tonKho->save();
            }


            /*
            |--------------------------------------------------------------------------
            | CHUYỂN TRẠNG THÁI
            |--------------------------------------------------------------------------
            */
            $phieuNhap->trangThai =
                'HoanThanh';

            $phieuNhap->save();


            DB::commit();


            return back()->with(
                'success',
                'Xác nhận phiếu nhập thành công. Số lượng sách đã được cập nhật vào kho.'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Không thể xác nhận phiếu nhập: ' .
                $e->getMessage()
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | HỦY PHIẾU
    |--------------------------------------------------------------------------
    |
    | Chỉ hủy phiếu Chưa xác nhận.
    |
    | Vì phiếu Chưa xác nhận chưa cộng tồn kho
    | nên khi hủy KHÔNG trừ tồn kho.
    |
    */
    public function cancel($maPN)
    {
        $phieuNhap =
            PhieuNhap::with('chiTiet')
                ->findOrFail($maPN);


        /*
         * Phiếu hoàn thành không được hủy
         */
        if (
            $phieuNhap->trangThai === 'HoanThanh'
        ) {

            return back()->with(
                'error',
                'Phiếu đã hoàn thành, không thể hủy.'
            );
        }


        /*
         * Phiếu đã hủy
         */
        if (
            $phieuNhap->trangThai === 'DaHuy'
        ) {

            return back()->with(
                'error',
                'Phiếu nhập đã được hủy.'
            );
        }


        /*
         * Chỉ phiếu Chưa xác nhận mới được hủy
         */
        if (
            $phieuNhap->trangThai !== 'ChoXacNhan'
        ) {

            return back()->with(
                'error',
                'Phiếu nhập không ở trạng thái có thể hủy.'
            );
        }


        /*
         * Phiếu phải có chi tiết
         */
        if (
            $phieuNhap->chiTiet->isEmpty()
        ) {

            return back()->with(
                'error',
                'Phiếu nhập không có chi tiết.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA SÁCH ĐÃ PHÁT SINH ĐƠN HÀNG
        |--------------------------------------------------------------------------
        */
        $maSachTrongPhieu =
            $phieuNhap->chiTiet
                ->pluck('maSach')
                ->unique()
                ->values()
                ->toArray();


        $daPhatSinhDon =
            DB::table('ct_don_hangs')
                ->whereIn(
                    'maSach',
                    $maSachTrongPhieu
                )
                ->exists();


        if ($daPhatSinhDon) {

            return back()->with(
                'error',
                'Không thể hủy phiếu nhập vì sách trong phiếu đã phát sinh đơn hàng.'
            );
        }


        DB::beginTransaction();

        try {

            /*
             * Không trừ tồn kho.
             */
            $phieuNhap->trangThai =
                'DaHuy';

            $phieuNhap->save();


            DB::commit();


            return back()->with(
                'success',
                'Hủy phiếu nhập thành công.'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Không thể hủy phiếu nhập: ' .
                $e->getMessage()
            );
        }
    }
}