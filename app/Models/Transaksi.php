<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCustomId;
use App\Models\Pengguna;

class Transaksi extends Model
{
    use HasFactory, HasCustomId, SoftDeletes;

    protected $table = 'transaksi';
    public $prefix = 'TRX';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($transaksi) {
            foreach ($transaksi->details as $detail) {
                if ($detail->produk) {
                    $detail->produk->increment('stok_saat_ini', $detail->jumlah_beli);
                }
            }
        });

        static::restoring(function ($transaksi) {
            foreach ($transaksi->details as $detail) {
                if ($detail->produk) {
                    $detail->produk->decrement('stok_saat_ini', $detail->jumlah_beli);
                }
            }
        });
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id')->withTrashed();
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    public function getProfitAttribute(): float
    {
        return $this->details->sum(function ($detail) {
            $hargaModal = $detail->harga_modal ?? ($detail->produk->harga_modal ?? 0);
            $hargaJual = $detail->harga_satuan_deal ?? 0;
            $qty = $detail->jumlah_beli ?? 0;

            return ($hargaJual - $hargaModal) * $qty;
        });
    }
}