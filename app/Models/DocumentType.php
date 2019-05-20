<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $table = "types";
    protected $guarded = ["id"];

    public function public_information(){
        return $this->hasMany(PublicInformation::class);
    }
}
