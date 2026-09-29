<section>
    <header class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#00529C] flex items-center justify-center shrink-0">
            <i class="fas fa-id-card"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-slate-800">
                Informasi Profil
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Perbarui data nama lengkap dan alamat email akun PLN DIGI Anda.
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block font-medium text-sm text-slate-700 mb-1">
                Nama Lengkap
            </label>
            <input id="name" name="name" type="text" class="form-input w-full rounded-xl border-slate-200 focus:border-[#00529C] focus:ring focus:ring-[#00529C]/20 transition" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block font-medium text-sm text-slate-700 mb-1">
                Alamat Email
            </label>
            <input id="email" name="email" type="email" class="form-input w-full rounded-xl border-slate-200 focus:border-[#00529C] focus:ring focus:ring-[#00529C]/20 transition" value="{{ old('email', $user->email) }}" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 rounded-xl bg-amber-50 border border-amber-200 text-sm text-amber-800 flex items-start gap-2">
                    <i class="fas fa-exclamation-triangle mt-0.5 text-amber-600"></i>
                    <div>
                        <span>Alamat email Anda belum diverifikasi.</span>
                        <button form="send-verification" class="underline font-medium text-amber-900 hover:text-black ml-1">
                            Klik di sini untuk mengirim ulang tautan verifikasi.
                        </button>
                    </div>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-emerald-600 flex items-center gap-1.5">
                        <i class="fas fa-check-circle"></i>
                        <span>Tautan verifikasi baru telah dikirim ke alamat email Anda.</span>
                    </p>
                @endif
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#00529C] hover:bg-[#003d75] text-white font-semibold text-sm transition shadow-sm hover:shadow flex items-center gap-2">
                <i class="fas fa-save text-xs"></i>
                <span>Simpan Perubahan</span>
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-emerald-600 flex items-center gap-1.5"
                >
                    <i class="fas fa-check-circle"></i>
                    <span>Profil berhasil disimpan.</span>
                </p>
            @endif
        </div>
    </form>
</section>
