@extends('layouts.main')
@section('title', 'Lapor Gangguan - PLN DIGI')

@section('content')
<section class="relative -mt-16 md:-mt-18 bg-gradient-to-br from-[#001230] via-[#00265a] to-[#001a4d] text-white overflow-hidden">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-8 md:pt-36 md:pb-10">
        <a href="{{ route('dashboard.outage') }}" class="inline-flex items-center text-white/50 hover:text-white text-sm mb-3 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Laporan
        </a>
        <h1 class="text-2xl md:text-3xl font-bold">Lapor Gangguan Listrik</h1>
        <p class="text-white/50 mt-1 text-sm">Laporkan gangguan listrik di lokasi Anda agar segera ditindaklanjuti.</p>
    </div>
</section>

<section class="py-8 md:py-10">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card p-6">
            <form method="POST" action="{{ route('dashboard.outage.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Kategori --}}
                <div class="mb-5">
                    <label for="kategori" class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Gangguan</label>
                    <select name="kategori" id="kategori" class="form-input w-full" required>
                        <option value="">— Pilih jenis gangguan —</option>
                        <option value="padam_total" {{ old('kategori') === 'padam_total' ? 'selected' : '' }}>Padam Total</option>
                        <option value="tegangan_rendah" {{ old('kategori') === 'tegangan_rendah' ? 'selected' : '' }}>Tegangan Rendah</option>
                        <option value="korsleting" {{ old('kategori') === 'korsleting' ? 'selected' : '' }}>Korsleting</option>
                        <option value="meteran_rusak" {{ old('kategori') === 'meteran_rusak' ? 'selected' : '' }}>Meteran Rusak</option>
                        <option value="lainnya" {{ old('kategori') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Pelanggan (opsional) --}}
                @if($customers->isNotEmpty())
                <div class="mb-5">
                    <label for="customer_id" class="block text-sm font-medium text-slate-700 mb-1.5">ID Pelanggan (Opsional)</label>
                    <select name="customer_id" id="customer_id" class="form-input w-full">
                        <option value="">— Tidak terkait pelanggan —</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->id_pelanggan }} — {{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                {{-- Lokasi --}}
                <div class="mb-5">
                    <label for="lokasi" class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi Gangguan</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-input w-full" placeholder="Contoh: Jl. Merdeka No. 10, RT 03/05, Jakarta Pusat" value="{{ old('lokasi') }}" required>
                    @error('lokasi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-5">
                    <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi Gangguan</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-input w-full" placeholder="Jelaskan gangguan yang terjadi secara detail..." required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Upload Foto --}}
                <div class="mb-6">
                    <label for="foto" class="block text-sm font-medium text-slate-700 mb-1.5">Foto (Opsional)</label>
                    <input type="file" name="foto" id="foto" accept="image/*" class="form-input w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#00529C]/10 file:text-[#00529C] hover:file:bg-[#00529C]/20">
                    <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG. Maks: 2MB</p>
                    @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-primary w-full">
                    <i class="fas fa-paper-plane mr-2"></i> Kirim Laporan
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
