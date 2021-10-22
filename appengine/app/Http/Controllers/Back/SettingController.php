<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SettingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = Setting::all();
        $set = array();
        foreach ($data as $key) {
            # code...
            $arr = array();
            $arr[$key->key] = $key->value;
            $set = array_merge($set, $arr);
        }

        return view('back.setting', compact('set'));
    }

    public function store(Request $request) {
        foreach ($request->all() as $item => $field) {
            if($item == 'logo' || $item == 'favicon' || $item == 'struktur') {
                $data = Setting::where('key', $item)->first();
                if ($request->has($item)) {
                    if ($data && $data != null) {
                        if (file_exists('img/' . substr($data->value, strrpos($data->value, '/') + 1))){
                            //unlink('img/' . substr($data->value, strrpos($data->value, '/') + 1));
                        }
                    }
                    $image = $request->file($item);
                    $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
                    $image->move('img/', $photo);
                    $value = 'img/'.$photo;

                    Setting::updateOrCreate(
                        ['key' => $item],
                        ['value' => $value]
                    );
                }
            } else {
                Setting::updateOrCreate(
                    ['key' => $item],
                    ['value' => $field]
                );
            }
        }
        return redirect(route('setting.index'))->with('pesan_status', [
            'tipe' => 'info',
            'desc' => 'Data Setting di-update',
            'judul' => 'Setting'
        ]);
    }
}
