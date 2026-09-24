{{-- Navbar --}}
<nav x-data="{ scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="{ 'py-3 shadow-md bg-white/5 backdrop-blur-md': scrolled, 'py-5 bg-transparent backdrop-blur-sm': !scrolled }"
     class="fixed top-0 w-full z-50 transition-all duration-300 border-b border-white/10" id="navbar">
    
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-12">
        <div class="flex items-center justify-between">
            
            {{-- Logo Section --}}
            <a href="{{ route('home') }}" class="flex items-center gap-4 group">
                {{-- Circular Emblem --}}
                <div class="relative w-[52px] h-[52px] flex items-center justify-center rounded-full border-[1.5px] border-white/40 bg-white/5 backdrop-blur-sm group-hover:border-[#FDB813] transition-colors shadow-sm">
                    {{-- Inner rotating dashed ring --}}
                    <div class="absolute inset-[4px] border border-white/20 rounded-full border-dashed animate-[spin_10s_linear_infinite]"></div>
                    {{-- Center icon --}}
                    <i class="fas fa-bolt text-[#FDB813] text-2xl drop-shadow-md transform group-hover:scale-110 transition-transform"></i>
                </div>
                
                {{-- Divider --}}
                <div class="h-10 w-[1.5px] bg-white/20 rounded-full"></div>
                
                {{-- Text --}}
                <div class="flex flex-col">
                    <span class="text-[22px] font-bold tracking-wide text-white italic drop-shadow-sm leading-none mb-1">
                        <span class="text-[#FDB813]">PLN</span>DIGI
                    </span>
                    <span class="text-[11px] text-white/80 font-medium tracking-wide leading-none">
                        Layanan Listrik Digital
                    </span>
                </div>
            </a>

            {{-- Center Menu --}}
            <div class="hidden md:flex items-center gap-10">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-[15px] font-medium transition-colors relative pb-1 {{ request()->routeIs('home') ? 'text-white' : 'text-white/80 hover:text-white' }}">
                    <i class="fas fa-home {{ request()->routeIs('home') ? '' : 'opacity-80 group-hover:opacity-100' }}"></i>
                    Beranda
                    @if(request()->routeIs('home'))
                        <div class="absolute -bottom-3 left-0 right-0 h-[3px] bg-[#FDB813] rounded-t-sm shadow-[0_0_8px_rgba(253,184,19,0.5)]"></div>
                    @endif
                </a>
                
                <a href="{{ route('simulasi') }}" class="flex items-center gap-2.5 text-[15px] font-medium transition-colors relative pb-1 {{ request()->routeIs('simulasi*') ? 'text-white' : 'text-white/80 hover:text-white' }}">
                    <i class="fas fa-search {{ request()->routeIs('simulasi*') ? '' : 'opacity-80 group-hover:opacity-100' }}"></i>
                    Simulasi
                    @if(request()->routeIs('simulasi*'))
                        <div class="absolute -bottom-3 left-0 right-0 h-[3px] bg-[#FDB813] rounded-t-sm shadow-[0_0_8px_rgba(253,184,19,0.5)]"></div>
                    @endif
                </a>
                
                <a href="{{ route('produk') }}" class="flex items-center gap-2.5 text-[15px] font-medium transition-colors relative pb-1 {{ request()->routeIs('produk*') ? 'text-white' : 'text-white/80 hover:text-white' }}">
                    <i class="fas fa-building {{ request()->routeIs('produk*') ? '' : 'opacity-80 group-hover:opacity-100' }}"></i>
                    Produk
                    @if(request()->routeIs('produk*'))
                        <div class="absolute -bottom-3 left-0 right-0 h-[3px] bg-[#FDB813] rounded-t-sm shadow-[0_0_8px_rgba(253,184,19,0.5)]"></div>
                    @endif
                </a>

                <a href="{{ route('news.index') }}" class="flex items-center gap-2.5 text-[15px] font-medium transition-colors relative pb-1 {{ request()->routeIs('news*') ? 'text-white' : 'text-white/80 hover:text-white' }}">
                    <i class="fas fa-newspaper {{ request()->routeIs('news*') ? '' : 'opacity-80 group-hover:opacity-100' }}"></i>
                    Berita
                    @if(request()->routeIs('news*'))
                        <div class="absolute -bottom-3 left-0 right-0 h-[3px] bg-[#FDB813] rounded-t-sm shadow-[0_0_8px_rgba(253,184,19,0.5)]"></div>
                    @endif
                </a>
                
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 text-[15px] font-medium transition-colors relative pb-1 {{ request()->routeIs('dashboard*') ? 'text-white' : 'text-white/80 hover:text-white' }}">
                        <i class="fas fa-table-columns {{ request()->routeIs('dashboard*') ? '' : 'opacity-80 group-hover:opacity-100' }}"></i>
                        Dashboard
                        @if(request()->routeIs('dashboard*'))
                            <div class="absolute -bottom-3 left-0 right-0 h-[3px] bg-[#FDB813] rounded-t-sm shadow-[0_0_8px_rgba(253,184,19,0.5)]"></div>
                        @endif
                    </a>
                @endauth
            </div>

            {{-- Right Section --}}
            <div class="hidden md:flex items-center gap-4">
                {{-- Theme Toggle --}}
                <button class="w-10 h-10 rounded-full border border-white/30 flex items-center justify-center text-white hover:bg-white/10 transition-colors" title="Mode Terang/Gelap">
                    <i class="fas fa-sun text-sm"></i>
                </button>
                
                @auth
                    <div class="relative ml-2" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2.5 px-4 py-2 bg-white/10 border border-white/20 rounded-full text-white text-sm font-medium hover:bg-white/20 transition-colors shadow-sm">
                            <i class="fas fa-user-circle text-lg text-[#FDB813]"></i>
                            <span>{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-[10px] ml-1" :class="open ? 'rotate-180' : ''" style="transition: transform 0.2s"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50 overflow-hidden">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-[#1B6EBB] transition-colors">
                                <i class="fas fa-user-edit w-5 text-center text-slate-400 mr-2"></i> Profil
                            </a>
                            <div class="h-px bg-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt w-5 text-center text-red-400 mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 text-[15px] font-medium text-white border border-white/50 rounded-full hover:bg-white/10 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 text-[15px] font-bold text-[#1B6EBB] bg-white rounded-full hover:bg-slate-50 shadow hover:shadow-md hover:-translate-y-0.5 transition-all">
                        Buat Akun
                    </a>
                @endauth
            </div>
            
            {{-- Mobile Toggle --}}
            <button class="md:hidden p-2 text-white/80 hover:text-white" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>
    
    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-200 shadow-lg absolute w-full top-full">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-slate-50"><i class="fas fa-home w-6 text-center text-[#1B6EBB]"></i> Beranda</a>
            <a href="{{ route('simulasi') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-50"><i class="fas fa-search w-6 text-center text-[#1B6EBB]"></i> Simulasi</a>
            <a href="{{ route('produk') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-50"><i class="fas fa-building w-6 text-center text-[#1B6EBB]"></i> Produk</a>
            <a href="{{ route('news.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-50"><i class="fas fa-newspaper w-6 text-center text-[#1B6EBB]"></i> Berita</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-50"><i class="fas fa-table-columns w-6 text-center text-[#1B6EBB]"></i> Dashboard</a>
                <hr class="border-slate-100 my-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt w-6 text-center text-red-500"></i> Keluar</button>
                </form>
            @else
                <hr class="border-slate-100 my-2">
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-semibold text-slate-900 hover:bg-slate-50">Masuk</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 mt-1 text-center rounded-md text-base font-bold text-white bg-[#1B6EBB] hover:bg-[#155A96]">Buat Akun</a>
            @endauth
        </div>
    </div>
</nav>
<div class="h-16"></div>
