<?php
use App\Models\Post;
use App\Models\Setting;
use Carbon\Carbon;
use GuzzleHttp\Client;
//used for FCM
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM as myFCM;

if (! function_exists('activeMenu')) {
    function activeMenu($uri = '')
    {
        $active = '';

        if (Request::is($uri . '/*') || Request::is($uri)) {
            $active = 'active pcoded-trigger';
        }
        return $active;
    }

    function ganti_titik_ke_koma($angka)
    {
        return str_replace(".", ",", $angka);
    }

    function format_angka_indo($angka)
    {
        $rupiah = number_format($angka, 0, ',', '.');
        return $rupiah;
    }

    function rubah_tanggal_indo($format_tgl)
    {
        $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $tahun = substr($format_tgl, 0, 4);
        $bulan = substr($format_tgl, 5, 2);
        $tgl = substr($format_tgl, 8, 2);
        $tgl_indonesia = $tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;

        return $tgl_indonesia;

    }

    //DATE INDONESIA BY FERI
    if (!function_exists('date_indonesian')) {
        function date_indonesian($date, $format = 'd F Y')
        {
            $date = date_create($date);
            $array1 = array('January', 'February', 'March', 'May', 'June', 'July', 'August', 'October', 'December', 'Aug', 'Oct', 'Dec', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
            $array2 = array('Januari', 'Februari', 'Maret', 'Mei', 'Juni', 'Juli', 'Agustus', 'Oktober', 'Desember', 'Agu', 'Okt', 'Dec', 'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            $new_date = date_format($date, $format);
            $hasil = str_replace($array1, $array2, $new_date);
            return $hasil;
        }
    }

    function TanggalIndowaktu($date)
    {

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);
        $waktu = substr($date, 11, 8);
        $result = $tgl . "/" . $bulan . "/" . $tahun . ' ' . $waktu;
        return ($result);
    }

    function TanggalIndo($date)
    {
        $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);

        $result = $tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;
        return ($result);
    }

    function TanggalIndo2($date)
    {

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);

        $result = $tgl . "/" . $bulan . "/" . $tahun;
        return ($result);
    }

    function TanggalIndo3($date)
    {

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);

        $result = $bulan . "/" . $tahun;
        return ($result);
    }

    function ubahformatTgl($tanggal)
    {
        $pisah = explode('/', $tanggal);
        $urutan = array($pisah[2], $pisah[1], $pisah[0]);
        $satukan = implode('-', $urutan);
        return $satukan;
    }

    function replace_level_word($stringnya)
    {
        $replace_text = str_replace("LEVEL ", "", $stringnya);
        return $replace_text;
    }
}
if (! function_exists('tanggalWaktu')) {
    function tanggalWaktu ($tanggal) {
        return Carbon::parse($tanggal)->isoFormat('Do MMMM YYYY, h:mm:ss a');
    }
}
if (! function_exists('Respon')) {
    function Respon ($data, $status, $pesan, $statusCode) {

        $res['status'] = $status;
        $res['pesan'] = $pesan;
        $res['data'] = $data;

        return response()->json($res, $statusCode);
    }
}
if (! function_exists('setImage')) {
    function setImage ($file, $dir) {
        $file_name = round(microtime(true) * 1000) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $file_name);
        return $file_name;
    }
}
if (! function_exists('tanggalIndo')) {
    function tanggalIndo($tanggal)
    {
        return Carbon::parse($tanggal)->format('d M Y');
    }
}
if (! function_exists('getSettingData')) {
    function getSettingData($var)
    {
        return Setting::where('key', $var)->first();
    }
}
if (! function_exists('angkaTitikTiga')) {
    function angkaTitikTiga($var)
    {
        return number_format($var, 0, ',', '.');
    }
}
if (!function_exists('arrBulan')) {
    function arrBulan()
    {
        return array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    }
}
if (!function_exists('latestPost')) {
    function latestPost()
    {
        return Post::where('active','Y')->latest()->limit(3)->get();
    }
}
if (!function_exists('pengumumanPost')) {
    function pengumumanPost()
    {
        return Post::whereHas('kategori', function($q) {
            $q->where('active', 'Y')
                ->where('seotitle', 'pengumuman');
        })->where('active','Y')->latest()->limit(3)->get();
    }
}
if (!function_exists('removeBaseURL')) {
    function removeBaseURL ($string) {
        return str_replace(url('/'), '', $string);
    }
}

if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        $result = Setting::where('key', $key)->first();
        if ($result) {
            return $result->value;
        } else {
            return '';
        }
    }

}
if (!function_exists('getKategori')) {
    function getKategori() {
        return \App\Models\PostCategory::where('active', 'Y')->withCount('posts')->get();
    }
}
if ((!function_exists('setFCMOption'))){
    function sendFCM($judul_pesan,$isi_pesan,$token){
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

        $downstreamResponse = FCM::sendTo($token, $opsi_fcm['option'], $opsi_fcm['notification'], $opsi_fcm['data']);

        return  $downstreamResponse->numberSuccess();
    }
}
if (!function_exists('hariIndo')) {
    function hariIndo($day) {
        $hari = "";
        if ($day == "Monday"){
            $hari = "Senin";
        }else if ($day == "Tuesday"){
            $hari = "Selasa";
        }else if ($day == "Wednesday"){
            $hari = "Rabu";
        }else if ($day == "Thursday"){
            $hari = "Kamis";
        }else if ($day == "Friday"){
            $hari = "Jumat";
        }else if ($day == "Saturday"){
            $hari = "Sabtu";
        }else if ($day == "Sunday"){
            $hari = "Minggu";
        }
        return $hari;
    }
}
