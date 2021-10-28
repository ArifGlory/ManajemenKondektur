<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TukarJadwalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'id_pegawai' => 'required',
            'id_jadwal' => 'required',
            'tanggal_jadwal_tukar' => 'required',
            'jam_mulai_tukar' => 'required',
            'jam_selesai_tukar' => 'required'
        ];
    }
}
