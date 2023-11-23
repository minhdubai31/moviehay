<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Episode;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Insert new comment
    public function store(Request $request) {
        $formData = $request->validate([
            'user_id' => 'required',
            'ep_id' => 'required',
            'cmt_content' => 'required|min: 1'
        ]);

        $comment = Comment::create($formData);
        
        return response([
            'username' => $comment->user->username,
            'cmt_content' => $comment->cmt_content,
            'created_at' => $comment->created_at,
            'ep_id' => $comment->episode->ep_id
        ]);
    }

    // Render comments list
    public function show(Episode $episode) {
        return view('comments.show', [
            'episode' => $episode
        ])->render();
    }

    // Delete a comment
    public function drop(Comment $cmt) {
        if(auth()->user()->username != 'admin' and auth()->user()->user_id != $cmt->user->user_id) {
            return redirect('/');
        }
        $cmt->delete();
        return back()->with('message', 'Bình luận đã được xóa');
    }
}
