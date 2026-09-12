<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSachRequest;
use App\Models\DanhMuc;
use App\Models\Sach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SachController extends Controller
{

    public function index(Request $request)
    {
        $keyword = trim((string) $request->input('keyword', ''));
        $maDanhMuc = $request->input('maDanhMuc');
        $status = $request->input('trangThai');
        $sort = $request->input('sort', 'maSach_desc');



        if (!in_array($status, [
            'Đang kinh doanh',
            'Ngừng kinh doanh'
        ])) {
            $status = null;
        }


        $query = Sach::with('danhMuc')
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where(
                        'tenSach',
                        'like',
                        '%' . $keyword . '%'
                    )
                    ->orWhere(
                        'maSach',
                        'like',
                        '%' . $keyword . '%'
                    );
                });
            })
            ->when($maDanhMuc, function ($query, $maDanhMuc) {
                $query->where(
                    'maDanhMuc',
                    $maDanhMuc
                );
            })
            ->when($status, function ($query, $status) {
                $query->where(
                    'trangThai',
                    $status
                );
            });

        switch ($sort) {

            case 'tenSach_asc':
                $query->orderBy(
                    'tenSach',
                    'asc'
                );
                break;

            case 'giaBan_asc':
                $query->orderBy(
                    'giaBan',
                    'asc'
                );
                break;

            case 'giaBan_desc':
                $query->orderBy(
                    'giaBan',
                    'desc'
                );
                break;

            default:
                $query->orderBy(
                    'maSach',
                    'desc'
                );
                break;
        }


        $sachs = $query
            ->paginate(10)
            ->withQueryString();


        $danhMucs = DanhMuc::orderBy(
            'tenDanhMuc'
        )->get();


        $stats = [

            // Tổng số sách
            'total' => Sach::count(),

            // Sách đang kinh doanh
            'active' => Sach::where(
                'trangThai',
                'Đang kinh doanh'
            )->count(),

            // Sách hết hàng
            'out_of_stock' => Sach::whereHas(
                'tonKho',
                function ($query) {
                    $query->where(
                        'soLuongTon',
                        '<=',
                        0
                    );
                }
            )->count(),

            // Sách ngừng kinh doanh
            'inactive' => Sach::where(
                'trangThai',
                'Ngừng kinh doanh'
            )->count(),
        ];

        return view(
            'sach.index',
            compact(
                'sachs',
                'keyword',
                'maDanhMuc',
                'status',
                'sort',
                'danhMucs',
                'stats'
            )
        );
    }


    public function create()
    {
        $danhMucs = DanhMuc::all();

        return view(
            'sach.create',
            compact('danhMucs')
        );
    }


    public function store(SaveSachRequest $request)
    {
        $data = $request->validated();


        unset($data['hinhAnh']);

        if ($request->hasFile('hinhAnh')) {

            $data['hinhAnh'] = $request
                ->file('hinhAnh')
                ->store(
                    'books',
                    'public'
                );
        }

        if (!isset($data['trangThai'])) {

            $data['trangThai'] =
                'Đang kinh doanh';
        }


        if (!in_array(
            $data['trangThai'],
            [
                'Đang kinh doanh',
                'Ngừng kinh doanh'
            ]
        )) {

            $data['trangThai'] =
                'Đang kinh doanh';
        }

        Sach::create($data);

        return redirect()
            ->route('sach.index')
            ->with(
                'success',
                'Thêm sách thành công.'
            );
    }


    /**
     * Hiển thị chi tiết sách
     */
    public function show($maSach)
    {


        $sach = Sach::with('danhMuc')
            ->findOrFail($maSach);

        return view(
            'sach.show',
            compact('sach')
        );
    }

    public function edit($maSach)
    {
        $sach = Sach::findOrFail($maSach);

        $danhMucs = DanhMuc::all();

        return view(
            'sach.edit',
            compact(
                'sach',
                'danhMucs'
            )
        );
    }

    public function update(
        SaveSachRequest $request,
        $maSach
    ) {
        $sach = Sach::findOrFail($maSach);

        $data = $request->validated();



        unset($data['hinhAnh']);


        if (isset($data['trangThai'])) {

            if (!in_array(
                $data['trangThai'],
                [
                    'Đang kinh doanh',
                    'Ngừng kinh doanh'
                ]
            )) {

                unset($data['trangThai']);
            }
        }

        if ($request->hasFile('hinhAnh')) {

            if (
                $sach->hinhAnh &&
                Storage::disk('public')->exists(
                    $sach->hinhAnh
                )
            ) {

                Storage::disk('public')->delete(
                    $sach->hinhAnh
                );
            }


            $data['hinhAnh'] = $request
                ->file('hinhAnh')
                ->store(
                    'books',
                    'public'
                );
        }


        $sach->update($data);

        return redirect()
            ->route('sach.index')
            ->with(
                'success',
                'Cập nhật sách thành công.'
            );
    }


    public function updateStatus(
        Request $request,
        $maSach
    ) {
        $sach = Sach::findOrFail($maSach);

        $request->validate([
            'trangThai' => [
                'required',
                'in:Đang kinh doanh,Ngừng kinh doanh'
            ],
        ]);

        $sach->update([
            'trangThai' => $request->trangThai
        ]);

        return redirect()
            ->route('sach.index')
            ->with(
                'success',
                'Cập nhật trạng thái sách thành công.'
            );
    }

    public function destroy($maSach)
    {
        $sach = Sach::with([
            'chiTietDonHangs',
            'chiTietGioHangs',
            'chiTietPhieuNhaps',
            'tonKho',
        ])->findOrFail($maSach);

        $hasRelatedData =
            $sach->chiTietDonHangs()->exists()
            || $sach->chiTietGioHangs()->exists()
            || $sach->chiTietPhieuNhaps()->exists()
            || $sach->tonKho()->exists();

        if ($hasRelatedData) {

            return redirect()
                ->route('sach.index')
                ->with(
                    'error',
                    'Không thể xóa sách vì sách đã phát sinh dữ liệu liên quan.'
                );
        }

        try {


            if (
                $sach->hinhAnh &&
                Storage::disk('public')->exists(
                    $sach->hinhAnh
                )
            ) {

                Storage::disk('public')->delete(
                    $sach->hinhAnh
                );
            }

            $sach->delete();

            return redirect()
                ->route('sach.index')
                ->with(
                    'success',
                    'Xóa sách thành công.'
                );

        } catch (\Exception $e) {

            return redirect()
                ->route('sach.index')
                ->with(
                    'error',
                    'Không thể xóa sách vì sách đã phát sinh dữ liệu liên quan.'
                );
        }
    }
}