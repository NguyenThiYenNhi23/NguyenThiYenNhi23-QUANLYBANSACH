<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Danh mục')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 48px 20px;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f6fb;
            color: #333;
        }

        .form-page {
            width: 100%;
            max-width: 720px;
            margin: 0 auto;
        }

        .page-title {
            margin: 0 0 24px;
            font-size: 28px;
            color: #222;
        }

        .form-card {
            padding: 30px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #aaa;
            border-radius: 7px;
            font: inherit;
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .form-control:focus {
            border-color: #5751b8;
            outline: none;
        }

        .form-error {
            margin-top: 7px;
            color: #d32f2f;
            font-size: 14px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn-primary,
        .btn-secondary {
            padding: 11px 18px;
            border: 0;
            border-radius: 7px;
            font: inherit;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: #5751b8;
            color: #fff;
        }

        .btn-secondary {
            background: #e5e5e5;
            color: #333;
        }
    </style>
</head>
<body>
    <main class="form-page">
        @yield('content')
    </main>
</body>
</html>
