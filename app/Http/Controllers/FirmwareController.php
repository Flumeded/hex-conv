<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;



class FirmwareController extends Controller
{

 public function upload(Request $Request)
{

    $Session = $Request->session();

    $key = $Session->get("uniqueId");

    if (empty($key)) {
        $key = UUID::v4();
        $Session->put("uniqueId", $key);

        $filename = $key . '.tmp';

        $File = $Request->file('uploadFormKey');

        if ($File) {
            $fullFilename = $File->move('myDirectory', $filename)->getFilename();
        } else {
            throw new FileNotFoundException('upl');
        }
        
        $cmdTpl = 'command %s';
        
        $cmd = sprintf($cmdTpl, escapeshellarg($fullFilename));
        exec($cmd, $output, $exitCode);
        
        dd("output: $output. Success: " . ($exitCode === 0));
    }

}
}