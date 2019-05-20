<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        $arr = [];

        if(env("APP_DEBUG")){
            dd($exception);
        }
        $arr["success"] = false;

        if($exception instanceof NotFoundHttpException){
            $arr["status"] = 404;
            $arr["error"] = "Not Found";
        }elseif($exception instanceof ValidationException){
            $arr["status"] = 422;
            $arr["errors"] = $exception->errors();
        }elseif ($exception instanceof HttpException){
            $arr["status"] = $exception->getStatusCode();
            $arr["error"] = $exception->getMessage();
        }else{
            $arr["status"] = 500;
            $arr["error"] = "Internal server error";
        }

        return response()->json($arr, $arr["status"]);
    }
}
