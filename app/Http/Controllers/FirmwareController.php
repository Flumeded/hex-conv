<?php

namespace App\Http\Controllers;

use App\Http\Requests\FirmwareUploadRequest;
use Log;
use Storage;
use Webpatser\Uuid\Uuid;

/**
 * Class FirmwareController
 * @package App\Http\Controllers
 */
class FirmwareController extends Controller
{
    private const CONVERT_COMMAND_TPL = '/usr/bin/avr-objcopy -I ihex %s -O binary %s 2>&1';
    private const OUTPUT_FILE_PATH_TPL = '%s.bin';
    private const DOWNLOAD_FILENAME = 'FLASH.bin';
    private const DOWNLOAD_DIR_TPL = 'firmwares/%s';
    private const FILENAME_SESSION_KEY = 'uniqueId';

    public function upload(FirmwareUploadRequest $request)
    {
        $Session = $request->session();

        if (!$Session->has(self::FILENAME_SESSION_KEY)) {
            $Session->put(self::FILENAME_SESSION_KEY, Uuid::generate(4));
        }

        $filename = $Session->get(self::FILENAME_SESSION_KEY);
        $userStorageDir = sprintf(self::DOWNLOAD_DIR_TPL, $filename);

        if ($request->hasFile(FirmwareUploadRequest::UPLOAD_FILE_KEY)) {
            $file = $request->file(FirmwareUploadRequest::UPLOAD_FILE_KEY);
            $fileSize = $file->getSize();
            $sourceFileRelativePath = $file->storeAs($userStorageDir, $filename);
            $sourceFileFullPath = Storage::disk('local')->path($sourceFileRelativePath);

            $outputFileFullPath = sprintf(self::OUTPUT_FILE_PATH_TPL, $sourceFileFullPath);

            //Assembling full execution command string with relative path
            $cmd = sprintf(self::CONVERT_COMMAND_TPL, escapeshellarg($sourceFileFullPath), escapeshellarg($outputFileFullPath));
            exec($cmd, $output, $exitCode);

            if ($exitCode > 0) {
                Log::warning('Error on executing converter: ' . implode(PHP_EOL, $output), [
                    'filesize' => $fileSize,
                ]);

                notify()->error(trans('converter.command_failed_title'), trans('converter.command_failed_text'));
                return redirect('/');
            }


            return response()->download($outputFileFullPath, self::DOWNLOAD_FILENAME);
        }

        notify()->error('Oopsie', 'Please select file to upload');
        return redirect('/');
    }

}
