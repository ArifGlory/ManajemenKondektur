<?php

namespace App\Http\Controllers\Back;

use App\Models\Kelas;
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
//used for FCM
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class CloudMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('back.cloud_message.create');
    }


    public function send(Request $request){
        $device_token = $request->input('device_token');
        $isi_pesan = $request->input('isi_pesan');
        $judul_pesan = $request->input('judul_pesan');

        $opsi_fcm =  $this->setFCMOption($judul_pesan,$isi_pesan);

        //response
        $downstreamResponse = FCM::sendTo($device_token, $opsi_fcm['option'], $opsi_fcm['notification'], $opsi_fcm['data']);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->tokensWithError();

        dd($downstreamResponse);
    }

    function setFCMOption($judul_pesan,$isi_pesan){
        //set the FCM
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($judul_pesan);
        $notificationBuilder->setBody($isi_pesan)
            ->setSound('default');
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $opsi_fcm['option'] = $option;
        $opsi_fcm['notification'] = $notification;
        $opsi_fcm['data'] = $data;

        return $opsi_fcm;
    }

    public function data(Request $request)
    {

    }


    public function create()
    {
        //
    }


   
}
