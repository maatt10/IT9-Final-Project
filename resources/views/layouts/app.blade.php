<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cash'Here POS - Cafe Point of Sale</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-[#1e293b] to-[#0f172a] shadow-lg flex flex-col fixed h-full z-10 transition-all duration-300">
            <!-- Logo Area -->
            <div class="p-6 border-b border-coral-100 relative">
                <div class="flex items-center gap-2">
                    <!-- Logo Image -->
                    <div class="w-20 h-20 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <span class="logo-text text-xl font-bold text-coral-100 whitespace-nowrap">Cash'Here POS</span>
                </div>
                <p class="store-text text-xs text-slate-200 mt-2 whitespace-nowrap">Store #001 - Davao Central</p>

                <!-- Collapse Button -->
                <button id="collapseBtn" onclick="toggleSidebar()" class="absolute top-6 right-4 text-coral-50 hover:text-coral-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 py-6">
                <div class="px-4 space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-coral-100 hover:bg-coral-50 hover:text-coral-600 transition group {{ request()->routeIs('dashboard') ? 'bg-coral-500 text-white' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="nav-text">Dashboard</span>
                    </a>

                    <a href="{{ route('sales.create') }}"
                        class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-coral-100 hover:bg-coral-50 hover:text-coral-600 transition group {{ request()->routeIs('sales.create') ? 'bg-coral-500 text-white' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 15v6"></path>
                        </svg>
                        <span class="nav-text">New Sale</span>
                    </a>

                    <a href="{{ route('sales.index') }}"
                        class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-coral-100 hover:bg-coral-50 hover:text-coral-600 transition group {{ request()->routeIs('sales.index') ? 'bg-coral-500 text-white' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <span class="nav-text">Sales History</span>
                    </a>

                    <a href="{{ route('inventory.index') }}"
                        class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-coral-100 hover:bg-coral-50 hover:text-coral-600 transition group {{ request()->routeIs('inventory.*') ? 'bg-coral-500 text-white' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="nav-text">Inventory</span>
                    </a>
                </div>
            </nav>

            <!-- Terminal Info - Responsive -->
            <div class="terminal-section p-4 border-t border-coral-100">
                <div class="flex items-center gap-2 text-coral-100">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse flex-shrink-0"></div>
                    <span class="terminal-status text-sm">Terminal POS-01</span>
                </div>
                <div class="terminal-datetime mt-2">
                    <p class="text-xs text-slate-200 leading-relaxed" id="currentDateTime"></p>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 ml-64 overflow-y-auto transition-all duration-300">
            <div class="py-6 px-4 sm:px-8">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-700">&times;</button>
                </div>
                @endif

                @yield('content')
            </div>
        </main>

    </div>

    <script>
        // Update date and time - responsive formatting
        function updateDateTime() {
            const now = new Date();
            
            // Compact date for mobile/collapsed sidebar
            const compactDate = now.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric'
            });
            const fullDate = now.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            const timeString = now.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            
            // Check if sidebar is collapsed
            const sidebar = document.querySelector('aside');
            const isCollapsed = sidebar && sidebar.style.width === '80px';
            
            if (isCollapsed || window.innerWidth < 768) {
                document.getElementById('currentDateTime').innerHTML = `${compactDate}<br>${timeString}`;
            } else {
                document.getElementById('currentDateTime').innerHTML = `${fullDate}<br>${timeString}`;
            }
        }
        
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

    <script>
        let sidebarCollapsed = false;

        function toggleSidebar() {
            const sidebar = document.querySelector('aside');
            const main = document.querySelector('main');
            const logoText = document.querySelector('.logo-text');
            const storeText = document.querySelector('.store-text');
            const navTexts = document.querySelectorAll('.nav-text');
            const terminalStatus = document.querySelector('.terminal-status');
            const terminalDateTime = document.querySelector('.terminal-datetime');

            if (!sidebarCollapsed) {
                // Collapse
                sidebar.style.width = '80px';
                main.style.marginLeft = '80px';
                
                // Hide text elements
                if (logoText) logoText.style.display = 'none';
                if (storeText) storeText.style.display = 'none';
                navTexts.forEach(text => text.style.display = 'none');
                
                // Small terminal
                if (terminalStatus) terminalStatus.style.fontSize = '10px';
                if (terminalDateTime) terminalDateTime.style.fontSize = '9px';
                
                // Update date format to compact
                updateDateTime();

            } else {
                // Expand
                sidebar.style.width = '256px';
                main.style.marginLeft = '256px';
                
                // Show text elements
                if (logoText) logoText.style.display = 'inline';
                if (storeText) storeText.style.display = 'block';
                navTexts.forEach(text => text.style.display = 'inline');
                
                // Restore terminal text size
                if (terminalStatus) terminalStatus.style.fontSize = '';
                if (terminalDateTime) terminalDateTime.style.fontSize = '';
                
                // Update date format to full
                updateDateTime();
            }
            sidebarCollapsed = !sidebarCollapsed;
        }

        // Auto-collapse on mobile
        function checkScreenSize() {
            const sidebar = document.querySelector('aside');
            const main = document.querySelector('main');
            const logoText = document.querySelector('.logo-text');
            const storeText = document.querySelector('.store-text');
            const navTexts = document.querySelectorAll('.nav-text');
            const terminalStatus = document.querySelector('.terminal-status');
            const terminalDateTime = document.querySelector('.terminal-datetime');

            if (window.innerWidth < 768) {
                if (!sidebarCollapsed) {
                    sidebar.style.width = '80px';
                    main.style.marginLeft = '80px';
                    if (logoText) logoText.style.display = 'none';
                    if (storeText) storeText.style.display = 'none';
                    navTexts.forEach(text => text.style.display = 'none');
                    if (terminalStatus) terminalStatus.style.fontSize = '10px';
                    if (terminalDateTime) terminalDateTime.style.fontSize = '9px';
                    sidebarCollapsed = true;
                    updateDateTime();
                }
            } else {
                if (sidebarCollapsed) {
                    sidebar.style.width = '256px';
                    main.style.marginLeft = '256px';
                    if (logoText) logoText.style.display = 'inline';
                    if (storeText) storeText.style.display = 'block';
                    navTexts.forEach(text => text.style.display = 'inline');
                    if (terminalStatus) terminalStatus.style.fontSize = '';
                    if (terminalDateTime) terminalDateTime.style.fontSize = '';
                    sidebarCollapsed = false;
                    updateDateTime();
                }
            }
        }

        // Run on load and resize
        window.addEventListener('load', checkScreenSize);
        window.addEventListener('resize', checkScreenSize);
    </script>
</body>

</html>