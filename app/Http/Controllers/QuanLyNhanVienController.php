<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class QuanLyNhanVienController extends Controller
{
public function index(Request $request)
{
    $keyword = trim($request->input('keyword', ''));

    $nhanViens = NhanVien::with('user')
        ->whereHas('user', function ($query) {
            $query->where('role', 'employee');
        })
        ->when($keyword !== '', function ($query) use ($keyword) {

            $query->where(function ($q) use ($keyword) {

                // Họ tên
                $q->where('hoTen', 'like', '%' . $keyword . '%')

                    // Email
                    ->orWhere('email', 'like', '%' . $keyword . '%')

                    // Số điện thoại
                    ->orWhere('sdt', 'like', '%' . $keyword . '%')

                    // Địa chỉ
                    ->orWhere('diaChi', 'like', '%' . $keyword . '%');

                // Trạng thái
                $keywordLower = mb_strtolower($keyword);

                if (
                    str_contains($keywordLower, 'hoạt động') ||
                    str_contains($keywordLower, 'hoat dong')
                ) {
                    $q->orWhereHas('user', function ($userQuery) {
                        $userQuery->where('trang_thai', true);
                    });
                }

                if (
                    str_contains($keywordLower, 'khóa') ||
                    str_contains($keywordLower, 'khoa')
                ) {
                    $q->orWhereHas('user', function ($userQuery) {
                        $userQuery->where('trang_thai', false);
                    });
                }
            });
        })
        ->orderBy('maNV', 'desc')
        ->paginate(10)
        ->withQueryString();

    return view(
        'quantri.ql_nhanvien.nv_index',
        compact('nhanViens', 'keyword')
    );
}

    // HIỂN THỊ FORM THÊM NHÂN VIÊN
    public function create()
    {
        return view('quantri.ql_nhanvien.nv_create');
    }

    // LƯU NHÂN VIÊN MỚI
    public function store(Request $request)
    {
        $request->validate([
            'hoTen' => [
                'required',
                'string',
                'max:100',
                'regex:/.*\S.*/u',
            ],

            'sdt' => [
                'required',
                'digits_between:10,11',
                'regex:/^0[0-9]{9,10}$/',
                'unique:users,phone',
            ],

            'email' => [
                'required',
                'email:rfc',
                'max:100',
                'unique:users,email',
            ],

            'diaChi' => [
                'nullable',
                'string',
                'max:255',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'max:100',
                'confirmed',
            ],
        ], [
            'hoTen.required' => 'Vui lòng nhập họ tên.',
            'hoTen.max' => 'Họ tên không được vượt quá 100 ký tự.',
            'hoTen.regex' => 'Họ tên không được để trống.',

            'sdt.required' => 'Vui lòng nhập số điện thoại.',
            'sdt.digits_between' => 'Số điện thoại phải có từ 10 đến 11 chữ số.',
            'sdt.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và chỉ được chứa chữ số.',
            'sdt.unique' => 'Số điện thoại đã được sử dụng. Vui lòng nhập số khác.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá 100 ký tự.',
            'email.unique' => 'Email đã được sử dụng. Vui lòng nhập email khác.',

            'diaChi.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 100 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        DB::transaction(function () use ($request) {

            // Tạo tài khoản đăng nhập
            $user = new User();

            $user->name = trim($request->hoTen);
            $user->email = strtolower(trim($request->email));
            $user->phone = trim($request->sdt);

            // Phải mã hóa mật khẩu
            $user->password = Hash::make($request->password);

            $user->role = 'employee';
            $user->trang_thai = true;

            $user->save();

            // Tạo thông tin nhân viên
            NhanVien::create([
                'user_id' => $user->id,
                'hoTen' => trim($request->hoTen),
                'sdt' => trim($request->sdt),
                'email' => strtolower(trim($request->email)),
                'diaChi' => $request->diaChi
                    ? trim($request->diaChi)
                    : null,
            ]);
        });

        return redirect()
            ->route('quantri.nhanvien.index')
            ->with('success', 'Thêm nhân viên thành công!');
    }
    // HIỂN THỊ FORM SỬA NHÂN VIÊN
    public function edit(NhanVien $nhanVien)
    {
        $nhanVien->load('user');

        return view(
            'quantri.ql_nhanvien.nv_edit',
            compact('nhanVien')
        );
    }
    // CẬP NHẬT NHÂN VIÊN
    public function update(Request $request, NhanVien $nhanVien)
    {
        $nhanVien->load('user');

        if (!$nhanVien->user) {
            return redirect()
                ->route('quantri.nhanvien.index')
                ->with('error', 'Không tìm thấy tài khoản nhân viên.');
        }

        $request->validate([
            'hoTen' => [
                'required',
                'string',
                'max:100',
                'regex:/.*\S.*/u',
            ],

            'sdt' => [
                'required',
                'digits_between:10,11',
                'regex:/^0[0-9]{9,10}$/',
                Rule::unique('users', 'phone')
                    ->ignore($nhanVien->user_id),
            ],

            'email' => [
                'required',
                'email:rfc',
                'max:100',
                Rule::unique('users', 'email')
                    ->ignore($nhanVien->user_id),
            ],

            'diaChi' => [
                'nullable',
                'string',
                'max:255',
            ],
        ], [
            'hoTen.required' => 'Vui lòng nhập họ tên.',
            'hoTen.max' => 'Họ tên không được vượt quá 100 ký tự.',
            'hoTen.regex' => 'Họ tên không được để trống.',

            'sdt.required' => 'Vui lòng nhập số điện thoại.',
            'sdt.digits_between' => 'Số điện thoại phải có từ 10 đến 11 chữ số.',
            'sdt.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và chỉ được chứa chữ số.',
            'sdt.unique' => 'Số điện thoại đã được sử dụng. Vui lòng nhập số khác.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá 100 ký tự.',
            'email.unique' => 'Email đã được sử dụng. Vui lòng nhập email khác.',

            'diaChi.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        ]);

        DB::transaction(function () use ($request, $nhanVien) {

            // Cập nhật tài khoản users
            $nhanVien->user->name = trim($request->hoTen);
            $nhanVien->user->email = strtolower(trim($request->email));
            $nhanVien->user->phone = trim($request->sdt);

            $nhanVien->user->save();

            // Cập nhật thông tin nhân viên
            $nhanVien->update([
                'hoTen' => trim($request->hoTen),
                'sdt' => trim($request->sdt),
                'email' => strtolower(trim($request->email)),
                'diaChi' => $request->diaChi
                    ? trim($request->diaChi)
                    : null,
            ]);
        });

        return redirect()
            ->route('quantri.nhanvien.index')
            ->with('success', 'Cập nhật nhân viên thành công!');
    }


  public function toggleStatus(NhanVien $nhanVien)
{
    $nhanVien->load('user');

    if (!$nhanVien->user) {
        return back()->with(
            'error',
            'Không tìm thấy tài khoản nhân viên.'
        );
    }

    // Nếu đang hoạt động → khóa
    if ($nhanVien->user->trang_thai) {

        $nhanVien->user->trang_thai = false;
        $nhanVien->user->save();

        return back()->with(
            'success',
            'Đã khóa tài khoản nhân viên.'
        );
    }

    // Nếu đang bị khóa → mở khóa
    $nhanVien->user->trang_thai = true;
    $nhanVien->user->save();

    return back()->with(
        'success',
        'Đã mở khóa tài khoản nhân viên.'
    );
}
}