<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    // Halaman pilih produk
    public function index()
    {
        $products = [
            [
                'id' => 'tagihan',
                'kategori' => 'pembayaran',
                'kategori_label' => 'Pembayaran',
                'nama' => 'Tagihan Listrik Pascabayar',
                'badge' => 'Pascabayar',
                'icon' => 'fa-file-invoice-dollar',
                'icon_bg' => 'bg-blue-50 text-[#00529C]',
                'badge_bg' => 'bg-[#00529C]/10 text-[#00529C]',
                'ringkasan' => 'Cek rincian dan bayar tagihan listrik bulanan Anda secara real-time tanpa antre.',
                'deskripsi' => 'Layanan resmi pengecekan dan pembayaran rekening listrik pascabayar PLN. Ketahui detail pemakaian kWh, tarif daya, periode rekening, dan denda keterlambatan dengan transparansi penuh.',
                'fitur' => [
                    'Cek tagihan instan dengan nomor ID Pelanggan',
                    'Rincian pemakaian daya dan biaya transparan',
                    'Multi-metode pembayaran (QRIS, VA Bank, E-Wallet)',
                    'Bukti pelunasan dan riwayat pembayaran tersimpan rapi',
                ],
                'route' => route('dashboard.tagihan'),
                'btn_text' => 'Bayar Tagihan',
            ],
            [
                'id' => 'token',
                'kategori' => 'pembayaran',
                'kategori_label' => 'Pembayaran',
                'nama' => 'Token Listrik Prabayar',
                'badge' => 'Prabayar',
                'icon' => 'fa-bolt',
                'icon_bg' => 'bg-amber-50 text-[#D4980A]',
                'badge_bg' => 'bg-[#FDB813]/20 text-[#9E6E00]',
                'ringkasan' => 'Beli stroom token listrik 24 jam dengan nominal fleksibel dan kode token instan.',
                'deskripsi' => 'Layanan isi ulang token listrik pintar PLN prabayar kapan saja selama 24 jam. Nomor stroom 20 digit langsung diterbitkan seketika setelah pembayaran berhasil dan tersimpan dalam riwayat.',
                'fitur' => [
                    'Pilihan nominal fleksibel mulai Rp 20.000 s/d Rp 1.000.000',
                    'Kode token 20 digit langsung tampil & mudah disalin',
                    'Pembelian aktif 24 jam nonstop tanpa perlu keluar rumah',
                    'Riwayat transaksi dan nomor stroom tersimpan aman',
                ],
                'route' => route('dashboard.token'),
                'btn_text' => 'Beli Token',
            ],
            [
                'id' => 'metering',
                'kategori' => 'pengawasan',
                'kategori_label' => 'Pengawasan & Meteran',
                'nama' => 'Catat Meter Mandiri (Self Metering)',
                'badge' => 'Swacam',
                'icon' => 'fa-tachometer-alt',
                'icon_bg' => 'bg-emerald-50 text-emerald-600',
                'badge_bg' => 'bg-emerald-100/70 text-emerald-800',
                'ringkasan' => 'Laporkan angka stand kWh meter mandiri setiap bulan untuk tagihan yang akurat.',
                'deskripsi' => 'Fitur baca meter mandiri (Swacam) yang memungkinkan Anda mencatat dan mengirimkan angka stand meter kWh listrik disertai foto kWh meter langsung dari rumah setiap tanggal 24-27 setiap bulan.',
                'fitur' => [
                    'Pelaporan angka stand meter mandiri tanpa menunggu petugas',
                    'Verifikasi upload foto bukti fisik kWh meter',
                    'Menghindari estimasi tagihan dan memastikan tagihan riil',
                    'Histori pencatatan angka meter bulanan tercatat rapi',
                ],
                'route' => route('dashboard.metering'),
                'btn_text' => 'Catat Meter',
            ],
            [
                'id' => 'monitoring',
                'kategori' => 'pengawasan',
                'kategori_label' => 'Pengawasan & Meteran',
                'nama' => 'Monitoring Pemakaian Listrik',
                'badge' => 'Analitik & Grafik',
                'icon' => 'fa-chart-line',
                'icon_bg' => 'bg-indigo-50 text-indigo-600',
                'badge_bg' => 'bg-indigo-100/70 text-indigo-800',
                'ringkasan' => 'Pantau tren konsumsi daya dan analisis efisiensi pengeluaran listrik Anda.',
                'deskripsi' => 'Layanan dashboard visualisasi analitik interaktif untuk memonitor pola konsumsi energi listrik rumah Anda dari waktu ke waktu. Temukan lonjakan pemakaian dan optimalkan pemakaian daya.',
                'fitur' => [
                    'Grafik interaktif konsumsi listrik (kWh) bulanan',
                    'Grafik tren pengeluaran biaya tagihan listrik',
                    'Deteksi fluktuasi konsumsi untuk mencegah pemborosan',
                    'Ringkasan data pemakaian kumulatif pelanggan',
                ],
                'route' => route('dashboard.monitoring'),
                'btn_text' => 'Lihat Monitoring',
            ],
            [
                'id' => 'simulasi',
                'kategori' => 'pengawasan',
                'kategori_label' => 'Pengawasan & Meteran',
                'nama' => 'Simulasi Keuangan & Tarif Listrik',
                'badge' => 'Kalkulator',
                'icon' => 'fa-calculator',
                'icon_bg' => 'bg-cyan-50 text-cyan-600',
                'badge_bg' => 'bg-cyan-100/70 text-cyan-800',
                'ringkasan' => 'Hitung estimasi konsumsi alat elektronik dan simulasi biaya pasang baru.',
                'deskripsi' => 'Alat bantu kalkulator cerdas untuk menghitung estimasi pemakaian daya listrik berbagai alat elektronik rumah tangga (AC, kulkas, televisi, mesin cuci) dan memproyeksikan tagihan bulanan.',
                'fitur' => [
                    'Kalkulator pemakaian daya berdasarkan peralatan rumah tangga',
                    'Proyeksi tagihan bulanan berdasarkan tarif daya VA pelanggan',
                    'Panduan estimasi penghematan energi listrik',
                    'Terintegrasi dengan informasi batas daya dan tarif per kWh',
                ],
                'route' => route('dashboard.simulasi'),
                'btn_text' => 'Buka Simulasi',
            ],
            [
                'id' => 'outage',
                'kategori' => 'bantuan',
                'kategori_label' => 'Bantuan & Layanan',
                'nama' => 'Lapor Gangguan & Pemadaman',
                'badge' => 'Layanan 24 Jam',
                'icon' => 'fa-exclamation-triangle',
                'icon_bg' => 'bg-red-50 text-red-500',
                'badge_bg' => 'bg-red-100/70 text-red-800',
                'ringkasan' => 'Laporkan masalah listrik padam atau kendala meteran dengan tracking tiket real-time.',
                'deskripsi' => 'Pusat pengaduan keluhan gangguan listrik terintegrasi. Laporkan pemadaman listrik di rumah maupun sekitar lingkungan, kendala pada kWh meter, dengan pemantauan penanganan teknisi PLN secara transparan.',
                'fitur' => [
                    'Pembuatan laporan aduan cepat dengan deskripsi & foto',
                    'Penerbitan nomor tiket aduan resmi secara otomatis',
                    'Pelacakan status penanganan teknisi (Pending, Diproses, Selesai)',
                    'Terhubung langsung dengan tim respon cepat pelayanan teknik PLN',
                ],
                'route' => route('dashboard.outage'),
                'btn_text' => 'Lapor Gangguan',
            ],
            [
                'id' => 'reward',
                'kategori' => 'bantuan',
                'kategori_label' => 'Bantuan & Layanan',
                'nama' => 'PLN Reward & Loyalty Point',
                'badge' => 'Program Loyalitas',
                'icon' => 'fa-gift',
                'icon_bg' => 'bg-amber-50 text-amber-500',
                'badge_bg' => 'bg-amber-100/70 text-amber-800',
                'ringkasan' => 'Kumpulkan poin apresiasi dari setiap transaksi untuk ditukar voucher dan hadiah.',
                'deskripsi' => 'Program apresiasi eksklusif bagi seluruh pelanggan setia PLN DIGI. Dapatkan poin reward setiap kali membayar tagihan tepat waktu atau membeli token listrik, dan tukarkan poin dengan beragam hadiah menarik.',
                'fitur' => [
                    'Poin otomatis terakumulasi dari setiap transaksi sukses',
                    'Peningkatan status tingkatan member (Silver, Gold, Platinum)',
                    'Katalog voucher diskon tagihan dan kupon merchant mitra',
                    'Pantau riwayat perolehan poin dan total akumulasi belanja',
                ],
                'route' => route('dashboard.reward'),
                'btn_text' => 'Lihat Reward',
            ],
        ];

        return view('produk.index', compact('products'));
    }

    // Form bayar tagihan
    public function tagihan()
    {
        $paymentMethods = PaymentMethod::active()->get();
        return view('produk.tagihan', compact('paymentMethods'));
    }

    // Cek tagihan pelanggan
    public function cekTagihan(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|string',
        ]);

        $customer = Customer::with(['tariff.category'])
            ->where('id_pelanggan', $request->id_pelanggan)
            ->first();

        if (!$customer) {
            return back()->with('error', 'ID Pelanggan tidak ditemukan.')->withInput();
        }

        // Ambil semua tagihan unpaid/overdue, urutkan terbaru
        $unpaidBills = Bill::where('customer_id', $customer->id)
            ->whereIn('status', ['unpaid', 'overdue'])
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        $paymentMethods = PaymentMethod::active()->get();

        return view('produk.tagihan', compact('customer', 'paymentMethods', 'unpaidBills'));
    }

    // Form beli token
    public function token(Request $request)
    {
        $paymentMethods = PaymentMethod::active()->get();
        $customer = null;

        if (auth()->check() && auth()->user()->customer) {
            $customer = auth()->user()->customer->load('tariff');
        }

        return view('produk.token', compact('paymentMethods', 'customer'));
    }

    // Cek ID Pelanggan / No Meter untuk beli token
    public function cekToken(Request $request)
    {
        $request->validate([
            'no_meter' => 'required|string',
        ]);

        $customer = Customer::with(['tariff.category'])
            ->where('id_pelanggan', $request->no_meter)
            ->first();

        if (!$customer) {
            return back()->with('error', 'Nomor Meter / ID Pelanggan tidak ditemukan. Pastikan nomor yang dimasukkan benar.')->withInput();
        }

        $paymentMethods = PaymentMethod::active()->get();

        return view('produk.token', compact('customer', 'paymentMethods'));
    }

    // Proses pembayaran (tagihan atau token)
    public function bayar(Request $request)
    {
        $request->validate([
            'type'              => 'required|in:tagihan,token',
            'amount'            => 'required|numeric|min:1000',
            'no_meter'          => 'required|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'bill_id'           => 'nullable|exists:bills,id',
        ]);

        $customer = Customer::with('tariff')
            ->where('id_pelanggan', $request->no_meter)
            ->first() ?? auth()->user()?->customer?->load('tariff');

        // Generate token jika pembelian token
        $tokenListrik = null;
        if ($request->type === 'token') {
            $rawToken = str_pad((string) random_int(0, 99999999999999999), 20, '0', STR_PAD_LEFT);
            $tokenListrik = implode(' ', str_split($rawToken, 4));
        }

        // Tentukan bill_id: hanya untuk type tagihan
        $billId = null;
        if ($request->type === 'tagihan' && $request->filled('bill_id')) {
            $billId = $request->bill_id;
        }

        $transaction = Transaction::create([
            'user_id'           => auth()->id(),
            'customer_id'       => $customer?->id,
            'bill_id'           => $billId,
            'payment_method_id' => $request->payment_method_id,
            'type'              => $request->type,
            'amount'            => $request->amount,
            'nominal'           => $request->type === 'token' ? $request->amount : null,
            'status'            => 'pending',
            'no_meter'          => $request->no_meter,
            'ref_number'        => 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
            'token_listrik'     => $tokenListrik,
        ]);

        return view('produk.payment', [
            'transaction' => $transaction->load(['paymentMethod', 'bill', 'customer.tariff']),
            'customer'    => $customer,
        ]);
    }

    // Konfirmasi pembayaran (simulasi)
    public function konfirmasi(Transaction $transaction)
    {
        // Pastikan hanya transaksi milik user ini yang bisa dikonfirmasi
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->update(['status' => 'success']);

        // Jika bayar tagihan, update status bill menjadi paid
        if ($transaction->type === 'tagihan' && $transaction->bill_id) {
            Bill::where('id', $transaction->bill_id)->update([
                'status'        => 'paid',
                'tanggal_bayar' => now()->toDateString(),
            ]);
        }

        return redirect()->route('produk.sukses', $transaction)
            ->with('success', 'Pembayaran berhasil! Ref: ' . $transaction->ref_number);
    }

    // Halaman sukses transaksi
    public function sukses(Transaction $transaction)
    {
        // Pastikan hanya transaksi milik user ini yang bisa dilihat
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->load('paymentMethod', 'customer', 'bill');

        return view('produk.success', compact('transaction'));
    }
}
