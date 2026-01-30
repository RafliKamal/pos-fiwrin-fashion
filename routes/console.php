<?php

use Illuminate\Support\Facades\Schedule;


Schedule::command('inspire')->hourly();

// --- JADWAL TRAINING ML ---
// Jalankan setiap Senin jam 02:00 pagi
Schedule::command('ml:train')
    ->weeklyOn(1, '02:00')
    ->timezone('Asia/Jakarta')
    ->appendOutputTo(storage_path('logs/ml_training.log'));

Schedule::command('ml:predict')->dailyAt('06:00');