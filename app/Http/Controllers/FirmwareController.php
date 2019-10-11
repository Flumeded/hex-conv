<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;






class FirmwareController extends Controller
{

	public function upload(Request $request)
    {
        $Session = $request->session();

        $key = $Session->get("uniqueId");

        if (empty($key)) {
            $key = Uuid::generate(4);
            $Session->put("uniqueId", $key);
        }

        $filename = $key;
        $downloadDir = 'firmwares/%s';
        $userStorageDir = sprintf($downloadDir, $filename);
        $requestKey = 'firmware';
        if ($request->hasFile($requestKey)) {

            $fullFilePath = "../storage/app/" . $request->file($requestKey)->storeAs($userStorageDir, $filename);
            //Assembling full execution command string with relative path
            $cmdTpl = '/usr/bin/avr-objcopy -I ihex %s -O binary %s.bin';
            $cmd = sprintf($cmdTpl, escapeshellarg($fullFilePath), escapeshellarg($fullFilePath));
            exec($cmd, $output, $exitCode);
            return response()->download($fullFilePath . '.bin', 'FLASH.bin');
        }
        else {

            notify()->error('Oopsie', 'Please select file to upload');
            return view('home');

        }

    }

}
