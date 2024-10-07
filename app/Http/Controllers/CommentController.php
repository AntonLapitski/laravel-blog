<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getAllPostComments(Request $request)
    {
        $comments = Post::find($request->route('id'))->comments()->get();

        return view('comments', ['comments' => $comments]);
    }

    public function setCommentToSelectedPost(Request $request)
    {
        $validated = $request->validate([
            'contents' => 'required',
        ]);

        $comment = new Comment();

        $comment->fill([
            'contents' => $request->get('contents'),
            'post_id' => $request->route('id')
        ]);

        $comment->save();

        return redirect('/posts');
    }

}
