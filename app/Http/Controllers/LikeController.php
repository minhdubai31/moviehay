<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Toggle Like
    public function toggle(Request $request) {
        $formData = $request->validate([
            'ep_id' => 'required',
            'user_id' => 'required'
        ]);

        $likeExist = Like::where('ep_id', '=', $formData['ep_id'])->where('user_id', '=', $formData['user_id']);
        
        // Check if like existed
        if($likeExist->count() == 0) {
            Like::create($formData);
            return response('create');
        }
        else {
            $likeExist->delete();
            return response('delete');
        }
    }
}
