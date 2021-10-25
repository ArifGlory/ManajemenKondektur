<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\ImportRequest;
use App\Http\Requests\JadwalRequest;
use App\Http\Requests\Pegawai2Request;
use App\Imports\SantriDataImport;
// use App\Models\PangkatGolongan;
use App\Models\Jadwal;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

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
                $data = Jadwal::select('users.name','users.nip','jadwal.*')
                    ->join('users','users.id','=','jadwal.id_pegawai')
                    ->orderBy('jadwal.created_at', 'DESC')
                    ->get();
                return Datatables::of($data)
                    ->addColumn('waktu',function ($item){
                        $waktu = $item->jam_mulai." - ".$item->jam_selesai;

                        return $waktu;
                    })
                    ->editColumn('tanggal_jadwal',function($item){
                        $tanggal_jadwal = $item->tanggal_jadwal;
                        $tanggal_jadwal = Carbon::parse($tanggal_jadwal)->format('d M Y');

                        return $tanggal_jadwal;
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
                        if ($role == "admin"){
                            $lihat = route('jadwal.show', $item->id_jadwal);
                            $edit = route('jadwal.edit', $item->id_jadwal);
                            $hapus = route('jadwal.destroy', $item->id_jadwal);
                            $button = 'LEHRM';
                            return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));

                        }else{
                            $lihat = route('jadwal.show', $item->id_jadwal);
                            $button = 'LEHM';
                            return view('datatable._action_button', compact('item', 'button', 'lihat'));
                        }

                    })
                    ->escapeColumns([])
                    ->addIndexColumn()
                    ->make(true);
    }


    public function create()
    {
        //
        $pegawai = User::where('jenis_user',"user")
            ->get();

        return view('back.jadwal.create',compact('pegawai'));
    }

    public function store(JadwalRequest $request)
    {
        //
        $request->validated();

        $tanggal_jadwal = $request->input('tanggal_jadwal');
        $hari = Carbon::parse($tanggal_jadwal)->format('l');
        $hari = hariIndo($hari);

        $save = Jadwal::create([
            'id_pegawai' => $request->input('id_pegawai'),
            'hari' => $hari,
            'tanggal_jadwal' => $tanggal_jadwal,
            'jam_mulai' => $request->input('jam_mulai'),
            'jam_selesai' => $request->input('jam_selesai')
        ]);
        if ($save) {
            return redirect(route('jadwal.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan Jadwal',
                    'judul' => 'Data Jadwal'
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
