<?php

namespace App\Http\Controllers;

use App\Constants\AlasanKeberatan;
use App\Events\PermohonanSubmited;
use App\Models\Keberatan;
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

    public function submitPermohonanKeberatan(Request $request){
        $this->validate($request,[
            "tujuan_penggunaan_informasi" => "required",
            "nama_pemohon" => "required",
            "alamat_pemohon" => "required",
            "pekerjaan_pemohon" => "required",
            "phone_pemohon" => "required",
            "alasan_id" => "required",
            "opd_id" => "required",
            "email" => "required|email"
        ]);

        $request->merge(["no_registrasi_keberatan" => rand(10000,99999)]);
        Keberatan::create($request->only([
            "no_registrasi_keberatan","no_pendaftaran_permohonan_informasi","tujuan_penggunaan_informasi",
            "nama_pemohon","alamat_pemohon","pekerjaan_pemohon","phone_pemohon","alasan_id",
            "opd_id","nama_kuasa_pemohon","alamat_kuasa_pemohon","kasus_posisi","email"
        ]));

        return response()->success();
    }

    public function trackingKeberatan(Request $request, Keberatan $keberatan){
        $this->validate($request,[
            "email" => "required|email",
            "no_registrasi_keberatan" => "required|exists:keberatan,no_registrasi_keberatan"
        ]);

        $info = $keberatan
            ->newQuery()
            ->where("email",$request->json("email"))
            ->where("no_registrasi_keberatan",$request->json("no_registrasi_keberatan"))
            ->firstOr(["*"],function(){
                return abort(404);
            });

        $status = $info->status == null ? "Belum ada response":AlasanKeberatan::getValue($info->alasan_id);
        $data = ["latest" => $status];

        return response()->success("OK",JsonResponse::HTTP_OK,$data);
    }
}
