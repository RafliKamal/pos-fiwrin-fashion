<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCustomId;

class RequestPelanggan extends Model
{
    use HasFactory, HasCustomId, SoftDeletes;

    protected $table = 'request_pelanggan';
    public $prefix = 'REQ';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}