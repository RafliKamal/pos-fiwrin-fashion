<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Process\Process;
use App\Mail\RestockAlertMail;
use App\Models\Produk;

class RunPrediction extends Command
{
    protected $signature = 'ml:predict';
    protected $description = 'Run Python ML prediction and cache the result';

    public function handle()
    {
        $scriptPath = base_path('python_scripts/predict.py');
        $pythonCommand = config('services.python.path', 'python');

        $process = new Process([$pythonCommand, '-W', 'ignore', $scriptPath]);
        $process->setWorkingDirectory(base_path('python_scripts'));
        $process->setTimeout(120);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Python prediction failed: ' . $process->getErrorOutput());
            return 1;
        }

        $output = $process->getOutput();
        $lines = explode("\n", trim($output));
        $jsonLine = end($lines);
        $data = json_decode($jsonLine, true);

        if ($data) {
            Cache::put('ml_prediction_data', $data, 60 * 60 * 24);
            $this->info('Prediction data cached successfully!');

            $this->checkAndSendRestockAlert($data);

            return 0;
        }

        $this->error('Failed to parse Python output: ' . $output);
        return 1;
    }

    private function checkAndSendRestockAlert(array $data): void
    {
        $restockData = $data['restock_data'] ?? [];

        if (empty($restockData)) {
            return;
        }

        $stokPerKategori = Produk::join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->selectRaw('kategori.nama_kategori, SUM(produk.stok_saat_ini) as total_stok')
            ->groupBy('kategori.nama_kategori')
            ->pluck('total_stok', 'nama_kategori')
            ->toArray();

        $lowStockItems = [];
        foreach ($restockData as $item) {
            $stok = $stokPerKategori[$item['kategori']] ?? 0;
            $selisih = $stok - $item['qty'];

            if ($selisih < 0 || $stok === 0) {
                $lowStockItems[] = [
                    'kategori' => $item['kategori'],
                    'prediksi' => $item['qty'],
                    'stok' => $stok,
                    'selisih' => $selisih,
                    'status' => $stok === 0 ? 'kosong' : 'kurang',
                ];
            }
        }

        if (!empty($lowStockItems)) {
            $ownerEmail = env('OWNER_EMAIL');

            if ($ownerEmail) {
                try {
                    Mail::to($ownerEmail)->send(new RestockAlertMail($lowStockItems));
                    $this->info("📧 Email peringatan stok terkirim ke: {$ownerEmail}");
                } catch (\Exception $e) {
                    $this->warn("Gagal kirim email: " . $e->getMessage());
                }
            }
        } else {
            $this->info("✅ Semua stok mencukupi, tidak ada email yang dikirim.");
        }
    }
}