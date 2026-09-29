{{-- Admin Sub-Navigation Tabs --}}
<div class="bg-white/10 backdrop-blur-md rounded-2xl p-1.5 border border-white/15 flex flex-wrap items-center gap-1">
    <a href="{{ route('admin.dashboard') }}"
       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all
              {{ request()->routeIs('admin.dashboard') ? 'bg-[#FDB813] text-[#001a4d] shadow-sm font-bold' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
        <i class="fas fa-chart-pie text-xs"></i>
        <span>Ikhtisar</span>
    </a>

    <a href="{{ route('admin.customers') }}"
       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all
              {{ request()->routeIs('admin.customers*') ? 'bg-[#FDB813] text-[#001a4d] shadow-sm font-bold' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
        <i class="fas fa-users text-xs"></i>
        <span>Pelanggan</span>
    </a>

    <a href="{{ route('admin.transactions') }}"
       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all
              {{ request()->routeIs('admin.transactions') ? 'bg-[#FDB813] text-[#001a4d] shadow-sm font-bold' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
        <i class="fas fa-receipt text-xs"></i>
        <span>Transaksi</span>
    </a>

    <a href="{{ route('admin.bills') }}"
       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all
              {{ request()->routeIs('admin.bills') ? 'bg-[#FDB813] text-[#001a4d] shadow-sm font-bold' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
        <i class="fas fa-file-invoice-dollar text-xs"></i>
        <span>Tagihan & Tunggakan</span>
    </a>

    <a href="{{ route('admin.outages') }}"
       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all
              {{ request()->routeIs('admin.outages*') ? 'bg-[#FDB813] text-[#001a4d] shadow-sm font-bold' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
        <i class="fas fa-exclamation-triangle text-xs"></i>
        <span>Tiket Gangguan</span>
    </a>

    <a href="{{ route('admin.meter_readings') }}"
       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all
              {{ request()->routeIs('admin.meter_readings*') ? 'bg-[#FDB813] text-[#001a4d] shadow-sm font-bold' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
        <i class="fas fa-tachometer-alt text-xs"></i>
        <span>Audit Meter (SwaCAM)</span>
    </a>

    <a href="{{ route('admin.letters') }}"
       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold transition-all border border-[#FDB813]/40
              {{ request()->routeIs('admin.letters*') ? 'bg-[#FDB813] text-[#001a4d] shadow-md' : 'bg-[#FDB813]/15 text-[#FDB813] hover:bg-[#FDB813]/25' }}">
        <i class="fas fa-magic text-xs"></i>
        <span>Pusat Surat AI</span>
        <span class="inline-block px-1.5 py-0.2 rounded-full text-[9px] bg-red-500 text-white font-black animate-pulse">AI</span>
    </a>
</div>
