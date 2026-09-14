<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class QuanLyDonHangController extends Controller
{
    private const STATUSES = [
        'ChoXacNhan',
        'DangXuLy',
        'DangGiao',
        'DaGiao',
        'HoanThanh',
        'DaHuy',
    ];

    private const STATUS_LABELS = [
        'ChoXacNhan' => 'Chờ xác nhận',
        'DangXuLy' => 'Đang xử lý',
        'DangGiao' => 'Đang giao',
        'DaGiao' => 'Đã giao',
        'HoanThanh' => 'Hoàn thành',
        'DaHuy' => 'Đã hủy',
    ];

    private const ALLOWED_TRANSITIONS = [
        'ChoXacNhan' => ['DangXuLy', 'DaHuy'],
        'DangXuLy' => ['DangGiao', 'DaHuy'],
        'DangGiao' => ['DaGiao'],
        'DaGiao' => ['HoanThanh'],
        'HoanThanh' => [],
        'DaHuy' => [],
    ];

    public function index(Request $request): View
    {
        $keyword = trim((string) $request->input('keyword', ''));
        $status = $request->input('trangThai');

        if (! in_array($status, self::STATUSES, true)) {
            $status = null;
        }

        $donHangs = DonHang::query()
            ->with('khachHang')
            ->when($keyword !== '', function ($query) use ($keyword): void {
                $query->where(function ($query) use ($keyword): void {
                    $query->where('maDH', $keyword)
                        ->orWhereHas('khachHang', function ($query) use ($keyword): void {
                            $query->where('hoTen', 'like', "%{$keyword}%")
                                ->orWhere('email', 'like', "%{$keyword}%")
                                ->orWhere('sdt', 'like', "%{$keyword}%");
                        });
                });
            })
            ->when($status !== null, fn ($query) => $query->where('trangThai', $status))
            ->orderByDesc('ngayDat')
            ->paginate(10)
            ->withQueryString();

        return view('quantri.ql_donhang.index', [
            'donHangs' => $donHangs,
            'keyword' => $keyword,
            'status' => $status,
            'statuses' => self::STATUS_LABELS,
        ]);
    }

    public function show(DonHang $donHang): View
    {
        $donHang->load([
            'khachHang',
            'diaChi',
            'phuongThucThanhToan',
            'chiTietDonHangs.sach',
        ]);

        return view('quantri.ql_donhang.show', [
            'donHang' => $donHang,
            'statuses' => self::STATUS_LABELS,
            'allowedStatuses' => self::ALLOWED_TRANSITIONS[$donHang->trangThai] ?? [],
        ]);
    }

    public function updateStatus(Request $request, DonHang $donHang): RedirectResponse
    {
        $validated = $request->validate([
            'trangThai' => ['required', Rule::in(self::STATUSES)],
        ], [
            'trangThai.required' => 'Vui lòng chọn trạng thái đơn hàng.',
            'trangThai.in' => 'Trạng thái đơn hàng không hợp lệ.',
        ]);

        $newStatus = $validated['trangThai'];
        $allowedStatuses = self::ALLOWED_TRANSITIONS[$donHang->trangThai] ?? [];

        if (! in_array($newStatus, $allowedStatuses, true)) {
            return back()->with('error', 'Đơn hàng không thể cập nhật sang trạng thái đã chọn.');
        }

        DB::transaction(function () use ($donHang, $newStatus): void {
            $donHang->update(['trangThai' => $newStatus]);
        });

        return redirect()
            ->route('quantri.donhang.show', $donHang)
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}