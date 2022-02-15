<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\ImportRequest;
use App\Http\Requests\JadwalRequest;
use App\Http\Requests\Pegawai2Request;
use App\Http\Requests\TukarJadwalRequest;
use App\Imports\SantriDataImport;
// use App\Models\PangkatGolongan;
use App\Models\Jadwal;
use App\Models\Kereta;
use App\Models\TukarJadwal;
use App\Models\RiwayatJadwal;
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
                $data = Jadwal::select('users.name','users.nip','jadwal.*','kereta.nomor_kereta')
                    ->join('users','users.id','=','jadwal.id_pegawai')
                    ->join('kereta','kereta.id_kereta','=','jadwal.id_kereta')
                    ->orderBy('jadwal.tanggal_jadwal', 'ASC')
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
        $data = Jadwal::select('users.name','users.nip','users.id as id_user','jadwal.*','kereta.nomor_kereta')
            ->join('users','users.id','=','jadwal.id_pegawai')
            ->join('kereta','kereta.id_kereta','=','jadwal.id_kereta')
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
                ->join('jadwal','jadwal.id_jadwal','=','tukar_jadwal.id_riwayat_jadwal')
                ->orderBy('tukar_jadwal.status', 'DESC')
                ->orderBy('jadwal.created_at', 'DESC')
                ->get();
        }else{
            $data = TukarJadwal::select('users.name','users.nip','users.id as id_user','jadwal.*','tukar_jadwal.*')
                ->join('users','users.id','=','tukar_jadwal.id_pegawai')
                ->join('jadwal','jadwal.id_jadwal','=','tukar_jadwal.id_riwayat_jadwal')
                ->where('tukar_jadwal.id_pegawai',Auth::user()->id)
                ->orderBy('tukar_jadwal.status', 'DESC')
                ->orderBy('jadwal.created_at', 'DESC')
                ->get();
        }

        return Datatables::of($data)
            ->addColumn('waktu',function ($item){
                $waktu = $item->jam_mulai." - ".$item->jam_selesai;

                return $waktu;
            })
            ->editColumn('status',function($item){
                $status = $item->status;
                if ($status == "Menunggu"){
                    $html_status = "<span class=\"badge badge-success\">$status</span>";
                }else{
                    $html_status = $status;
                }

                return $html_status;
            })
            ->editColumn('tanggal_jadwal',function($item){
                $tanggal_jadwal = $item->tanggal_jadwal;
                $tanggal_jadwal = Carbon::parse($tanggal_jadwal)->format('d M Y');

                if ($item->status == "Diterima"){
                    $tanggal_jadwal = $tanggal_jadwal." [Telah Diubah ke Tanggal Penukaran]";
                }

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
        $permintaan_baru = TukarJadwal::select('users.name','users.nip','users.id as id_user','jadwal.*','tukar_jadwal.*')
            ->join('users','users.id','=','tukar_jadwal.id_pegawai')
            ->join('jadwal','jadwal.id_jadwal','=','tukar_jadwal.id_riwayat_jadwal')
            ->where('tukar_jadwal.status',"Menunggu")
            ->get();

        return view('back.jadwal.index_tukar_jadwal',compact('permintaan_baru'));
    }

    public function ajukanTukar($id_jadwal){
        $data = Jadwal::select('users.name','users.nip','users.id','jadwal.*','kereta.nama_kereta','kereta.nomor_kereta')
            ->join('users','users.id','=','jadwal.id_pegawai')
            ->join('kereta','kereta.id_kereta','=','jadwal.id_kereta')
            ->where('id_jadwal',$id_jadwal)
            ->first();

        $available_kereta = Kereta::select('kereta.*'
            ,'jadwal.id_jadwal'
            ,'jadwal.hari'
            ,'jadwal.tanggal_jadwal')
            ->join('jadwal','jadwal.id_kereta','=','kereta.id_kereta')
            ->get();

        return view('back.jadwal.tukar', compact('data','available_kereta'));
    }

    public function storePenukaran(TukarJadwalRequest $request){
        $request->validated();

        $id_jadwal_ditukar = $request->input('id_jadwal_tukar');
        $jadwal_tukar = Jadwal::findOrFail($id_jadwal_ditukar);

        $tanggal_jadwal_tukar = $jadwal_tukar['tanggal_jadwal'];
        $hari_tukar = Carbon::parse($tanggal_jadwal_tukar)->format('l');
        $hari_tukar = hariIndo($hari_tukar);
        $select_alasan = $request->input('select_alasan');

        if ($select_alasan == "sakit"){
            //simpan surat kleterangan sakit
            if ($request->hasFile('file_pendukung')) {
                $image = $request->file('file_pendukung');
                $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
                $image->move('img/file_pendukung/', $photo);
            }

            $save = TukarJadwal::create([
                'id_jadwal_diinginkan' => $jadwal_tukar['id_jadwal'],
                'id_riwayat_jadwal' => $request->input('id_jadwal'),
                'id_pegawai' => $request->input('id_pegawai'),
                'id_kereta_tukar' => $jadwal_tukar['id_kereta'],
                'hari_tukar' => $hari_tukar,
                'tanggal_jadwal_tukar' => $tanggal_jadwal_tukar,
                'alasan' => "Sakit",
                'file_pendukung' => $photo
            ]);
        }else{
            $deskripsi_alasan = $request->input('deskripsi_alasan');
            $save = TukarJadwal::create([
                'id_jadwal_diinginkan' => $jadwal_tukar['id_jadwal'],
                'id_riwayat_jadwal' => $request->input('id_jadwal'),
                'id_pegawai' => $request->input('id_pegawai'),
                'id_kereta_tukar' => $jadwal_tukar['id_kereta'],
                'hari_tukar' => $hari_tukar,
                'tanggal_jadwal_tukar' => $tanggal_jadwal_tukar,
                'alasan' => $deskripsi_alasan
            ]);
        }

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
        $kereta = Kereta::all();

        return view('back.jadwal.create',compact('pegawai','kereta'));
    }

    public function store(JadwalRequest $request)
    {
        //
        $request->validated();

        $tanggal_jadwal = $request->input('tanggal_jadwal');
        $hari = Carbon::parse($tanggal_jadwal)->format('l');
        $hari = hariIndo($hari);

        $cek_kesamaan_jadwal = Jadwal::select('users.name','users.nip')
            ->join('users','users.id','=','jadwal.id_pegawai')
            ->where('tanggal_jadwal',$tanggal_jadwal)
            ->where('jam_mulai',$request->input('jam_mulai'))
            ->where('jam_selesai',$request->input('jam_selesai'))
            ->first();

        if ($cek_kesamaan_jadwal){
            return Redirect::back()->withErrors(['msg' => 'Jadwal telah diisi oleh '.$cek_kesamaan_jadwal->name. " - ".$cek_kesamaan_jadwal->nip]);
        }else{
            $save = Jadwal::create([
                'id_pegawai' => $request->input('id_pegawai'),
                'id_kereta' => $request->input('id_kereta'),
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
        $data = Jadwal::select('users.name','users.nip','users.id as id_user','jadwal.*',
        'kereta.nama_kereta','kereta.nomor_kereta')
            ->join('users','users.id','=','jadwal.id_pegawai')
            ->join('kereta','kereta.id_kereta','=','jadwal.id_kereta','left')
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

        if ($data->status == "Diterima"){
            $riwayat_jadwal = RiwayatJadwal::findOrFail($data->id_riwayat_jadwal);
        }else{
            $riwayat_jadwal = array();
        }

        return view('back.jadwal.show_tukar_jadwal', compact('data','riwayat_jadwal'));
    }

    public  function updateTukarJadwal(Request $request){
        $requestData = $request->all();
        $id = $requestData['id_tukar_jadwal'];
        $data = TukarJadwal::findOrFail($id);

        $jadwal = Jadwal::findOrFail($data->id_jadwal);

        if ($requestData['status'] == "Diterima"){

            //simpan riwayat jadwal
            $history_jadwal = RiwayatJadwal::create([
                'id_pegawai' => $jadwal->id_pegawai,
                'hari' => $jadwal->hari,
                'tanggal_jadwal' => $jadwal->tanggal_jadwal,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai
            ]);
            $requestData['id_riwayat_jadwal'] = $history_jadwal->id_riwayat_jadwal;

            //update data jadwal tsb
            $data_update_jadwal = array(
                'hari'=>$data->hari_tukar,
                'tanggal_jadwal'=>$data->tanggal_jadwal_tukar,
                'jam_mulai'=>$data->jam_mulai_tukar,
                'jam_selesai'=>$data->jam_selesai_tukar
            );
            $update_jadwal = $jadwal->update($data_update_jadwal);
        }

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
        $kereta_selected = Kereta::where('id_kereta',$data->id_kereta)
            ->first();

        $kereta = Kereta::all();

        return view('back.jadwal.edit', compact('data','kereta','kereta_selected'));
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

    public function cetakJadwal(Request $request){
        $current_month = date('m');
        $current_year = date('Y');
        $bulan_aktif = bulanIndo($current_month);

        $data = Jadwal::select('users.name','users.nip','users.jabatan','jadwal.*','kereta.nomor_kereta','kereta.nama_kereta','kereta.deskripsi_kereta')
            ->join('users','users.id','=','jadwal.id_pegawai')
            ->join('kereta','kereta.id_kereta','=','jadwal.id_kereta','left')
            ->whereYear('jadwal.tanggal_jadwal', '=', $current_year)
            ->whereMonth('jadwal.tanggal_jadwal', '=', $current_month)
            ->orderBy('jadwal.tanggal_jadwal', 'ASC')
            ->groupBy('jadwal.tanggal_jadwal')
            ->get();

        return view('back.jadwal.report_jadwal', compact('data','bulan_aktif','current_year'));
    }

   
}
