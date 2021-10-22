<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\DokumenRequest;
// use App\Models\Jabatan;
use App\Http\Requests\JenisSkRequest;
use App\Http\Requests\log_saldoRequest;
use App\Models\Dokumen;
use App\Models\Isilog_saldo;
use App\Models\JenisSk;
use App\Models\log_saldo;
use App\Models\LogSaldo;
use App\Models\ModelHasRoles;
// use App\Models\PangkatGolongan;
use App\Models\Santri;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use DataTables;
use App\Http\Controllers\Controller;

class LogSaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */


    public function index(Request $request)
    {
        $role = Auth::user()->jenis_user;
        if ($role == "admin"){
            return view('back.log_saldo.index');
        }else{
            abort('404');
        }
    }

    /*
     * Sumber data untuk datatable
     * pada Manajemen Pengguna
     * */
    public function data(Request $request)
    {
                $role = Auth::user()->jenis_user;
                if ($role == "admin"){
                    $data = LogSaldo::select('users.*','log_saldo.*','log_saldo.created_at as tanggal_log')
                        ->leftJoin('users','users.id','=','log_saldo.id_pesantren')
                        ->orderBy('log_saldo.id_log', 'DESC')
                        ->get();
                }else{
                    abort('404');
                }


                return Datatables::of($data)
                    ->editColumn('tanggal_log',function(LogSaldo $logSaldo){
                        $tanggal_log = $logSaldo->created_at;
                        $tanggal_log = Carbon::parse($tanggal_log)->format('d M Y | H:i');

                        return $tanggal_log;
                    })
                    ->editColumn('jumlah',function(LogSaldo $logSaldo){
                        $jumlah = $logSaldo->jumlah;
                        $jumlah = "Rp. ".number_format($jumlah,0,',','.');

                        return $jumlah;
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
                            $button = 'LRM';
                            $lihat = route('log-saldo.show', $item->id_log);
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
    }

    public function store(Request $request)
    {
    }

    public function update(Request $request, $id)
    {

    }


    public function show($id){
        $data = LogSaldo::select('users.*','log_saldo.*','log_saldo.keterangan as ket_log')
            ->join('users','users.id','=','log_saldo.id_pesantren')
            ->where('id_log',$id)
            ->first();

        return view('back.log_saldo.show', compact('data'));
    }

    public function edit($id){

    }


    public function destroy($id)
    {
        //
    }

   
}
