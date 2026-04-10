<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Agent Dashboard' }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-indigo-800 to-indigo-900 text-white flex-shrink-0 hidden lg:block">
            <div class="p-6 border-b border-indigo-700">
                <h1 class="text-xl font-bold">🏢 Agent Portal</h1>
                @if(isset($agent))
                <p class="text-indigo-200 text-sm mt-1">{{ $agent->business_name }}</p>
                @endif
            </div>
            
            <nav class="p-4 space-y-1">
                <a href="{{ route('agent.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('agent.dashboard') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-700/50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('agent.customers') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('agent.customers') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-700/50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Khách hàng
                </a>
                
                <a href="{{ route('agent.weddings') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('agent.weddings') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-700/50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Thiệp cưới
                </a>
                
                <a href="{{ route('agent.settings') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('agent.settings') ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:bg-indigo-700/50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Cài đặt
                </a>
            </nav>
            
            <!-- User section -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-indigo-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-indigo-300 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('dashboard') }}" class="flex-1 py-2 text-center text-xs bg-indigo-700 rounded hover:bg-indigo-600">User Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-2 text-xs bg-red-600/30 text-red-200 rounded hover:bg-red-600/50">Đăng xuất</button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Mobile header -->
        <div class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-indigo-800 text-white px-4 py-3 flex items-center justify-between">
            <h1 class="font-bold">🏢 Agent Portal</h1>
            <button onclick="document.getElementById('mobileSidebar').classList.toggle('hidden')" class="p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        
        <!-- Mobile sidebar -->
        <div id="mobileSidebar" class="lg:hidden fixed inset-0 z-40 hidden">
            <div class="absolute inset-0 bg-black/50" onclick="this.parentElement.classList.add('hidden')"></div>
            <aside class="absolute left-0 top-0 bottom-0 w-64 bg-indigo-900 text-white overflow-y-auto">
                <div class="p-6">
                    <h1 class="text-xl font-bold">🏢 Agent Portal</h1>
                </div>
                <nav class="p-4 space-y-1">
                    <a href="{{ route('agent.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white hover:bg-indigo-700">Dashboard</a>
                    <a href="{{ route('agent.customers') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white hover:bg-indigo-700">Khách hàng</a>
                    <a href="{{ route('agent.weddings') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white hover:bg-indigo-700">Thiệp cưới</a>
                    <a href="{{ route('agent.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white hover:bg-indigo-700">Cài đặt</a>
                </nav>
            </aside>
        </div>
        
        <!-- Main content -->
        <main class="flex-1 lg:ml-0">
            <div class="lg:hidden h-14"></div> <!-- Spacer for mobile header -->
            
            @if(session('success'))
            <div class="m-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="m-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
            @endif
            
            {{ $slot }}
        </main>
    </div>
    
    @livewireScripts
</body>
</html>
