@extends('layouts.main')
@section('title', '{{ isset($customer) ? "Edit" : "Tambah" }} Pelanggan - Admin PLN DIGI')

@section('content')
<section class="py-12 md:py-20">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 animate-fade-up">
            <h1 class="text-2xl font-bold text-slate-900">{{ isset($customer) ? 'Edit' : 'Tambah' }} Pelanggan</h1>
            <p class="text-slate-500 text-sm mt-1">{{ isset($customer) ? 'Update data pelanggan' : 'Tambahkan data pelanggan baru' }}</p>
        </div>

        <div class="card p-8 animate-fade-up delay-100">
            <form action="{{ isset($customer) ? route('admin.customers.update', $customer) : route('admin.customers.store') }}" method="POST">
                @csrf
                @if(isset($customer))
                    @method('PUT')
                @endif

                <div class="space-y-5">
                    <div>
                        <label class="form-label">ID Pelanggan</label>
                        <input type="text" name="id_pelanggan" class="form-input" placeholder="5312 XXXX XXXX"
                               value="{{ old('id_pelanggan', $customer->id_pelanggan ?? '') }}" required>
                        @error('id_pelanggan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" name="nama" class="form-input" placeholder="Nama lengkap"
                               value="{{ old('nama', $customer->nama ?? '') }}" required>
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-input" rows="3" placeholder="Alamat lengkap" required>{{ old('alamat', $customer->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Tarif</label>
                            <select name="tarif" class="form-select" required>
                                @foreach(['R1', 'R2', 'R3', 'B1', 'B2', 'I1', 'I2'] as $t)
                                    <option value="{{ $t }}" {{ old('tarif', $customer->tarif ?? '') === $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Daya (VA)</label>
                            <select name="daya" class="form-select" required>
                                @foreach([450, 900, 1300, 2200, 3500, 5500, 6600] as $d)
                                    <option value="{{ $d }}" {{ old('daya', $customer->daya ?? '') == $d ? 'selected' : '' }}>{{ number_format($d) }} VA</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Tagihan (Rp)</label>
                        <input type="number" name="tagihan" class="form-input" placeholder="0" min="0"
                               value="{{ old('tagihan', $customer->tagihan ?? 0) }}">
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-8">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> {{ isset($customer) ? 'Update' : 'Simpan' }}
                    </button>
                    <a href="{{ route('admin.customers') }}" class="btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
