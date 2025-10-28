<?php

namespace App\Support;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SecureStorage
{
    /**
     * Store an uploaded file on the private disk.
     */
    public static function storeUploadedFile(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, 'private');
    }

    /**
     * Determine if the given path exists on either private or legacy public disk.
     */
    public static function exists(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        foreach (['private', 'public'] as $disk) {
            if (Storage::disk($disk)->exists($path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Delete the given path from private storage and clean up any legacy public copy.
     */
    public static function delete(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        foreach (['private', 'public'] as $disk) {
            $adapter = Storage::disk($disk);
            if ($adapter->exists($path)) {
                $adapter->delete($path);
            }
        }
    }

    /**
     * Resolve the filesystem adapter that can read the given path.
     */
    public static function resolveReadableAdapter(string $path): ?FilesystemAdapter
    {
        foreach (['private', 'public'] as $disk) {
            $adapter = Storage::disk($disk);
            if ($adapter->exists($path)) {
                return $adapter;
            }
        }

        return null;
    }

    /**
     * Generate a streamed download response for the given path if it exists.
     */
    public static function download(string $path, ?string $name = null)
    {
        $adapter = static::resolveReadableAdapter($path);

        if (!$adapter) {
            return null;
        }

        $downloadName = $name ?: basename($path);

        return $adapter->download($path, $downloadName);
    }
}
