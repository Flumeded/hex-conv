<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirmwareUploadRequest extends FormRequest
{
    public const UPLOAD_FILE_KEY = 'firmware';

    /**
     * Validate uploaded file name
     *
     * @return array
     */
    public function rules()
    {
        return [
            static::UPLOAD_FILE_KEY => ['required', 'file','mimetypes:text/plain','max:1024']
        ];
    }
}
