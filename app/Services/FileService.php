<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function handleFileUpload(UploadedFile $file, string $folder = ''): string
    {
        $extension = $file->getClientOriginalExtension();
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $originalName.'-'.uniqid().'.'.$extension;
        $filePath = $fileName;

        if ($folder) {
            $filePath = $folder.'/'.$filePath;
        }

        Storage::disk('public')->put($filePath, file_get_contents($file->getRealPath()));

        return $filePath;
    }
}
