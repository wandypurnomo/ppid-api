<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicInformation extends Model
{
    protected $table = "info_publik";
    public $timestamps = false;
    protected $casts = [
        "is_dip" => "boolean"
    ];

    protected $dates = [
        "upload_date"
    ];

    protected $appends = [
        "publication_type","publication_sub_type","publication_opd",
        "publication_opd_author","publication_doc_type","publication_duration",
        "upload_file_url"
    ];

    protected $hidden = [
        "sub_type","opd","document_type","duration",
        "jenis_id","subjenis_id","opd_id","type_id","duration_id",
        "upload_file"
    ];

    public function opd(){
        return $this->belongsTo(Opd::class);
    }

    public function sub_type(){
        return $this->belongsTo(SubType::class,"subjenis_id");
    }

    public function document_type(){
        return $this->belongsTo(DocumentType::class,"type_id");
    }

    public function duration(){
        return $this->belongsTo(Duration::class);
    }

    // custom attributes
    public function getPublicationTypeAttribute(){
        return $this->sub_type->type->jenis_info_publik;
    }

    public function getPublicationSubTypeAttribute(){
        return $this->sub_type->subjenis_info_publik;
    }

    public function getPublicationOpdAttribute(){
        return is_null($this->opd) ? "-":$this->opd->opd_name;
    }

    public function getPublicationOpdAuthorAttribute(){
        return is_null($this->opd) ? "-":$this->opd->author;
    }

    public function getPublicationDocTypeAttribute(){
        return $this->document_type->doc_type;
    }

    public function getPublicationDurationAttribute(){
        return $this->duration->duration_name;
    }

    public function getUploadFileUrlAttribute(){
        $path = "http://ppid.magelangkab.go.id/protected/public/";

        if($this->attributes["upload_file"] == null){
            $path = null;
        }else{
            $path = $path."/".$this->attributes["upload_file"];
        }

        return $path;
    }
}
