<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\IsiSaldoRequest;
use App\Http\Requests\PegawaiRequest;
use App\Models\Dokumen;
use App\Models\ImagePesantren;
use App\Models\Jabatan;
use App\Models\Kelas;
use App\Models\LogSaldo;
use App\Models\ModelHasRoles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use DataTables;
use App\Http\Controllers\Controller;

class PesantrenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function __construct()
    {

    }

    public function index(Request $request)
    {

        if (Auth::user()->jenis_user == "admin"){
            $search = $request->input('search');
            $status = $request->input('status');

            if($status == 'terhapus') {
                $data = User::select('*','users.id as id_user')
                    ->leftJoin('provinsi','provinsi.id_provinsi','=','users.id_provinsi')
                    ->leftJoin('kategori','kategori.id','=','users.id_kategori')
                    ->where('users.jenis_user','!=',"admin")
                    ->orderby('users.id','DESC')
                    ->onlyTrashed()
                    ->when($search, function ($query, $search) {
                        return $query->where('users.name', 'like', '%'. $search .'%');
                    })
                    ->paginate(12);
            } else {
                $data = User::select('*','users.id as id_user')
                    ->leftJoin('provinsi','provinsi.id_provinsi','=','users.id_provinsi')
                    ->leftJoin('kategori','kategori.id','=','users.id_kategori')
                    ->where('users.jenis_user','!=',"admin")
                    ->orderby('users.id','DESC')
                    ->when($search, function ($query, $search) {
                        return $query->where('users.name', 'like', '%'. $search .'%');
                    })->paginate(12);
            }

            if ($request->ajax()) {
                return view('back.pesantren._list_pesantren', compact('data'));
            }
            return view('back.pesantren.index', compact('data'));
        }else{
            return redirect()->back()->with('error_permission','Permission only admin');
        }



        //return view('back.pegawai.index');
    }

    /*
     * Sumber data untuk datatable
     * pada Manajemen Pengguna
     * */
    public function data(Request $request)
    {
        //$data = Pegawai::query();
        $data = User::select('*','users.id as id_user')
            ->join('provinsi','provinsi.id_provinsi','=','users.id_provinsi')
            ->leftJoin('kategori','kategori.id','=','users.id_kategori')
            ->where('users.jenis_user','!=',"admin");
            /*->orderby('users.id','DESC');*/
        //dd($data->get());

        return Datatables::eloquent($data)
            ->addColumn('_action', function ($item) {/*
                 /*
                 * L = Lihat => $lihat
                 * C = Cetak => $cetak
                 * E = Edit => $edit
                 * H = Hapus => $hapus
                 * R = Restore = $restore
                 * M = Modal Dialog*/
                $button = 'LEHRM';
                $lihat = url('/pesantren.show', $item->id);
                $edit = url('/pesantren.edit', $item->id);
                $hapus = url('/pesantren.destroy', $item->id);
                return view('datatable._action_button', compact('item', 'button', 'edit', 'hapus','lihat'));
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function addSaldo($id){
        if (Auth::user()->jenis_user == "admin"){
            $data = User::select()
                ->where('id',$id)
                ->first();

            return view('back.pesantren.add_saldo', compact('data'));
        }else{
            return abort('404');
        }


    }

    public function storeSaldo(IsiSaldoRequest $request){
        if (Auth::user()->jenis_user == "admin"){
            $validated = $request->validated();
            $data = User::findOrFail($request->input('id'));

            $jumlah_pengisian = $request->input('jumlah');
            $new_saldo = $data->saldo + $jumlah_pengisian;
            $update_pesantren = $data->update(array('saldo' => $new_saldo));

            //insert ke log
            LogSaldo::create([
                'id_pesantren' => $data->id,
                'jumlah' => $jumlah_pengisian,
                'keterangan' => "Pengisian saldo pesantren  ".$data->name,
                'created_by' => Auth::user()->id
            ]);

            if ($update_pesantren) {
                return redirect(route('pesantren.show',$data->id))
                    ->with('pesan_status', [
                        'tipe' => 'info',
                        'desc' => 'Pengisian Saldo Berhasil',
                        'judul' => 'Data Pesantren'
                    ]);
            } else {
                Redirect::back()->with('pesan_status', [
                    'tipe' => 'error',
                    'desc' => 'Server Error',
                    'judul' => 'Terdapat kesalahan pada server.'
                ]);
            }

        }else{
            return abort('404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show($id)
    {

        $data = User::select('*','users.id as id_user')
            ->join('provinsi','provinsi.id_provinsi','=','users.id_provinsi')
            ->leftJoin('kategori','kategori.id','=','users.id_kategori')
            ->where('users.id',$id)
            ->first();
        $user_id = $id;

        $image_pesantren = ImagePesantren::select('*')
            ->where('id_user',$id)
            ->get();

        Session::put('id_pesantren',$id);

        return view('back.pesantren.show', compact('data','user_id','image_pesantren'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        //$data = Pegawai::find($id);
        $data = User::select()
            ->join('jabatan','jabatan.id','=','users.id_jabatan')
            ->join('pangkat_golongan','pangkat_golongan.id','=','users.id_pangkat_golongan')
            ->where('users.id',$id)
            ->first();

        $jabatan = Jabatan::all();
        $pangkat_golongan = PangkatGolongan::all();
        $user_id = $id;

        return view('back.pegawai.edit', compact('data','jabatan','pangkat_golongan','user_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = User::findOrFail($id);
        $requestData = $request->all();
        $requestData['updated_by'] = Auth::user()->id;

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
            $image->move('img/user/', $photo);
            $requestData['picture'] = $photo;
        }
        $data = User::findOrFail($id);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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

    public function trash (Request $request) {
        $data = User::select('jabatan.*','pangkat_golongan.*','users.*')
            ->join('jabatan','jabatan.id','=','users.id_jabatan')
            ->join('pangkat_golongan','pangkat_golongan.id','=','users.id_pangkat_golongan')
            ->onlyTrashed();
        return Datatables::of($data)
            ->addColumn('_action', function ($item) {
                /*
                 * L = Lihat => $lihat
                 * C = Cetak => $cetak
                 * E = Edit => $edit
                 * H = Hapus => $hapus
                 * R = Restore = $restore
                 * M = Modal Dialog*/
                $button = 'EHRM';
                $edit = route('pegawai.edit', $item->id);
                $hapus = route('pegawai.destroy', $item->id);
                $restore = route('pegawai.restore', $item->id);
                return view('datatable._action_button', compact('item','button', 'edit', 'hapus', 'restore'));
            })
            ->orderColumn('deleted_at', '+deleted_at $1')
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }
    public function restore ($id) {
        $info = User::withTrashed()->where('id',$id)->restore();
        if($info) {
            return Respon('', true, 'Berhasil mengembalikan data', 200);
        } else {
            return Respon('', false, 'Gagal mengembalikan data', 200);
        }
    }

    public function resetpass($id){
        $arr['id'] = $id;
        $arr['password'] = '12345678';
        $data = User::findOrFail($id);
        $update = $data->update($arr);
        if ($update) {
            return redirect(route('pesantren.index'))
                ->with('pesan_status', [
                    'tipe' => 'info',
                    'desc' => 'Password berhasil di reset ke default',
                    'judul' => 'Data Pesantren'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'error',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }
    }
}
