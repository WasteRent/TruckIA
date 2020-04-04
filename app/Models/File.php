<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = ['description', 'filename', 'content_type'];

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
