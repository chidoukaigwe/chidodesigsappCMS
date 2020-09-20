<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', Article::class);

        return request()->user()->articles;

    }


    public function store(Request $request)
    {
        $this->authorize('viewAny', Article::class);
        //  fetch user that made req
        //  use the article relationship on the user to do the creation
       request()->user()->articles()->create($this->validateData());

    }

    public function show(Article $article)
    {
        //  Code example without creating a policy

        // if (request()->user()->isNot($article->user)) {
        //     return response([], 403);
        // }

        //  Can a user view this article?
        $this->authorize('view', $article);

        return $article;
    }

    public function update(Article $article)
    {

        $this->authorize('view', $article);

        $article->update($this->validateData());

    }

    public function destroy(Article $article)
    {

        $this->authorize('view', $article);


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
