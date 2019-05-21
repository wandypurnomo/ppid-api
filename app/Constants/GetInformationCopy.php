<?php namespace App\Constants;

class GetInformationCopy{
    const MANUAL = 1;
    const EMAIL = 2;

    public static function getOptionArray(){
        return [
            self::MANUAL => "Mengambil Langsung",
            self::EMAIL => "Email"
        ];
    }

    public static function getValue($key){
        $x = self::getOptionArray();
        return $x[$key];
    }
}
