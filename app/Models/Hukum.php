<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hukum extends Model
{
    protected $table = "hukum";
    protected $appends = ["upload_file_url"];

    public function getUploadFileUrlAttribute(){
        $path = "http://ppid.magelangkab.go.id/protected/public/";

        if($this->attributes["upload_file"] == null){
            $path = null;
        }else{
            $path = $path."/".$this->attributes["upload_file"];
        }

        return $path;
    }
}
