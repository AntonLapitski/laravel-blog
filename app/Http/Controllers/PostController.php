<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getAllPosts()
    {
        $posts = Post::all();

        return view('posts', ['posts' => $posts]);
    }


    public function getPostById(Request $request)
    {
        $post = Post::find($request->route('id'));

        return view('show', ['post' => $post]);
    }


    public function createPost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $post = new Post();

        $post->fill([
            'title' => $request->get('title'),
            'content' => $request->get('content')
        ]);

        $post->save();

        return redirect('/posts');
    }


    public function editPost(Request $request)
    {
        $post = Post::find($request->route('id'));

        return view('edit', ['post' => $post]);
    }


    public function updatePost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $post = Post::find($request->route('id'));

        $post->title = $request->get('title');
        $post->content = $request->get('content');

        $post->save();


        return redirect('/posts');
    }

    public function deletePost(Request $request)
    {

        $post = Post::find($request->route('id'));
        $post->comments()->delete();
        $post->delete();

        return redirect('/posts');
    }
}
