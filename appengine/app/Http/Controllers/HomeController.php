<?php

namespace App\Http\Controllers;

use App\Fungsional;
use App\Models\Cuti;
use App\Models\Dokumen;
use App\Models\Iklan;
use App\Models\Infografis;
use App\Models\Jabatan;
use App\Models\Jadwal;
use App\Models\JadwalAktivitas;
use App\Models\JenisSk;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Santri;
use App\Models\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

    }


    public function dashboard(Request $request){

        $role = Auth::user()->jenis_user;
        if ($role == "admin"){

            $jml_pegawai = User::where('jenis_user','user')
                ->count();
            $jml_jadwal = Jadwal::count();

            return view('back.dashboard',compact('jml_jadwal','jml_pegawai'));

        }else{
            $jml_pegawai = User::where('jenis_user','user')
                ->count();
            $jml_jadwal = Jadwal::count();
            return view('back.dashboard_pegawai',compact('jml_jadwal','jml_pegawai'));
        }

    }

    public function editProfile(Request $request){
        $data = User::findOrFail(Auth::user()->id);

        return view('auth.edit_profile',compact('data'));
    }

    public function updateProfile(Request $request){
        $requestData = $request->all();

        $data = User::findOrFail($requestData['id_user']);
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

            return redirect(route('dashboard'))
                ->with('pesan_status', [
                    'tipe' => 'info',
                    'desc' => 'Data Berhasil diupdate',
                    'judul' => 'Data Profil'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'error',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }
    }

    public function cariJadwal(Request $request){
        return view('back.jadwal.index_pegawai');
    }


}
