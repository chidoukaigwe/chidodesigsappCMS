<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use Searchable;

    public $asYouType = true;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }

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
