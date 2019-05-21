<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(["namespace"=>"Auth"],function($router){
    $router->post("login","AuthController@login");
    $router->post("register","AuthController@register");

    $router->group(["middleware"=>"auth"],function($router){
        $router->post("logout","AuthController@logout");
    });
});

$router->get("public-information","PublicInformationController@index");
$router->get("type","PublicInformationController@getType");
$router->get("sub-type","PublicInformationController@getSubType");
$router->get("opd","PublicInformationController@getOpd");
$router->get("doc-type","PublicInformationController@getDocType");
$router->get("duration","PublicInformationController@getDuration");
$router->post("contact-us/send","ContactController@send");

$router->get("faq","ProfileController@faq");

$router->group(["prefix"=>"profile"],function($router){
    $router->get("profile-ppid","ProfileController@getProfilePpid");
    $router->get("maklumat","ProfileController@getMaklumat");
    $router->get("struktur-organisasi","ProfileController@getStrukturOrganisasi");
    $router->get("pejabat","ProfileController@getPejabat");
    $router->get("visi-misi","ProfileController@getVisiMisi");
    $router->get("lhkpn","ProfileController@getLhkpn");
});

$router->post("permohonan-informasi/submit","PermohonanController@submitPermohonanInformasi");

