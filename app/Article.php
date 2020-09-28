<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    //  This article belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function path()
    {
        return '/article/' . $this->id;
    }

}
