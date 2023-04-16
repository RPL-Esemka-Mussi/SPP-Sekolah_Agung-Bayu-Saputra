<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    use HasFactory;

    protected $table = "spp";

    protected $fillable = [
        'tahun',
        'nominal',
    ];

    protected $hidden;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pembayaran(){
        return $this->hasMany(Pembayaran::class);
    }
}
