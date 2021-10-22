<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //
        return view('back.pengguna.index');
    }

    /*
     * Sumber data untuk datatable
     * pada Manajemen Pengguna
     * */
    public function data(Request $request)
    {
        $data = User::select('model_has_roles.model_id',
            'users.*')
            ->leftJoin('model_has_roles','model_has_roles.model_id','=','users.id')
            ->where('model_has_roles.role_id','!=',1) // bukan superadmin
            ->where('model_has_roles.role_id','!=',3) // bukan pegawai
            ->get();
        return Datatables::of($data)
            ->editColumn('picture', function ($item) {
                $size = 30;
                return view('datatable._image', compact('item', 'size'));
            })
            ->editColumn('created_at', function ($item) {
                return tanggalIndo($item->created_at);
            })
            ->addColumn('_action', function ($item) {
                /*
                  * C = Cetak => $cetak
                  * E = Edit => $edit
                  * H = Hapus => $hapus
                  * R = Restore = $restore
                  * M = Modal Dialog*/
                $button = 'EHRM';
                $edit = route('pengguna.edit', $item->id);
                $hapus = route('pengguna.destroy', $item->id);
                $restore = route('pengguna.restore', $item->id);
                return view('datatable._action_button', compact('item', 'button', 'edit', 'hapus', 'restore'));
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $role = Role::pluck('name', 'id');
        return view('back.pengguna.create', compact('role'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $photo = 'no_img.png';

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
            $image->move('img/user/', $photo);
        }
        $store = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('nama_lengkap'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'picture' => $photo
        ]);
        if ($store) {
            if ($request->input('role')) {
                $store->assignRole($request->input('role'));
            }
            return redirect(route('pengguna.index'))
                ->with('pesan_status', [
                    'tipe' => 'info',
                    'desc' => 'Data Berhasil ditambahkan',
                    'judul' => 'Data Pengguna'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'danger',
                'desc' => 'Server Error',
                'judul' => 'Terdapat kesalahan pada server.'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show($id)
    {
        //
        $user = User::find($id);
        return Respon($user, true, 'Berhasil mendapatkan data', 200);
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
        $data = User::find($id);
        $role_user = $data->roles->pluck('id');
        $roles = Role::pluck('name', 'id');
        return view('back.pengguna.edit', compact('data', 'roles', 'role_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pengguna)
    {
        //
        //$validate = $request->validated();
        $data = User::findOrFail($pengguna);
        if ($request->input('password')) {
            $requestData = $request->all();
        } else {
            $requestData = $request->except(['password']);
        }
        if ($request->has('photo')) {
            if ($data->picture != 'no_img.png') {
                unlink('img/user/' . $data->picture);
            }
            $image = $request->file('photo');
            $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
            $image->move('img/user/', $photo);
            $requestData['picture'] = $photo;
        }
        $data = User::findOrFail($pengguna);
        $update = $data->update($requestData);

        if ($update) {
            $data->syncRoles($request->input('role'));
            return redirect(route('pengguna.index'))
                ->with('pesan_status', [
                    'tipe' => 'info',
                    'desc' => 'Data Berhasil diupdate',
                    'judul' => 'Data Pengguna'
                ]);
        } else {
            Redirect::back()->with('pesan_status', [
                'tipe' => 'danger',
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
        $data = User::onlyTrashed();
        return Datatables::of($data)
            ->editColumn('photo', function ($item) {
                $size = 30;
                return view('datatable._image', compact('item', 'size'));
            })
            ->editColumn('created_at', function ($item) {
                return tanggalIndo($item->created_at);
            })
            ->addColumn('_action', function ($item) {
                /*
                 * L = Lihat => $lihat
                 * C = Cetak => $cetak
                 * E = Edit => $edit
                 * H = Hapus => $hapus
                 * R = Restore = $restore
                 * M = Modal Dialog*/
                $button = 'EHRM';
                $edit = route('pengguna.edit', $item->id);
                $hapus = route('pengguna.destroy', $item->id);
                $restore = route('pengguna.restore', $item->id);
                return view('datatable._action_button', compact('item','button', 'edit', 'hapus', 'restore'));
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }
    public function restore ($pengguna) {
        $info = User::withTrashed()->where('id',$pengguna)->restore();
        if($info) {
            return Respon('', true, 'Gagal mengembalikan data', 200);
        } else {
            return Respon('', false, 'Gagal mengembalikan data', 200);
        }
    }

    public function gantiPassword (Request $request) {
        $this->validate($request,[
           'set_password_lama' => 'required',
           'set_password' => 'required'
        ]);
        $user = Auth::user();
        if (Hash::check($request->input('set_password'), $user->password)) {
            return Respon('', false, 'Password Lama tidak benar!', 200);
        }
        $data = User::find($user->id);
        $update = $data->update([
           'password' => $request->input('set_password')
        ]);
        if ($update) {
            return Respon('', false, 'Berhasil merubah password', 200);
        } else {
            return Respon('', false, 'Gagal merubah password', 200);
        }
    }
    public function change (Request $request) {
        $this->validate($request, [
           'change-old-password' => 'required',
           'change-password' => 'min:8|required_with:change-re-password|same:change-re-password',
           'change-re-password' => 'min:8',
        ]);
        $err = new \stdClass;
        $user = Auth::user();
        if (Hash::check($request->input('change-old-password'), $user->password)) {
            $user->fill([
                'password' => $request->input('change-password')
            ])->save();

            return Respon('', true, 'Berhasil mengubah password!', 200);
        } else {
            $err->message = 'The given data was invalid.';
            $err->errors = (object) ["change-old-password" => ["Password lama tidak sama!"]];

            return response()->json($err, 422);
        }

    }
}
