<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function index()
    {

        return request()->user()->articles;

    }


    public function store(Request $request)
    {
        //  fetch user that made req
        //  use the article relationship on the user to do the creation
       request()->user()->articles()->create($this->validateData());

    }


    public function show(Article $article)
    {
        if (request()->user()->isNot($article->user)) {
            return response([], 403);
        }
        return $article;
    }

    public function update(Article $article)
    {
        if (request()->user()->isNot($article->user)) {
            return response([], 403);
        }

        $article->update($this->validateData());

    }

    public function destroy(Article $article)
    {

        if (request()->user()->isNot($article->user)) {
            return response([], 403);
        }

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
