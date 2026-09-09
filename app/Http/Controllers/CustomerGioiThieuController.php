<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CustomerGioiThieuController extends Controller
{
    public function index(): View
    {
        return view('customer.gioithieu');
    }
}