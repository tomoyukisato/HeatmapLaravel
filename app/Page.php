<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $fillable=[
        "page_url",
        "site_id",
    ];
    public function link_click(){
        return $this->hasMany("App\LinkClick");
    }
}
