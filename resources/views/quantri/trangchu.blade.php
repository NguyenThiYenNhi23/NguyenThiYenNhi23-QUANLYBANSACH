@extends('quantri.layouts.quantri_layout')

@section('title', 'Trang chủ quản trị')

@section('header-title', 'Trang chủ')

@section('content')

    <div class="welcome">

        <h1>
            Xin chào, {{ auth()->user()->name }}
        </h1>

        <p>
            Chào mừng bạn đến với hệ thống quản lý bán sách.
        </p>

    </div>

@endsection