<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    public const PATH = 'trucki/files';

    protected $fillable = ['description', 'filename', 'content_type', 'size'];

    public function getSizeAttribute($value)
    {
        return number_format($value / 1000000, 2, ',', '.').'MB';
    }

    public function getPath()
    {
        return self::PATH."/{$this->filename}";
    }

    public function getLink()
    {
        if (config('filesystems.default') == 'spaces') {
            $url = Storage::temporaryUrl($this->getPath(), now()->addHours(2));

            return str_replace('.digitaloceanspaces.com', '.cdn.digitaloceanspaces.com', $url);
        }

        return Storage::url($this->getPath());
    }

    public static function storeFile(UploadedFile $uploadedFile, string $description = '')
    {
        $uploadedFile->store(self::PATH);

        $file = new File([
            'description' => $description,
            'filename' => $uploadedFile->hashName(),
            'content_type' => $uploadedFile->getMimeType(),
        ]);
        $file->save();

        return $file;
    }

    public function getBase64()
    {
        if (config('filesystems.default') == 's3') {
            if (! Storage::exists($this->getPath())) {
                return null;
            }

            return base64_encode(file_get_contents(Storage::temporaryUrl($this->getPath(), now()->addHours(2))));
        }
        
        if (! Storage::exists($this->getPath())) {
            return null;
        }

        return base64_encode(Storage::get($this->getPath()));
    }

    public function removeFile()
    {
        Storage::delete($this->getPath());
    }
}
