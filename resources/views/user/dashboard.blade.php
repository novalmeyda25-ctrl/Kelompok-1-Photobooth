<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whimsybooth - Photo Booth Web</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-[#FBF9F5] min-h-screen text-[#2C241D]">

    <!-- Navbar -->
    <nav class="bg-white border-b border-[#F4EFE6] px-8 py-4 flex justify-between items-center shadow-sm">
        <a href="{{ route('home') }}" class="font-bold text-lg text-[#D9777F]">Whimsybooth</a>

        <!-- Pojok Kanan Atas -->
        <div class="flex items-center gap-4">
            @guest
                <a href="{{ route('login') }}" class="px-5 py-2 rounded-xl border border-[#EBE3D5] text-sm font-semibold hover:bg-[#FAF8F5] transition">
                    Log in
                </a>
            @else
                <span class="text-xs font-medium text-[#7A6B5D]">Halo, <b>{{ auth()->user()->name }}</b></span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 rounded-xl text-xs font-semibold hover:bg-red-100 transition">
                        Logout
                    </button>
                </form>
            @endguest
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="max-w-3xl mx-auto text-center py-24 px-4 space-y-4">
        <h1 class="text-3xl font-bold">Photo Booth Web - Online Camera & Photo Strip Maker</h1>
        <p class="text-sm text-[#7A6B5D]">
            Abadikan momen seru dengan filter dan bingkai menarik. Silakan login untuk mulai mengunduh hasil fotomu.
        </p>
    </main>

</body>
</html>