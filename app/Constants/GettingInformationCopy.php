<?php namespace App\Constants;

class GettingInformationCopy{
    const MANUAL = 1;
    const FAX = 2;
    const EMAIL = 3;

    public static function getOptionArray(){
        return [
            self::MANUAL => "Mengambil Langsung",
            self::FAX => "Faksimili",
            self::EMAIL => "Email"
        ];
    }

    public static function getValue($key){
        $x = self::getOptionArray();
        return $x[$key];
    }
}
