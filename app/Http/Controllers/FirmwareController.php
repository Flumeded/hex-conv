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
    }
}