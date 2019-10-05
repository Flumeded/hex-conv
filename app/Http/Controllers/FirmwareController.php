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
		$File = $Request->file($requestKey);
		$fullFilename = $File->storeAs($downloadDir, $filename);
		$Request->file($requestKey)->storeAs($downloadDir, $filename);
		$cmdTpl = './convert.sh %s';
		$cmd = sprintf($cmdTpl, escapeshellarg($filename));
		exec($cmd, $output, $exitCode);
	}

}
