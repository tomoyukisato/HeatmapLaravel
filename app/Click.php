<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    public $fillable=[
        'page_id',
        'page_x',
        'page_y',
        'pc_tab_sp',
        'body_width',
        'body_height',
    ];
}
