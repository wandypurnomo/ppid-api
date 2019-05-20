<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use App\Models\Duration;
use App\Models\Opd;
use App\Models\PublicInformation;
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
}
