<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory, HasCustomId, SoftDeletes;

    protected $table = 'kategori';
    public $prefix = 'KAT';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}