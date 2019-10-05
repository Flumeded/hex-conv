<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\Process\Process;
use Webpatser\Uuid\Uuid;



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
		$downloadDir = 'firmwares';
		$requestKey = 'firmware';
		$fullFilename = "../storage/app/" . $Request->file($requestKey)->storeAs($downloadDir, $filename);
		//Assembling full execution command string with relative path
		$cmdTpl = '/usr/bin/avr-objcopy -I ihex %s -O binary %s.bin';
		$cmd = sprintf($cmdTpl, escapeshellarg($fullFilename), escapeshellarg($fullFilename));
		exec($cmd, $output, $exitCode);
	}

}
