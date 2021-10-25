<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_jadwal',
        'id_pegawai',
        'hari',
        'tanggal_jadwal',
        'jam_mulai',
        'jam_selesai',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'id_jadwal';

    protected $table = 'jadwal';
}
