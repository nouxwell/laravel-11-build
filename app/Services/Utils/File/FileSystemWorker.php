<?php

namespace App\Services\Utils\File;

use Illuminate\Support\Facades\File;

class FileSystemWorker
{

    public static function createFolderIfNotExist(string $folder): void
    {
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }
    }

    public static function removeFolder(string $folder): void
    {
        if (File::exists($folder)) {
            File::deleteDirectory($folder);
        }
    }

    public static function deleteFile(string $file): bool
    {
        if (!File::exists($file)) {
            return false;
        }

        return File::delete($file);
    }

    public static function pathExists(string $path): bool
    {
        return File::exists($path);
    }
}
