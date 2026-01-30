<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;

trait HasCustomId
{
    protected static function bootHasCustomId()
    {
        static::creating(function ($model) {
            $prefix = $model->prefix ?? 'ID';

            if ($prefix === 'TRX') {
                $dateCode = Carbon::now()->format('Ymd');
                $fullPrefix = $prefix . $dateCode;

                $lastRecord = static::withTrashed()
                    ->where('id', 'like', $fullPrefix . '%')
                    ->orderBy('id', 'desc')
                    ->first();

                if (!$lastRecord) {
                    $number = 1;
                } else {
                    $lastNumber = (int) substr($lastRecord->id, -3);
                    $number = $lastNumber + 1;
                }

                $model->id = $fullPrefix . str_pad($number, 3, '0', STR_PAD_LEFT);

            } else {
                $lastRecord = static::withTrashed()
                    ->where('id', 'like', $prefix . '%')
                    ->orderBy('id', 'desc')
                    ->first();

                if (!$lastRecord) {
                    $number = 1;
                } else {
                    $lastNumber = (int) substr($lastRecord->id, strlen($prefix));
                    $number = $lastNumber + 1;
                }

                $model->id = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}