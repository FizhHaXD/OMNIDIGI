{{-- Footer --}}
<footer class="bg-[#001230] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Main --}}
        <div class="py-14 grid grid-cols-1 md:grid-cols-12 gap-10">
            {{-- Brand --}}
            <div class="md:col-span-4">
                <div class="flex items-center gap-2.5 mb-5">
                    <div class="w-9 h-9 bg-[#FDB813] rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-[#001a4d] text-sm"></i>
                    </div>
                    <span class="text-lg font-bold">PLN<span class="text-[#FDB813]">DIGI</span></span>
                </div>
                <p class="text-white/50 text-sm leading-relaxed max-w-xs">
                    Layanan listrik digital untuk kemudahan Anda. Bayar tagihan, beli token, dan kelola kebutuhan listrik dalam satu platform.
                </p>
            </div>

            {{-- Links --}}
            <div class="md:col-span-2">
                <h4 class="text-sm font-semibold text-white/90 mb-4">Layanan</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('produk.tagihan') }}" class="text-white/40 hover:text-white/80 transition-colors">Bayar Tagihan</a></li>
                    <li><a href="{{ route('produk.token') }}" class="text-white/40 hover:text-white/80 transition-colors">Beli Token</a></li>
                    <li><a href="{{ route('simulasi') }}" class="text-white/40 hover:text-white/80 transition-colors">Simulasi Pasang</a></li>
                </ul>
            </div>

            <div class="md:col-span-2">
                <h4 class="text-sm font-semibold text-white/90 mb-4">Informasi</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#" class="text-white/40 hover:text-white/80 transition-colors">Tentang PLN</a></li>
                    <li><a href="#" class="text-white/40 hover:text-white/80 transition-colors">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-white/40 hover:text-white/80 transition-colors">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            <div class="md:col-span-4">
                <h4 class="text-sm font-semibold text-white/90 mb-4">Kontak</h4>
                <ul class="space-y-2.5 text-sm text-white/40">
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-phone mt-0.5 text-[#FDB813]/60 text-xs"></i>
                        <span>123 (PLN Call Center 24 Jam)</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-envelope mt-0.5 text-[#FDB813]/60 text-xs"></i>
                        <span>pln123@pln.co.id</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-map-marker-alt mt-0.5 text-[#FDB813]/60 text-xs"></i>
                        <span>Jl. Trunojoyo Blok M I/135, Jakarta Selatan</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="border-t border-white/10 py-5 flex flex-col md:flex-row items-center justify-between gap-3">
            <p class="text-xs text-white/30">&copy; {{ date('Y') }} PLN DIGI — Project Lomba PLN Digital Innovation</p>
            <div class="flex gap-3">
                <a href="#" class="w-8 h-8 bg-white/5 rounded-full flex items-center justify-center text-white/30 hover:bg-white/10 hover:text-white/60 transition-all text-xs">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-8 h-8 bg-white/5 rounded-full flex items-center justify-center text-white/30 hover:bg-white/10 hover:text-white/60 transition-all text-xs">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="w-8 h-8 bg-white/5 rounded-full flex items-center justify-center text-white/30 hover:bg-white/10 hover:text-white/60 transition-all text-xs">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
