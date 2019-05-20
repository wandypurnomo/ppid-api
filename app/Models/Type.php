<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = "jenis";
    protected $guarded = ["id"];

    public function sub_types(){
        return $this->hasMany(SubType::class,"jenis_id");
    }
}
