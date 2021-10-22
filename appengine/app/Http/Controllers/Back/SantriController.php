<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\DokumenRequest;
// use App\Models\Jabatan;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\JenisSkRequest;
use App\Http\Requests\KelasRequest;
use App\Http\Requests\SantriRequest;
use App\Imports\SantriDataImport;
use App\Models\Dokumen;
use App\Models\JenisSk;
use App\Models\Kelas;
use App\Models\Kitab;
use App\Models\LogSaldo;
use App\Models\ModelHasRoles;
// use App\Models\PangkatGolongan;
use App\Models\OrangTua;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
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
use Maatwebsite\Excel\Facades\Excel;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('back.santri.index');
    }

    /*
     * Sumber data untuk datatable
     * pada Manajemen Pengguna
     * */
    public function data(Request $request)
    {
                $role = Auth::user()->jenis_user;
                if ($role == "admin"){
                    $data = Santri::select('santri.*','orang_tua.*','santri.id_santri as primary_santri')
                        ->leftJoin('orang_tua','orang_tua.email','=','santri.email_wali_santri')
                        ->orderBy('santri.id_santri', 'DESC')
                        ->get();
                }else{
                    $data = Santri::select('santri.*','orang_tua.*','santri.id_santri as primary_santri')
                        ->leftJoin('orang_tua','orang_tua.email','=','santri.email_wali_santri')
                        ->where('santri.id_pesantren',Auth::user()->id)
                        ->orderBy('santri.id_santri', 'DESC')
                        ->get();
                }


                return Datatables::of($data)
                    ->editColumn('name',function(Santri $santri){
                        //name maksudnya nama wali nya, bukan nama santri
                        $name = $santri->name;
                        if ($name == null){
                            $name = "Belum di pilih";
                        }

                        return $name;
                    })
                    ->editColumn('status_aktivasi',function(Santri $santri){
                        $status = $santri->status_aktivasi;
                        if ($status == 0){
                            $status = "Belum aktivasi premium";
                        }else{
                            $status = "Sudah Aktivasi Premium";
                        }

                        return $status;
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
                            $lihat = route('santri.show', $item->primary_santri);
                            $edit = route('santri.edit', $item->primary_santri);
                            $hapus = route('santri.destroy', $item->primary_santri);
                            if ($item->status_aktivasi == 0){
                                $button = 'LEHARM';
                                $aktivasi = route('santri.aktivasi', $item->primary_santri);
                                return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus','aktivasi'));
                            }else{
                                $button = 'LEHRM';
                                return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));
                            }

                        }else{
                            $lihat = route('santri.show', $item->primary_santri);
                            $edit = route('santri.edit', $item->primary_santri);
                            $hapus = route('santri.destroy', $item->primary_santri);
                            if ($item->status_aktivasi == 0){
                                $button = 'LEHAM';
                                $aktivasi = route('santri.aktivasi', $item->primary_santri);
                                return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus','aktivasi'));
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
        $role = Auth::user()->jenis_user;
        if ($role == "admin") {
            $id_pesantren = Session::get('id_pesantren');
        }else{
            $id_pesantren = Auth::user()->id;
        }
        $wali_santris = OrangTua::where('id_pesantren',$id_pesantren)
            ->get();

        return view('back.santri.create',compact('wali_santris'));
    }

    public function createMulti()
    {
        //
        return view('back.santri.create_multi');
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

    public function store(SantriRequest $request)
    {
        //
        $request->validated();
        $role = Auth::user()->jenis_user;
        if ($role == "admin") {
            $id_pesantren = Session::get('id_pesantren');
        }else{
            $id_pesantren = Auth::user()->id;
        }

        $email_wali_santri = $request->input('email_wali_santri');
        if ($email_wali_santri == "null" || $email_wali_santri == null){
            $email_wali_santri = null;
        }

        if ($request->hasFile('foto_santri')) {
            $image = $request->file('foto_santri');
            $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
            $image->move('img/santri/', $photo);
        }

        $save = Santri::create([
            'nama_santri' => $request->input('nama_santri'),
            'asal_santri' => $request->input('asal_santri'),
            'email_wali_santri' => $email_wali_santri,
            'id_pesantren' => $id_pesantren,
            'foto_santri' => $photo
        ]);
        if ($save) {
            return redirect(route('santri.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan Santri',
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

    public function update(Request $request, $id)
    {
        //

        $requestData = $request->all();

        $data = Santri::findOrFail($id);

        if ($request->hasFile('foto_santri')) {
            //hapus foto lama
            if ($data->foto_santri != "padrao.png"){
                if (file_exists('img/santri/' . $data->foto_santri)) {
                    unlink('img/santri/' . $data->foto_santri);
                }
            }

            $image = $request->file('foto_santri');
            $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
            $image->move('img/santri/', $photo);
            $requestData['foto_santri'] = $photo;
        }

        $update = $data->update($requestData);
        if ($update) {
            $orang_tua = OrangTua::where('email',$data->email_wali_santri)
                ->first();
            $judul = "Data Santri ".$data->nama_santri." telah diubah";
            $isi_pesan = "Cek detailnya di aplikasi Nyantri";
            if ($orang_tua->fcm_token != null){
                sendFCM($judul,$isi_pesan,$orang_tua->fcm_token);
            }


            return redirect(route('santri.index'))
                ->with('pesan_status', [
                    'tipe' => 'info',
                    'desc' => 'Data Berhasil diupdate',
                    'judul' => 'Data Santri'
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
        $data = Santri::select('santri.*',
            'orang_tua.*',
            'users.name as nama_pesantren',
            'orang_tua.name as nama_wali',
            'santri.id_santri as primary_santri')
            ->leftJoin('users','users.id','=','santri.id_pesantren')
            ->leftJoin('orang_tua','orang_tua.email','=','santri.email_wali_santri')
            ->where('santri.id_santri',$id)
            ->first();

        $pelanggaran = Pelanggaran::where('id_santri',$id)
            ->get();
        $kitab = Kitab::select()
            ->join('kitab_milik_santri','kitab_milik_santri.id_kitab','=','kitab.id_kitab')
            ->where('kitab_milik_santri.id_santri',$id)
            ->get();
        $prestasi = Prestasi::where('id_santri',$id)
            ->get();

       

        return view('back.santri.show', compact('data','pelanggaran','kitab','prestasi'));
    }


    public function edit($id){
        $data = Santri::select('santri.*','orang_tua.*','santri.id_pesantren as primary_pesantren','santri.id_santri as primary_santri')
            ->leftJoin('orang_tua','orang_tua.email','=','santri.email_wali_santri')
            ->where('santri.id_santri',$id)
            ->first();

        $wali_santris = OrangTua::where('id_pesantren',$data->primary_pesantren)
            ->get();

        return view('back.santri.edit', compact('data','wali_santris'));
    }

    public function destroy($id)
    {
        //

        $info = Santri::withTrashed()->find($id);
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

    public function aktivasi($id){
        $data = Santri::findOrFail($id);
        $pesantren = User::findOrFail($data->id_pesantren);

        $res = [];

        if ($pesantren->saldo > 10000){
            $update = $data->update(array('status_aktivasi' => 1));

            //update saldo pesantren
            $new_saldo = $pesantren->saldo - 10000;
            $update_pesantren = $pesantren->update(array('saldo' => $new_saldo));

            //insert ke log
            LogSaldo::create([
                'id_pesantren' => $data->id_pesantren,
                'jumlah' => 10000,
                'keterangan' => "Aktivasi akun premium santri ".$data->nama_santri,
                'created_by' => Auth::user()->id
            ]);

            if ($update){
                $res['pesan'] = 'Aktivasi Akun Premium Santri ini telah berhasil';
                $res['statusCode'] = 200;
                $res['status'] = true;
                $res['data'] = '';
            }else{
                $res['pesan'] = 'Aktivasi Akun Premium Santri ini gagal,coba lagi nanti';
                $res['statusCode'] = 200;
                $res['status'] = false;
                $res['data'] = '';
            }

        }else{
            $res['pesan'] = 'Saldo Pesantren tidak cukup';
            $res['statusCode'] = 200;
            $res['status'] = false;
            $res['data'] = '';
        }


        return Respon($res['data'], $res['status'], $res['pesan'], $res['statusCode']);
    }

   
}
