<?php namespace App\Http\Controllers\Auth;

use App\Constants\Activation;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller{

    public function login(Request $request)
    {
        $this->validate($request,[
            "username" => "required|exists:users,username",
            "password" => "required"
        ]);

        $request->merge(["is_active"=>Activation::ACTIVE]);
        $credential = $request->only(["username","password"]);
        if(!$token = auth()->attempt($credential->toArray())){
            return response()->error("Credential not match",JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response()->success("OK",JsonResponse::HTTP_OK,[
            "token"=>$token
        ]);
    }

    public function register(Request $request, User $user)
    {
        $this->validate($request,[
            "username" => "required|unique:users,username",
            "password" => "required"
        ]);

        $request->merge([
            "is_active" => Activation::ACTIVE,
            "password" => app("hash")->make($request->json("password"))
        ]);

        $content = $request->only(["username","password","is_active"]);

        $user->newQuery()->create($content);

        return response()->success();
    }

    public function logout()
    {
        auth("api")->logout();
        return response()->success();
    }
}
