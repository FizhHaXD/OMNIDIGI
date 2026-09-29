@extends('layouts.main')
@section('title', 'Kelola Pelanggan - Admin PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1 bg-white/10 rounded-full text-[#FDB813] text-xs font-semibold uppercase tracking-wider mb-3 border border-white/10">
                    <i class="fas fa-users"></i> CRM & Master Data
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Data Pelanggan PLN</h1>
                <p class="text-white/60 text-sm mt-1">Daftar pelanggan terdaftar, daya tersambung, dan status rekening.</p>
            </div>
            <a href="{{ route('admin.customers.create') }}" class="btn-primary text-xs py-2.5 flex items-center gap-2">
                <i class="fas fa-user-plus text-xs"></i> Tambah Pelanggan Baru
            </a>
        </div>

        {{-- Sub-Navigation Tabs --}}
        @include('admin.partials.nav')
    </div>
</section>

<section class="py-8 md:py-12 bg-slate-50/60 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3.5 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Filter & Search Bar --}}
        <div class="card p-4 mb-6">
            <form method="GET" action="{{ route('admin.customers') }}" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berdasarkan nama, ID Pelanggan, atau alamat..."
                           class="form-input text-xs pl-9 w-full rounded-xl">
                </div>
                <div class="w-full md:w-48">
                    <select name="status" class="form-input text-xs w-full rounded-xl" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Pelanggan Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary text-xs py-2 px-4 whitespace-nowrap">
                    Filter Data
                </button>
                @if(request()->hasAny(['q', 'status']))
                    <a href="{{ route('admin.customers') }}" class="btn-outline text-xs py-2 px-4 whitespace-nowrap text-slate-600">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Table Container --}}
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">ID Pelanggan</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Nama & Kontak</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Alamat</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Gol. Tarif</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Daya</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tagihan Terakhir</th>
                            <th class="px-5 py-3.5 text-right text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($customers as $c)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm font-mono font-bold text-[#00529C]">
                                    {{ $c->id_pelanggan }}
                                    @if(!$c->status_aktif)
                                        <span class="block text-[10px] text-red-500 font-sans font-semibold">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="text-sm font-bold text-slate-900">{{ $c->nama }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $c->nomor_telepon ?? ($c->email ?? '-') }}</p>
                                </td>
                                <td class="px-5 py-3.5 text-xs text-slate-500 max-w-[220px] truncate" title="{{ $c->alamat }}">{{ $c->alamat }}</td>
                                <td class="px-5 py-3.5 text-xs font-semibold text-slate-700">
                                    <span class="inline-block px-2 py-0.5 rounded bg-blue-50 text-[#00529C] font-mono">
                                        {{ $c->tarif }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-xs font-medium text-slate-600">{{ number_format($c->daya) }} VA</td>
                                <td class="px-5 py-3.5 text-xs font-bold {{ $c->tagihan > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                    Rp {{ number_format($c->tagihan, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.customers.edit', $c) }}" class="p-2 rounded-lg text-slate-400 hover:text-[#00529C] hover:bg-[#00529C]/5 transition-all" title="Edit Pelanggan">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.customers.delete', $c) }}" method="POST" onsubmit="return confirm('Hapus data pelanggan {{ $c->nama }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all" title="Hapus">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-slate-400 text-sm">
                                    Tidak ada data pelanggan yang cocok dengan pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($customers->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
