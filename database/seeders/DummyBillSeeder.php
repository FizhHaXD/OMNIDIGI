<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\MeterReading;
use App\Models\Bill;

class DummyBillSeeder extends Seeder
{
    public function run(): void
    {
        $cust = Customer::find(1);
        if (!$cust) {
            $this->command->error("Customer ID 1 tidak ditemukan.");
            return;
        }

        // 1. Update meter reading September 2026 (id=3) menjadi 'billed'
        $mrSept = MeterReading::find(3);
        if ($mrSept) {
            $mrSept->update(['status' => 'billed']);
        } else {
            $mrSept = MeterReading::firstOrCreate(
                ['customer_id' => 1, 'bulan' => 9, 'tahun' => 2026],
                [
                    'meteran_awal' => 1645,
                    'meteran_akhir' => 1843,
                    'total_kwh' => 198,
                    'status' => 'billed',
                ]
            );
        }

        // 2. Buat / Update Tagihan September 2026 (Status: unpaid)
        Bill::updateOrCreate(
            ['customer_id' => 1, 'bulan' => 9, 'tahun' => 2026],
            [
                'meter_reading_id' => $mrSept->id,
                'total_kwh' => 198.00,
                'total_biaya' => 286050.60,
                'denda' => 0.00,
                'status' => 'unpaid',
                'tanggal_jatuh_tempo' => '2026-09-30',
                'tanggal_bayar' => null,
            ]
        );

        // 3. Buat Meter Reading Oktober 2026
        $mrOkt = MeterReading::firstOrCreate(
            ['customer_id' => 1, 'bulan' => 10, 'tahun' => 2026],
            [
                'meteran_awal' => 1843,
                'meteran_akhir' => 2050,
                'status' => 'billed',
            ]
        );

        // 4. Buat Tagihan Oktober 2026 (Status: unpaid)
        Bill::updateOrCreate(
            ['customer_id' => 1, 'bulan' => 10, 'tahun' => 2026],
            [
                'meter_reading_id' => $mrOkt->id,
                'total_kwh' => 207.00,
                'total_biaya' => 299052.90,
                'denda' => 0.00,
                'status' => 'unpaid',
                'tanggal_jatuh_tempo' => '2026-10-31',
                'tanggal_bayar' => null,
            ]
        );

        $unpaidCount = $cust->unpaidBills()->count();
        $totalTagihan = $cust->total_tagihan;

        $this->command->info("Data dummy tagihan belum dibayar berhasil dibuat!");
        $this->command->info("Customer: {$cust->nama} ({$cust->id_pelanggan})");
        $this->command->info("Jumlah Tagihan Belum Dibayar: {$unpaidCount}");
        $this->command->info("Total Tagihan: Rp " . number_format($totalTagihan, 0, ',', '.'));
    }
}
