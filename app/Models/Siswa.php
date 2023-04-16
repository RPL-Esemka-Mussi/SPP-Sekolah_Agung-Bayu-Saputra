<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nis',
        'kelas_id',
        'alamat',
        'no_telp',
    ];

    protected $hidden;

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function pembayaran(){
        return $this->hasMany(Pembayaran::class);
    }
}

?>
