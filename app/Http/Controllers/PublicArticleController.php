<?php

namespace App\Http\Controllers;

use App\PublicArticle;
use Illuminate\Http\Request;

class PublicArticleController extends Controller
{
    public function store()
    {

        $data = request()->validate([
            'title' => 'required',
            'body' => 'required',
            'excerpt' => 'required'

        ]);

        PublicArticle::create($data);
    }
}
