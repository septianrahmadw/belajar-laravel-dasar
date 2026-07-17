<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - LabBooking Admin</title>
    @fonts
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
            body { font-family: 'Inter', sans-serif; }
        </style>
    @endif
    <style>
        #sidebar {
            width: 256px;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #sidebar.collapsed {
            width: 72px;
        }
        #mainContent {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #sidebar .sidebar-label {
            transition: opacity 0.2s ease 0.1s;
            opacity: 1;
        }
        #sidebar.collapsed .sidebar-label {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s ease;
        }
        #sidebar .sidebar-section-label {
            transition: opacity 0.2s ease;
            opacity: 1;
            max-height: 20px;
        }
        #sidebar.collapsed .sidebar-section-label {
            opacity: 0;
            max-height: 0;
            overflow: hidden;
        }
        #sidebar .sidebar-badge {
            display: inline-flex;
        }
        #sidebar.collapsed .sidebar-badge {
            display: none;
        }
        #sidebar .sidebar-header-text {
            transition: opacity 0.2s ease 0.1s;
            opacity: 1;
        }
        #sidebar.collapsed .sidebar-header-text {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s ease;
        }
        #sidebar .nav-tooltip {
            display: none;
        }
        #sidebar.collapsed .nav-link:hover .nav-tooltip {
            display: block;
        }
        #sidebar.collapsed .user-info {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s ease;
        }
        #sidebar .user-info {
            opacity: 1;
            transition: opacity 0.2s ease 0.1s;
        }
        #sidebar.collapsed .logout-form {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s ease;
        }
        #sidebar .logout-form {
            opacity: 1;
            transition: opacity 0.2s ease 0.1s;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans antialiased">
    <div class="flex min-h-screen">
        <aside id="sidebar" class="bg-gray-900 text-white flex flex-col shrink-0 fixed h-full z-40 overflow-hidden">
            <div class="p-5 border-b border-gray-800 flex items-center gap-2.5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 7.41A2.25 2.25 0 012.25 5.497V5.25" />
                        </svg>
                    </div>
                    <div class="sidebar-header-text whitespace-nowrap overflow-hidden">
                        <span class="text-lg font-bold">Lab<span class="text-indigo-400">Booking</span></span>
                        <span class="block text-[10px] text-gray-500 font-medium -mt-0.5">Admin Panel</span>
                    </div>
                </a>
            </div>

            <nav class="flex-1 p-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="nav-link relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                    <span class="sidebar-label whitespace-nowrap">Dashboard</span>
                    <span class="nav-tooltip absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded-md whitespace-nowrap shadow-lg z-50">Dashboard</span>
                </a>

                <div class="pt-4 pb-1 px-3">
                    <span class="sidebar-section-label text-[10px] font-bold uppercase tracking-wider text-gray-600">Manajemen</span>
                </div>

                <a href="{{ route('admin.rooms.index') }}" class="nav-link relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.rooms.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" /></svg>
                    <span class="sidebar-label whitespace-nowrap">Ruangan</span>
                    <span class="nav-tooltip absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded-md whitespace-nowrap shadow-lg z-50">Ruangan</span>
                </a>

                <a href="{{ route('admin.bookings.index') }}" class="nav-link relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.bookings.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                    <span class="sidebar-label whitespace-nowrap">Booking</span>
                    @if (\App\Models\Booking::where('status', 'pending')->count() > 0)
                    <span class="sidebar-badge ml-auto bg-amber-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">{{ \App\Models\Booking::where('status', 'pending')->count() }}</span>
                    @endif
                    <span class="nav-tooltip absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded-md whitespace-nowrap shadow-lg z-50">Booking</span>
                </a>

                <a href="{{ route('admin.prodis.index') }}" class="nav-link relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.prodis.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                    <span class="sidebar-label whitespace-nowrap">Prodi</span>
                    <span class="nav-tooltip absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded-md whitespace-nowrap shadow-lg z-50">Prodi</span>
                </a>

                @if (auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="nav-link relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    <span class="sidebar-label whitespace-nowrap">Pengguna</span>
                    <span class="nav-tooltip absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded-md whitespace-nowrap shadow-lg z-50">Pengguna</span>
                </a>
                @endif
            </nav>

            <div class="p-3 border-t border-gray-800">
                <a href="{{ route('home') }}" target="_blank" class="nav-link relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:bg-gray-800 hover:text-white transition-colors mb-1">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                    <span class="sidebar-label whitespace-nowrap">Lihat Situs</span>
                    <span class="nav-tooltip absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded-md whitespace-nowrap shadow-lg z-50">Lihat Situs</span>
                </a>
                <div class="flex items-center gap-3 px-3 py-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-semibold shrink-0
                        {{ auth()->user()->isAdmin() ? 'bg-indigo-600' : 'bg-amber-600' }}">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="user-info flex-1 min-w-0 whitespace-nowrap overflow-hidden">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-gray-500 truncate flex items-center gap-1">
                            <span class="inline-flex items-center px-1.5 py-0 rounded text-[9px] font-bold uppercase
                                {{ auth()->user()->isAdmin() ? 'bg-indigo-900 text-indigo-300' : 'bg-amber-900 text-amber-300' }}">
                                {{ auth()->user()->role_label }}
                            </span>
                        </p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="logout-form shrink-0">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-white transition-colors" title="Logout">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div id="mainContent" class="flex-1" style="margin-left: 256px;">
            <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
                <div class="flex items-center justify-between h-16 px-8">
                    <div class="flex items-center gap-3">
                        <button id="sidebarToggle" type="button" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" title="Toggle Sidebar">
                            <svg id="iconCollapse" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                            <svg id="iconExpand" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6h17.25m-17.25 6h17.25m-17.25 6h17.25M3 12h.008M3 6h.008M3 18h.008" /></svg>
                        </button>
                        <h1 class="text-xl font-bold text-gray-900">@yield('header', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        @yield('actions')
                    </div>
                </div>
            </header>

            <div class="p-8">
                @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
                @endif

                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-3 mb-1">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z" /></svg>
                        <p class="text-sm text-red-700 font-medium">Terjadi kesalahan:</p>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5 ml-8">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')

    <script>
    (function() {
        var sidebar = document.getElementById('sidebar');
        var mainContent = document.getElementById('mainContent');
        var toggle = document.getElementById('sidebarToggle');
        var iconCollapse = document.getElementById('iconCollapse');
        var iconExpand = document.getElementById('iconExpand');
        var STORAGE_KEY = 'labbooking-sidebar';

        function setCollapsed(collapsed) {
            if (collapsed) {
                sidebar.classList.add('collapsed');
                mainContent.style.marginLeft = '72px';
                iconCollapse.classList.add('hidden');
                iconExpand.classList.remove('hidden');
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.style.marginLeft = '256px';
                iconCollapse.classList.remove('hidden');
                iconExpand.classList.add('hidden');
            }
        }

        // Load saved state
        try {
            var saved = localStorage.getItem(STORAGE_KEY);
            setCollapsed(saved === 'collapsed');
        } catch (e) {
            setCollapsed(false);
        }

        toggle.addEventListener('click', function() {
            var isCollapsed = sidebar.classList.contains('collapsed');
            var newState = !isCollapsed;
            setCollapsed(newState);
            try {
                localStorage.setItem(STORAGE_KEY, newState ? 'collapsed' : 'expanded');
            } catch (e) {}
        });
    })();
    </script>
</body>
</html>