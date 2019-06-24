<?php namespace App\Constants;

class StatusPermohonan{
    const DIPENUHI = 1;
    const DITOLAK = 2;
    const SENGKETA_INFORMASI = 3;
    const DIPENUHI_SEBAGIAN = 4;

    public static function getOptionArray(){
        return [
            self::DIPENUHI => "Permohonan Dipenuhi",
            self::DIPENUHI_SEBAGIAN => "Permohonan Dipenuhi Sebagian",
            self::DITOLAK => "Permohonan Ditolak",
            self::SENGKETA_INFORMASI => "Sengketa Informasi"
        ];
    }

    public static function getValue($key){
        $x = self::getOptionArray();
        return $x[$key];
    }
}
