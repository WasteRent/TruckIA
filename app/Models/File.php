<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    public const PATH = 'truckts/mantenimientos/files';

    protected $fillable = ['description', 'filename', 'content_type', 'size'];

    public function getSizeAttribute($value)
    {
        return number_format($value / 1000000, 2, ',', '.') . 'MB';
    }

    public function getPath()
    {
        return self::PATH . "/{$this->filename}";
    }

    public function getLink()
    {
        $url = Storage::url($this->getPath());
        return str_replace('.digitaloceanspaces.com', '.cdn.digitaloceanspaces.com', $url);
    }
}
