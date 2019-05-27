<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    protected $guarded = ["id"];

    public function public_information(){
        return $this->hasMany(PublicInformation::class,"opd_id");
    }
}
