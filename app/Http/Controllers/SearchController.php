<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Article as ArticleResource;

class SearchController extends Controller
{
    public function index()
    {
        $data = request()->validate([
            'searchTerm' => 'required',
        ]);

        $articles = Article::search($data['searchTerm'])
            ->where('user_id', request()->user()->id)
            ->get();

        return ArticleResource::collection($articles);
    }
}
