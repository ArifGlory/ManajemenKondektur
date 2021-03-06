<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TukarJadwal extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tukar_jadwal',
        'id_jadwal_diinginkan',
        'id_pegawai',
        'id_kereta_tukar',
        'id_riwayat_jadwal',
        'hari_tukar',
        'tanggal_jadwal_tukar',
        'alasan',
        'file_pendukung',
        'status',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'id_tukar_jadwal';

    protected $table = 'tukar_jadwal';
}
