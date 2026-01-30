<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory, HasCustomId, SoftDeletes;

    protected $table = 'produk';
    public $prefix = 'PRD';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'produk_id');
    }
}