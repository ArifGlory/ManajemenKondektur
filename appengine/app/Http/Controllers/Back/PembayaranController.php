<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\pembayaranRequest;
use App\Http\Requests\JenisSkRequest;
use App\Http\Requests\KelasRequest;
use App\Models\Dokumen;
use App\Models\OrangTua;
use App\Models\Pembayaran;
use App\Models\pembayaranAktivitas;
use App\Models\JenisSk;
use App\Models\Santri;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use DataTables;
use App\Http\Controllers\Controller;
use function foo\func;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('back.pembayaran.index');
    }

    /*
     * Sumber data untuk datatable
     * pada Manajemen Pengguna
     * */
    public function data(Request $request)
    {
                $role = Auth::user()->jenis_user;
                if ($role == "admin"){
                    $data = Pembayaran::select()
                        ->join('santri','santri.id_santri','=','pembayaran.id_santri')
                        ->orderBy('id_pembayaran', 'DESC')
                        ->get();
                }else{
                    $data = Pembayaran::select()
                        ->join('santri','santri.id_santri','=','pembayaran.id_santri')
                        ->where('pembayaran.id_pesantren',Auth::user()->id)
                        ->orderBy('id_pembayaran', 'DESC')
                        ->get();
                }


                return Datatables::of($data)
                    ->editColumn('jml_bayar',function(Pembayaran $pembayaran){
                        $hasil_rupiah = "Rp " . number_format($pembayaran->jml_bayar,0,',','.');

                        return $hasil_rupiah;
                    })
                    ->addColumn('_action', function ($item) {
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
                            $lihat = route('pembayaran.show', $item->id_pembayaran);
                            $edit = route('pembayaran.edit', $item->id_pembayaran);
                            $hapus = route('pembayaran.destroy', $item->id_pembayaran);
                            return view('datatable._action_button', compact('item', 'button', 'lihat','edit', 'hapus'));
                        }else{
                            $button = 'LHRM';
                            $lihat = route('pembayaran.show', $item->id_pembayaran);
                            $hapus = route('pembayaran.destroy', $item->id_pembayaran);
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
        $santri = Santri::where('id_pesantren',Auth::user()->id)
            ->get();

        return view('back.pembayaran.create',compact('santri'));
    }

    public function store(PembayaranRequest $request)
    {
        //
        $request->validated();
        $id_pesantren     = Auth::user()->id;
        //$year             = date('Y');

        $save = Pembayaran::create([
            'id_santri' => $request->input('id_santri'),
            'bulan' => $request->input('bulan'),
            'jml_bayar' => $request->input('jml_bayar'),
            'keterangan' => $request->input('keterangan'),
            'status_pembayaran' => $request->input('status_pembayaran'),
            'id_pesantren' => $id_pesantren,
            'tahun' => $request->input('tahun')
        ]);
        if ($save) {
            $santri = Santri::where('id_santri',$request->input('id_santri'))
                ->first();
            $orang_tua = OrangTua::where('email',$santri->email_wali_santri)
                ->first();
            $judul = "Pembayaran santri ".$santri->nama_santri." ditambahkan";
            $isi_pesan = $request->input('jml_bayar')." telah dibayarkan, klik untuk melihat detail";
            if ($orang_tua->fcm_token != null){
                sendFCM($judul,$isi_pesan,$orang_tua->fcm_token);
            }


            return redirect(route('pembayaran.index'))
                ->with('pesan_status',[
                    'tipe' => 'info',
                    'desc' => 'Berhasil menambahkan tagihan pembayaran',
                    'judul' => 'Data pembayaran'
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

        $data = Pembayaran::findOrFail($id);
        $update = $data->update($requestData);

        if ($update) {
            return redirect(route('pembayaran.index'))
                ->with('pesan_status', [
                    'tipe' => 'info',
                    'desc' => 'Data Berhasil diupdate',
                    'judul' => 'Data pembayaran'
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
        $data = Pembayaran::select('pembayaran.created_at as tgl_buat_tagihan','users.*','pembayaran.*','santri.*')
            ->join('santri','santri.id_santri','=','pembayaran.id_santri')
            ->leftJoin('users','users.id','=','pembayaran.id_pesantren')
            ->where('pembayaran.id_pembayaran',$id)
            ->first();

        return view('back.pembayaran.show', compact('data'));
    }

    public function edit($id){
        $data = Pembayaran::select()
            ->join('santri','santri.id_santri','=','pembayaran.id_santri')
            ->where('id_pembayaran',$id)
            ->first();

        $santri = Santri::where('id_pesantren',Auth::user()->id)
            ->get();

        return view('back.pembayaran.edit', compact('data','santri'));
    }

    public function destroy($id)
    {
        //

        $info = Pembayaran::find($id);
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
