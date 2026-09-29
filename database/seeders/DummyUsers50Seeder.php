<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\MeterReading;
use App\Models\OutageReport;
use App\Models\PaymentMethod;
use App\Models\RewardClaim;
use App\Models\Tariff;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyUsers50Seeder extends Seeder
{
    /**
     * Run the database seeds for 50 dummy users with various real-world scenarios.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $defaultPassword = Hash::make('password');

        $tariffs = Tariff::all()->keyBy('kode');

        $userDataList = array (
  0 => 
  array (
    'name' => 'Bambang Sudarsono',
    'email' => 'bambang.s@plndigi.com',
    'case' => 'pascabayar_tertib',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Jakarta Selatan',
    'prov' => 'DKI Jakarta',
    'kode_id' => '5311',
  ),
  1 => 
  array (
    'name' => 'Siti Nurhaliza Putri',
    'email' => 'siti.nur@plndigi.com',
    'case' => 'pascabayar_tertib',
    'tariff' => 'R1-900',
    'daya' => 900,
    'kota' => 'Bandung',
    'prov' => 'Jawa Barat',
    'kode_id' => '5321',
  ),
  2 => 
  array (
    'name' => 'Hendra Gunawan',
    'email' => 'hendra.g@plndigi.com',
    'case' => 'pascabayar_tertib',
    'tariff' => 'R1-2200',
    'daya' => 2200,
    'kota' => 'Surabaya',
    'prov' => 'Jawa Timur',
    'kode_id' => '5331',
  ),
  3 => 
  array (
    'name' => 'Rina Agustina',
    'email' => 'rina.agustina@plndigi.com',
    'case' => 'pascabayar_tertib',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Semarang',
    'prov' => 'Jawa Tengah',
    'kode_id' => '5341',
  ),
  4 => 
  array (
    'name' => 'Dimas Arya Pratama',
    'email' => 'dimas.arya@plndigi.com',
    'case' => 'pascabayar_tertib',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Yogyakarta',
    'prov' => 'DI Yogyakarta',
    'kode_id' => '5342',
  ),
  5 => 
  array (
    'name' => 'Maya Indah Safitri',
    'email' => 'maya.indah@plndigi.com',
    'case' => 'pascabayar_tertib',
    'tariff' => 'R1-900',
    'daya' => 900,
    'kota' => 'Medan',
    'prov' => 'Sumatera Utara',
    'kode_id' => '5351',
  ),
  6 => 
  array (
    'name' => 'Joko Tri Wahyudi',
    'email' => 'joko.tri@plndigi.com',
    'case' => 'pascabayar_tertib',
    'tariff' => 'R1-2200',
    'daya' => 2200,
    'kota' => 'Makassar',
    'prov' => 'Sulawesi Selatan',
    'kode_id' => '5361',
  ),
  7 => 
  array (
    'name' => 'Sri Wahyuni',
    'email' => 'sri.wahyuni@plndigi.com',
    'case' => 'pascabayar_tertib',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Denpasar',
    'prov' => 'Bali',
    'kode_id' => '5371',
  ),
  8 => 
  array (
    'name' => 'Arif Budiman',
    'email' => 'arif.budiman@plndigi.com',
    'case' => 'pascabayar_tertib',
    'tariff' => 'R1-450',
    'daya' => 450,
    'kota' => 'Malang',
    'prov' => 'Jawa Timur',
    'kode_id' => '5332',
  ),
  9 => 
  array (
    'name' => 'Nurmala Sari',
    'email' => 'nurmala.sari@plndigi.com',
    'case' => 'pascabayar_tertib',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Palembang',
    'prov' => 'Sumatera Selatan',
    'kode_id' => '5381',
  ),
  10 => 
  array (
    'name' => 'Agus Priyanto',
    'email' => 'agus.priyanto@plndigi.com',
    'case' => 'pascabayar_overdue',
    'tariff' => 'R1-2200',
    'daya' => 2200,
    'kota' => 'Bekasi',
    'prov' => 'Jawa Barat',
    'kode_id' => '5322',
  ),
  11 => 
  array (
    'name' => 'Tri Handayani',
    'email' => 'tri.handayani@plndigi.com',
    'case' => 'pascabayar_overdue',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Jakarta Timur',
    'prov' => 'DKI Jakarta',
    'kode_id' => '5313',
  ),
  12 => 
  array (
    'name' => 'Wawan Kurniawan',
    'email' => 'wawan.kurnia@plndigi.com',
    'case' => 'pascabayar_overdue',
    'tariff' => 'R2-3500',
    'daya' => 3500,
    'kota' => 'Bandung',
    'prov' => 'Jawa Barat',
    'kode_id' => '5321',
  ),
  13 => 
  array (
    'name' => 'Ratna Juwita',
    'email' => 'ratna.juwita@plndigi.com',
    'case' => 'pascabayar_overdue',
    'tariff' => 'R1-900',
    'daya' => 900,
    'kota' => 'Surabaya',
    'prov' => 'Jawa Timur',
    'kode_id' => '5331',
  ),
  14 => 
  array (
    'name' => 'Dedi Iskandar',
    'email' => 'dedi.iskandar@plndigi.com',
    'case' => 'pascabayar_overdue',
    'tariff' => 'R1-2200',
    'daya' => 2200,
    'kota' => 'Tangerang',
    'prov' => 'Banten',
    'kode_id' => '5314',
  ),
  15 => 
  array (
    'name' => 'Endang Sulastri',
    'email' => 'endang.sulastri@plndigi.com',
    'case' => 'pascabayar_overdue',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Cimahi',
    'prov' => 'Jawa Barat',
    'kode_id' => '5323',
  ),
  16 => 
  array (
    'name' => 'Ferry Andika',
    'email' => 'ferry.andika@plndigi.com',
    'case' => 'pascabayar_overdue',
    'tariff' => 'R2-3500',
    'daya' => 3500,
    'kota' => 'Batam',
    'prov' => 'Kepulauan Riau',
    'kode_id' => '5352',
  ),
  17 => 
  array (
    'name' => 'CV Abadi Surya Makmur',
    'email' => 'surya.abadi@plndigi.com',
    'case' => 'pascabayar_overdue_bisnis',
    'tariff' => 'B1-6600',
    'daya' => 6600,
    'kota' => 'Surabaya',
    'prov' => 'Jawa Timur',
    'kode_id' => '5331',
  ),
  18 => 
  array (
    'name' => 'Bayu Wicaksono',
    'email' => 'bayu.wicaksono@plndigi.com',
    'case' => 'prabayar_token',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Jakarta Barat',
    'prov' => 'DKI Jakarta',
    'kode_id' => '5315',
  ),
  19 => 
  array (
    'name' => 'Dian Kusuma Wardani',
    'email' => 'dian.kusuma@plndigi.com',
    'case' => 'prabayar_token',
    'tariff' => 'R1-900',
    'daya' => 900,
    'kota' => 'Surakarta',
    'prov' => 'Jawa Tengah',
    'kode_id' => '5343',
  ),
  20 => 
  array (
    'name' => 'Fajar Nugroho',
    'email' => 'fajar.nugroho@plndigi.com',
    'case' => 'prabayar_token',
    'tariff' => 'R1-2200',
    'daya' => 2200,
    'kota' => 'Depok',
    'prov' => 'Jawa Barat',
    'kode_id' => '5324',
  ),
  21 => 
  array (
    'name' => 'Gita Gutawa Putri',
    'email' => 'gita.putri@plndigi.com',
    'case' => 'prabayar_token',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Bogor',
    'prov' => 'Jawa Barat',
    'kode_id' => '5325',
  ),
  22 => 
  array (
    'name' => 'Ilham Maulana',
    'email' => 'ilham.maulana@plndigi.com',
    'case' => 'prabayar_token',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Padang',
    'prov' => 'Sumatera Barat',
    'kode_id' => '5353',
  ),
  23 => 
  array (
    'name' => 'Lestari Handoko',
    'email' => 'lestari.handoko@plndigi.com',
    'case' => 'prabayar_token',
    'tariff' => 'R1-900',
    'daya' => 900,
    'kota' => 'Pekanbaru',
    'prov' => 'Riau',
    'kode_id' => '5354',
  ),
  24 => 
  array (
    'name' => 'Reza Fahlevi',
    'email' => 'reza.fahlevi@plndigi.com',
    'case' => 'prabayar_token',
    'tariff' => 'R1-2200',
    'daya' => 2200,
    'kota' => 'Balikpapan',
    'prov' => 'Kalimantan Timur',
    'kode_id' => '5362',
  ),
  25 => 
  array (
    'name' => 'Sinta Maharani',
    'email' => 'sinta.maharani@plndigi.com',
    'case' => 'prabayar_token',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Pontianak',
    'prov' => 'Kalimantan Barat',
    'kode_id' => '5363',
  ),
  26 => 
  array (
    'name' => 'Kevin Sanjaya Sukamuljo',
    'email' => 'kevin.sanjaya@plndigi.com',
    'case' => 'fresh_user',
    'tariff' => NULL,
    'daya' => NULL,
    'kota' => 'Jakarta Utara',
    'prov' => 'DKI Jakarta',
    'kode_id' => '5316',
  ),
  27 => 
  array (
    'name' => 'Jessica Mila Agnesia',
    'email' => 'jessica.mila@plndigi.com',
    'case' => 'fresh_user',
    'tariff' => NULL,
    'daya' => NULL,
    'kota' => 'Jakarta Selatan',
    'prov' => 'DKI Jakarta',
    'kode_id' => '5312',
  ),
  28 => 
  array (
    'name' => 'Aditya Bagus Panuntun',
    'email' => 'aditya.bagus@plndigi.com',
    'case' => 'fresh_user',
    'tariff' => NULL,
    'daya' => NULL,
    'kota' => 'Bandung',
    'prov' => 'Jawa Barat',
    'kode_id' => '5321',
  ),
  29 => 
  array (
    'name' => 'Nadia Syahrini',
    'email' => 'nadia.syahrini@plndigi.com',
    'case' => 'fresh_user',
    'tariff' => NULL,
    'daya' => NULL,
    'kota' => 'Semarang',
    'prov' => 'Jawa Tengah',
    'kode_id' => '5341',
  ),
  30 => 
  array (
    'name' => 'Randi Ramadhan',
    'email' => 'randi.ramadhan@plndigi.com',
    'case' => 'fresh_user',
    'tariff' => NULL,
    'daya' => NULL,
    'kota' => 'Surabaya',
    'prov' => 'Jawa Timur',
    'kode_id' => '5331',
  ),
  31 => 
  array (
    'name' => 'Tiara Andini Permata',
    'email' => 'tiara.andini@plndigi.com',
    'case' => 'fresh_user',
    'tariff' => NULL,
    'daya' => NULL,
    'kota' => 'Jember',
    'prov' => 'Jawa Timur',
    'kode_id' => '5333',
  ),
  32 => 
  array (
    'name' => 'Eko Prasetyo',
    'email' => 'eko.prasetyo@plndigi.com',
    'case' => 'metering_pending',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Tangerang Selatan',
    'prov' => 'Banten',
    'kode_id' => '5317',
  ),
  33 => 
  array (
    'name' => 'Yuni Shara Kusuma',
    'email' => 'yuni.shara@plndigi.com',
    'case' => 'metering_pending',
    'tariff' => 'R1-2200',
    'daya' => 2200,
    'kota' => 'Batu',
    'prov' => 'Jawa Timur',
    'kode_id' => '5334',
  ),
  34 => 
  array (
    'name' => 'Gunawan Wibisono',
    'email' => 'gunawan.w@plndigi.com',
    'case' => 'metering_pending',
    'tariff' => 'R1-900',
    'daya' => 900,
    'kota' => 'Cirebon',
    'prov' => 'Jawa Barat',
    'kode_id' => '5326',
  ),
  35 => 
  array (
    'name' => 'Dewi Persik Cahyani',
    'email' => 'dewi.persik@plndigi.com',
    'case' => 'metering_verified',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Sidoarjo',
    'prov' => 'Jawa Timur',
    'kode_id' => '5335',
  ),
  36 => 
  array (
    'name' => 'Teguh Firmansyah',
    'email' => 'teguh.f@plndigi.com',
    'case' => 'metering_verified',
    'tariff' => 'R2-3500',
    'daya' => 3500,
    'kota' => 'Sukabumi',
    'prov' => 'Jawa Barat',
    'kode_id' => '5327',
  ),
  37 => 
  array (
    'name' => 'Mega Utami Putri',
    'email' => 'mega.utami@plndigi.com',
    'case' => 'metering_rejected',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Magelang',
    'prov' => 'Jawa Tengah',
    'kode_id' => '5344',
  ),
  38 => 
  array (
    'name' => 'Rizky Billar Pratama',
    'email' => 'rizky.billar@plndigi.com',
    'case' => 'reward_collector',
    'tariff' => 'R1-2200',
    'daya' => 2200,
    'kota' => 'Jakarta Selatan',
    'prov' => 'DKI Jakarta',
    'kode_id' => '5312',
  ),
  39 => 
  array (
    'name' => 'Anisa Rahmawati',
    'email' => 'anisa.rahma@plndigi.com',
    'case' => 'reward_collector',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Bandung',
    'prov' => 'Jawa Barat',
    'kode_id' => '5321',
  ),
  40 => 
  array (
    'name' => 'Bagus Dwi Saputra',
    'email' => 'bagus.dwi@plndigi.com',
    'case' => 'reward_collector',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Yogyakarta',
    'prov' => 'DI Yogyakarta',
    'kode_id' => '5342',
  ),
  41 => 
  array (
    'name' => 'Citra Kirana Sari',
    'email' => 'citra.kirana@plndigi.com',
    'case' => 'reward_collector',
    'tariff' => 'R2-3500',
    'daya' => 3500,
    'kota' => 'Surabaya',
    'prov' => 'Jawa Timur',
    'kode_id' => '5331',
  ),
  42 => 
  array (
    'name' => 'Danang Sutrisno',
    'email' => 'danang.s@plndigi.com',
    'case' => 'reward_collector',
    'tariff' => 'R1-2200',
    'daya' => 2200,
    'kota' => 'Semarang',
    'prov' => 'Jawa Tengah',
    'kode_id' => '5341',
  ),
  43 => 
  array (
    'name' => 'Farhan Kopi Kenangan',
    'email' => 'kopi.kenangan@plndigi.com',
    'case' => 'bisnis_komersial',
    'tariff' => 'B1-6600',
    'daya' => 6600,
    'kota' => 'Jakarta Selatan',
    'prov' => 'DKI Jakarta',
    'kode_id' => '5312',
  ),
  44 => 
  array (
    'name' => 'H. Syukur Resto Minang',
    'email' => 'resto.minang@plndigi.com',
    'case' => 'bisnis_komersial',
    'tariff' => 'B2-10K',
    'daya' => 10600,
    'kota' => 'Bandung',
    'prov' => 'Jawa Barat',
    'kode_id' => '5321',
  ),
  45 => 
  array (
    'name' => 'Erwin Jaya Percetakan',
    'email' => 'jaya.grafika@plndigi.com',
    'case' => 'bisnis_komersial',
    'tariff' => 'B1-6600',
    'daya' => 6600,
    'kota' => 'Surabaya',
    'prov' => 'Jawa Timur',
    'kode_id' => '5331',
  ),
  46 => 
  array (
    'name' => 'dr. Maya Klinik Pratama',
    'email' => 'klinik.sehat@plndigi.com',
    'case' => 'sosial_klinik',
    'tariff' => 'S2-900',
    'daya' => 900,
    'kota' => 'Medan',
    'prov' => 'Sumatera Utara',
    'kode_id' => '5351',
  ),
  47 => 
  array (
    'name' => 'Lukman Hakim',
    'email' => 'lukman.hakim@plndigi.com',
    'case' => 'outage_reporter',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Makassar',
    'prov' => 'Sulawesi Selatan',
    'kode_id' => '5361',
  ),
  48 => 
  array (
    'name' => 'Widya Ningsih',
    'email' => 'widya.ningsih@plndigi.com',
    'case' => 'outage_reporter',
    'tariff' => 'R1-2200',
    'daya' => 2200,
    'kota' => 'Denpasar',
    'prov' => 'Bali',
    'kode_id' => '5371',
  ),
  49 => 
  array (
    'name' => 'Hasan Basri',
    'email' => 'hasan.basri@plndigi.com',
    'case' => 'outage_reporter',
    'tariff' => 'R1-1300',
    'daya' => 1300,
    'kota' => 'Palembang',
    'prov' => 'Sumatera Selatan',
    'kode_id' => '5381',
  ),
);
        $streets = array (
  0 => 'Jl. Melati No. %d, RT 02/RW 05',
  1 => 'Jl. Mawar No. %d, Komplek PLN',
  2 => 'Jl. Dahlia No. %d, Kelurahan Sukamaju',
  3 => 'Jl. Kenanga Indah No. %d',
  4 => 'Jl. Cempaka Putih Raya No. %d',
  5 => 'Jl. Flamboyan No. %d, Blok B4',
  6 => 'Jl. Garuda No. %d, Perumahan Asri',
  7 => 'Jl. Rajawali Barat No. %d',
  8 => 'Jl. Diponegoro No. %d',
  9 => 'Jl. Jend. Sudirman Kav. %d',
);

        foreach ($userDataList as $idx => $u) {
            $userNum = $idx + 1;

            // 1. Create or update User
            $user = User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => $defaultPassword,
                    'role' => 'user',
                    'email_verified_at' => $now->copy()->subDays(rand(10, 100)),
                ]
            );

            // Skip customer for fresh_user
            if ($u['case'] === 'fresh_user') {
                continue;
            }

            // 2. Customer ID Pelanggan (12 digits)
            $idPelanggan = $u['kode_id'] . str_pad($userNum, 8, '0', STR_PAD_LEFT);
            $tariff = $tariffs->get($u['tariff']);
            $streetTemplate = $streets[$userNum % count($streets)];
            $alamat = sprintf($streetTemplate, rand(10, 150)) . ', ' . $u['kota'] . ', ' . $u['prov'];
            $telepon = '08' . rand(11, 23) . rand(1000000, 9999999);

            $customer = Customer::updateOrCreate(
                ['id_pelanggan' => $idPelanggan],
                [
                    'user_id' => $user->id,
                    'tariff_id' => $tariff ? $tariff->id : 3,
                    'nama' => $u['name'],
                    'alamat' => $alamat,
                    'nomor_telepon' => $telepon,
                    'email' => $u['email'],
                ]
            );

            $tarifPerKwh = $tariff ? $tariff->harga_per_kwh : 1444.7;

            // ── Case 1: Pascabayar Tertib (Tagihan 2 bulan lalu & lalu lunas, bulan ini belum bayar)
            if ($u['case'] === 'pascabayar_tertib') {
                $kwhM2 = rand(150, 220);
                $mr2 = MeterReading::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $now->copy()->subMonths(2)->month, 'tahun' => $now->copy()->subMonths(2)->year],
                    ['meteran_awal' => 1000, 'meteran_akhir' => 1000 + $kwhM2, 'status' => 'billed']
                );
                $kwhM1 = rand(150, 230);
                $mr1 = MeterReading::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $now->copy()->subMonth()->month, 'tahun' => $now->copy()->subMonth()->year],
                    ['meteran_awal' => 1000 + $kwhM2, 'meteran_akhir' => 1000 + $kwhM2 + $kwhM1, 'status' => 'billed']
                );
                $kwhCur = rand(160, 240);
                $mrCur = MeterReading::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $now->month, 'tahun' => $now->year],
                    ['meteran_awal' => 1000 + $kwhM2 + $kwhM1, 'meteran_akhir' => 1000 + $kwhM2 + $kwhM1 + $kwhCur, 'status' => 'billed']
                );

                // Tagihan 2 bulan lalu (Paid)
                $biaya2 = round($kwhM2 * $tarifPerKwh, 2);
                $b2 = Bill::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $mr2->bulan, 'tahun' => $mr2->tahun],
                    ['meter_reading_id' => $mr2->id, 'total_kwh' => $kwhM2, 'total_biaya' => $biaya2, 'denda' => 0, 'status' => 'paid', 'tanggal_jatuh_tempo' => $now->copy()->subMonths(2)->endOfMonth()->toDateString(), 'tanggal_bayar' => $now->copy()->subMonths(2)->subDays(8)->toDateString()]
                );
                Transaction::firstOrCreate(
                    ['ref_number' => 'TRX-' . $now->copy()->subMonths(2)->format('Ym') . '-' . str_pad($userNum * 10 + 1, 5, '0', STR_PAD_LEFT)],
                    ['user_id' => $user->id, 'customer_id' => $customer->id, 'bill_id' => $b2->id, 'payment_method_id' => 1, 'type' => 'tagihan', 'amount' => $biaya2, 'status' => 'success', 'no_meter' => $idPelanggan, 'created_at' => $now->copy()->subMonths(2)->subDays(8)]
                );

                // Tagihan 1 bulan lalu (Paid)
                $biaya1 = round($kwhM1 * $tarifPerKwh, 2);
                $b1 = Bill::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $mr1->bulan, 'tahun' => $mr1->tahun],
                    ['meter_reading_id' => $mr1->id, 'total_kwh' => $kwhM1, 'total_biaya' => $biaya1, 'denda' => 0, 'status' => 'paid', 'tanggal_jatuh_tempo' => $now->copy()->subMonth()->endOfMonth()->toDateString(), 'tanggal_bayar' => $now->copy()->subMonth()->subDays(5)->toDateString()]
                );
                Transaction::firstOrCreate(
                    ['ref_number' => 'TRX-' . $now->copy()->subMonth()->format('Ym') . '-' . str_pad($userNum * 10 + 2, 5, '0', STR_PAD_LEFT)],
                    ['user_id' => $user->id, 'customer_id' => $customer->id, 'bill_id' => $b1->id, 'payment_method_id' => 2, 'type' => 'tagihan', 'amount' => $biaya1, 'status' => 'success', 'no_meter' => $idPelanggan, 'created_at' => $now->copy()->subMonth()->subDays(5)]
                );

                // Tagihan Bulan Berjalan (Unpaid)
                $biayaCur = round($kwhCur * $tarifPerKwh, 2);
                Bill::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $mrCur->bulan, 'tahun' => $mrCur->tahun],
                    ['meter_reading_id' => $mrCur->id, 'total_kwh' => $kwhCur, 'total_biaya' => $biayaCur, 'denda' => 0, 'status' => 'unpaid', 'tanggal_jatuh_tempo' => $now->copy()->endOfMonth()->toDateString(), 'tanggal_bayar' => null]
                );
            }

            // ── Case 2: Pascabayar Menunggak / Overdue
            elseif ($u['case'] === 'pascabayar_overdue' || $u['case'] === 'pascabayar_overdue_bisnis') {
                $kwhM2 = rand(250, 450);
                $mr2 = MeterReading::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $now->copy()->subMonths(2)->month, 'tahun' => $now->copy()->subMonths(2)->year],
                    ['meteran_awal' => 2000, 'meteran_akhir' => 2000 + $kwhM2, 'status' => 'billed']
                );
                $kwhM1 = rand(260, 480);
                $mr1 = MeterReading::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $now->copy()->subMonth()->month, 'tahun' => $now->copy()->subMonth()->year],
                    ['meteran_awal' => 2000 + $kwhM2, 'meteran_akhir' => 2000 + $kwhM2 + $kwhM1, 'status' => 'billed']
                );
                $kwhCur = rand(270, 500);
                $mrCur = MeterReading::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $now->month, 'tahun' => $now->year],
                    ['meteran_awal' => 2000 + $kwhM2 + $kwhM1, 'meteran_akhir' => 2000 + $kwhM2 + $kwhM1 + $kwhCur, 'status' => 'billed']
                );

                $biaya2 = round($kwhM2 * $tarifPerKwh, 2);
                Bill::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $mr2->bulan, 'tahun' => $mr2->tahun],
                    ['meter_reading_id' => $mr2->id, 'total_kwh' => $kwhM2, 'total_biaya' => $biaya2, 'denda' => 50000, 'status' => 'overdue', 'tanggal_jatuh_tempo' => $now->copy()->subMonths(2)->endOfMonth()->toDateString(), 'tanggal_bayar' => null]
                );
                $biaya1 = round($kwhM1 * $tarifPerKwh, 2);
                Bill::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $mr1->bulan, 'tahun' => $mr1->tahun],
                    ['meter_reading_id' => $mr1->id, 'total_kwh' => $kwhM1, 'total_biaya' => $biaya1, 'denda' => 25000, 'status' => 'overdue', 'tanggal_jatuh_tempo' => $now->copy()->subMonth()->endOfMonth()->toDateString(), 'tanggal_bayar' => null]
                );
                $biayaCur = round($kwhCur * $tarifPerKwh, 2);
                Bill::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $mrCur->bulan, 'tahun' => $mrCur->tahun],
                    ['meter_reading_id' => $mrCur->id, 'total_kwh' => $kwhCur, 'total_biaya' => $biayaCur, 'denda' => 0, 'status' => 'unpaid', 'tanggal_jatuh_tempo' => $now->copy()->endOfMonth()->toDateString(), 'tanggal_bayar' => null]
                );
            }

            // ── Case 3: Prabayar / Token Aktif
            elseif ($u['case'] === 'prabayar_token') {
                $nominals = [50000, 100000, 200000];
                for ($k = 0; $k < 3; $k++) {
                    $nom = $nominals[$k % count($nominals)];
                    $stroom = rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999);
                    $trxDate = $now->copy()->subDays((3 - $k) * 12);
                    Transaction::firstOrCreate(
                        ['ref_number' => 'TRX-' . $trxDate->format('Ymd') . '-' . str_pad($userNum * 10 + $k + 1, 5, '0', STR_PAD_LEFT)],
                        [
                            'user_id' => $user->id,
                            'customer_id' => $customer->id,
                            'bill_id' => null,
                            'payment_method_id' => ($k % 4) + 1,
                            'type' => 'token',
                            'amount' => $nom,
                            'nominal' => (string)$nom,
                            'status' => 'success',
                            'no_meter' => $idPelanggan,
                            'token_listrik' => $stroom,
                            'created_at' => $trxDate,
                        ]
                    );
                }
            }

            // ── Case 5: Catat Meter Mandiri
            elseif (str_starts_with($u['case'], 'metering_')) {
                $statusMeter = str_replace('metering_', '', $u['case']); // pending, verified, rejected
                if ($statusMeter === 'rejected') {
                    $statusMeter = 'pending'; // Sesuai enum table: pending, verified, billed
                }

                $kwhOld = 180;
                $mrOld = MeterReading::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $now->copy()->subMonth()->month, 'tahun' => $now->copy()->subMonth()->year],
                    ['meteran_awal' => 1500, 'meteran_akhir' => 1500 + $kwhOld, 'status' => 'billed']
                );
                $kwhCur = 195;
                MeterReading::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $now->month, 'tahun' => $now->year],
                    [
                        'meteran_awal' => 1680,
                        'meteran_akhir' => 1680 + $kwhCur,
                        'status' => $statusMeter,
                    ]
                );
                $biayaOld = round($kwhOld * $tarifPerKwh, 2);
                Bill::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $mrOld->bulan, 'tahun' => $mrOld->tahun],
                    ['meter_reading_id' => $mrOld->id, 'total_kwh' => $kwhOld, 'total_biaya' => $biayaOld, 'denda' => 0, 'status' => 'paid', 'tanggal_jatuh_tempo' => $now->copy()->subMonth()->endOfMonth()->toDateString(), 'tanggal_bayar' => $now->copy()->subMonth()->subDays(6)->toDateString()]
                );
            }

            // ── Case 6: Reward Collector & Voucher Klaim
            elseif ($u['case'] === 'reward_collector') {
                for ($m = 0; $m < 4; $m++) {
                    $trxDate = $now->copy()->subDays((4 - $m) * 15);
                    Transaction::firstOrCreate(
                        ['ref_number' => 'TRX-' . $trxDate->format('Ymd') . '-' . str_pad($userNum * 10 + $m + 1, 5, '0', STR_PAD_LEFT)],
                        [
                            'user_id' => $user->id,
                            'customer_id' => $customer->id,
                            'bill_id' => null,
                            'payment_method_id' => ($m % 4) + 1,
                            'type' => 'token',
                            'amount' => 200000,
                            'nominal' => '200000',
                            'status' => 'success',
                            'no_meter' => $idPelanggan,
                            'token_listrik' => rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999),
                            'created_at' => $trxDate,
                        ]
                    );
                }

                RewardClaim::firstOrCreate(
                    ['voucher_code' => 'PLN-DISC50-' . strtoupper(substr(md5($user->id . '1'), 0, 6))],
                    [
                        'user_id' => $user->id,
                        'reward_id' => '1',
                        'nama' => 'Diskon Tagihan Listrik Rp 50.000',
                        'poin' => 250,
                        'status' => 'active',
                        'expired_at' => $now->copy()->addDays(30),
                    ]
                );
                RewardClaim::firstOrCreate(
                    ['voucher_code' => 'PLN-PLP-' . strtoupper(substr(md5($user->id . '2'), 0, 6))],
                    [
                        'user_id' => $user->id,
                        'reward_id' => '4',
                        'nama' => 'Gratis Biaya Layanan PLN Life 1 Bulan',
                        'poin' => 150,
                        'status' => 'used',
                        'expired_at' => $now->copy()->addDays(15),
                    ]
                );
            }

            // ── Case 7: Bisnis & Sosial
            elseif ($u['case'] === 'bisnis_komersial' || $u['case'] === 'sosial_klinik') {
                $kwhM1 = rand(950, 1600);
                $mr1 = MeterReading::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $now->copy()->subMonth()->month, 'tahun' => $now->copy()->subMonth()->year],
                    ['meteran_awal' => 10000, 'meteran_akhir' => 10000 + $kwhM1, 'status' => 'billed']
                );
                $kwhCur = rand(1050, 1750);
                $mrCur = MeterReading::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $now->month, 'tahun' => $now->year],
                    ['meteran_awal' => 10000 + $kwhM1, 'meteran_akhir' => 10000 + $kwhM1 + $kwhCur, 'status' => 'billed']
                );

                $biaya1 = round($kwhM1 * $tarifPerKwh, 2);
                $b1 = Bill::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $mr1->bulan, 'tahun' => $mr1->tahun],
                    ['meter_reading_id' => $mr1->id, 'total_kwh' => $kwhM1, 'total_biaya' => $biaya1, 'denda' => 0, 'status' => 'paid', 'tanggal_jatuh_tempo' => $now->copy()->subMonth()->endOfMonth()->toDateString(), 'tanggal_bayar' => $now->copy()->subMonth()->subDays(4)->toDateString()]
                );
                Transaction::firstOrCreate(
                    ['ref_number' => 'TRX-' . $now->copy()->subMonth()->format('Ym') . '-' . str_pad($userNum * 10 + 1, 5, '0', STR_PAD_LEFT)],
                    ['user_id' => $user->id, 'customer_id' => $customer->id, 'bill_id' => $b1->id, 'payment_method_id' => 6, 'type' => 'tagihan', 'amount' => $biaya1, 'status' => 'success', 'no_meter' => $idPelanggan, 'created_at' => $now->copy()->subMonth()->subDays(4)]
                );

                $biayaCur = round($kwhCur * $tarifPerKwh, 2);
                Bill::updateOrCreate(
                    ['customer_id' => $customer->id, 'bulan' => $mrCur->bulan, 'tahun' => $mrCur->tahun],
                    ['meter_reading_id' => $mrCur->id, 'total_kwh' => $kwhCur, 'total_biaya' => $biayaCur, 'denda' => 0, 'status' => 'unpaid', 'tanggal_jatuh_tempo' => $now->copy()->endOfMonth()->toDateString(), 'tanggal_bayar' => null]
                );
            }

            // ── Case 8: Outage Reporter
            elseif ($u['case'] === 'outage_reporter') {
                $laporanStatus = $userNum === 48 ? 'diproses' : 'selesai';
                OutageReport::firstOrCreate(
                    ['user_id' => $user->id, 'lokasi' => $alamat],
                    [
                        'customer_id' => $customer->id,
                        'kategori' => 'padam_total',
                        'deskripsi' => 'Listrik padam tiba-tiba di sekitar blok perumahan sejak sore hari, trafo terdengar mendengung keras.',
                        'lokasi' => $alamat,
                        'status' => $laporanStatus,
                        'catatan_petugas' => $laporanStatus === 'selesai' ? 'Petugas PLN Rayon telah melakukan perbaikan sekring trafo distribusi.' : 'Petugas sedang menuju lokasi gangguan.',
                        'created_at' => $now->copy()->subDays(rand(1, 5)),
                    ]
                );
            }
        }

        $this->command->info('50 Dummy users beserta skenario data lengkap berhasil dibuat!');
    }
}
