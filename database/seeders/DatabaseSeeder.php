<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\MeterReading;
use App\Models\News;
use App\Models\OutageReport;
use App\Models\PaymentMethod;
use App\Models\Tariff;
use App\Models\TariffCategory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── 1. USERS ───────────────────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin PLN',
            'email'    => 'admin@plndigi.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        $user = User::create([
            'name'     => 'Hafizh Wijdan',
            'email'    => 'hafizh@mail.com',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        // ─── 2. TARIFF CATEGORIES ───────────────────────────────────────────────
        $catR = TariffCategory::create(['kode' => 'R', 'nama' => 'Rumah Tangga',  'deskripsi' => 'Tarif untuk keperluan rumah tangga']);
        $catB = TariffCategory::create(['kode' => 'B', 'nama' => 'Bisnis',        'deskripsi' => 'Tarif untuk keperluan bisnis dan komersial']);
        $catI = TariffCategory::create(['kode' => 'I', 'nama' => 'Industri',      'deskripsi' => 'Tarif untuk keperluan industri besar']);
        $catS = TariffCategory::create(['kode' => 'S', 'nama' => 'Sosial',        'deskripsi' => 'Tarif untuk keperluan sosial (sekolah, rumah sakit, dll)']);

        // ─── 3. TARIFFS ─────────────────────────────────────────────────────────
        $tariffs = [
            // Rumah Tangga (subsidi)
            ['tariff_category_id' => $catR->id, 'kode' => 'R1-450',  'nama' => 'Rumah Tangga 450VA',  'daya_va' => 450,  'harga_per_kwh' => 415,   'biaya_beban' => 11000,  'biaya_pasang' => 385000,  'biaya_admin' => 50000,  'is_subsidi' => true],
            ['tariff_category_id' => $catR->id, 'kode' => 'R1-900',  'nama' => 'Rumah Tangga 900VA',  'daya_va' => 900,  'harga_per_kwh' => 605,   'biaya_beban' => 20000,  'biaya_pasang' => 590000,  'biaya_admin' => 50000,  'is_subsidi' => true],
            // Rumah Tangga (non-subsidi)
            ['tariff_category_id' => $catR->id, 'kode' => 'R1-1300', 'nama' => 'Rumah Tangga 1300VA', 'daya_va' => 1300, 'harga_per_kwh' => 1444.7,'biaya_beban' => 40500,  'biaya_pasang' => 960000,  'biaya_admin' => 75000,  'is_subsidi' => false],
            ['tariff_category_id' => $catR->id, 'kode' => 'R1-2200', 'nama' => 'Rumah Tangga 2200VA', 'daya_va' => 2200, 'harga_per_kwh' => 1444.7,'biaya_beban' => 67500,  'biaya_pasang' => 1500000, 'biaya_admin' => 75000,  'is_subsidi' => false],
            ['tariff_category_id' => $catR->id, 'kode' => 'R2-3500', 'nama' => 'Rumah Tangga 3500VA', 'daya_va' => 3500, 'harga_per_kwh' => 1699.53,'biaya_beban' => 105000, 'biaya_pasang' => 2500000, 'biaya_admin' => 100000, 'is_subsidi' => false],
            ['tariff_category_id' => $catR->id, 'kode' => 'R3-6600', 'nama' => 'Rumah Tangga 6600VA', 'daya_va' => 6600, 'harga_per_kwh' => 1699.53,'biaya_beban' => 189000, 'biaya_pasang' => 4500000, 'biaya_admin' => 100000, 'is_subsidi' => false],
            // Bisnis
            ['tariff_category_id' => $catB->id, 'kode' => 'B1-6600', 'nama' => 'Bisnis 6600VA',       'daya_va' => 6600, 'harga_per_kwh' => 1444.7,'biaya_beban' => 189000, 'biaya_pasang' => 4200000, 'biaya_admin' => 150000, 'is_subsidi' => false],
            ['tariff_category_id' => $catB->id, 'kode' => 'B2-10K',  'nama' => 'Bisnis 10.600VA',     'daya_va' => 10600,'harga_per_kwh' => 1699.53,'biaya_beban' => 304200, 'biaya_pasang' => 6500000, 'biaya_admin' => 150000, 'is_subsidi' => false],
            // Sosial
            ['tariff_category_id' => $catS->id, 'kode' => 'S2-900',  'nama' => 'Sosial 900VA',        'daya_va' => 900,  'harga_per_kwh' => 605,   'biaya_beban' => 18000,  'biaya_pasang' => 590000,  'biaya_admin' => 50000,  'is_subsidi' => true],
        ];

        $tariffModels = [];
        foreach ($tariffs as $t) {
            $tariffModels[$t['kode']] = Tariff::create($t);
        }

        // ─── 4. PAYMENT METHODS ─────────────────────────────────────────────────
        $methods = [
            ['kode' => 'qris',     'nama' => 'QRIS',           'icon' => 'qris',     'is_active' => true],
            ['kode' => 'gopay',    'nama' => 'GoPay',          'icon' => 'gopay',    'is_active' => true],
            ['kode' => 'ovo',      'nama' => 'OVO',            'icon' => 'ovo',      'is_active' => true],
            ['kode' => 'dana',     'nama' => 'DANA',           'icon' => 'dana',     'is_active' => true],
            ['kode' => 'bca',      'nama' => 'Transfer BCA',   'icon' => 'bca',      'is_active' => true],
            ['kode' => 'mandiri',  'nama' => 'Transfer Mandiri','icon' => 'mandiri', 'is_active' => true],
            ['kode' => 'bni',      'nama' => 'Transfer BNI',   'icon' => 'bni',      'is_active' => true],
            ['kode' => 'cash',     'nama' => 'Tunai',          'icon' => 'cash',     'is_active' => false],
        ];

        $payMethods = [];
        foreach ($methods as $m) {
            $payMethods[$m['kode']] = PaymentMethod::create($m);
        }

        // ─── 5. CUSTOMERS ────────────────────────────────────────────────────────
        $customersData = [
            ['user_id' => $user->id, 'tariff_id' => $tariffModels['R1-1300']->id, 'id_pelanggan' => '531200012345', 'nama' => 'Hafizh Wijdan',   'alamat' => 'Jl. Merdeka No. 10, Jakarta Pusat',     'nomor_telepon' => '081234567890', 'email' => 'hafizh@mail.com'],
            ['user_id' => null,      'tariff_id' => $tariffModels['R1-2200']->id, 'id_pelanggan' => '531200026789', 'nama' => 'Budi Santoso',    'alamat' => 'Jl. Sudirman No. 25, Bandung',          'nomor_telepon' => '082345678901', 'email' => null],
            ['user_id' => null,      'tariff_id' => $tariffModels['R1-900']->id,  'id_pelanggan' => '531200031122', 'nama' => 'Siti Rahayu',     'alamat' => 'Jl. Gatot Subroto No. 5, Surabaya',    'nomor_telepon' => '083456789012', 'email' => null],
            ['user_id' => null,      'tariff_id' => $tariffModels['B1-6600']->id, 'id_pelanggan' => '531200043344', 'nama' => 'Ahmad Fauzi',     'alamat' => 'Jl. Diponegoro No. 15, Semarang',      'nomor_telepon' => '084567890123', 'email' => 'ahmad@bisnis.com'],
            ['user_id' => null,      'tariff_id' => $tariffModels['R1-1300']->id, 'id_pelanggan' => '531200055566', 'nama' => 'Dewi Lestari',    'alamat' => 'Jl. Ahmad Yani No. 30, Medan',         'nomor_telepon' => '085678901234', 'email' => null],
            ['user_id' => null,      'tariff_id' => $tariffModels['R1-450']->id,  'id_pelanggan' => '531200066677', 'nama' => 'Rizky Pratama',   'alamat' => 'Jl. Pahlawan No. 8, Yogyakarta',       'nomor_telepon' => '086789012345', 'email' => null],
            ['user_id' => null,      'tariff_id' => $tariffModels['R2-3500']->id, 'id_pelanggan' => '531200077788', 'nama' => 'Anita Susanti',   'alamat' => 'Jl. Pemuda No. 50, Makassar',          'nomor_telepon' => '087890123456', 'email' => null],
            ['user_id' => null,      'tariff_id' => $tariffModels['S2-900']->id,  'id_pelanggan' => '531200088899', 'nama' => 'SDN Merdeka 01',  'alamat' => 'Jl. Pendidikan No. 1, Bandung',        'nomor_telepon' => '088901234567', 'email' => 'sdn.merdeka@mail.com'],
        ];

        $customerModels = [];
        foreach ($customersData as $c) {
            $customerModels[] = Customer::create($c);
        }

        // ─── 6. METER READINGS ──────────────────────────────────────────────────
        // Data baca meteran untuk 3 bulan terakhir (per customer)
        $now = now();
        $meterData = [
            // customer[0] - Hafizh, R1-1300
            ['customer_id' => $customerModels[0]->id, 'bulan' => $now->copy()->subMonths(2)->month, 'tahun' => $now->copy()->subMonths(2)->year, 'meteran_awal' => 1250, 'meteran_akhir' => 1447, 'status' => 'billed'],
            ['customer_id' => $customerModels[0]->id, 'bulan' => $now->copy()->subMonth()->month,   'tahun' => $now->copy()->subMonth()->year,   'meteran_awal' => 1447, 'meteran_akhir' => 1645, 'status' => 'billed'],
            ['customer_id' => $customerModels[0]->id, 'bulan' => $now->month,                       'tahun' => $now->year,                       'meteran_awal' => 1645, 'meteran_akhir' => 1843, 'status' => 'billed'],
            // customer[1] - Budi, R1-2200
            ['customer_id' => $customerModels[1]->id, 'bulan' => $now->copy()->subMonth()->month,   'tahun' => $now->copy()->subMonth()->year,   'meteran_awal' => 3200, 'meteran_akhir' => 3512, 'status' => 'billed'],
            ['customer_id' => $customerModels[1]->id, 'bulan' => $now->month,                       'tahun' => $now->year,                       'meteran_awal' => 3512, 'meteran_akhir' => 3820, 'status' => 'verified'],
            // customer[2] - Siti, R1-900
            ['customer_id' => $customerModels[2]->id, 'bulan' => $now->copy()->subMonth()->month,   'tahun' => $now->copy()->subMonth()->year,   'meteran_awal' => 890,  'meteran_akhir' => 1022, 'status' => 'billed'],
            ['customer_id' => $customerModels[2]->id, 'bulan' => $now->month,                       'tahun' => $now->year,                       'meteran_awal' => 1022, 'meteran_akhir' => 1150, 'status' => 'verified'],
            // customer[3] - Ahmad (Bisnis)
            ['customer_id' => $customerModels[3]->id, 'bulan' => $now->copy()->subMonth()->month,   'tahun' => $now->copy()->subMonth()->year,   'meteran_awal' => 7800, 'meteran_akhir' => 8350, 'status' => 'billed'],
            ['customer_id' => $customerModels[3]->id, 'bulan' => $now->month,                       'tahun' => $now->year,                       'meteran_awal' => 8350, 'meteran_akhir' => 8900, 'status' => 'verified'],
            // customer[4] - Dewi
            ['customer_id' => $customerModels[4]->id, 'bulan' => $now->month,                       'tahun' => $now->year,                       'meteran_awal' => 2100, 'meteran_akhir' => 2320, 'status' => 'verified'],
        ];

        $meterModels = [];
        foreach ($meterData as $m) {
            $meterModels[] = MeterReading::create($m);
        }

        // ─── 7. BILLS ────────────────────────────────────────────────────────────
        // Tagihan berdasarkan meter readings berstatus 'billed'
        $billedMeters = array_filter($meterModels, fn($m) => $m->status === 'billed');

        $billsData = [
            // Hafizh - 2 bulan lalu (sudah lunas)
            ['customer_id' => $customerModels[0]->id, 'meter_reading_id' => $meterModels[0]->id,
             'bulan' => $meterModels[0]->bulan, 'tahun' => $meterModels[0]->tahun,
             'total_kwh' => 197, 'total_biaya' => 284606.9, 'denda' => 0, 'status' => 'paid',
             'tanggal_jatuh_tempo' => $now->copy()->subMonths(2)->endOfMonth()->toDateString(),
             'tanggal_bayar' => $now->copy()->subMonths(2)->subDays(5)->toDateString()],
            // Hafizh - bulan lalu (belum lunas)
            ['customer_id' => $customerModels[0]->id, 'meter_reading_id' => $meterModels[1]->id,
             'bulan' => $meterModels[1]->bulan, 'tahun' => $meterModels[1]->tahun,
             'total_kwh' => 198, 'total_biaya' => 286050.6, 'denda' => 0, 'status' => 'unpaid',
             'tanggal_jatuh_tempo' => $now->copy()->subMonth()->endOfMonth()->toDateString(),
             'tanggal_bayar' => null],
            // Hafizh - bulan berjalan (belum lunas)
            ['customer_id' => $customerModels[0]->id, 'meter_reading_id' => $meterModels[2]->id,
             'bulan' => $meterModels[2]->bulan, 'tahun' => $meterModels[2]->tahun,
             'total_kwh' => 198, 'total_biaya' => 286050.6, 'denda' => 0, 'status' => 'unpaid',
             'tanggal_jatuh_tempo' => $now->copy()->endOfMonth()->toDateString(),
             'tanggal_bayar' => null],
            // Budi - bulan lalu (belum lunas)
            ['customer_id' => $customerModels[1]->id, 'meter_reading_id' => $meterModels[3]->id,
             'bulan' => $meterModels[3]->bulan, 'tahun' => $meterModels[3]->tahun,
             'total_kwh' => 312, 'total_biaya' => 518237.4, 'denda' => 0, 'status' => 'unpaid',
             'tanggal_jatuh_tempo' => $now->copy()->subMonth()->endOfMonth()->toDateString(),
             'tanggal_bayar' => null],
            // Siti - bulan lalu (sudah lunas)
            ['customer_id' => $customerModels[2]->id, 'meter_reading_id' => $meterModels[5]->id,
             'bulan' => $meterModels[5]->bulan, 'tahun' => $meterModels[5]->tahun,
             'total_kwh' => 132, 'total_biaya' => 99860, 'denda' => 0, 'status' => 'paid',
             'tanggal_jatuh_tempo' => $now->copy()->subMonth()->endOfMonth()->toDateString(),
             'tanggal_bayar' => $now->copy()->subMonth()->subDays(3)->toDateString()],
            // Ahmad (Bisnis) - bulan lalu (belum lunas + denda)
            ['customer_id' => $customerModels[3]->id, 'meter_reading_id' => $meterModels[7]->id,
             'bulan' => $meterModels[7]->bulan, 'tahun' => $meterModels[7]->tahun,
             'total_kwh' => 550, 'total_biaya' => 983908.5, 'denda' => 50000, 'status' => 'overdue',
             'tanggal_jatuh_tempo' => $now->copy()->subMonths(2)->endOfMonth()->toDateString(),
             'tanggal_bayar' => null],
        ];

        $billModels = [];
        foreach ($billsData as $b) {
            $billModels[] = Bill::create($b);
        }

        // ─── 8. TRANSACTIONS ─────────────────────────────────────────────────────
        $transactions = [
            // Pembayaran tagihan Hafizh 2 bulan lalu (success)
            ['user_id' => $user->id, 'customer_id' => $customerModels[0]->id, 'bill_id' => $billModels[0]->id,
             'payment_method_id' => $payMethods['qris']->id,
             'type' => 'tagihan', 'amount' => 284606.9, 'status' => 'success',
             'no_meter' => '531200012345', 'ref_number' => 'TRX-' . now()->format('Ymd') . '-00001'],
            // Pembayaran tagihan Siti (success)
            ['user_id' => $user->id, 'customer_id' => $customerModels[2]->id, 'bill_id' => $billModels[3]->id,
             'payment_method_id' => $payMethods['gopay']->id,
             'type' => 'tagihan', 'amount' => 99860, 'status' => 'success',
             'no_meter' => '531200031122', 'ref_number' => 'TRX-' . now()->format('Ymd') . '-00002'],
            // Pembelian token Hafizh
            ['user_id' => $user->id, 'customer_id' => $customerModels[0]->id, 'bill_id' => null,
             'payment_method_id' => $payMethods['ovo']->id,
             'type' => 'token', 'amount' => 50000, 'nominal' => '50000', 'status' => 'success',
             'no_meter' => '531200012345', 'ref_number' => 'TRX-' . now()->format('Ymd') . '-00003',
             'token_listrik' => '1234 5678 9012 3456 7890'],
            // Simulasi pembayaran gagal
            ['user_id' => $user->id, 'customer_id' => null, 'bill_id' => null,
             'payment_method_id' => $payMethods['bca']->id,
             'type' => 'token', 'amount' => 100000, 'nominal' => '100000', 'status' => 'failed',
             'no_meter' => '999900001111', 'ref_number' => 'TRX-' . now()->format('Ymd') . '-00004'],
        ];

        foreach ($transactions as $t) {
            Transaction::create($t);
        }

        // ─── 9. NEWS ─────────────────────────────────────────────────────────────
        $newsData = [
            [
                'judul'        => 'PLN Hadirkan Layanan Digital Terintegrasi untuk Pelanggan',
                'slug'         => 'pln-hadirkan-layanan-digital-terintegrasi',
                'konten'       => 'PT PLN (Persero) terus berinovasi dalam menghadirkan layanan digital yang terintegrasi untuk kemudahan pelanggan. Melalui aplikasi PLN DIGI, pelanggan kini dapat mengakses berbagai layanan kelistrikan seperti pembayaran tagihan, pembelian token, pelaporan gangguan, hingga monitoring pemakaian listrik secara real-time.\n\nInovasi ini merupakan bagian dari transformasi digital PLN yang bertujuan untuk meningkatkan kualitas pelayanan dan kepuasan pelanggan. Dengan PLN DIGI, seluruh kebutuhan kelistrikan dapat dikelola dalam satu platform yang mudah dan efisien.',
                'kategori'     => 'info',
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'judul'        => 'Promo Cashback 10% untuk Pembelian Token Listrik',
                'slug'         => 'promo-cashback-10-persen-token',
                'konten'       => 'Dapatkan cashback 10% untuk setiap pembelian token listrik melalui PLN DIGI! Promo berlaku mulai 1 hingga 30 September 2026.\n\nSyarat dan ketentuan:\n- Minimal pembelian token Rp 50.000\n- Maksimal cashback Rp 25.000 per transaksi\n- Berlaku untuk semua metode pembayaran\n- Cashback akan dikreditkan dalam 3x24 jam\n\nJangan lewatkan kesempatan ini! Beli token listrik sekarang dan nikmati cashback-nya.',
                'kategori'     => 'promo',
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'judul'        => 'Pemeliharaan Jaringan Listrik Area Jakarta Selatan',
                'slug'         => 'pemeliharaan-jaringan-jakarta-selatan',
                'konten'       => 'Informasi penting untuk pelanggan PLN di wilayah Jakarta Selatan. PLN akan melaksanakan pemeliharaan jaringan listrik pada:\n\nTanggal: 20 September 2026\nWaktu: 08:00 - 14:00 WIB\nArea: Kebayoran Baru, Cilandak, Pasar Minggu\n\nSelama pemeliharaan berlangsung, pasokan listrik di area tersebut akan terganggu sementara. PLN mohon maaf atas ketidaknyamanan yang ditimbulkan. Pemeliharaan ini dilakukan untuk meningkatkan keandalan sistem kelistrikan di wilayah tersebut.',
                'kategori'     => 'gangguan',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'judul'        => '5 Tips Hemat Listrik di Rumah yang Mudah Diterapkan',
                'slug'         => '5-tips-hemat-listrik-rumah',
                'konten'       => 'Menghemat listrik bukan hanya baik untuk kantong Anda, tapi juga untuk lingkungan. Berikut 5 tips sederhana yang bisa langsung Anda terapkan:\n\n1. Gunakan Lampu LED\nGanti lampu pijar dengan LED yang lebih hemat energi hingga 80%.\n\n2. Cabut Charger yang Tidak Digunakan\nCharger yang tetap tersambung ke listrik tetap mengonsumsi daya meskipun tidak mengisi perangkat.\n\n3. Atur Suhu AC pada 24-26°C\nSuhu ini adalah suhu optimal yang nyaman dan hemat energi.\n\n4. Manfaatkan Cahaya Alami\nBuka tirai dan gunakan cahaya matahari di siang hari.\n\n5. Gunakan Timer pada Peralatan Elektronik\nAtur timer untuk mematikan peralatan secara otomatis saat tidak diperlukan.',
                'kategori'     => 'tips',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'judul'        => 'PLN Raih Penghargaan Best Digital Innovation 2026',
                'slug'         => 'pln-raih-penghargaan-digital-innovation',
                'konten'       => 'PT PLN (Persero) berhasil meraih penghargaan Best Digital Innovation 2026 dalam ajang Indonesia Digital Awards. Penghargaan ini diberikan atas keberhasilan PLN dalam mentransformasi layanan kelistrikan melalui platform digital.\n\nDirektur Utama PLN menyampaikan bahwa penghargaan ini menjadi motivasi untuk terus berinovasi dan memberikan layanan terbaik kepada seluruh pelanggan di Indonesia. PLN berkomitmen untuk terus mengembangkan teknologi digital demi kemudahan dan kenyamanan pelanggan.',
                'kategori'     => 'info',
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'judul'        => 'Gratis Biaya Admin untuk Pelanggan Baru PLN DIGI',
                'slug'         => 'gratis-biaya-admin-pelanggan-baru',
                'konten'       => 'Kabar gembira untuk pelanggan baru PLN DIGI! Dapatkan gratis biaya administrasi untuk 3 transaksi pertama Anda.\n\nPromo ini berlaku untuk:\n- Pembayaran tagihan listrik\n- Pembelian token listrik\n\nDaftar sekarang di PLN DIGI dan nikmati kemudahan mengelola kelistrikan Anda!',
                'kategori'     => 'promo',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
        ];

        foreach ($newsData as $n) {
            News::create($n);
        }

        // ─── 10. OUTAGE REPORTS ──────────────────────────────────────────────────
        $outages = [
            [
                'user_id'     => $user->id,
                'customer_id' => $customerModels[0]->id,
                'kategori'    => 'padam_total',
                'deskripsi'   => 'Listrik padam total sejak jam 20:00 WIB malam ini. Seluruh rumah di RT 03 mengalami hal yang sama. Sudah cek MCB dan tidak ada yang trip.',
                'lokasi'      => 'Jl. Merdeka No. 10, RT 03/05, Jakarta Pusat',
                'status'      => 'selesai',
                'catatan_petugas' => 'Gangguan telah diperbaiki. Penyebab: kabel putus di gardu distribusi terdekat.',
            ],
            [
                'user_id'     => $user->id,
                'customer_id' => $customerModels[0]->id,
                'kategori'    => 'tegangan_rendah',
                'deskripsi'   => 'Tegangan listrik tidak stabil sejak 2 hari terakhir. Lampu redup dan AC tidak bisa menyala normal.',
                'lokasi'      => 'Jl. Merdeka No. 10, RT 03/05, Jakarta Pusat',
                'status'      => 'diproses',
                'catatan_petugas' => 'Petugas sedang melakukan pengecekan di gardu induk area.',
            ],
            [
                'user_id'     => $user->id,
                'customer_id' => null,
                'kategori'    => 'meteran_rusak',
                'deskripsi'   => 'Display meteran digital menampilkan error dan angka tidak berubah meski listrik terpakai.',
                'lokasi'      => 'Jl. Sudirman No. 25, Bandung',
                'status'      => 'dilaporkan',
                'catatan_petugas' => null,
            ],
        ];

        foreach ($outages as $o) {
            OutageReport::create($o);
        }
    }
}
