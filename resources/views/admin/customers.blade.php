@extends('layouts.main')
@section('title', 'Kelola Pelanggan - Admin PLN DIGI')

@section('content')
{{-- Header --}}
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 md:pt-36 md:pb-20">
        <div class="flex items-end justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold">Data Pelanggan</h1>
                <p class="text-white/50 mt-2">Kelola data pelanggan PLN.</p>
            </div>
            <a href="{{ route('admin.customers.create') }}" class="btn-secondary text-sm py-2.5">
                <i class="fas fa-plus text-xs"></i> Tambah
            </a>
        </div>
    </div>
</section>

<section class="py-10 md:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="table-container">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">ID Pelanggan</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Nama</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Alamat</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tarif</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Daya</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Tagihan</th>
                            <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($customers as $c)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm font-mono text-slate-600">{{ $c->id_pelanggan }}</td>
                                <td class="px-5 py-3.5 text-sm font-medium text-slate-900">{{ $c->nama }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500 max-w-[200px] truncate">{{ $c->alamat }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $c->tarif }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ number_format($c->daya) }} VA</td>
                                <td class="px-5 py-3.5 text-sm font-semibold {{ $c->tagihan > 0 ? 'text-red-500' : 'text-emerald-600' }}">
                                    Rp {{ number_format($c->tagihan, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-1.5">
                                        <a href="{{ route('admin.customers.edit', $c) }}" class="p-2 rounded-lg text-slate-400 hover:text-[#00529C] hover:bg-[#00529C]/5 transition-all" title="Edit">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.customers.delete', $c) }}" method="POST" onsubmit="return confirm('Hapus pelanggan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all" title="Hapus">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400 text-sm">Belum ada data pelanggan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($customers->hasPages())
                <div class="px-5 py-4 border-t border-slate-100">{{ $customers->links() }}</div>
            @endif
        </div>

        <a href="{{ route('admin.dashboard') }}" class="inline-block mt-6 text-sm text-slate-400 hover:text-[#00529C] transition-colors">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>
</section>
@endsection
