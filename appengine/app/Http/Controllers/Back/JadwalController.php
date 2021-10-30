<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\ImportRequest;
use App\Http\Requests\JadwalRequest;
use App\Http\Requests\Pegawai2Request;
use App\Http\Requests\TukarJadwalRequest;
use App\Imports\SantriDataImport;
// use App\Models\PangkatGolongan;
use App\Models\Jadwal;
use App\Models\TukarJadwal;
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


    public function dataCariJadwal(Request $request)
    {
        $role = Auth::user()->jenis_user;
        $data = Jadwal::select('users.name','users.nip','users.id as id_user','jadwal.*')
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
                $id_user = Auth::user()->id;
                if ($role == "admin"){
                    $lihat = route('jadwal.show', $item->id_jadwal);
                    $edit = route('jadwal.edit', $item->id_jadwal);
                    $hapus = route('jadwal.destroy', $item->id_jadwal);
                    $button = 'LEHRM';
                    return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));

                }else{
                    if ($item->id_user == $id_user){
                        $lihat = route('jadwal.show', $item->id_jadwal);
                        $tukar = route('jadwal.tukar', $item->id_jadwal);
                        $button = 'LT';
                        return view('datatable._action_button', compact('item', 'button', 'lihat','tukar'));
                    }else{
                        $lihat = route('jadwal.show', $item->id_jadwal);
                        $button = 'L';
                        return view('datatable._action_button', compact('item', 'button', 'lihat'));
                    }

                }

            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

    public function dataTukarJadwal(Request $request)
    {
        $role = Auth::user()->jenis_user;
        if ($role == "admin"){
            $data = TukarJadwal::select('users.name','users.nip','users.id as id_user','jadwal.*','tukar_jadwal.*')
                ->join('users','users.id','=','tukar_jadwal.id_pegawai')
                ->join('jadwal','jadwal.id_jadwal','=','tukar_jadwal.id_jadwal')
                ->orderBy('jadwal.created_at', 'DESC')
                ->get();
        }else{
            $data = TukarJadwal::select('users.name','users.nip','users.id as id_user','jadwal.*','tukar_jadwal.*')
                ->join('users','users.id','=','tukar_jadwal.id_pegawai')
                ->join('jadwal','jadwal.id_jadwal','=','tukar_jadwal.id_jadwal')
                ->where('tukar_jadwal.id_pegawai',Auth::user()->id)
                ->orderBy('jadwal.created_at', 'DESC')
                ->get();
        }

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
            ->editColumn('tanggal_jadwal_tukar',function($item){
                $tanggal_jadwal_tukar = $item->tanggal_jadwal_tukar;
                $tanggal_jadwal_tukar = Carbon::parse($tanggal_jadwal_tukar)->format('d M Y');

                return $tanggal_jadwal_tukar;
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
                $id_user = Auth::user()->id;
                if ($role == "admin"){
                    $lihat = route('jadwal.show-tukar-jadwal', $item->id_tukar_jadwal);
                    $button = 'L';
                    return view('datatable._action_button', compact('item', 'button', 'lihat'));

                }else{
                    if ($item->id_user == $id_user){
                        $lihat = route('jadwal.show-tukar-jadwal', $item->id_tukar_jadwal);
                        $button = 'L';
                        return view('datatable._action_button', compact('item', 'button', 'lihat'));
                    }

                }

            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

    public function listTukarJadwal(Request $request){
        return view('back.jadwal.index_tukar_jadwal');
    }

    public function ajukanTukar($id_jadwal){
        $data = Jadwal::select('users.name','users.nip','users.id','jadwal.*')
            ->join('users','users.id','=','jadwal.id_pegawai')
            ->where('id_jadwal',$id_jadwal)
            ->first();

        return view('back.jadwal.tukar', compact('data'));
    }

    public function storePenukaran(TukarJadwalRequest $request){
        $request->validated();

        $tanggal_jadwal_tukar = $request->input('tanggal_jadwal_tukar');
        $hari_tukar = Carbon::parse($tanggal_jadwal_tukar)->format('l');
        $hari_tukar = hariIndo($hari_tukar);

        $save = TukarJadwal::create([
            'id_jadwal' => $request->input('id_jadwal'),
            'id_pegawai' => $request->input('id_pegawai'),
            'hari_tukar' => $hari_tukar,
            'tanggal_jadwal_tukar' => $tanggal_jadwal_tukar,
            'jam_mulai_tukar' => $request->input('jam_mulai_tukar'),
            'jam_selesai_tukar' => $request->input('jam_selesai_tukar')
        ]);
        if ($save) {
            return redirect(route('jadwal.tukar-jadwal'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan Pengajuan',
                    'judul' => 'Data Penukaran Jadwal'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'danger',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }
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
        $data = Jadwal::findOrFail($id);

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
        $data = Jadwal::select('users.name','users.nip','users.id as id_user','jadwal.*')
            ->join('users','users.id','=','jadwal.id_pegawai')
            ->where('id_jadwal',$id)
            ->first();

        return view('back.jadwal.show', compact('data'));
    }

    public function showTukarJadwal($id_tukar_jadwal){
        $data = TukarJadwal::select('users.name','users.nip','users.id as id_user',
            'jadwal.hari','jadwal.tanggal_jadwal','jadwal.jam_mulai','jadwal.jam_selesai',
            'tukar_jadwal.*')
            ->join('users','users.id','=','tukar_jadwal.id_pegawai')
            ->join('jadwal','jadwal.id_jadwal','=','tukar_jadwal.id_jadwal')
            ->where('id_tukar_jadwal',$id_tukar_jadwal)
            ->first();

        return view('back.jadwal.show_tukar_jadwal', compact('data'));
    }

    public  function updateTukarJadwal(Request $request){
        $requestData = $request->all();
        $id = $requestData['id_tukar_jadwal'];
        $data = TukarJadwal::findOrFail($id);

        $update = $data->update($requestData);
        if ($update) {

            return redirect(route('jadwal.tukar-jadwal'))
                ->with('pesan_status', [
                    'tipe' => 'info',
                    'desc' => 'Data Berhasil diupdate',
                    'judul' => 'Data Tukar Jadwal'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'error',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }
    }


    public function edit($id){
        $data = Jadwal::select('users.name','users.nip','users.id','jadwal.*')
            ->join('users','users.id','=','jadwal.id_pegawai')
            ->where('id_jadwal',$id)
            ->first();

        return view('back.jadwal.edit', compact('data'));
    }

    public function destroy($id)
    {
        //

        $info = Jadwal::find($id);
        $delete = $info->destroy($id);
        /*if ($info->trashed()) {
            $delete = $info->forceDelete();
        } else {
            $delete = $info->destroy($id);
        }*/

        $response = [];
        if($delete) {
            return Respon('', true, 'Berhasil menghapus data', 200);

        } else {
            return Respon('', false, 'Gagal menghapus data', 200);
        }
    }

   
}
