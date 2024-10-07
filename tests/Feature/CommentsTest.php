<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CommentsTest extends TestCase
{
    use DatabaseMigrationss;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function a_user_can_read_all_the_comments()
    {
        $comment = factory('App\Comment')->create();
        $response = $this->get('/get-comments/');
        $response->assertSee($comment->contents);
    }

    public function users_can_create_a_new_comment()
    {
        $comment = factory('App\Comment')->make();
        $this->post('/set-comment/'. 1, $comment->toArray());
        $this->assertEquals(1, Comment::all()->count());
    }

    public function a_comment_requires_a_contents()
    {
        $comment = factory('App\Comment')->make(['contents' => null]);
        $this->post('/set-comment/' . 1, $comment->toArray())
            ->assertSessionHasErrors('contents');
    }
}
