<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\DokumenRequest;
// use App\Models\Jabatan;
use App\Http\Requests\JadwalRequest;
use App\Http\Requests\JenisSkRequest;
use App\Http\Requests\KelasRequest;
use App\Models\Dokumen;
use App\Models\JadwalAktivitas;
use App\Models\JenisSk;
use App\Models\Kelas;
use App\Models\ModelHasRoles;
// use App\Models\PangkatGolongan;
use App\Models\OrangTua;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use DataTables;
use App\Http\Controllers\Controller;

//used for FCM
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('back.jadwal.index');
    }

    /*
     * Sumber data untuk datatable
     * pada Manajemen Pengguna
     * */
    public function data(Request $request)
    {
                $role = Auth::user()->jenis_user;
                if ($role == "admin"){
                    $data = JadwalAktivitas::select()
                        ->orderBy('id_jadwal', 'DESC')
                        ->get();
                }else{
                    $data = JadwalAktivitas::select()
                        ->where('id_pesantren',Auth::user()->id)
                        ->orderBy('id_jadwal', 'DESC')
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
                            $lihat = route('jadwal.show', $item->id_jadwal);
                            $edit = route('jadwal.edit', $item->id_jadwal);
                            $hapus = route('jadwal.destroy', $item->id_jadwal);
                            return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));
                        }else{
                            $button = 'LHRM';
                            $lihat = route('jadwal.show', $item->id_jadwal);
                            $hapus = route('jadwal.destroy', $item->id_jadwal);
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

        return view('back.jadwal.create');
    }

    public function store(JadwalRequest $request)
    {
        //
        $request->validated();
        $id_pesantren     = Auth::user()->id;

        $save = JadwalAktivitas::create([
            'nama_jadwal' => $request->input('nama_jadwal'),
            'tanggal_jadwal' => $request->input('tanggal_jadwal'),
            'keterangan' => $request->input('keterangan'),
            'id_pesantren' => $id_pesantren
        ]);
        if ($save) {
            $multiple_token = OrangTua::where('id_pesantren',$id_pesantren)
                ->pluck('fcm_token')
                //->where('id_pesantren',$id_pesantren)
                ->toArray();
            $judul = "Ada Jadwal kegiatan baru !";
            $isi_pesan = "terdapat jadwal kegiatan baru dari pesantren anda";
            sendFCM($judul,$isi_pesan,$multiple_token);

            return redirect(route('jadwal.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan Jadwal Kegiatan',
                    'judul' => 'Data Jadwal Kegiatan'
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
        unset($requestData['_token']);

        $data = JadwalAktivitas::findOrFail($id);
        $update = $data->update($requestData);

        if ($update) {
            return redirect(route('jadwal.index'))
                ->with('pesan_status', [
                    'tipe' => 'info',
                    'desc' => 'Data Berhasil diupdate',
                    'judul' => 'Data Jadwal'
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
        $data = JadwalAktivitas::select('users.*','jadwal_aktivitas.*','jadwal_aktivitas.keterangan as keterangan_jadwal')
            ->join('users','users.id','=','jadwal_aktivitas.id_pesantren')
            ->where('jadwal_aktivitas.id_jadwal',$id)
            ->first();

        return view('back.jadwal.show', compact('data'));
    }

    public function edit($id){
        $data = JadwalAktivitas::select('*')
            ->where('id_jadwal',$id)
            ->first();

        return view('back.jadwal.edit', compact('data'));
    }

    public function destroy($id)
    {
        //

        $info = JadwalAktivitas::find($id);
        $delete = $info->destroy($id);

        $response = [];
        if($delete) {
            return Respon('', true, 'Berhasil menghapus data', 200);

        } else {
            return Respon('', false, 'Gagal menghapus data', 200);
        }
    }

   
}
