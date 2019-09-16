<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirmwareController extends Controller
{

    public function convert(){
        return view("convert");
    }


    public function download(){
        return view("download");
    }

    function upload(Request $request){
        $request->file('firmware')->store('firmware');
        return view("convert");
        echo shell_exec('sh /var/www/hex-conv/scripts/convert.sh');
        sleep(5);
        return view('donwload');
    }
}