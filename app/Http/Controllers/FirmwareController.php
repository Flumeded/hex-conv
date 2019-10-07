<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\Process\Process;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Storage;



class FirmwareController extends Controller
{

	public function upload(Request $Request)
	{

		$Session = $Request->session();

		$key = $Session->get("uniqueId");

		if (empty($key)) {
			$key = Uuid::generate(4);
			$Session->put("uniqueId", $key);
		}

		$filename = $key;
		$downloadDir = 'firmwares/%s';
		$userStorageDir = sprintf($downloadDir, $filename);
		$requestKey = 'firmware';
		$fullFilePath = "../storage/app/" . $Request->file($requestKey)->storeAs($userStorageDir, $filename);
		//Assembling full execution command string with relative path
		$cmdTpl = '/usr/bin/avr-objcopy -I ihex %s -O binary %s.bin';
		$cmd = sprintf($cmdTpl, escapeshellarg($fullFilePath), escapeshellarg($fullFilePath));
		exec($cmd, $output, $exitCode);
        return response()->download ($fullFilePath . '.bin', 'FLASH.bin');

	}

}
