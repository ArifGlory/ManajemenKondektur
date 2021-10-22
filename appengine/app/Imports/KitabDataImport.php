<?php

namespace App\Imports;

use App\Models\Kitab;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class KitabDataImport implements ToModel  , SkipsOnError , WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable,SkipsErrors;

    public function model(array $row)
    {
        $id_pesantren  = Session::get('id_pesantren_kitab');
        $id_santri     = Session::get('id_santri_kitab');

        if (empty($row[2])){
            $keterangan = null;
        }else{
            $keterangan = $row[2];
        }

        return new Kitab([
            'nama_kitab'=>$row[0],
            'nilai'=>$row[1],
            'keterangan'=>$keterangan,
            'id_santri' => $id_santri,
            'id_pesantren' => $id_pesantren
        ]);
    }

    /**
     * @param Failure[] $failures
     */


    /**
     * @param Throwable $e
     */
    public function onError(Throwable $e)
    {

    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '0' => 'required|string',
            '1' => 'required|string',
            //'2' => 'required|string',
            // so on
        ];
    }
}
