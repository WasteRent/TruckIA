<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = ['description', 'filename', 'content_type', 'size'];

    public function getSizeAttribute($value)
    {
        return number_format($value / 1000000, 2, ',', '.') . 'MB';
    }

    public function getPath()
    {
        return "truckts/mantenimientos/files/{$this->filename}";
    }

    public function getLink()
    {
        $url = Storage::url("truckts/mantenimientos/files/{$this->filename}");
        return str_replace('.digitaloceanspaces.com', '.cdn.digitaloceanspaces.com', $url);
    }
}
