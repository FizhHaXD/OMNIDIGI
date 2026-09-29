<section>
    <header class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
            <i class="fas fa-shield-alt"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-slate-800">
                Perbarui Kata Sandi
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Pastikan akun Anda menggunakan kata sandi yang panjang dan kuat demi keamanan akun.
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-medium text-sm text-slate-700 mb-1">
                Kata Sandi Saat Ini
            </label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-input w-full rounded-xl border-slate-200 focus:border-[#00529C] focus:ring focus:ring-[#00529C]/20 transition" autocomplete="current-password" placeholder="Masukkan kata sandi saat ini" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block font-medium text-sm text-slate-700 mb-1">
                Kata Sandi Baru
            </label>
            <input id="update_password_password" name="password" type="password" class="form-input w-full rounded-xl border-slate-200 focus:border-[#00529C] focus:ring focus:ring-[#00529C]/20 transition" autocomplete="new-password" placeholder="Masukkan kata sandi baru (minimal 8 karakter)" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block font-medium text-sm text-slate-700 mb-1">
                Konfirmasi Kata Sandi Baru
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input w-full rounded-xl border-slate-200 focus:border-[#00529C] focus:ring focus:ring-[#00529C]/20 transition" autocomplete="new-password" placeholder="Ulangi kata sandi baru" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#00529C] hover:bg-[#003d75] text-white font-semibold text-sm transition shadow-sm hover:shadow flex items-center gap-2">
                <i class="fas fa-key text-xs"></i>
                <span>Simpan Kata Sandi</span>
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-emerald-600 flex items-center gap-1.5"
                >
                    <i class="fas fa-check-circle"></i>
                    <span>Kata sandi berhasil diperbarui.</span>
                </p>
            @endif
        </div>
    </form>
</section>
