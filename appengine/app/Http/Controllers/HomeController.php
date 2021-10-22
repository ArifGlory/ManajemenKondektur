<?php

namespace App\Http\Controllers;

use App\Fungsional;
use App\Models\Cuti;
use App\Models\Dokumen;
use App\Models\Iklan;
use App\Models\Infografis;
use App\Models\Jabatan;
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

            return view('back.dashboard');

        }else{
            $jml_kelas = Kelas::where('id_pesantren',Auth::user()->id)
                ->count();
            $jml_santri = Santri::where('id_pesantren',Auth::user()->id)
                ->count();
            $jml_jadwal = JadwalAktivitas::where('id_pesantren',Auth::user()->id)
                ->count();

            $santri_new =  Santri::where('id_pesantren',Auth::user()->id)
                ->orderBy('id_santri',"DESC")
                ->limit(5)
                ->get();
            $jadwal_new = JadwalAktivitas::where('id_pesantren',Auth::user()->id)
                ->orderBy('id_jadwal',"DESC")
                ->limit(5)
                ->get();
            $saldo = Auth::user()->saldo;

            return view('back.dashboard_pesantren',compact('jml_kelas','santri_new','jml_santri','jml_jadwal','jadwal_new','saldo'));
        }


    }


}
