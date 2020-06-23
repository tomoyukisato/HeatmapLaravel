<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    public $fillable=[
        "site_url",
        "title"
    ];

    public function page(){
        return $this->hasMany('App\Page');
    }
}
