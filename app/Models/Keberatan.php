<?php

namespace App\Models;

use App\Constants\AlasanKeberatan;
use Illuminate\Database\Eloquent\Model;

class Keberatan extends Model
{
    protected $table = "keberatan";

    public function opd(){
        return $this->belongsTo(Opd::class);
    }

    public function getAlasanAttribute(){
        $alasan_id = $this->attributes["alasan_id"];
        return AlasanKeberatan::getValue($alasan_id);
    }
}
