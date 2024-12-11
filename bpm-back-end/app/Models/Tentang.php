<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tentang extends Model
{
    use HasFactory;

    protected $table = 'tentang'; 
    
    protected $primaryKey = 'ten_id'; 

    protected $fillable = [
        'ten_category',
        'ten_isi',
        'ten_status',
        'ten_modif_by',
        'ten_modif_date',
    ];

    public $timestamps = false; 
}
