<?php

namespace Tests\Feature;

use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_article_can_be_added()
    {

        $this->post('/api/article', $this->data());

        $article = Article::first();

        $this->assertEquals('Test Article Title', $article->title);
        $this->assertEquals('Test Article Body', $article->body);
        $this->assertEquals('This is an Article Excerpt', $article->excerpt);

    }

    /** @test */
    public function fields_are_required()
    {
        collect(['title', 'body', 'excerpt'])

            ->each( function ($field){

                $response = $this->post('/api/article', array_merge($this->data(), [$field => '']));

                $response->assertSessionHasErrors($field);

                //  Assert that no contact was added to the DB (article table)
                $this->assertCount(0, Article::all());

            });
    }

    /** @test */
    public function a_article_can_be_retrieved()
    {

        $article = factory(Article::class)->create();

        $response = $this->get('/api/article/' . $article->id);

        // dd($article);

        $response->assertJson([
            'title' => $article->title,
            'body' => $article->body,
            'excerpt' => $article->excerpt,
        ]);


    }

    /** @test */
    public function a_article_can_be_patched()
    {
        $this->withoutExceptionHandling();

        //  Article Gets Cached At Beginning Of Request
        $article = factory(Article::class)->create();

        $response = $this->patch('/api/article/' . $article->id, $this->data());

        //  Override Contact With Our Fresh Article
        $article = $article->fresh();

        $this->assertEquals('Test Article Title', $article->title);
        $this->assertEquals('Test Article Body', $article->body);
        $this->assertEquals('This is an Article Excerpt', $article->excerpt);

    }

    /** @test */
    public function a_article_can_be_deleted()
    {
        //  Article Gets Cached At Beginning Of Request
        $article = factory(Article::class)->create();

        $response = $this->delete('/api/article/' . $article->id);

        $this->assertCount(0, Article::all());
    }


    private function data()
    {
        return [
            'title' => 'Test Article Title' ,
            'body' => 'Test Article Body',
            'excerpt' => 'This is an Article Excerpt',
        ];
    }
}
