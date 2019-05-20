<?php

function getContent($json){
    $d = json_decode($json,true);
    if(!is_array($d)){
        $d = json_decode($d,true);
    }
    return $d ?? [];
}

function auth($guard="api"){
    return app("auth")->guard($guard);
}

function paginatedData($data,$itemName = "items"){
    $d = [
        $itemName => $data->items(),
        "first_page_url" => $data->url(1),
        "last_page_url" => $data->lastPage() == 1 ? null : $data->url($data->lastPage()),
        "next_page_url" => $data->nextPageUrl(),
        "previous_page_url" => $data->previousPageUrl(),
        "current_page" => $data->currentPage(),
        "first_page" => 1,
        "last_page" => $data->lastPage(),
        "total" => $data->total(),
    ];
    return $d;
}
