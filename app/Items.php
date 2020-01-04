<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable = [
        'photo', 'title', 'price', 'condition', 'description', 'location', 'category'
    ];
}
