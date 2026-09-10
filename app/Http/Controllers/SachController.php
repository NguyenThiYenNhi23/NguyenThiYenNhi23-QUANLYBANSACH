<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSachRequest;
use App\Models\DanhMuc;
use App\Models\Sach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SachController extends Controller
{
    /**
     * Hiển thị danh sách sách
     * Có chức năng tìm kiếm
     */
    public function index(Request $request)
    {
        $keyword = trim((string) $request->input('keyword', ''));
        $maDanhMuc = $request->input('maDanhMuc');
        $status = $request->input('trangThai');
        $sort = $request->input('sort', 'maSach_desc');

        $query = Sach::with('danhMuc')
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('tenSach', 'like', '%' . $keyword . '%')
                        ->orWhere('maSach', 'like', '%' . $keyword . '%');
                });
            })
            ->when($maDanhMuc, function ($query, $maDanhMuc) {
                $query->where('maDanhMuc', $maDanhMuc);
            })
            ->when($status, function ($query, $status) {
                $query->where('trangThai', $status);
            });

        switch ($sort) {
            case 'tenSach_asc':
                $query->orderBy('tenSach', 'asc');
                break;
            case 'giaBan_asc':
                $query->orderBy('giaBan', 'asc');
                break;
            case 'giaBan_desc':
                $query->orderBy('giaBan', 'desc');
                break;
            default:
                $query->orderBy('maSach', 'desc');
                break;
        }

        $sachs = $query->paginate(10)->withQueryString();
        $danhMucs = DanhMuc::orderBy('tenDanhMuc')->get();

        $stats = [
            'total' => Sach::count(),
            'active' => Sach::where('trangThai', 'Đang kinh doanh')->count(),
            'out_of_stock' => Sach::where('trangThai', 'Hết hàng')->count(),
            'inactive' => Sach::where('trangThai', 'Ngừng kinh doanh')->count(),
        ];

        return view('sach.index', compact(
            'sachs',
            'keyword',
            'maDanhMuc',
            'status',
            'sort',
            'danhMucs',
            'stats'
        ));
    }


    /**
     * Hiển thị form thêm sách
     */
    public function create()
    {
        $danhMucs = DanhMuc::all();

        return view('sach.create', compact('danhMucs'));
    }


    /**
     * Lưu sách mới
     */
    public function store(SaveSachRequest $request)
    {
        $data = $request->validated();
        unset($data['hinhAnh']);

        if ($request->hasFile('hinhAnh')) {
            $data['hinhAnh'] = $request->file('hinhAnh')->store('books', 'public');
        }

        Sach::create($data);

        return redirect()
            ->route('sach.index')
            ->with('success', 'Thêm sách thành công.');
    }


    /**
     * Hiển thị chi tiết sách
     */
    public function show($maSach)
    {
        $sach = Sach::with('danhMuc')
            ->findOrFail($maSach);

        return view('sach.show', compact('sach'));
    }


    /**
     * Hiển thị form sửa
     */
    public function edit($maSach)
    {
        $sach = Sach::findOrFail($maSach);

        $danhMucs = DanhMuc::all();

        return view('sach.edit', compact(
            'sach',
            'danhMucs'
        ));
    }


    /**
     * Cập nhật thông tin sách
     */
    public function update(
        SaveSachRequest $request,
        $maSach
    ) {
        $sach = Sach::findOrFail($maSach);

        $data = $request->validated();
        unset($data['hinhAnh']);

        if ($request->hasFile('hinhAnh')) {
            if ($sach->hinhAnh && Storage::disk('public')->exists($sach->hinhAnh)) {
                Storage::disk('public')->delete($sach->hinhAnh);
            }

            $data['hinhAnh'] = $request->file('hinhAnh')->store('books', 'public');
        }

        $sach->update($data);

        return redirect()
            ->route('sach.index')
            ->with('success', 'Cập nhật sách thành công.');
    }


    /**
     * Cập nhật trạng thái sách
     */
    public function updateStatus(
        Request $request,
        $maSach
    ) {
        $sach = Sach::with('tonKho')->findOrFail($maSach);

        $request->validate([
            'trangThai' => [
                'required',
                'in:Đang kinh doanh,Hết hàng,Ngừng kinh doanh',
            ],
        ]);

        $trangThai = $request->trangThai;
        $soLuongTon = (int) optional($sach->tonKho)->soLuongTon;

        if ($trangThai === 'Đang kinh doanh' && $soLuongTon === 0) {
            return back()->withErrors([
                'trangThai' => 'Không thể chuyển sang "Đang kinh doanh" khi số lượng tồn bằng 0.',
            ]);
        }

        $sach->update([
            'trangThai' => $trangThai
        ]);

        return redirect()
            ->route('sach.index')
            ->with(
                'success',
                'Cập nhật trạng thái thành công.'
            );
    }


    /**
     * Xóa sách
     */
    public function destroy($maSach)
    {
        $sach = Sach::with([
            'chiTietDonHangs',
            'chiTietGioHangs',
            'chiTietPhieuNhaps',
            'tonKho',
        ])->findOrFail($maSach);

        $hasRelatedData = $sach->chiTietDonHangs()->exists()
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
            if ($sach->hinhAnh && Storage::disk('public')->exists($sach->hinhAnh)) {
                Storage::disk('public')->delete($sach->hinhAnh);
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