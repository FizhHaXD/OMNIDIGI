<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\OutageReport;
use App\Services\LetterFormatterService;
use Illuminate\Console\Command;

class GenerateLetterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'letter:generate 
                            {type=sp1 : Jenis dokumen (sp1, sp2, spk, ba_meter)}
                            {id? : ID Bill (untuk sp1/sp2) atau ID Outage (untuk spk)}
                            {--format=text : Format output (text, wa, json, pdf)}
                            {--output= : Path file output jika format pdf atau ingin simpan ke file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dokumen kedinasan PLN ke format Teks, WhatsApp Broadcast, JSON, atau PDF via CLI';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $type = $this->argument('type');
        $id = $this->argument('id');
        $format = $this->option('format');

        $bill = null;
        $outage = null;

        if (in_array($type, ['sp1', 'sp2', 'ba_meter'])) {
            $bill = $id ? Bill::with(['customer.tariff'])->find($id) : Bill::with(['customer.tariff'])->whereIn('status', ['unpaid', 'overdue'])->first();
            if (! $bill) {
                $this->error("Data rekening tagihan tidak ditemukan.");
                return Command::FAILURE;
            }
        } elseif ($type === 'spk') {
            $outage = $id ? OutageReport::with(['user', 'customer'])->find($id) : OutageReport::with(['user', 'customer'])->latest()->first();
            if (! $outage) {
                $this->error("Data laporan gangguan tidak ditemukan.");
                return Command::FAILURE;
            }
        }

        $nomorSurat = LetterFormatterService::generateNomorSurat($type);
        $this->info("Menghasilkan Dokumen Kedinasan PLN: [{$type}] {$nomorSurat}");

        // Format 1: WhatsApp Broadcast
        if ($format === 'wa') {
            $text = LetterFormatterService::toWhatsApp($type, $bill, $outage);
            $this->line("\n" . $text . "\n");
            return Command::SUCCESS;
        }

        // Format 2: JSON Payload untuk AI Agent
        if ($format === 'json') {
            $payload = [
                'document_type' => strtoupper($type),
                'nomor_surat'   => $nomorSurat,
                'customer'      => [
                    'nama'         => $bill?->customer->nama ?? $outage?->user->name ?? 'Pelanggan',
                    'id_pelanggan' => $bill?->customer->id_pelanggan ?? '-',
                    'alamat'       => $bill?->customer->alamat ?? $outage?->lokasi ?? '-',
                    'daya'         => $bill?->customer->tariff->daya_va ?? 1300,
                ],
                'financial'     => [
                    'total_biaya' => $bill?->total_biaya ?? 0,
                    'denda'       => $bill?->denda ?? 0,
                ],
                'generated_at'  => now()->toIso8601String(),
            ];

            $jsonString = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $this->line("\n" . $jsonString . "\n");

            if ($outPath = $this->option('output')) {
                file_put_contents($outPath, $jsonString);
                $this->info("JSON berhasil disimpan ke: {$outPath}");
            }
            return Command::SUCCESS;
        }

        // Format 3: PDF via Built-in Headless Browser CLI
        if ($format === 'pdf') {
            $outputPath = $this->option('output') ?? storage_path("app/public/{$type}_{$nomorSurat}.pdf");
            $outputPath = str_replace(['/', '\\'], '_', $outputPath);
            $outputPath = storage_path("app/public/{$type}_" . time() . ".pdf");

            $billIdParam = $bill ? "&bill_id={$bill->id}" : "";
            $outageIdParam = $outage ? "&outage_id={$outage->id}" : "";
            $previewUrl = "http://localhost:8000/admin/letters/preview?type={$type}{$billIdParam}{$outageIdParam}";

            $this->info("Mengonversi URL pratinjau ke PDF via headless browser...");
            $this->line("URL: {$previewUrl}");

            $res = LetterFormatterService::convertUrlToPdfViaCli($previewUrl, $outputPath);

            if ($res['success']) {
                $this->info("✅ Berhasil membuat file PDF!");
                $this->line("Lokasi File: " . $res['output_path']);
            } else {
                $this->warn("⚠️ Konversi CLI otomatis: " . ($res['message'] ?? 'Jalankan preview di browser lalu tekan Cetak / Simpan PDF'));
                $this->line("Command manual: " . ($res['command'] ?? ''));
            }
            return Command::SUCCESS;
        }

        // Default: Plain Text
        $plain = LetterFormatterService::toPlainText($type, $bill, $outage);
        $this->line("\n" . $plain . "\n");

        if ($outPath = $this->option('output')) {
            file_put_contents($outPath, $plain);
            $this->info("Teks surat berhasil disimpan ke: {$outPath}");
        }

        return Command::SUCCESS;
    }
}
