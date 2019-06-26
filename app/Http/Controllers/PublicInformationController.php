<?php

namespace App\Http\Controllers;

use App\Constants\StatusPermohonan;
use App\Models\DocumentType;
use App\Models\Duration;
use App\Models\Opd;
use App\Models\PermohonanInformasi;
use App\Models\PublicInformation;
use App\Models\Sop;
use App\Models\SubType;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicInformationController extends Controller
{
    public function index(Request $request, PublicInformation $information){
        $information = $information->newQuery();

        if($request->has("id") && $request->get("id") != ""){
            $information = $information->findOrFail($request->get("id"));
            return response()->success("OK",JsonResponse::HTTP_OK,["public_information" => $information]);
        }

        $where = function($i) use ($request){
            // filtering here
            if($request->has("type") && $request->get("type") != ""){
                $i->whereHas("sub_type",function($st) use ($request){
                    $st->whereHas("type",function($t) use ($request){
                        $t->where("id",$request->get("type"));
                    });
                });
            }

            if($request->has("sub_type") && $request->get("sub_type") != ""){
                $i->where("subjenis_id",$request->get("sub_type"));
            }

            if($request->has("opd") && $request->get("opd") != ""){
                $i->where("opd_id",$request->get("opd"));
            }

            if($request->has("doc_type") && $request->get("doc_type") != ""){
                $i->where("type_id",$request->get("doc_type"));
            }

            if($request->has("duration") && $request->get("duration") != "null"){
                $i->where("duration_id",$request->get("duration"));
            }

            if($request->has("keyword") && $request->get("keyword") != ""){
                $i->where("judul","like","%".$request->get("keyword")."%");
            }
        };


        $information->where($where);


        if(!$information->exists()){
            return response()->error("Not Found",JsonResponse::HTTP_NOT_FOUND);
        }

        $data = paginatedData($information->paginate(10),"public_informations");

        return response()->success("OK",JsonResponse::HTTP_OK,$data);
    }

    public function getType(Type $type){
        $type = $type->newQuery();

        if(!$type->exists()){
            return response()->error("Not Found",JsonResponse::HTTP_NOT_FOUND);
        }

        $type = $type->get();

        return response()->success("OK",JsonResponse::HTTP_OK,["types"=>$type]);
    }

    public function getSubType(Request $request,SubType $type){
        $type = $type->newQuery();

        if($request->has("type_id") && $request->get("type_id") != ""){
            $type->where("jenis_id",$request->get("type_id"));
        }

        if($request->has("opd_id") && $request->get("opd_id") != ""){
            $type->whereHas("public_information",function($pi) use ($request){
                $pi->where("opd_id",$request->get("opd_id"));
            });
        }


        if(!$type->exists()){
            return response()->error("Not Found",JsonResponse::HTTP_NOT_FOUND);
        }

        $type = $type->get();

        return response()->success("OK",JsonResponse::HTTP_OK,["sub_types"=>$type]);
    }

    public function getOpd(Opd $opd){
        $opd = $opd->newQuery();

        if(!$opd->exists()){
            return response()->error("Not Found",JsonResponse::HTTP_NOT_FOUND);
        }

        $opd = $opd->get();

        return response()->success("OK",JsonResponse::HTTP_OK,["opd"=>$opd]);
    }

    public function getDocType(DocumentType $type){
        $type = $type->newQuery();

        if(!$type->exists()){
            return response()->error("Not Found",JsonResponse::HTTP_NOT_FOUND);
        }

        $type = $type->get();

        return response()->success("OK",JsonResponse::HTTP_OK,["doc_types"=>$type]);
    }

    public function getDuration(Duration $duration){
        $duration = $duration->newQuery();

        if(!$duration->exists()){
            return response()->error("Not Found",JsonResponse::HTTP_NOT_FOUND);
        }

        $duration = $duration->get();

        return response()->success("OK",JsonResponse::HTTP_OK,["durations"=>$duration]);
    }

    public function getYear(PublicInformation $information){
        $x = $information->newQuery()->groupBy("tahun");
        if($x->count() == 0){
            return abort(404);
        }

        return response()->success("OK",JsonResponse::HTTP_OK,["years"=>$x->pluck("tahun")]);

    }

    public function registrationSummary(PermohonanInformasi $informasi){
        $x = $informasi->newQuery();

        $x->selectRaw(
            "YEAR(created_at) year,
            (SELECT COUNT(*) from permohonan where status=".StatusPermohonan::DIPENUHI." and YEAR(created_at) = year) as dipenuhi,
            (SELECT COUNT(*) from permohonan where status=".StatusPermohonan::DITOLAK." and YEAR(created_at) = year) as ditolak,
            (SELECT COUNT(*) from permohonan where status=".StatusPermohonan::SENGKETA_INFORMASI." and YEAR(created_at) = year) as sengketa_informasi,
            (SELECT COUNT(*) from permohonan where status=".StatusPermohonan::DIPENUHI_SEBAGIAN." and YEAR(created_at) = year) as dipenuhi_sebagian,
            (SELECT COUNT(*) from permohonan where status=null and YEAR(created_at) = year) as sedang_proses,
            (SELECT COUNT(*) from permohonan where YEAR(created_at) = year) as total_permohonan");
        $x->groupBy("year");

        $x = $x->get();

        if($x->count() == 0){
            abort(404);
        }

        return response()->success("OK",JsonResponse::HTTP_OK,["summary" => $x]);
    }

    public function getSop(Sop $sop){
        $x = $sop->newQuery();

        if($x->count() == 0){
            return abort(404);
        }

        return response()->success("OK",JsonResponse::HTTP_OK,["sop"=>$x->get()]);
    }

    public function statusPermohonan(){
        return response()->success("OK",JsonResponse::HTTP_OK,["status_permohonan"=>StatusPermohonan::getOptionArray()]);
    }
}
