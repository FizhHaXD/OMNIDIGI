<section class="space-y-6">
    <header class="flex items-start gap-3">
        <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
            <i class="fas fa-triangle-exclamation"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-red-600">
                Hapus Akun
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Setelah akun Anda dihapus, seluruh sumber daya dan data riwayat transaksi Anda akan dihapus secara permanen. Pastikan Anda telah mengunduh atau mencatat data penting sebelum melanjutkan.
            </p>
        </div>
    </header>

    <button
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition shadow-sm hover:shadow flex items-center gap-2"
    >
        <i class="fas fa-trash-alt text-xs"></i>
        <span>Hapus Akun Saya</span>
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 class="text-lg font-bold text-slate-800">
                    Konfirmasi Hapus Akun
                </h2>
            </div>

            <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                Apakah Anda benar-benar yakin ingin menghapus akun Anda? Seluruh data riwayat pembayaran listrik, token, dan klaim voucher akan dihapus secara permanen. Masukkan kata sandi akun Anda untuk mengonfirmasi.
            </p>

            <div class="mb-6">
                <label for="password" class="block font-medium text-sm text-slate-700 mb-1">
                    Kata Sandi Konfirmasi
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-input w-full rounded-xl border-slate-200 focus:border-red-500 focus:ring focus:ring-red-500/20 transition"
                    placeholder="Masukkan kata sandi akun Anda"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold text-sm hover:bg-slate-100 transition"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition shadow-sm flex items-center gap-2"
                >
                    <i class="fas fa-trash-alt text-xs"></i>
                    <span>Ya, Hapus Permanen</span>
                </button>
            </div>
        </form>
    </x-modal>
</section>
