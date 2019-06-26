<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sop extends Model
{
    protected $table = "sop";
    protected $guarded = ["id"];

    protected $appends = ["file_url"];

    public function getFileUrlAttribute(){
        return env("PUBLIC_URL").DIRECTORY_SEPARATOR.$this->attributes["sop_file"];
    }
}
