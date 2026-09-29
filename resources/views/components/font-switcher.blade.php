{{-- PLN DIGI — Interactive Font Switcher Modal & Floating Widget --}}

{{-- 1. Floating Action Button (Pojok Kanan Bawah) --}}
<div class="fixed bottom-6 right-6 z-[9999] flex items-center">
    <button
        onclick="window.openFontSwitcherModal()"
        type="button"
        id="floating-font-btn"
        title="Uji Coba & Diskusi Font Tim (Klik untuk Memilih Font)"
        class="group flex items-center gap-2.5 px-4 py-3 bg-gradient-to-r from-[#00529C] to-[#00265a] text-white rounded-full shadow-[0_8px_25px_rgba(0,82,156,0.6)] hover:shadow-[#00529C]/80 border-2 border-[#FDB813] transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer"
    >
        <div class="w-8 h-8 rounded-full bg-[#FDB813] text-[#001a4d] flex items-center justify-center font-black text-sm shadow-md group-hover:rotate-12 transition-transform">
            <i class="fas fa-font"></i>
        </div>
        <div class="text-left hidden sm:block">
            <p class="text-[10px] font-extrabold uppercase tracking-wider text-[#FDB813] leading-none">Uji Coba</p>
            <p class="text-[13px] font-bold text-white leading-tight mt-0.5">Pilih Font</p>
        </div>
        <span id="floating-font-name-badge" class="inline-flex items-center justify-center px-2.5 py-0.5 text-[11px] font-bold rounded-full bg-white/20 text-[#FDB813] border border-white/20">
            Jakarta
        </span>
    </button>
</div>

{{-- 2. Center Modal Dialog with Backdrop Overlay --}}
<div
    id="pln-font-modal"
    class="fixed inset-0 z-[999999] hidden flex items-center justify-center p-4 sm:p-6 bg-slate-900/70 backdrop-blur-sm transition-opacity duration-200"
    onclick="if(event.target === this) window.closeFontSwitcherModal()"
