<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class TrainModelML extends Command
{
    protected $signature = 'ml:train';
    protected $description = 'Retrain ML Model using Python with Live Database Data';

    public function handle()
    {
        $this->info(' Memulai Training ML...');

        $scriptPath = base_path('python_scripts/train_model.py');

        if (!file_exists($scriptPath)) {
            $this->error(" Script Python tidak ditemukan di: $scriptPath");
            return;
        }

        $pythonCommand = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'python' : 'python3';

        $process = new Process([$pythonCommand, $scriptPath]);

        $process->setTimeout(600);

        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->error($buffer);
            } else {
                $this->line($buffer);
            }
        });

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->info(' Model ML Berhasil Diupdate dan Disimpan!');
    }
}