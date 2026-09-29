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

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Foto Profil Section dengan Sanitasi Keamanan --}}
        <div class="p-5 rounded-2xl bg-slate-50/90 border border-slate-200/90">
            <label class="block font-bold text-sm text-slate-800 mb-3">
                Foto Profil Akun
            </label>

            <div class="flex flex-col sm:flex-row sm:items-center gap-5">
                {{-- Avatar Display Preview --}}
                <div class="relative group shrink-0">
                    <div id="avatar-container" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full ring-4 ring-[#00529C]/15 overflow-hidden shadow-md bg-gradient-to-tr from-[#00265a] to-[#00529C] flex items-center justify-center text-white text-3xl font-black">
                        @if($user->avatar_url)
                            <img id="avatar-preview-img" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            <span id="avatar-fallback-initial" class="hidden">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @else
                            <img id="avatar-preview-img" src="" alt="Preview" class="w-full h-full object-cover hidden">
                            <span id="avatar-fallback-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    {{-- Camera overlay badge --}}
                    <label for="avatar" class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-[#FDB813] hover:bg-yellow-400 text-slate-900 flex items-center justify-center shadow-md cursor-pointer border-2 border-white transition active:scale-95" title="Ubah Foto Profil">
                        <i class="fas fa-camera text-xs"></i>
                    </label>
                </div>

                {{-- Upload Controls & Info --}}
                <div class="space-y-2.5 flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <label for="avatar" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 text-[#00529C] border border-slate-300 text-xs font-bold transition shadow-xs cursor-pointer inline-flex items-center gap-1.5 active:scale-95">
                            <i class="fas fa-upload text-xs"></i>
                            <span>Pilih Foto Baru</span>
                        </label>
                        <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="previewAvatar(this)" />

                        @if($user->avatar)
                            <label class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 text-xs font-semibold cursor-pointer transition">
                                <input type="checkbox" name="remove_avatar" value="1" class="rounded text-red-600 focus:ring-red-500" onchange="handleRemoveAvatar(this)">
                                <span>Hapus Foto Profil</span>
                            </label>
                        @endif
                    </div>

                    <div id="file-chosen-name" class="text-xs text-slate-500 font-medium hidden">
                        Berkas dipilih: <strong class="text-slate-800" id="file-name-text"></strong>
                    </div>

                    <p class="text-xs text-slate-500 leading-relaxed">
                        Format didukung: <strong>JPG, JPEG, PNG, WEBP</strong> (Maks. 2 MB).
                    </p>

                    {{-- Security & Sanitization Note --}}
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-[11px] font-medium">
                        <i class="fas fa-shield-alt text-emerald-600"></i>
                        <span>Sanitasi Keamanan: Berkas divalidasi, metadata EXIF dibersihkan, & dikonversi ke WebP teroptimasi.</span>
                    </div>
                </div>
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

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

    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Client-side quick size validation
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file foto profil melebihi 2 MB.');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('avatar-preview-img');
                    const initial = document.getElementById('avatar-fallback-initial');
                    const nameDisplay = document.getElementById('file-chosen-name');
                    const nameText = document.getElementById('file-name-text');

                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    img.classList.remove('opacity-40');
                    if (initial) initial.classList.add('hidden');

                    if (nameDisplay && nameText) {
                        nameText.textContent = file.name;
                        nameDisplay.classList.remove('hidden');
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        function handleRemoveAvatar(checkbox) {
            const img = document.getElementById('avatar-preview-img');
            const initial = document.getElementById('avatar-fallback-initial');
            if (checkbox.checked) {
                if (img) img.classList.add('opacity-30');
            } else {
                if (img) img.classList.remove('opacity-30');
            }
        }
    </script>
</section>