>
    <div
        class="w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col max-h-[90vh] animate-scale-up"
        onclick="event.stopPropagation()"
    >
        {{-- Header Modal --}}
        <div class="p-6 bg-gradient-to-r from-[#001230] via-[#00265a] to-[#001a4d] text-white relative">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-[#FDB813] text-xl shadow-inner">
                        <i class="fas fa-text-height"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white tracking-tight">Uji Coba Tipografi Tim</h3>
                        <p class="text-xs text-white/60 mt-0.5">Pilih font untuk melihat perubahan tampilan secara instan</p>
                    </div>
                </div>
                <button
                    onclick="window.closeFontSwitcherModal()"
                    type="button"
                    class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/25 text-white flex items-center justify-center transition cursor-pointer"
                >
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            {{-- Info Pill Font Aktif --}}
            <div class="mt-4 flex items-center justify-between text-xs bg-white/10 border border-white/15 px-4 py-2.5 rounded-xl backdrop-blur-sm">
                <span class="text-white/70">Font Aktif Saat Ini:</span>
                <span id="modal-active-font-badge" class="font-bold text-[#FDB813] flex items-center gap-1.5 text-sm">
                    <i class="fas fa-check-circle text-xs"></i>
                    <span id="modal-active-font-name">Plus Jakarta Sans</span>
                </span>
            </div>
        </div>

        {{-- Font List (Scrollable Cards) --}}
        <div id="font-options-container" class="p-5 space-y-3 overflow-y-auto flex-1 max-h-[52vh] bg-slate-50/50">

            {{-- 1. Plus Jakarta Sans --}}
            <div
                onclick="window.selectPlnFont('jakarta')"
                data-font-id="jakarta"
                class="font-card cursor-pointer p-4 rounded-2xl border-2 transition-all duration-200 bg-white hover:border-[#00529C] hover:shadow-md"
            >
                <div class="flex items-center justify-between mb-1.5">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-[16px] text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Plus Jakarta Sans</span>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-md bg-blue-100 text-[#00529C]">Sans-Serif</span>
                        <span class="text-[10px] bg-amber-100 text-amber-800 font-semibold px-1.5 py-0.5 rounded">Bawaan</span>
                    </div>
                    <div class="font-check-indicator w-6 h-6 rounded-full border border-slate-300 flex items-center justify-center text-xs">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <p class="text-[13px] text-slate-600 line-clamp-1 leading-normal" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    PLN DIGI — Layanan Listrik Digital Terpadu Rp 250.000
                </p>
                <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                    <i class="fas fa-tag text-[9px]"></i> Modern, Bersih & Tingkat Keterbacaan Sangat Tinggi
                </p>
            </div>

            {{-- 2. Montserrat --}}
            <div
                onclick="window.selectPlnFont('montserrat')"
                data-font-id="montserrat"
                class="font-card cursor-pointer p-4 rounded-2xl border-2 transition-all duration-200 bg-white hover:border-[#00529C] hover:shadow-md"
            >
                <div class="flex items-center justify-between mb-1.5">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-[16px] text-slate-800" style="font-family: 'Montserrat', sans-serif;">Montserrat</span>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-700">Geometric</span>
                    </div>
                    <div class="font-check-indicator w-6 h-6 rounded-full border border-slate-300 flex items-center justify-center text-xs">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <p class="text-[13px] text-slate-600 line-clamp-1 leading-normal" style="font-family: 'Montserrat', sans-serif;">
                    PLN DIGI — Layanan Listrik Digital Terpadu Rp 250.000
                </p>
                <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                    <i class="fas fa-tag text-[9px]"></i> Kokoh, Tajam, Berbobot & Sangat Modern
                </p>
            </div>

            {{-- 3. Rubik --}}
            <div
                onclick="window.selectPlnFont('rubik')"
                data-font-id="rubik"
                class="font-card cursor-pointer p-4 rounded-2xl border-2 transition-all duration-200 bg-white hover:border-[#00529C] hover:shadow-md"
            >
                <div class="flex items-center justify-between mb-1.5">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-[16px] text-slate-800" style="font-family: 'Rubik', sans-serif;">Rubik</span>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-700">Rounded</span>
                    </div>
                    <div class="font-check-indicator w-6 h-6 rounded-full border border-slate-300 flex items-center justify-center text-xs">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <p class="text-[13px] text-slate-600 line-clamp-1 leading-normal" style="font-family: 'Rubik', sans-serif;">
                    PLN DIGI — Layanan Listrik Digital Terpadu Rp 250.000
                </p>
                <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                    <i class="fas fa-tag text-[9px]"></i> Sudut Huruf Lembut, Ramah & Dinamis
                </p>
            </div>

            {{-- 4. Lato --}}
            <div
                onclick="window.selectPlnFont('lato')"
                data-font-id="lato"
                class="font-card cursor-pointer p-4 rounded-2xl border-2 transition-all duration-200 bg-white hover:border-[#00529C] hover:shadow-md"
            >
                <div class="flex items-center justify-between mb-1.5">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-[16px] text-slate-800" style="font-family: 'Lato', sans-serif;">Lato</span>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-700">Humanist</span>
                    </div>
                    <div class="font-check-indicator w-6 h-6 rounded-full border border-slate-300 flex items-center justify-center text-xs">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <p class="text-[13px] text-slate-600 line-clamp-1 leading-normal" style="font-family: 'Lato', sans-serif;">
                    PLN DIGI — Layanan Listrik Digital Terpadu Rp 250.000
                </p>
                <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                    <i class="fas fa-tag text-[9px]"></i> Seimbang, Hangat, Formal & Stabil Korporat
                </p>
            </div>

            {{-- 5. Oswald --}}
            <div
                onclick="window.selectPlnFont('oswald')"
                data-font-id="oswald"
                class="font-card cursor-pointer p-4 rounded-2xl border-2 transition-all duration-200 bg-white hover:border-[#00529C] hover:shadow-md"
            >
                <div class="flex items-center justify-between mb-1.5">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-[16px] text-slate-800" style="font-family: 'Oswald', sans-serif;">Oswald</span>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-700">Condensed</span>
                    </div>
                    <div class="font-check-indicator w-6 h-6 rounded-full border border-slate-300 flex items-center justify-center text-xs">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <p class="text-[13px] text-slate-600 line-clamp-1 leading-normal" style="font-family: 'Oswald', sans-serif;">
                    PLN DIGI — Layanan Listrik Digital Terpadu Rp 250.000
                </p>
                <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                    <i class="fas fa-tag text-[9px]"></i> Ramping, Padat, Kuat & Impactful untuk Headline
                </p>
            </div>

            {{-- 6. Merriweather --}}
            <div
                onclick="window.selectPlnFont('merriweather')"
                data-font-id="merriweather"
                class="font-card cursor-pointer p-4 rounded-2xl border-2 transition-all duration-200 bg-white hover:border-[#00529C] hover:shadow-md"
            >
                <div class="flex items-center justify-between mb-1.5">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-[16px] text-slate-800" style="font-family: 'Merriweather', serif;">Merriweather</span>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-md bg-amber-100 text-amber-800">Serif</span>
                    </div>
                    <div class="font-check-indicator w-6 h-6 rounded-full border border-slate-300 flex items-center justify-center text-xs">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <p class="text-[13px] text-slate-600 line-clamp-1 leading-normal" style="font-family: 'Merriweather', serif;">
                    PLN DIGI — Layanan Listrik Digital Terpadu Rp 250.000
                </p>
                <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                    <i class="fas fa-tag text-[9px]"></i> Karakter Serif Klasik, Berwibawa & Editorial Resmi
                </p>
            </div>

        </div>

        {{-- Footer Actions --}}
        <div class="p-4 bg-white border-t border-slate-200 flex items-center justify-between gap-3 text-xs">
            <button
                onclick="window.selectPlnFont('jakarta')"
                type="button"
                class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:text-slate-800 hover:bg-slate-100 font-semibold transition flex items-center gap-2 cursor-pointer"
            >
                <i class="fas fa-rotate-left text-xs"></i>
                <span>Reset ke Default</span>
            </button>
            <button
                onclick="window.closeFontSwitcherModal()"
                type="button"
                class="px-6 py-2.5 rounded-xl bg-[#00529C] hover:bg-[#003d75] text-white font-bold transition shadow-md hover:shadow-lg cursor-pointer"
            >
                Terapkan & Tutup
            </button>
        </div>
    </div>
</div>

{{-- Global Pure JavaScript Controller (100% Reliable without library dependency) --}}
<script>
    const PLN_FONTS = {
        jakarta: {
            id: 'jakarta',
            name: 'Plus Jakarta Sans',
            label: 'Jakarta',
            family: "'Plus Jakarta Sans', sans-serif"
        },
        montserrat: {
            id: 'montserrat',
            name: 'Montserrat',
            label: 'Montserrat',
            family: "'Montserrat', sans-serif"
        },
        rubik: {
            id: 'rubik',
            name: 'Rubik',
            label: 'Rubik',
            family: "'Rubik', sans-serif"
        },
        lato: {
            id: 'lato',
            name: 'Lato',
            label: 'Lato',
            family: "'Lato', sans-serif"
        },
        oswald: {
            id: 'oswald',
            name: 'Oswald',
            label: 'Oswald',
            family: "'Oswald', sans-serif"
        },
        merriweather: {
            id: 'merriweather',
            name: 'Merriweather',
            label: 'Merriweather',
            family: "'Merriweather', serif"
        }
    };

    window.openFontSwitcherModal = function() {
        const modal = document.getElementById('pln-font-modal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            window.syncFontModalUi();
        }
    };

    window.closeFontSwitcherModal = function() {
        const modal = document.getElementById('pln-font-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    };

    window.selectPlnFont = function(fontId) {
        const font = PLN_FONTS[fontId] || PLN_FONTS['jakarta'];
        localStorage.setItem('pln_active_font', font.id);

        // Apply CSS to all elements
        window.applyPlnFont(font.family);

        // Sync Badges & UI
        window.syncFontModalUi();
    };

    window.applyPlnFont = function(family) {
        let styleEl = document.getElementById('pln-dynamic-font-override');
        if (!styleEl) {
            styleEl = document.createElement('style');
            styleEl.id = 'pln-dynamic-font-override';
            document.head.appendChild(styleEl);
        }
        styleEl.innerHTML = `
            :root {
                --app-font-family: ${family};
            }
            body, h1, h2, h3, h4, h5, h6, p, span, a, button, input, select, textarea, label {
                font-family: ${family} !important;
            }
        `;
    };

    window.syncFontModalUi = function() {
        const activeId = localStorage.getItem('pln_active_font') || 'jakarta';
        const font = PLN_FONTS[activeId] || PLN_FONTS['jakarta'];

        // Update Navbar badge
        const navBadge = document.getElementById('navbar-font-name-badge');
        if (navBadge) navBadge.textContent = font.label;

        // Update Floating button badge
        const floatBadge = document.getElementById('floating-font-name-badge');
        if (floatBadge) floatBadge.textContent = font.label;

        // Update Modal header badge
        const modalBadge = document.getElementById('modal-active-font-name');
        if (modalBadge) modalBadge.textContent = font.name;

        // Update Cards styling
        document.querySelectorAll('.font-card').forEach(card => {
            const id = card.getAttribute('data-font-id');
            const indicator = card.querySelector('.font-check-indicator');
            if (id === font.id) {
                card.className = 'font-card cursor-pointer p-4 rounded-2xl border-2 transition-all duration-200 bg-blue-50/70 border-[#00529C] shadow-md ring-2 ring-[#00529C]/20';
                if (indicator) {
                    indicator.className = 'font-check-indicator w-6 h-6 rounded-full bg-[#00529C] text-white flex items-center justify-center text-xs shadow';
                }
            } else {
                card.className = 'font-card cursor-pointer p-4 rounded-2xl border-2 transition-all duration-200 bg-white border-slate-200 hover:border-slate-300 hover:bg-slate-50';
                if (indicator) {
                    indicator.className = 'font-check-indicator w-6 h-6 rounded-full border border-slate-300 text-transparent flex items-center justify-center text-xs';
                }
            }
        });
    };

    // Keyboard support: Escape closes modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            window.closeFontSwitcherModal();
        }
    });

    // Auto-run on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const activeId = localStorage.getItem('pln_active_font') || 'jakarta';
        const font = PLN_FONTS[activeId] || PLN_FONTS['jakarta'];
        window.applyPlnFont(font.family);
        window.syncFontModalUi();
    });

    // Immediate execution for fast rendering
    (function() {
        const activeId = localStorage.getItem('pln_active_font') || 'jakarta';
        const font = PLN_FONTS[activeId] || PLN_FONTS['jakarta'];
        window.applyPlnFont(font.family);
    })();
</script>
