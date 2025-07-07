<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ManagerOne CRM</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#f5f7fa] to-[#c3cfe2] text-[#1b1b18] p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white/90 rounded-lg shadow-2xl px-8 py-10 flex flex-col items-center animate-fade-in">
            <div class="flex flex-col items-center mb-6">
                <div class="bg-gradient-to-tr from-black to-gray p-4 rounded-full shadow-lg mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 32 32" stroke-width="1.5" stroke="currentColor" class="w-14 h-14 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6.115 5.19.319 1.913A6 6 0 0 0 8.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 0 0 2.288-4.042 1.087 1.087 0 0 0-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 0 1-.98-.314l-.295-.295a1.125 1.125 0 0 1 0-1.591l.13-.132a1.125 1.125 0 0 1 1.3-.21l.603.302a.809.809 0 0 0 1.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 0 0 1.528-1.732l.146-.292M6.115 5.19A9 9 0 1 0 17.18 4.64M6.115 5.19A8.965 8.965 0 0 1 12 3c1.929 0 3.716.607 5.18 1.64" />
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-[#1b1b18] mb-2">ManagerOne</h1>
                <p class="text-base  font-semibold uppercase tracking-wider">CRM Professionale</p>
            </div>
            <p class="text-center text-lg text-[#444] mb-6">La soluzione completa per gestire clienti, progetti e team in modo semplice, veloce e sicuro.</p>
            @if (Route::has('login'))
                <nav class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full mt-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="w-full sm:w-auto px-6 py-2 bg-gradient-to-r from-[#6366f1] to-[#38bdf8] text-white font-semibold rounded-lg shadow hover:scale-105 transition-transform text-center">
                            Vai alla Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="w-full sm:w-auto px-6 py-2 bg-[#f1f5f9] text-[#1b1b18] border border-[#6366f1]/30 font-semibold rounded-lg shadow hover:bg-[#e0e7ef] transition-colors text-center">
                            Accedi
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="w-full sm:w-auto px-6 py-2 bg-black text-white font-semibold rounded-lg shadow hover:scale-105 transition-transform text-center">
                                Registrati
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
        <div class="text-center text-xs text-[#888] mt-8">
            &copy; {{ date('Y') }} ManagerOne. Tutti i diritti riservati.
        </div>
    </div>
    <style>
        .animate-fade-in {
            animation: fadeIn 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>

</html>
