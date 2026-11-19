<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Whimsybooth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-900 min-h-screen p-8 text-white">

    <div class="max-w-3xl mx-auto bg-slate-800 rounded-3xl p-8 flex justify-between items-center border border-slate-700 shadow-lg">
        <div>
            <span class="text-xs bg-purple-500/20 text-purple-300 px-3 py-1 rounded-full font-semibold">⚡ ADMIN PANEL</span>
            <h1 class="text-xl font-bold mt-3">Halo, Admin {{ auth()->user()->name }}</h1>
            <p class="text-xs text-slate-400 mt-1">Halaman kontrol pengelola sistem Whimsybooth.</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-500/20 text-red-300 rounded-xl text-xs font-semibold hover:bg-red-500/30 transition">
                Logout
            </button>
        </form>
    </div>

</body>
</html>