<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\DokumenRequest;
// use App\Models\Jabatan;
use App\Http\Requests\JenisSkRequest;
use App\Http\Requests\KelasRequest;
use App\Http\Requests\PrestasiRequest;
use App\Models\Dokumen;
use App\Models\IsiKelas;
use App\Models\JenisSk;
use App\Models\Kelas;
use App\Models\ModelHasRoles;
// use App\Models\PangkatGolongan;
use App\Models\OrangTua;
use App\Models\Prestasi;
use App\Models\Santri;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use DataTables;
use App\Http\Controllers\Controller;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('back.prestasi.index');
    }

    /*
     * Sumber data untuk datatable
     * pada Manajemen Pengguna
     * */
    public function data(Request $request)
    {
                $role = Auth::user()->jenis_user;
                if ($role == "admin"){
                    $data = Prestasi::select()
                        ->leftJoin('santri','santri.id_santri','=','prestasi.id_santri')
                        ->orderBy('id_prestasi', 'DESC')
                        ->get();
                }else{
                    $data = Prestasi::select()
                        ->leftJoin('santri','santri.id_santri','=','prestasi.id_santri')
                        ->where('prestasi.id_pesantren',Auth::user()->id)
                        ->orderBy('id_prestasi', 'DESC')
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
                            $lihat = route('prestasi.show', $item->id_prestasi);
                            $edit = route('prestasi.edit', $item->id_prestasi);
                            $hapus = route('prestasi.destroy', $item->id_prestasi);
                            return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));
                        }else{
                            $button = 'LHERM';
                            $lihat = route('prestasi.show', $item->id_prestasi);
                            $edit = route('prestasi.edit', $item->id_prestasi);
                            $hapus = route('prestasi.destroy', $item->id_prestasi);
                            return view('datatable._action_button', compact('item', 'button', 'lihat', 'hapus','edit'));
                        }

                    })
                    ->escapeColumns([])
                    ->addIndexColumn()
                    ->make(true);
    }


    public function create()
    {
        //
        $santri = Santri::where('id_pesantren',Auth::user()->id)
            ->get();


        return view('back.prestasi.create',compact('santri'));
    }

    public function store(PrestasiRequest $request)
    {
        //
        $request->validated();

        $id_santri =  $request->input('id_santri');
        $santri = Santri::findOrFail($id_santri)
            ->first();
        $id_pesantren = $santri->id_pesantren;

        $save = Prestasi::create([
            'nama_prestasi' => $request->input('nama_prestasi'),
            'id_santri' => $request->input('id_santri'),
            'hadiah' => $request->input('hadiah'),
            'id_pesantren' => $id_pesantren
        ]);
        if ($save) {

            $orang_tua = OrangTua::where('email',$santri->email_wali_santri)
                ->first();
            $judul = "Santri anda mendapatkan prestasi baru !";
            $isi_pesan = "Ayo cek di aplikasi Nyantri";
            if ($orang_tua->fcm_token != null){
                sendFCM($judul,$isi_pesan,$orang_tua->fcm_token);
            }

            return redirect(route('prestasi.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan Prestasi',
                    'judul' => 'Data Prestasi'
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

        $data = Prestasi::findOrFail($id);
        $update = $data->update($requestData);

        if ($update) {
            return redirect(route('prestasi.index'))
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
        $data = Prestasi::select('users.name as nama_pesantren',
            'santri.*',
            'prestasi.*')
            ->leftJoin('santri','santri.id_santri','=','prestasi.id_santri')
            ->leftJoin('users','users.id','=','prestasi.id_pesantren')
            ->where('prestasi.id_prestasi',$id)
            ->first();

        return view('back.prestasi.show', compact('data'));
    }

    public function edit($id){
        $data = Prestasi::select('santri.*',
            'prestasi.*')
            ->leftJoin('santri','santri.id_santri','=','prestasi.id_santri')
            ->where('prestasi.id_prestasi',$id)
            ->first();

        return view('back.prestasi.edit', compact('data'));
    }


    public function destroy($id)
    {
        //

        $info = Prestasi::find($id);
        $delete = $info->forceDelete();

        $response = [];
        if($delete) {
            return Respon('', true, 'Berhasil menghapus data', 200);

        } else {
            return Respon('', false, 'Gagal menghapus data', 200);
        }
    }

   
}
