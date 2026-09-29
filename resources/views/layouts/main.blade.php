<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="PLN DIGI - Layanan listrik digital. Bayar tagihan, beli token, dan simulasi pasang listrik baru.">

    <title>@yield('title', 'PLN DIGI - Layanan Listrik Digital')</title>

    <!-- Google Fonts (Plus Jakarta Sans, Montserrat, Rubik, Lato, Merriweather, Oswald) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,400&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,400&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Oswald:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Local Fonts Fallback Definition -->
    <style>
        @font-face {
            font-family: 'Montserrat';
            src: url('/fonts/Montserrat/Montserrat-VariableFont_wght.ttf') format('truetype');
            font-weight: 100 900;
            font-display: swap;
        }
        @font-face {
            font-family: 'Rubik';
            src: url('/fonts/Rubik/Rubik-VariableFont_wght.ttf') format('truetype');
            font-weight: 300 900;
            font-display: swap;
        }
        @font-face {
            font-family: 'Oswald';
            src: url('/fonts/Oswald/Oswald-VariableFont_wght.ttf') format('truetype');
            font-weight: 200 700;
            font-display: swap;
        }
        @font-face {
            font-family: 'Lato';
            src: url('/fonts/Lato/Lato-Regular.ttf') format('truetype');
            font-weight: 400;
            font-display: swap;
        }
        @font-face {
            font-family: 'Merriweather';
            src: url('/fonts/Merriweather/Merriweather-Regular.ttf') format('truetype');
            font-weight: 400;
            font-display: swap;
        }
    </style>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-50">
    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-success" class="fixed top-20 right-4 z-50 bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slide-in">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-2 hover:opacity-70"><i class="fas fa-times"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div id="flash-error" class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slide-in">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-2 hover:opacity-70"><i class="fas fa-times"></i></button>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    {{-- Floating Font Switcher for Team Evaluation --}}
    @include('components.font-switcher')

    @stack('scripts')
    <script>
        // Auto-dismiss flash messages
        setTimeout(() => {
            document.querySelectorAll('#flash-success, #flash-error').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateX(100%)';
                setTimeout(() => el.remove(), 300);
            });
        }, 4000);
    </script>
</body>
</html>
