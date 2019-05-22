<?php

namespace App\Http\Controllers;

use App\Events\PermohonanSubmited;
use App\Models\PermohonanInformasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    public function submitPermohonanInformasi(Request $request){
        $this->validate($request,[
            "pemohon_nama" => "required",
            "pemohon_id" => "required",
            "pemohon_category" => "required",
            "pemohon_alamat" => "required",
            "pemohon_phone" => "required",
            "pemohon_email" => "required",
            "pemohon_kebutuhan" => "required",
            "pengguna_nama" => "required",
            "pengguna_id" => "required",
            "pengguna_alamat" => "required",
            "pengguna_phone" => "required",
            "pengguna_email" => "required",
            "pengguna_tujuan" => "required",
            "cara" => "required",
            "salinan" => "required",
            "cara_salin" => "required",
            "opd_id" => "required|exists:opds,id"
        ]);

        $pemohon = PermohonanInformasi::storePermohonan($request);
        event(new PermohonanSubmited($pemohon));
        return response()->success();
    }

    public function tracking(Request $request, PermohonanInformasi $informasi){
        $this->validate($request,[
            "email" => "required|email",
            "reg_number" => "required|exists:permohonan,reg_number"
        ]);

        $info = $informasi
                    ->newQuery()
                    ->where("pemohon_email",$request->json("email"))
                    ->where("reg_number",$request->json("reg_number"))
                    ->firstOr(["*"],function(){
                        return abort(404);
                    });

        $latest = $info->last_status();
        $history = $info->history();

        $data = [
            "status" => [
                "latest" => $latest,
                "history" => $history
            ]
        ];

        return response()->success("OK",JsonResponse::HTTP_OK,$data);

    }
}
