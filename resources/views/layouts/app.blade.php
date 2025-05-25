<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BersihQ Laundry')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Additional Plugins -->
    @stack('plugins')
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .bg-gradient-custom {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }

        .bg-gradient-custom-light {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
        }

        /* Custom scrollbar untuk sidebar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        /* Memperbaiki tampilan input */
        input:focus,
        select:focus,
        textarea:focus {
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.2) !important;
        }

        input,
        select,
        textarea {
            outline: none !important;
        }

        /* Menghilangkan spinner pada input number */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Animasi untuk dropdown */
        .dropdown-menu {
            transition-property: opacity, transform;
            transition-duration: 200ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dropdown-menu.hidden {
            opacity: 0;
            transform: translateY(-10px);
        }

        .dropdown-menu.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-gradient-custom-light min-h-screen" x-data>
    <!-- Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-gray-900/50 z-10 lg:hidden hidden"></div>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed h-full bg-gradient-custom shadow-xl z-20 transition-all duration-300 ease-in-out flex flex-col -translate-x-full lg:translate-x-0"
            style="width: 18rem;">
            <!-- Logo -->
            <div class="flex items-center h-16 px-4 border-b border-white/20">
                <div class="flex items-center justify-center min-w-[2rem]">
                    <span class="text-xl font-bold text-white">
                        BersihQ
                    </span>
                </div>
            </div>

            <!-- Profile Section -->
            <div class="px-4 py-3 border-b border-white/20">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-semibold text-white">{{ substr(auth()->user()->nama, 0, 1) }}</span>
                    </div>
                    <div class="profile-info min-w-0">
                        <h3 class="text-sm font-semibold text-white truncate">{{ auth()->user()->nama }}</h3>
                        <p class="text-xs text-white/80">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-3 overflow-y-auto custom-scrollbar">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out {{ request()->routeIs('dashboard') ? 'text-emerald-800 bg-white' : 'text-white hover:bg-white/10' }}">
                    <div class="flex items-center justify-center w-8 h-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-all duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span class="ml-3 whitespace-nowrap">Dashboard</span>
                </a>

                <a href="{{ route('orders.index') }}"
                    class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out {{ request()->routeIs('orders.index') ? 'text-emerald-800 bg-white' : 'text-white hover:bg-white/10' }}">
                    <div class="flex items-center justify-center w-8 h-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-all duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="ml-3 whitespace-nowrap">Pesanan</span>
                </a>

                <a href="{{ route('customers.index') }}"
                    class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out {{ request()->routeIs('customers.index') ? 'text-emerald-800 bg-white' : 'text-white hover:bg-white/10' }}">
                    <div class="flex items-center justify-center w-8 h-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-all duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="ml-3 whitespace-nowrap">Pelanggan</span>
                </a>

                <a href="{{ route('services.index') }}"
                    class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out {{ request()->routeIs('services.index') ? 'text-emerald-800 bg-white' : 'text-white hover:bg-white/10' }}">
                    <div class="flex items-center justify-center w-8 h-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-all duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="ml-3 whitespace-nowrap">Layanan</span>
                </a>

                @if (auth()->user()->role === 'admin')
                    <!-- Divider -->
                    <div class="border-t border-white/20 my-4"></div>

                    <!-- Laporan -->
                    <div x-data="{ open: {{ request()->routeIs('reports.*') ? 'true' : 'false' }} }" class="space-y-3">
                        <p class="px-3 text-xs font-semibold text-white/60 uppercase tracking-wider mb-2">Laporan</p>
                        <button @click="open = !open" type="button"
                            class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out text-white hover:bg-white/10 {{ request()->routeIs('reports.*') ? 'bg-white/10' : '' }}">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-8 h-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-all duration-200"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <span class="ml-3 whitespace-nowrap">Laporan</span>
                            </div>
                            <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-1 px-3">
                            <div class="relative pl-3">
                                <!-- Garis vertikal -->
                                <div class="absolute left-0 top-0 h-full w-px bg-white/20"></div>
                                <a href="{{ route('reports.transactions') }}"
                                    class="block relative py-2 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out {{ request()->routeIs('reports.transactions') ? 'text-emerald-800 bg-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                                    <div class="relative flex items-center">
                                        <!-- Garis horizontal -->
                                        <div class="absolute -left-3 top-1/2 w-2 h-px bg-white/20"></div>
                                        <span class="pl-4">Transaksi</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->role === 'admin')
                    <!-- Divider -->
                    <div class="border-t border-white/20 my-4"></div>

                    <!-- Pengaturan -->
                    <div class="space-y-3">
                        <p class="px-3 text-xs font-semibold text-white/60 uppercase tracking-wider mb-2">Pengaturan
                        </p>
                        <a href="{{ route('users.index') }}"
                            class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out {{ request()->routeIs('users.*') ? 'text-emerald-800 bg-white' : 'text-white hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-all duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <span class="ml-3 whitespace-nowrap">Pengguna</span>
                        </a>
                        {{-- whatsapp bot --}}
                        <div x-data="{ open: {{ request()->routeIs('whatsapp.*') ? 'true' : 'false' }} }" class="space-y-3">
                            <button @click="open = !open" type="button"
                                class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out text-white hover:bg-white/10 {{ request()->routeIs('whatsapp.*') ? 'bg-white/10' : '' }}">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-8 h-8">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5 transition-all duration-200" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                    </div>
                                    <span class="ml-3 whitespace-nowrap">WhatsApp Bot</span>
                                </div>
                                <svg class="w-4 h-4 ml-2 transition-transform duration-200"
                                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-1 px-3">
                                <div class="relative pl-3">
                                    <!-- Garis vertikal -->
                                    <div class="absolute left-0 top-0 h-full w-px bg-white/20"></div>

                                    <!-- Connect -->
                                    <a href="{{ route('whatsapp.connect') }}"
                                        class="block relative py-2 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out {{ request()->routeIs('whatsapp.connect') ? 'text-emerald-800 bg-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                                        <div class="relative flex items-center">
                                            <!-- Garis horizontal -->
                                            <div class="absolute -left-3 top-1/2 w-2 h-px bg-white/20"></div>
                                            <span class="pl-4">Connect</span>
                                        </div>
                                    </a>

                                    <!-- Config -->
                                    <a href="{{ route('whatsapp.config') }}"
                                        class="block relative py-2 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out {{ request()->routeIs('whatsapp.config') ? 'text-emerald-800 bg-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                                        <div class="relative flex items-center">
                                            <!-- Garis horizontal -->
                                            <div class="absolute -left-3 top-1/2 w-2 h-px bg-white/20"></div>
                                            <span class="pl-4">Config</span>
                                        </div>
                                    </a>

                                    <!-- Template Text -->
                                    <a href="{{ route('whatsapp.template') }}"
                                        class="block relative py-2 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out {{ request()->routeIs('whatsapp.template') ? 'text-emerald-800 bg-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                                        <div class="relative flex items-center">
                                            <!-- Garis horizontal -->
                                            <div class="absolute -left-3 top-1/2 w-2 h-px bg-white/20"></div>
                                            <span class="pl-4">Template Text</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Divider -->
                <div class="border-t border-white/20 my-4"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out text-white hover:bg-white/10">
                        <div class="flex items-center justify-center w-8 h-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-all duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <span class="ml-3 whitespace-nowrap">Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div id="main-content" class="flex-1 transition-all duration-300 ease-in-out lg:ml-[18rem]">
            <!-- Mobile Header -->
            <div class="sticky top-0 z-10 bg-emerald-800 shadow-sm lg:hidden">
                <div class="flex items-center justify-between px-4 h-16">
                    <button id="mobile-menu-button" class="p-2 rounded-lg text-white hover:bg-white/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="text-lg font-bold text-white">BersihQ</span>
                    <div class="w-10"></div>
                </div>
            </div>

            <div class="min-h-screen">
                <!-- Content Area -->
                <main class="p-6">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="mb-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 p-4 text-sm text-white flex justify-between items-start"
                            role="alert">
                            <div class="flex">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                            <button type="button" class="text-white/80 hover:text-white focus:outline-none"
                                onclick="this.parentElement.remove()">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 rounded-xl bg-red-500/10 backdrop-blur-sm border border-red-500/20 p-4 text-sm text-white flex justify-between items-start"
                            role="alert">
                            <div class="flex">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                            <button type="button" class="text-white/80 hover:text-white focus:outline-none"
                                onclick="this.parentElement.remove()">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');

        // Toggle untuk mobile
        function toggleMobileSidebar() {
            const isHidden = sidebar.classList.contains('-translate-x-full');

            if (isHidden) {
                sidebar.classList.remove('-translate-x-full');
                sidebarBackdrop.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebarBackdrop.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        // Event listeners
        mobileMenuButton.addEventListener('click', toggleMobileSidebar);
        sidebarBackdrop.addEventListener('click', toggleMobileSidebar);

        // Handle resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                sidebarBackdrop.classList.add('hidden');
                document.body.style.overflow = '';
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
