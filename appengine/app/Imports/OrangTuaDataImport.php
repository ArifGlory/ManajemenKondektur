<?php

namespace App\Imports;

use App\Models\OrangTua;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class OrangTuaDataImport implements ToModel  , SkipsOnError , WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable,SkipsErrors;

    public function model(array $row)
    {
        $role = Auth::user()->jenis_user;
        if ($role == "admin"){
            $id_pesantren     = Session::get('id_pesantren');
        }else{
            $id_pesantren     = Auth::user()->id;
        }

        return new OrangTua([
            'name'=>$row[0],
            'email'=>$row[1],
            'phone'=>$row[2],
            'id_pesantren'=>$id_pesantren
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
