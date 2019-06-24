<?php

namespace App\Http\Controllers;

use App\Constants\Profile;
use App\Models\CompanyProfile;
use App\Models\Faq;
use App\Models\Hukum;
use App\Models\Option;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function faq(Faq $faq){
        $faq = $faq->newQuery();

        if(!$faq->exists()){
            return response()->error("Not Found",JsonResponse::HTTP_NOT_FOUND);
        }

        return response()->success("OK",JsonResponse::HTTP_OK,["faq"=>$faq->get()]);
    }

    public function getProfilePpid(CompanyProfile $profile){
        $profile = $profile->newQuery();
        $profile = $profile->findOrFail(Profile::PROFILE_PPID);
        return response()->success("OK",JsonResponse::HTTP_OK,["profile_ppid"=>$profile]);
    }

    public function getMaklumat(CompanyProfile $profile){
        $profile = $profile->newQuery();
        $profile = $profile->findOrFail(Profile::MAKLUMAT);
        return response()->success("OK",JsonResponse::HTTP_OK,["maklumat"=>$profile]);
    }

    public function getStrukturOrganisasi(CompanyProfile $profile){
        $profile = $profile->newQuery();
        $profile = $profile->findOrFail(Profile::STRUKTUR_ORGANISASI);
        return response()->success("OK",JsonResponse::HTTP_OK,["struktur_organisasi"=>$profile]);
    }

    public function getPejabat(CompanyProfile $profile){
        $profile = $profile->newQuery();
        $profile = $profile->findOrFail(Profile::PEJABAT);
        return response()->success("OK",JsonResponse::HTTP_OK,["pejabat"=>$profile]);
    }

    public function getVisiMisi(CompanyProfile $profile){
        $profile = $profile->newQuery();
        $profile = $profile->findOrFail(Profile::VISI_MISI);
        return response()->success("OK",JsonResponse::HTTP_OK,["visi_misi"=>$profile]);
    }

    public function getLhkpn(CompanyProfile $profile){
        $profile = $profile->newQuery();
        $profile = $profile->findOrFail(Profile::LHKPN);

        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $profile->konten, $match);

        $data = [
            "id" => $profile->id,
            "judul" => $profile->judul,
            "konten" => is_array($match) && count($match) > 0 ? $match[0]:"",
            "created_at" => $profile->created_at,
            "updated_at" => $profile->updated_at,
        ];
        return response()->success("OK",JsonResponse::HTTP_OK,["lhkpn"=>$data]);
    }

    public function getHukum(Hukum $hukum){
        $hukum = $hukum->newQuery();

        if(!$hukum->exists()){
            return response()->error("Not Found",JsonResponse::HTTP_NOT_FOUND);
        }

        $hukum = $hukum->get();

        return response()->success("OK",JsonResponse::HTTP_OK,["hukum"=>$hukum]);
    }

    public function getOptions(){
        $x = Option::all();
        return response()->success("OK",JsonResponse::HTTP_OK,$x);
    }

    public function getOption($key){
        $x = Option::whereKey($key)->firstOrFail();
        return response()->success("OK",JsonResponse::HTTP_OK,$x);
    }
}
