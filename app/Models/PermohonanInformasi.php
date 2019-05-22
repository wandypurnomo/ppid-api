<?php

namespace App\Models;

use App\Constants\StatusPermohonan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PermohonanInformasi extends Model
{
    protected $table = "permohonan";
    protected $guarded = ["id"];
    public $timestamps = false;

    public static function storePermohonan(Request $request){
        $fields = [
            "pemohon_nama","pemohon_id","pemohon_category","pemohon_alamat","pemohon_phone","pemohon_email", "pemohon_kebutuhan",
            "pengguna_nama","pengguna_id","pengguna_alamat","pengguna_phone","pengguna_email","pengguna_tujuan",
            "cara","salinan","opd_id"
        ];

        return self::create($request->only($fields));
    }

    public function status_logs(){
        return $this->hasMany(StatusLog::class,"permohonan_id")->where("type","permohonan")->orderBy("created_at","desc");
    }

    public function last_status(){
        return $this->status_logs()->latest()->first();
    }

    public function history(){
        return $this->status_logs;
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->reg_number = rand(10000,99999);
            $model->status_date = Carbon::now()->format("Y-m-d");
            $model->created_at = Carbon::now();
        });
    }
}
