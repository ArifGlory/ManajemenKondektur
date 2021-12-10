<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kereta extends Model
{

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_kereta',
        'nomor_kereta',
        'nama_kereta',
        'deskripsi_kereta',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'id_kereta';

    protected $table = 'kereta';
    protected $dates = ['deleted_at'];
}
