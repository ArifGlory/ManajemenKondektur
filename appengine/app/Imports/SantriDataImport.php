<?php

namespace App\Imports;

use App\Models\Santri;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class SantriDataImport implements ToModel , SkipsOnError , SkipsOnFailure , WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    use SkipsErrors,Importable,SkipsFailures;

    public function model(array $row)
    {
        $id_pesantren     = Auth::user()->id;
        if (empty($row[2])){
            $email_wali = null;
        }else{
            $email_wali = $row[2];
        }


        return new Santri([
            'nama_santri'=>$row[0],
            'asal_santri'=>$row[1],
            'email_wali_santri'=>$email_wali,
            'id_pesantren'=>$id_pesantren
        ]);
    }

    /**
     * @param Throwable $e
     */
    public function onError(Throwable $e)
    {

    }

    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
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
            '2' => function($attribute, $value, $onFailure) {
                if ($value == '' || $value == null ) {
                    $value = null;

                    return $value;
                }
            }
            // so on
        ];
    }
}
