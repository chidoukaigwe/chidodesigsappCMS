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
        $this->withExceptionHandling();

        $this->post('/api/article', [
            'title' => 'Test Article Title' ,
            'body' => 'Test Article Body',
            'excerpt' => 'This is an Article Excerpt',
            ]);

        $article = Article::first();

        $this->assertEquals('Test Article Title', $article->title);
        $this->assertEquals('Test Article Body', $article->body);
        $this->assertEquals('This is an Article Excerpt', $article->excerpt);

    }
}
