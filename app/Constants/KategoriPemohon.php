<?php namespace App\Constants;

class KategoriPemohon{
    const ORGANISASI = 1;
    const PERSEORANGAN = 2;

    public static function getOptionArray(){
        return [
            self::ORGANISASI => "Organisasi Perseorangan",
            self::PERSEORANGAN => "Perseorangan"
        ];
    }

    public static function getValue($key){
        $x = self::getOptionArray();
        return $x[$key];
    }
}
