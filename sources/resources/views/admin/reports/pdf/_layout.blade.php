<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Laporan BookStore' }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111827;
            margin: 24px;
        }

        h1 {
            font-size: 20px;
            margin: 0 0 4px;
        }

        h2 {
            font-size: 14px;
            margin: 0 0 8px;
        }

        p {
            margin: 0;
        }

        .header {
            border-bottom: 2px solid #111827;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .brand {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .muted {
            color: #6b7280;
        }

        .summary {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }

        .summary td {
            border: 1px solid #d1d5db;
            padding: 8px;
        }

        .summary .label {
            color: #6b7280;
            font-size: 10px;
        }

        .summary .value {
            font-size: 14px;
            font-weight: bold;
            margin-top: 2px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th,
        table.data td {
            border: 1px solid #d1d5db;
            padding: 6px;
            vertical-align: top;
        }

        table.data th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            background-color: #e5e7eb;
        }

        .footer {
            margin-top: 18px;
            font-size: 10px;
            color: #6b7280;
            text-align: right;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
