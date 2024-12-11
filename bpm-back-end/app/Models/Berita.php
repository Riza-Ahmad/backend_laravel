<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Berita extends Model
{
    use HasFactory;


    protected $table = 'berita'; 
    protected $primaryKey = 'ber_id'; 

    
    protected $fillable = [
        'ber_judul',
        'ber_tgl',
        'ber_isi',
        'ber_status',
        'ber_created_by',
        'ber_penulis',
    ];

    public $timestamps = false; 
}
