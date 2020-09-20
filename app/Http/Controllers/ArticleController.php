<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function index()
    {
        //  Get Articles
        $articles = Article::orderBy('created_at', 'desc')->paginate(5);

        //  Return Collection of articles as a resource
        return ArticleResource::collection($articles);

    }


    public function store(Request $request)
    {

        Article::create($this->validateData());

    }


    public function show(Article $article)
    {
        return $article;
    }

    public function update(Article $article)
    {

        $article->update($this->validateData());

    }

    public function destroy(Article $article)
    {

        $article->delete();

    }

    private function validateData()
    {

        return request()->validate([
            'title' => 'required',
            'body' => 'required',
            'excerpt' => 'required',
        ]);


    }
}
