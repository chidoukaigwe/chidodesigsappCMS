<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\PublicArticle;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublicArticlesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_public_article_can_be_added()
    {

        $this->post('/api/articles/public', $this->data());

        $publicArticle = PublicArticle::first();

        $this->assertEquals('Test Article', $publicArticle->title);
        $this->assertEquals('Test Body', $publicArticle->body);
        $this->assertEquals('Test Excerpt', $publicArticle->excerpt);
    }

    /** @test */
    public function fields_are_required()
    {
        collect(['title', 'body', 'excerpt'])
            ->each(function($field){

                $response = $this->post('/api/articles/public',
                array_merge($this->data(), [$field => '']));

            $response->assertSessionHasErrors($field);

            $this->assertCount(0, PublicArticle::all());

            });
    }

    /** @test */
    public function a_title_is_required()
    {

        $response = $this->post('/api/articles/public',
            array_merge($this->data(), ['title' => '']));

        $response->assertSessionHasErrors('title');

        $this->assertCount(0, PublicArticle::all());

    }

    /** @test */
    public function a_body_is_required()
    {

        $response = $this->post('/api/articles/public', array_merge($this->data(), ['body' => '']));

        $response->assertSessionHasErrors('body');

        $this->assertCount(0, PublicArticle::all());

    }

    public function data()
    {
        return [
            'title' => 'Test Article',
            'body' => 'Test Body',
            'excerpt' => 'Test Excerpt'
        ];
    }

}
