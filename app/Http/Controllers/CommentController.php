<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Auth;

class CommentController extends Controller
{
    function saveComment(Request $request, $id) {
    	$comments = new Comment();
    	$comments->content = $request->comment;
    	$comments->task_id = $id;
    	$comments->user_id = Auth::user()->id;
    	$comments->save();

    	return response()->json(['time' => $comments->created_at->diffForHumans()]);
    }

    public function deleteComment($id) {
        $comment = Comment::find($id)->delete();
        // return redirect('/');
    }

    public function editComment(Request $request, $id) {
        $comment = Comment::find($id);
        $comment->content = $request->input;
        $comment->save();
    }
}
