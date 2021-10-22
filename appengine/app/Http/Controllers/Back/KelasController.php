<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\DokumenRequest;
// use App\Models\Jabatan;
use App\Http\Requests\JenisSkRequest;
use App\Http\Requests\KelasRequest;
use App\Models\Dokumen;
use App\Models\IsiKelas;
use App\Models\JenisSk;
use App\Models\Kelas;
use App\Models\ModelHasRoles;
// use App\Models\PangkatGolongan;
use App\Models\Santri;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use DataTables;
use App\Http\Controllers\Controller;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('back.kelas.index');
    }

    /*
     * Sumber data untuk datatable
     * pada Manajemen Pengguna
     * */
    public function data(Request $request)
    {
                $role = Auth::user()->jenis_user;
                if ($role == "admin"){
                    $data = Kelas::select()
                        ->orderBy('id_kelas', 'DESC')
                        ->get();
                }else{
                    $data = Kelas::select()
                        ->where('id_pesantren',Auth::user()->id)
                        ->orderBy('id_kelas', 'DESC')
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
                            $lihat = route('kelas.show', $item->id_kelas);
                            $edit = route('kelas.edit', $item->id_kelas);
                            $hapus = route('kelas.destroy', $item->id_kelas);
                            return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));
                        }else{
                            $button = 'LHRM';
                            $lihat = route('kelas.show', $item->id_kelas);
                            $hapus = route('kelas.destroy', $item->id_kelas);
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

        return view('back.kelas.create');
    }

    public function store(KelasRequest $request)
    {
        //
        $request->validated();
        $role = Auth::user()->jenis_user;

        if ($role == "admin"){
            $id_pesantren = Session::get('id_pesantren');
        }else{
            $id_pesantren     = Auth::user()->id;
        }

        $save = Kelas::create([
            'nama_kelas' => $request->input('nama_kelas'),
            'id_pesantren' => $id_pesantren
        ]);
        if ($save) {
            return redirect(route('kelas.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan Kelas',
                    'judul' => 'Data Kelas'
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

        $data = Kelas::findOrFail($id);
        $update = $data->update($requestData);

        if ($update) {
            return redirect(route('kelas.index'))
                ->with('pesan_status', [
                    'tipe' => 'info',
                    'desc' => 'Data Berhasil diupdate',
                    'judul' => 'Data Kelas'
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
        $data = Kelas::select()
            ->join('users','users.id','=','kelas.id_pesantren')
            ->where('id_kelas',$id)
            ->first();

        $santri_dikelas = IsiKelas::select()
            ->join('santri','santri.id_santri','=','isi_kelas.id_santri')
            ->where('id_kelas',$id)
            ->get();


        return view('back.kelas.show', compact('data','santri_dikelas'));
    }

    public function edit($id){
        $data = Kelas::select('*')
            ->where('id_kelas',$id)
            ->first();

        return view('back.kelas.edit', compact('data'));
    }

    public function removeSantri($id_isi_kelas){
        $info = IsiKelas::find($id_isi_kelas);
        $info->destroy($id_isi_kelas);

        return Redirect::back();
    }

    public function addSantri($id_kelas){
        $santri_dikelas = Santri::where('id_pesantren',Auth::user()->id)
            ->get();

        return view('back.kelas.add_santri', compact('id_kelas','santri_dikelas'));
    }

    public function storeSantri(Request $request){
        $id_pesantren       = Auth::user()->id;
        $id_kelas           = $request->input('id_kelas');

        $save = IsiKelas::create([
            'id_kelas' => $request->input('id_kelas'),
            'id_santri' => $request->input('id_santri'),
            'id_pesantren' => $id_pesantren
        ]);
        if ($save) {
            return redirect(route('kelas.show',$id_kelas))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan Santri di kelas ini',
                    'judul' => 'Data Kelas'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'danger',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }
    }

    public function destroy($id)
    {
        //

        $info = Kelas::withTrashed()->find($id);
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
