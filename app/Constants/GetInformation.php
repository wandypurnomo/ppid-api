<?php namespace App\Constants;

class GetInformation{
    const SELF = 1;
    const COPY = 2;

    public static function getOptionArray(){
        return [
            self::SELF => "Melihat/membaca/mendengarkan/mencatat",
            self::COPY => "Mendapatkan Salinan Informasi (hardcopy/softcopy) *Biaya fotocopy ditanggung oleh pemohon"
        ];
    }

    public static function getValue($key){
        $x = self::getOptionArray();
        return $x[$key];
    }
}
