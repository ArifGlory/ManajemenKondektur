<?php

namespace App\Http\Controllers\Back;


use App\Http\Requests\ImportRequest;
use App\Http\Requests\JenisSkRequest;
use App\Http\Requests\orang_tuaRequest;
use App\Http\Requests\OrangTuaRequest;
use App\Imports\OrangTuaDataImport;
use App\Imports\SantriDataImport;
use App\Models\Dokumen;
use App\Models\Isiorang_tua;
use App\Models\JenisSk;
use App\Models\orang_tua;
use App\Models\ModelHasRoles;
use App\Models\OrangTua;
use App\Models\Santri;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use DataTables;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class OrangTuaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('back.orang_tua.index');
    }

    /*
     * Sumber data untuk datatable
     * pada Manajemen Pengguna
     * */
    public function data(Request $request)
    {
                $role = Auth::user()->jenis_user;
                if ($role == "admin"){
                    $data = OrangTua::select()
                        ->orderBy('id', 'DESC')
                        ->get();
                }else{
                    $data = OrangTua::select()
                        ->where('id_pesantren',Auth::user()->id)
                        ->orderBy('id', 'DESC')
                        ->get();
                }


                return Datatables::of($data)
                    ->addColumn('_action', function ($item) {/*
                         /*
                         * L = Lihat => $lihat
                         * C = Cetak => $cetak
                         * E = Edit => $edit
                         * H = Hapus => $hapus
                         * R = Restore = $restore
                         * M = Modal Dialog*/
                        $role = Auth::user()->jenis_user;
                        if ($role != "admin"){
                            $button = 'LEHRM';
                            $lihat = route('wali-santri.show', $item->id);
                            $edit = route('wali-santri.edit', $item->id);
                            $hapus = route('wali-santri.destroy', $item->id);
                            return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));
                        }else{
                            $button = 'LHRM';
                            $lihat = route('wali-santri.show', $item->id);
                            $hapus = route('wali-santri.destroy', $item->id);
                            return view('datatable._action_button', compact('item', 'button', 'lihat', 'hapus'));
                        }

                    })
                    ->escapeColumns([])
                    ->addIndexColumn()
                    ->make(true);
    }


    public function create()
    {
        //

        $role = Auth::user()->jenis_user;
        if ($role == "admin"){
            $pesantren = User::select('name','id')
                ->get();

            return view('back.orang_tua.create_by_admin',compact('pesantren'));
        }else{
            return view('back.orang_tua.create');
        }
    }

    public function createMulti()
    {
        //
        $role = Auth::user()->jenis_user;
        if ($role == "admin"){
            $pesantren = User::select('name','id')
                ->get();

            return view('back.orang_tua.create_multi_by_admin',compact('pesantren'));
        }else{
            return view('back.orang_tua.create_multi');
        }
    }

    public function store(OrangTuaRequest $request)
    {
        //
        $request->validated();
        $role = Auth::user()->jenis_user;
        if ($role == "admin"){
            $id_pesantren = $request->input('id_pesantren');
        }else{
            $id_pesantren     = Auth::user()->id;
        }

        $password = "12345678";
        $hashPwd = Hash::make($password);

        $save = OrangTua::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => $hashPwd,
            'id_pesantren' => $id_pesantren
        ]);
        if ($save) {
            return redirect(route('wali-santri.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan Wali Santri',
                    'judul' => 'Data Wali'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'danger',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }
    }

    public function storeMulti(ImportRequest $request){
        $nama_file = "";

        $role = Auth::user()->jenis_user;
        if ($role == "admin"){
            $id_pesantren = $request->input('id_pesantren');
            Session::put('id_pesantren',$id_pesantren);
        }

        if ($request->hasFile('file_excel')) {
            $file = $request->file('file_excel');
            $nama_file = round(microtime(true) * 1000) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/excel/'), $nama_file);
        }

        //$save =  Excel::import(new OrangTuaDataImport(), public_path('/excel/'.$nama_file) );
        $import = new OrangTuaDataImport();
        $import->import(public_path('/excel/'.$nama_file));

        if ($import) {
            return redirect(route('wali-santri.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil import data Wali Santri',
                    'judul' => 'Data Wali Santri'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'danger',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }

    }

    public function update(OrangTuaRequest $request, $id)
    {
        //
        $request->validated();
        $requestData = $request->all();

        $data = OrangTua::findOrFail($id);
        $update = $data->update($requestData);

        if ($update) {
            return redirect(route('wali-santri.index'))
                ->with('pesan_status', [
                    'tipe' => 'info',
                    'desc' => 'Data Berhasil diupdate',
                    'judul' => 'Data Wali Santri'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'error',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }

    }


    public function show($id){
        $data = OrangTua::select()
            ->where('id',$id)
            ->first();

        $santri = Santri::select('santri.*','users.name as nama_pesantren')
            ->join('users','users.id','=','santri.id_pesantren')
            ->where('santri.email_wali_santri',$data->email)
            ->get();


        return view('back.orang_tua.show', compact('data','santri'));
    }

    public function edit($id){
        $data = OrangTua::select('*')
            ->where('id',$id)
            ->first();

        return view('back.orang_tua.edit', compact('data'));
    }


    public function destroy($id)
    {
        //

        $info = OrangTua::withTrashed()->find($id);
        if ($info->trashed()) {
            $delete = $info->forceDelete();
        } else {
            $delete = $info->destroy($id);
        }

        $response = [];
        if($delete) {
            return Respon('', true, 'Berhasil menghapus data', 200);

        } else {
            return Respon('', false, 'Gagal menghapus data', 200);
        }
    }

   
}
