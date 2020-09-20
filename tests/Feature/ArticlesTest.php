<?php

namespace Tests\Feature;

use App\User;
use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticlesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    //  Run This Function Before Any Test Code Is run
    protected function setUp(): void
    {
        parent::setUp();

        //  Create a user before every single test
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_list_of_articles_can_be_fetched_for_the_authenticated_user()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $article = factory(Article::class)->create(['user_id' => $user->id]);
        $anotherArticle = factory(Article::class)->create(['user_id' => $anotherUser->id]);

        $response = $this->get('/api/articles?api_token=' . $user->api_token);

        //  dd(json_decode($response->getContent()));

        $response->assertJsonCount(1)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'article_id' => $article->id
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function an_unauthenticated_user_should_be_redirected_to_login()
    {
        $response = $this->post('/api/article', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Article::all());
    }

    /** @test */
    public function an_authenticated_user_can_add_a_article()
    {

        $response = $this->post('/api/article', $this->data());

        $article = Article::first();

        $this->assertEquals('Test Article Title', $article->title);
        $this->assertEquals('Test Article Body', $article->body);
        $this->assertEquals('This is an Article Excerpt', $article->excerpt);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'article_id' => $article->id
            ],
            'links' => [
                'self' => $article->path()
            ]
        ]);

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

        $article = factory(Article::class)->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/article/' . $article->id . '?api_token=' .  $this->user->api_token);

        $response->assertJson([
            'data' => [
                'article_id' => $article->id,
                'title' => $article->title,
                'body' => $article->body,
                'excerpt' => $article->excerpt,
                'created_at' => $article->created_at->format('m/d/Y'),
                'last_updated' => $article->updated_at->diffForHumans(),
            ]
        ]);

    }

    /** @test */
    public function only_the_users_articles_can_be_retrieved()
    {
        //  This article belongs to user created in setup
        $article = factory(Article::class)->create(['user_id' => $this->user->id]);

        //  create another user
        $anotherUser = factory(User::class)->create();

        //  try to fetch setup user's article
        $response = $this->get('/api/article/' . $article->id . '?api_token=' .  $anotherUser->api_token);

        $response->assertStatus(403);

    }

    /** @test */
    public function a_article_can_be_patched()
    {

        //  Article Gets Cached At Beginning Of Request
        $article = factory(Article::class)->create(['user_id' => $this->user->id]);

        $response = $this->patch('/api/article/' . $article->id, $this->data());

        //  Override Contact With Our Fresh Article
        $article = $article->fresh();

        $this->assertEquals('Test Article Title', $article->title);
        $this->assertEquals('Test Article Body', $article->body);
        $this->assertEquals('This is an Article Excerpt', $article->excerpt);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'article_id' => $article->id,
            ],
            'links' => [
                'self' => $article->path()
            ]
        ]);

    }

    /** @test */
    public function only_the_owner_of_the_article_can_patch_the_contact()
    {
        $article = factory(Article::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->patch('/api/article/' . $article->id, array_merge($this->data(), ['api_token' => $anotherUser->api_token]));

        $response->assertStatus(403);

    }

    /** @test */
    public function a_article_can_be_deleted()
    {
        //  Article Gets Cached At Beginning Of Request
        $article = factory(Article::class)->create(['user_id' => $this->user->id]);

        $response = $this->delete('/api/article/' . $article->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Article::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function only_the_owner_can_delete_the_article()
    {
        $article = factory(Article::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->delete('/api/article/' . $article->id, ['api_token' => $this->user->api_token]);

        $response->assertStatus((403));

    }

    private function data()
    {
        return [
            'title' => 'Test Article Title' ,
            'body' => 'Test Article Body',
            'excerpt' => 'This is an Article Excerpt',
            'api_token' => $this->user->api_token
        ];
    }
}
