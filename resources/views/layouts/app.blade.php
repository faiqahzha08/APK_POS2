<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 12px 24px -8px rgb(0 0 0 / 0.1); }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-8">
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-md shadow-indigo-200">
                            <i data-lucide="shopping-bag" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="font-bold text-lg tracking-tight text-slate-900">POS</span>
                    </a>

                    <div class="hidden md:flex items-center gap-1">
                        <a href="{{ url('/dashboard') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition
                           {{ request()->is('dashboard') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-100' }}">
                            Dashboard
                        </a>
                        <a href="{{ url('/user') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition
                           {{ request()->is('user*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-100' }}">
                            User
                        </a>
                        <a href="{{ url('/produk') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition
                           {{ request()->is('produk*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-100' }}">
                            Produk
                        </a>
                        <a href="{{ url('/penjualan') }}"
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition
                           {{ request()->is('penjualan*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-100' }}">
                            Penjualan
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 text-sm text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full">
                        <i data-lucide="user-circle" class="w-4 h-4"></i>
                        <span class="font-medium">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition shadow-sm shadow-red-200">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm">
                <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-xs text-slate-400">
        © {{ date('Y') }} POS System
    </footer>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>