<?php
namespace App\Traits;

use Faker\Provider\Uuid;

trait UuidForKey{

    public static function bootUuidForKey(){
        static::creating(function($model){
            $model->incrementing = false;
            $model->fillable = ['id'];
            $model->{$model->getKeyName()} = (string)Uuid::uuid();
        });
    }
}