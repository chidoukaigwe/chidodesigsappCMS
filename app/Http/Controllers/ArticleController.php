<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Article as ArticleResource;

class ArticleController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', Article::class);

        Article::paginate(5);

        return ArticleResource::collection(request()->user()->articles);

    }


    public function store(Request $request)
    {
        $this->authorize('viewAny', Article::class);

        //  fetch user that made req
        //  use the article relationship on the user to do the creation
       $article = request()->user()->articles()->create($this->validateData());

       return (new ArticleResource($article))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);

    }

    public function show(Article $article)
    {
        /**
         *  Code example without creating a policy
         *  if (request()->user()->isNot($article->user)) {
         *    return response([], 403);
         *   }
         */

        $this->authorize('view', $article);

        return new ArticleResource($article);
    }

    public function update(Article $article)
    {

        $this->authorize('view', $article);

        $article->update($this->validateData());

        return (new ArticleResource($article))
                ->response()
                ->setStatusCode(Response::HTTP_OK);

    }

    public function destroy(Article $article)
    {

        $this->authorize('view', $article);

        $article->delete();

        return response([], Response::HTTP_NO_CONTENT);

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
