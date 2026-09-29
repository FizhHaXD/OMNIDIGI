# 🎨 Step 4: Color Palette & Design System — PLN DIGI

Dokumentasi warna untuk kebutuhan pembuatan UI Kit / Figma Design System & konsistensi tampilan web.  
Terakhir diperbarui: 28 September 2026.

[⬅️ Kembali ke Step 3: Dummy Users](03-DUMMY-USERS.md) | [Indeks Dokumentasi](README.md) | [Lanjut ke Step 5: Feature Changelog ➡️](05-FEATURE-CHANGELOG.md)

---

## Brand

| Token | Hex | Keterangan |
|-------|-----|------------|
| Primary | `#00529C` | Biru korporat PLN. Button utama, link aktif, icon, nominal harga. |
| Secondary | `#FDB813` | Kuning petir PLN. Aksen, indikator aktif navbar, badge, glow. |
| Primary Medium | `#2D6DA8` | Biru lebih muda. Backdrop navbar, CTA section, stat bar. |
| Secondary Warm | `#D4980A` | Emas gelap. Button sekunder, border tab aktif. |

### Turunan Brand (Hover & Supporting)

| Hex | Konteks |
|-----|---------|
| `#245A8D` | Hover state button primary |
| `#B8850A` | Hover state button secondary |
| `#1B6EBB` | Hero background beranda, tombol register, link berita |
| `#155A96` | Hover tombol "Buat Akun" mobile navbar |
| `#B8780A` | Teks kutipan & aksen emas gelap |
| `#9E6E00` | Teks badge token prabayar |
| `#7A5500` | Icon di dalam floating pill kuning hero |
| `#FFD060` | Hover teks fitur di hero |

---

## Gradients

### Header Halaman (Footer, Simulasi, Produk, Dashboard, News, Admin)

```
Direction: 135° (top-left → bottom-right)
Stop 0%   : #001230  — navy pekat
Stop 50%  : #00265A  — navy tengah
Stop 100% : #001A4D  — navy indigo
```

### Hero Beranda

```
Direction: 135°
Stop 0%   : #2782C9  — biru terang
Stop 50%  : #1B6EBB  — biru ocean
Stop 100% : #0F477E  — biru dalam
```

Overlay teks agar terbaca di atas foto:

```
Direction: 90° (left → right)
Stop 0%   : #1961A5 opacity 95%
Stop 100% : transparent
```

### Panel Login (Kiri)

```
Direction: 135°
Stop 0%   : #2782C9
Stop 50%  : #1561A8
Stop 100% : #0A2F5C
```

### Fallback Thumbnail Berita (Tanpa Gambar)

```
Direction: 135°
Stop 0%   : #1B6EBB
Stop 100% : #003D75
```

---

## Status & Feedback

Setiap status punya 3 layer: **surface** (background), **border**, dan **text/icon**.

### Sukses / Lunas

| Layer | Hex | Tailwind |
|-------|-----|----------|
| Surface | `#ECFDF5` | emerald-50 |
| Border | `#A7F3D0` | emerald-200 |
| Text | `#047857` | emerald-700 |

Dipakai di: badge tagihan lunas, transaksi berhasil, indikator QRIS aktif.

### Pending / Menunggu

| Layer | Hex | Tailwind |
|-------|-----|----------|
| Surface | `#FFFBEB` | amber-50 |
| Border | `#FDE68A` | amber-200 |
| Text | `#B45309` | amber-700 |

Dipakai di: status menunggu pembayaran, jatuh tempo, instruksi scan QRIS.

### Gagal / Gangguan Padam

| Layer | Hex | Tailwind |
|-------|-----|----------|
| Surface | `#FEF2F2` | red-50 |
| Border | `#FECACA` | red-200 |
| Text | `#DC2626` | red-600 |
| Button | `#EF4444` | red-500 |

Dipakai di: laporan listrik padam, gagal bayar, tombol hapus.

---

## Neutral (Skala Slate)

| Token | Hex | Tailwind | Fungsi |
|-------|-----|----------|--------|
| Text Heading | `#0F172A` | slate-900 | Judul halaman, angka besar, total harga |
| Text Body | `#1E293B` | slate-800 | Paragraf utama, subjudul kartu |
| Text Secondary | `#334155` | slate-700 | Label form, teks tabel, deskripsi |
| Text Muted | `#64748B` | slate-500 | Tanggal, keterangan, hint |
| Text Disabled | `#94A3B8` | slate-400 | Placeholder, icon pasif |
| Border Default | `#E2E8F0` | slate-200 | Border kartu, divider, outline input |
| Border Subtle | `#F1F5F9` | slate-100 | Divider tipis, grid line chart |
| Surface Canvas | `#F8FAFC` | slate-50 | Background halaman |
| Surface Card | `#FFFFFF` | white | Background kartu, modal, form |

---

## Section Background

| Hex | Konteks |
|-----|---------|
| `#EFF3F8` | Section FAQ beranda |
| `#CCDFF2` | Section "Apa itu PLN DIGI?" |
| `#B8D4EE` | Overlay foto di section tersebut (opacity 40%) |

---

## Gamifikasi (PLN Reward Tier)

Warna ini dinamis dari backend berdasarkan total poin pelanggan.

| Tier | Hex | Syarat Poin |
|------|-----|-------------|
| Gold | `#FFD700` | ≥ 5.000 |
| Silver | `#C0C0C0` | ≥ 2.000 |
| Bronze | `#CD7F32` | < 2.000 |

---

## Drop Shadow & Glow

Spesifikasi efek untuk diterjemahkan ke Figma.

| Elemen | Warna | Opacity | X | Y | Blur | Spread |
|--------|-------|---------|---|---|------|--------|
| Indikator navbar aktif | `#FDB813` | 50% | 0 | 0 | 8 | 0 |
| Floating icon pill hero | `#FDB813` | 45% | 0 | 0 | 20 | 0 |
| Shadow panel foto hero | `#FDB813` | 12% | -10 | 0 | 40 | 0 |
| Glass card "Apa itu PLN" | `#003C78` | 12% | 0 | 8 | 48 | 0 |

Border khusus:

| Elemen | Warna | Opacity | Ketebalan |
|--------|-------|---------|-----------|
| Border lengkung foto hero | `#FDB813` | 35% | 2px |

---

## Chart Monitoring KWh

| Peran | Warna | Opacity |
|-------|-------|---------|
| Garis grafik | `#00529C` | 75% |
| Area fill di bawah garis | `#FDB813` | 10% |
| Grid lines | `#F1F5F9` | 100% |

---

## QRIS Code Generator

| Peran | Hex |
|-------|-----|
| Pixel gelap | `#0F172A` |
| Pixel terang | `#FFFFFF` |
