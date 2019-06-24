<?php namespace App\Constants;

class AlasanKeberatan{
    const DITOLAK = 1;
    const TIDAK_DISEDIAKAN = 2;
    const TIDAK_DITANGGAPI = 3;
    const TANGGAPAN_TIDAK_SESUAI = 4;
    const TIDAK_DIPENUHI = 5;
    const BIAYA_TIDAK_WAJAR  = 6;
    const MELEBIHI_BATAS_WAKTU = 7;

    public static function getOptions(){
        return [
            self::DITOLAK => "Permohonan informasi ditolak.",
            self::TIDAK_DISEDIAKAN => "Informasi berkala tidak disediakan.",
            self::TIDAK_DITANGGAPI => "Permintaan informasi tidak ditanggapi.",
            self::TANGGAPAN_TIDAK_SESUAI => "Permintaan informasi ditanggapi tidak seperti yang diminta.",
            self::TIDAK_DIPENUHI => "Permintaan informasi tidak dipenuhi.",
            self::BIAYA_TIDAK_WAJAR => "Biaya yang dikenakan tidak wajar.",
            self::MELEBIHI_BATAS_WAKTU => "Informasi disampaikan melebihi batas waktu yang ditentukan."
        ];
    }

    public static function getValue($alasan){
        $x = self::getOptions();
        return $x[$alasan];
    }
}
