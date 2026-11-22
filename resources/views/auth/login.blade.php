<!--<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Whimsybooth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-[#FBF9F5] min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-lg border border-[#F4EFE6] p-8 space-y-6">
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-bold text-[#2C241D]">Masuk ke Akun</h1>
            <p class="text-xs text-[#7A6B5D]">Masukkan email dan password untuk melanjutkan</p>
        </div>

        {{-- Error Alert --}}
        <!__@if ($errors->any()) -->
            <!--<div class="p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl space-y-1">
                <!__@foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
               <!-- @endforeach
            </div>
        @endif

        <!-- Form Login Universal (Admin & User) -->
       <!-- <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <!--<label class="block text-xs font-semibold text-[#5A4D41] mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                       class="w-full px-4 py-3 rounded-xl border border-[#EBE3D5] text-sm focus:outline-none focus:border-[#D9777F] bg-[#FAF8F5]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#5A4D41] mb-1">Password</label>
                <input type="password" name="password" required placeholder="••••••••"
                       class="w-full px-4 py-3 rounded-xl border border-[#EBE3D5] text-sm focus:outline-none focus:border-[#D9777F] bg-[#FAF8F5]">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="rounded border-[#EBE3D5] text-[#D9777F]">
                <label for="remember" class="text-xs text-[#7A6B5D]">Ingat Saya</label>
            </div>

            <button type="submit" 
                    class="w-full py-3.5 bg-[#D9777F] text-white font-semibold rounded-xl text-sm shadow-md hover:opacity-95 transition">
                Masuk
            </button>
        </form>

        <div class="text-center text-xs text-[#7A6B5D]">
            <p>Belum punya akun? <a href="{{ route('register') }}" class="text-[#D9777F] font-semibold hover:underline">Daftar di sini</a></p>
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="text-xs text-[#7A6B5D] hover:underline">&larr; Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>