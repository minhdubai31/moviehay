<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Replycomment;
use Illuminate\Http\Request;

class ReplycommentController extends Controller
{
    // Insert new reply comment
    public function store(Request $request) {
        $data = $request->validate([
            'cmt_id' => 'required',
            'rcmt_content' => 'required|min: 1',
            'user_id' => 'required',
            'rcmt_who' => 'required'
        ]);

        $replycomment = Replycomment::create($data);

        return response([
            'username' => $replycomment->user->username,
            'cmt_content' => $replycomment->rcmt_content,
            'created_at' => $replycomment->created_at,
            'ep_id' => $replycomment->comment->ep_id,
            'rcmt_who' => $replycomment->replyUser->username
        ]);
    }

    // Delete a replycomment
    public function drop(Replycomment $rcmt) {
        if(auth()->user()->username != 'admin' and auth()->user()->user_id != $rcmt->user->user_id) {
            return redirect('/');
        }
        $rcmt->delete();
        return back()->with('message', 'Bình luận đã được xóa');
    }
}
