<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\ImportRequest;
use App\Http\Requests\Pegawai2Request;
use App\Imports\SantriDataImport;
// use App\Models\PangkatGolongan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('back.pegawai.index');
    }

    /*
     * Sumber data untuk datatable
     * pada Manajemen Pengguna
     * */
    public function data(Request $request)
    {
                $role = Auth::user()->jenis_user;
                $data = User::select('users.*')
                    ->where('jenis_user',"user")
                    ->orderBy('users.id', 'DESC')
                    ->get();


                return Datatables::of($data)
                    ->editColumn('jabatan',function ($item){
                        if ($item->jabatan == "KDT"){
                            $nama_jabatan = "Kondektur";
                        }else if ($item->jabatan == "LIA"){
                            $nama_jabatan = "Penyelia";
                        }if ($item->jabatan == "KUPT"){
                            $nama_jabatan = "Kepala UPT";
                        }

                        return $nama_jabatan;
                    })
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
                            $lihat = route('pegawai.show', $item->id);
                            $edit = route('pegawai.edit', $item->id);
                            $hapus = route('pegawai.destroy', $item->id);
                            if ($item->status_aktivasi == 0){
                                $button = 'LEHARM';
                                return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));
                            }else{
                                $button = 'LEHRM';
                                return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));
                            }

                        }else{
                            $lihat = route('pegawai.show', $item->id);
                            $edit = route('pegawai.edit', $item->id);
                            $hapus = route('pegawai.destroy', $item->id);
                            if ($item->status_aktivasi == 0){
                                $button = 'LEHAM';
                                return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));
                            }else{
                                $button = 'LEHM';
                                return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));
                            }
                        }

                    })
                    ->escapeColumns([])
                    ->addIndexColumn()
                    ->make(true);
    }


    public function create()
    {
        //

        return view('back.pegawai.create');
    }

    public function createMulti()
    {
        //
        return view('back.pegawai.create_multi');
    }

    public function storeMulti(ImportRequest $request){
        $nama_file = "";
        if ($request->hasFile('file_excel')) {
            $file = $request->file('file_excel');
            $nama_file = round(microtime(true) * 1000) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/excel/'), $nama_file);
        }

        //$save =  Excel::import(new SantriDataImport(), public_path('/excel/'.$nama_file) );
        $import = new SantriDataImport();
        $import->import(public_path('/excel/'.$nama_file));


        if ($import) {
            return redirect(route('santri.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil import data Santri',
                    'judul' => 'Data Santri'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'danger',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }

    }

    public function store(Pegawai2Request $request)
    {
        //
        $request->validated();
        $role = Auth::user()->jenis_user;

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
            $image->move('img/pegawai/', $photo);
        }

        $save = User::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'nip' => $request->input('nip'),
            'pangkat' => $request->input('pangkat'),
            'jabatan' => $request->input('jabatan'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'foto' => $photo
        ]);
        if ($save) {
            return redirect(route('pegawai.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan Pegawai',
                    'judul' => 'Data Pegawai'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'danger',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        //

        $requestData = $request->all();

        $data = User::findOrFail($id);

        if ($request->hasFile('foto')) {
            //hapus foto lama
            if ($data->foto != "padrao.png"){
                if (file_exists('img/pegawai/' . $data->foto)) {
                    unlink('img/pegawai/' . $data->foto);
                }
            }

            $image = $request->file('foto');
            $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
            $image->move('img/pegawai/', $photo);
            $requestData['foto'] = $photo;
        }

        $update = $data->update($requestData);
        if ($update) {

            return redirect(route('pegawai.index'))
                ->with('pesan_status', [
                    'tipe' => 'info',
                    'desc' => 'Data Berhasil diupdate',
                    'judul' => 'Data Pegawai'
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
        $data = User::select('users.*')
            ->where('id',$id)
            ->first();

        return view('back.pegawai.show', compact('data'));
    }


    public function edit($id){
        $data = User::select('users.*')
            ->where('users.id',$id)
            ->first();

        $jabatan = $data->jabatan;
        if ($jabatan == "KDT"){
            $nama_jabatan = "Kondektur";
        }else if ($jabatan == "LIA"){
            $nama_jabatan = "Penyelia";
        }if ($jabatan == "KUPT"){
            $nama_jabatan = "Kepala UPT";
        }

        return view('back.pegawai.edit', compact('data','nama_jabatan'));
    }

    public function destroy($id)
    {
        //

        $info = User::withTrashed()->find($id);
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
