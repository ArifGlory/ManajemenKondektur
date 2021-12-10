<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\ImportRequest;
use App\Http\Requests\KeretaRequest;
use App\Http\Requests\Pegawai2Request;
use App\Imports\SantriDataImport;
// use App\Models\PangkatGolongan;
use App\Models\Kereta;
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
use function GuzzleHttp\Promise\all;

class KeretaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('back.kereta.index');
    }

    /*
     * Sumber data untuk datatable
     * pada Manajemen Pengguna
     * */
    public function data(Request $request)
    {
                $role = Auth::user()->jenis_user;
                $data = Kereta::select('*')
                    ->get();


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
                        $lihat = route('kereta.show', $item->id_kereta);
                        $edit = route('kereta.edit', $item->id_kereta);
                        $hapus = route('kereta.destroy', $item->id_kereta);

                        $button = 'LEHM';
                        return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));

                    })
                    ->escapeColumns([])
                    ->addIndexColumn()
                    ->make(true);
    }


    public function create()
    {
        //

        return view('back.kereta.create');
    }

    public function store(Request $request)
    {
        //
        //dd($request->all());
        //$request->validated();
        $role = Auth::user()->jenis_user;

        $save = Kereta::create([
            'nomor_kereta' => $request->input('nomor_kereta'),
            'nama_kereta' => $request->input('nama_kereta'),
            'deskripsi_kereta' => $request->input('deskripsi_kereta')
        ]);
        if ($save) {
            return redirect(route('kereta.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan Kereta',
                    'judul' => 'Data Kereta'
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
                if (file_exists('img/kereta/' . $data->foto)) {
                    unlink('img/kereta/' . $data->foto);
                }
            }

            $image = $request->file('foto');
            $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
            $image->move('img/kereta/', $photo);
            $requestData['foto'] = $photo;
        }

        $update = $data->update($requestData);
        if ($update) {

            return redirect(route('kereta.index'))
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
        $data = Kereta::select('*')
            ->where('id_kereta',$id)
            ->first();

        return view('back.kereta.show', compact('data'));
    }


    public function edit($id){
        $data = User::select('users.*')
            ->where('users.id',$id)
            ->first();

        $jabatan = $data->jabatan;
        if ($jabatan == "KDR"){
            $nama_jabatan = "Kondektur";
        }else if ($jabatan == "LIA"){
            $nama_jabatan = "Penyelia";
        }if ($jabatan == "KUPT"){
            $nama_jabatan = "Kepala UPT";
        }

        return view('back.kereta.edit', compact('data','nama_jabatan'));
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
