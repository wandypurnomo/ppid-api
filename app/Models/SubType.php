<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubType extends Model
{
    protected $table = "subjenis";
    protected $guarded = ["id"];

    public function type(){
        return $this->belongsTo(Type::class,"jenis_id");
    }

    public function public_information(){
        return $this->hasMany(PublicInformation::class,"subjenis_id");
    }
}
