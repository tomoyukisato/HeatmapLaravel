<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkClick extends Model
{
    public $fillable=[
        'page_id',
        'device',
        'link'
    ];

    public function page(){
        $this->belongsTo("App\Page");
    }
}
