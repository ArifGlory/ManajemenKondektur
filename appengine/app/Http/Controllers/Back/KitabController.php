<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\ImportRequest;
use App\Http\Requests\KitabRequest;
use App\Http\Requests\KMSRequest;
use App\Imports\KitabDataImport;
use App\Models\Kitab;
use App\Models\KitabMilikSantri;
use App\Models\OrangTua;
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

class KitabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('back.kitab.index');
    }

   
    public function data(Request $request)
    {
        //
        $role = Auth::user()->jenis_user;
        if ($role == "admin"){
            $data = Kitab::select()
                ->orderBy('id_kitab', 'DESC')
                ->get();     
        }else{
            $data = Kitab::select()
                ->where('id_pesantren',Auth::user()->id)
                ->orderBy('id_kitab', 'DESC')
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
                            $lihat = route('kitab.show', $item->id_kitab);
                            $edit = route('kitab.edit', $item->id_kitab);
                            $hapus = route('kitab.destroy', $item->id_kitab);
                            return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));
                        }else{
                            $button = 'LEHRM';
                            $lihat = route('kitab.show', $item->id_kitab);
                            $edit = route('kitab.edit', $item->id_kitab);
                            $hapus = route('kitab.destroy', $item->id_kitab);
                            return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));
                        }

                    })
                    ->escapeColumns([])
                    ->addIndexColumn()
                    ->make(true);            
    }


    public function create()
    {
        //dd(Auth::user()->id);

        return view('back.kitab.create');
    }

    public function make($id_kitab)
    {
        //
        $data = Santri::select()
            ->where('id_pesantren',Auth::user()->id)
            ->get();

        return view('back.kitab.add_santri',compact('data','id_kitab'));
    }

    public function makeMulti($id_santri){

       /* $tes =  Session::get('tes');
        dd($tes);*/
        $data  = Santri::find($id_santri)
            ->first();

        Session::put('id_santri_kitab', $id_santri);
        Session::put('id_pesantren_kitab', $data->id_pesantren);

        return view('back.kitab.create_multi');
    }

    public function storeMulti(ImportRequest $request){
        $nama_file = "";
        $id_santri     = Session::get('id_santri_kitab');

        if ($request->hasFile('file_excel')) {
            $file = $request->file('file_excel');
            $nama_file = round(microtime(true) * 1000) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/excel/'), $nama_file);
        }

        //$save =  Excel::import(new SantriDataImport(), public_path('/excel/'.$nama_file) );
        $import = new KitabDataImport();
        $import->import(public_path('/excel/'.$nama_file));

        if ($import) {
            return redirect(route('santri.show',$id_santri))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil import data Kitab',
                    'judul' => 'Data kitab'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'danger',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }
    }

    public function store(KitabRequest $request)
    {
        //
        $request->validated();
        
        $id_pesantren = Auth::user()->id;


        $save = Kitab::create([
            'nama_kitab' => $request->input('nama_kitab'),
            'keterangan' => $request->input('keterangan'),
            'id_pesantren' => $id_pesantren
        ]);

        if ($save) {
            return redirect(route('kitab.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan kitab',
                    'judul' => 'Data kitab'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'danger',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }
    }
    
    public function storeSantriToKitab(KMSRequest $request){
        $request->validated();
        
        $requestData = $request->all();
        $id_pesantren = Auth::user()->id;
        $id_kitab = $request->input('id_kitab');
        $id_santri = $request->input('id_santri');
        $status = $request->input('status');
        
        for($i=0;$i < count($id_santri); $i++){
            $save = KitabMilikSantri::create([
                'id_kitab' => $id_kitab,
                'id_santri' => $id_santri[$i],
                'id_pesantren' => $id_pesantren,
                'status' => $status
            ]);

            $santri = Santri::where('id_santri',$id_santri[$i])
                ->first();
            $orang_tua = OrangTua::where('email',$santri->email_wali_santri)
                ->first();
            $judul = "Kitab Baru ditambahkan pada santri anda";
            $isi_pesan = "Cek detailnya di aplikasi Nyantri";
            if ($orang_tua->fcm_token != null){
                sendFCM($judul,$isi_pesan,$orang_tua->fcm_token);
            }
        }
        
        if ($save) {
            return redirect(route('kitab.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan kitab ke santri',
                    'judul' => 'Data kitab'
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

        $data = Kitab::findOrFail($id);
        $update = $data->update($requestData);

        if ($update) {
            return redirect(route('kitab.index'))
                ->with('pesan_status', [
                    'tipe' => 'info',
                    'desc' => 'Data Berhasil diupdate',
                    'judul' => 'Data Kitab'
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
        //
        $data = Kitab::findOrFail($id);
    
        $santri_dikitab = KitabMilikSantri::select()
        ->join('santri','santri.id_santri','=','kitab_milik_santri.id_santri')
        ->where('kitab_milik_santri.id_kitab',$id)
        ->get();
        
       
            
        return view('back.kitab.show',compact('data','santri_dikitab'));    
    }

    public function edit($id){
        //
       
        $data = Kitab::find($id);

        return view('back.kitab.edit',compact('data'));
    }
    
    public function removeFromKitab($id_kms){
        $info = KitabMilikSantri::find($id_kms);
        $kitab = Kitab::where('id_kitab',$info->id_kitab)
            ->first();
        $santri = Santri::where('id_santri',$info->id_santri)
            ->first();
        $orang_tua = OrangTua::where('email',$santri->email_wali_santri)
            ->first();


        $judul = "Kitab ".$kitab->nama_kitab." dihapus dari santri anda";
        $isi_pesan = "Cek detailnya di aplikasi Nyantri";
        if ($orang_tua->fcm_token != null){
            sendFCM($judul,$isi_pesan,$orang_tua->fcm_token);
        }


        $info->destroy($id_kms);

        return Redirect::back();
    }
    
    public function editStatus($id_kms){
        $info = KitabMilikSantri::find($id_kms);
        if($info->status == "Belum Selesai"){
            $status_new = "Selesai";
        }else{
            $status_new = "Belum Selesai";
        }
        
        $data_update = array(
            'status'=>$status_new
            );
            
        $update = $info->update($data_update);
        
        return Redirect::back();
    }

    public function hapus($id){
        $info = Kitab::find($id);
        $info->destroy($id);

        return Redirect::back();
    }

    public function destroy($id)
    {
        //

        $info = Kitab::find($id);
        $delete = $info->destroy($id);

        $response = [];
        if($delete) {
            return Respon('', true, 'Berhasil menghapus data', 200);

        } else {
            return Respon('', false, 'Gagal menghapus data', 200);
        }
    }

   
}
