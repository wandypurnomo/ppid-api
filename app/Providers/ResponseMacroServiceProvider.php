<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Http\ResponseFactory;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        ResponseFactory::macro("success",function($message="OK", $status = JsonResponse::HTTP_OK,$data=null){
            $arr = [
                "success" => true,
                "status" => $status,
                "message" => $message
            ];

            if($data != null){
                $arr["payload"]= $data;
            }
            return response()->json($arr,$status);
        });

        ResponseFactory::macro('error', function ($message = "Bad Request", $status = JsonResponse::HTTP_BAD_REQUEST) {
            return response()->json([
                'success'  => false,
                "status" => $status,
                'error' => $message,
            ], $status);
        });

        ResponseFactory::macro("errors",function($messages){
            return response()->json([
                'success' => false,
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $messages
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(){}
}
