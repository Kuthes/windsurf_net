<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sentinel Hotspot Controller')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar-active {
            background-color: rgb(59 130 246);
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-4">
                <h1 class="text-xl font-bold">Sentinel</h1>
                <p class="text-sm text-gray-400">Hotspot Controller</p>
            </div>
            <nav class="mt-8">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('users.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('users.*') ? 'sidebar-active' : '' }}">
                    Users
                </a>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="px-6 py-4">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h1>
                </div>
            </header>
            
            <!-- Content -->
            <main class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
