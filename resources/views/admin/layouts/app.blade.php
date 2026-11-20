
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin WhimsyBooth')</title>
@stack('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: #f8f5f2;
            color: #39332f;
        }

        .sidebar {
            width: 240px;
            flex-shrink: 0;
            background: #fff;
            padding: 30px 20px;
            border-right: 1px solid #eee5df;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 40px;
            color: #8d6e63;
        }

        .brand img {
            width: 45px;
            height: 45px;
            object-fit: contain;
        }

        .sidebar a {
            display: block;
            padding: 13px 15px;
            margin-bottom: 10px;
            text-decoration: none;
            color: #6b625d;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background: #f4eafa;
            color: #9472ad;
            transform: translateX(4px);
        }

        .sidebar a.active {
            background: #eee3f5;
            color: #88649f;
            font-weight: bold;
        }

        .main {
            flex: 1;
            min-width: 0;
            padding: 35px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .header h1 {
            font-size: 28px;
            color: #765b83;
        }

        .header p {
            color: #8b817b;
            margin-top: 8px;
        }

        .profile {
            background: white;
            padding: 12px 18px;
            border-radius: 12px;
            color: #765b83;
            border: 1px solid #eee3f5;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 16px;
            border: 1px solid #eee5df;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(160, 125, 180, 0.12);
            border-color: #e6d5ef;
        }

        .stat-card p {
            color: #8b817b;
            margin-bottom: 15px;
        }

        .stat-card h2 {
            font-size: 30px;
            color: #765b83;
        }

        .content {
            margin-top: 30px;
            padding: 30px;
            background: white;
            border-radius: 16px;
            border: 1px solid #eee5df;
            transition: all 0.3s ease;
        }

        .content:hover {
            box-shadow: 0 8px 20px rgba(160, 125, 180, 0.10);
        }

        .content h2 {
            color: #765b83;
        }

        .content p {
            margin-top: 12px;
            color: #8b817b;
        }

        @media (max-width: 700px) {
            .sidebar {
                width: 170px;
                padding: 20px 10px;
            }

            .main {
                padding: 20px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .header {
                gap: 15px;
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>

    @include('admin.partials.sidebar')

    <main class="main">

        @include('admin.partials.header')

        @yield('content')

</main>

@stack('scripts')
