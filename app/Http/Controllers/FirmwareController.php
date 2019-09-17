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

//Uploadinf firmware to the server
    function upload(Request $request){
        $filename = rand(1, 100);
        $request->file('firmware')->storeAs('firmware', $filename);
        return view("convert");
        //junky scrip kiddo shell launch
        
        shell_exec("/var/www/hex-conv/scripts/convert.sh '".$filename."'");
        sleep(5);
        return view('donwload');
    }
}