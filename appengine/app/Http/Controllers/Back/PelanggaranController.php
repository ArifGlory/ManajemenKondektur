<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\JenisSkRequest;
use App\Http\Requests\PelanggaranRequest;
use App\Models\Dokumen;
use App\Models\JenisSk;
use App\Models\Kelas;
use App\Models\ModelHasRoles;
use App\Models\OrangTua;
use App\Models\Pelanggaran;
use App\Models\Santri;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use DataTables;
use App\Http\Controllers\Controller;

class PelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return "not now, still on construction";
    }

    /*
     * Sumber data untuk datatable
     * pada Manajemen Pengguna
     * */
    public function data(Request $request)
    {
        //
    }


    public function create()
    {
        //

        return view('back.pelanggaran.create');
    }

    public function make($id_santri)
    {
        //
        $data = Santri::select()
            ->where('id_santri',$id_santri)
            ->first();

        return view('back.pelanggaran.create',compact('data'));
    }

    public function store(PelanggaranRequest $request)
    {
        //
        $request->validated();

        $id_santri = $request->input('id_santri');
        $santri = Santri::findOrFail($id_santri)
            ->first();
        $id_pesantren = $santri->id_pesantren;

        $save = Pelanggaran::create([
            'nama_pelanggaran' => $request->input('nama_pelanggaran'),
            'jenis_pelanggaran' => $request->input('jenis_pelanggaran'),
            'id_santri' => $request->input('id_santri'),
            'keterangan' => $request->input('keterangan'),
            'id_pesantren' => $id_pesantren
        ]);
        if ($save) {
            $orang_tua = OrangTua::where('email',$santri->email_wali_santri)
                ->first();
            $judul = "Santri anda membuat pelanggaran !";
            $isi_pesan = "Cek detailnya di aplikasi Nyantri";
            if ($orang_tua->fcm_token != null){
                sendFCM($judul,$isi_pesan,$orang_tua->fcm_token);
            }

            return redirect(route('santri.show',$id_santri))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan Pelanggaran',
                    'judul' => 'Data Pelanggaran'
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

    }

    public function show($id){
        //
    }

    public function edit($id){
        //
    }

    public function hapus($id){
        $info = Pelanggaran::find($id);
        $info->destroy($id);

        return Redirect::back();
    }

    public function destroy($id)
    {
        //

        $info = Pelanggaran::find($id);
        dd($info);
        $delete = $info->destroy($id);

        return Redirect::back();
    }

   
}
