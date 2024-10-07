<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PostsTest extends TestCase
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

    public function a_user_can_read_all_the_posts()
    {
        $post = factory('App\Post')->create();
        $response = $this->get('/posts');
        $response->assertSee($post->title);
    }

    public function a_user_can_read_single_post()
    {
        $post = factory('App\Post')->create();
        $response = $this->get('/show-post/'.$post->id);
        $response->assertSee($post->title)
            ->assertSee($post->content);
    }

    public function users_can_create_a_new_post()
    {
        $post = factory('App\Post')->make();
        $this->post('/create-post',$post->toArray());
        $this->assertEquals(1, Post::all()->count());
    }

    public function a_post_requires_a_title(){
        $post = factory('App\Task')->make(['title' => null]);
        $this->post('/create-post',$post->toArray())
            ->assertSessionHasErrors('title');
    }


    public function a_post_requires_a_content(){
        $post = factory('App\Post')->make(['content' => null]);
        $this->post('/create-post',$post->toArray())
            ->assertSessionHasErrors('content');
    }

    public function update_the_task(){
        $post = factory('App\Post')->make(['title' => 'test', 'content' => 'essay']);
        $post->title = "Updated Title";
        $this->put('/update-post/'.$post->id, $post->toArray());
        $this->assertDatabaseHas('posts', ['id'=> $post->id , 'title' => 'Updated Title']);
    }

    public function delete_the_task(){
        $post = factory('App\Post')->make(['title' => 'test', 'content' => 'essay']);
        $this->delete('/delete-post/' . $post->id);
        $this->assertDatabaseMissing('posts',['id'=> $post->id]);
    }
}
