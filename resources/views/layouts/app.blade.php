<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Spaceur' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased">
    <div class="min-h-screen">
        <header class="border-b border-neutral-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-xl border border-neutral-200 bg-white">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-full w-full object-contain">
                    </div>

                    <div>
                        <h1 class="text-base font-semibold tracking-tight text-neutral-900">Spaceur Cashier</h1>
                        <p class="text-xs text-neutral-500">Gesture POS System</p>
                    </div>
                </div>

                <nav class="flex items-center gap-2">
                    <a href="{{ route('home') }}"
                       class="rounded-lg px-4 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-100">
                        Home
                    </a>
                    <a href="{{ route('cashier.gesture-login') }}"
                       class="rounded-lg px-4 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-100">
                        Kasir
                    </a>
                    <a href="{{ route('admin.products.index') }}"
                       class="rounded-lg px-4 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-100">
                        Admin
                    </a>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-6 py-8">
            @yield('content')
        </main>
    </div>
</body>
</html>