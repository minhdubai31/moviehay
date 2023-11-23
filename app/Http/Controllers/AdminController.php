<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use App\Models\View;
use App\Models\Serie;
use App\Models\Comment;
use App\Models\Replycomment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class AdminController extends Controller
{
    // Homepage
    public function index()
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        return View('admin.index', [
            'total_users' => User::all()->count(),
            'total_views' => View::all()->count(),
            'total_likes' => Like::all()->count(),
            'total_comments' => Comment::all()->count()+Replycomment::all()->count()
        ]);
    }

    // Films manager
    public function films(Request $request)
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        // Check if admin search for a film
        if ($request['search']) {
            $returnSeries = Serie::where('sr_name', 'like', '%' . $request['search'] . '%')
                ->orWhereHas('seasons', function (Builder $query) use ($request) {
                    $query->where('ss_name', 'like', '%' . $request['search'] . '%');
                })
                ->paginate(2);
        } else {
            $returnSeries = Serie::Paginate(2);
        }

        // Return admin films manager
        return view('admin.films', [
            'series' => $returnSeries
        ]);
    }

    // Users manager
    public function users(Request $request)
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        // Check if admin search for a user (don't list admin user)
        if ($request['search']) {
            $returnUsers = User::where([['username', 'like', '%' . $request['search'] . '%'], ['username', '<>', 'admin']])
                ->orWhere([['email', 'like', '%' . $request['search'] . '%'], ['username', '<>', 'admin']])
                ->paginate(10);
        } else {
            $returnUsers = User::where('username', '<>', 'admin')->paginate(10);
        }

        // Return admin users manager
        return View('admin.users', [
            'users' => $returnUsers
        ]);
    }

    // Users manager
    public function comments(Request $request)
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        // Check if admin search for a comments
        if ($request['search']) {
            $returnComments = Comment::where('cmt_content', 'like', '%' . $request['search'] . '%')
                ->orWhereHas('user', function (Builder $query) use ($request) {
                    $query->where('username', 'like', '%' . $request['search'] . '%');
                })
                ->orWhereHas('episode', function (Builder $query) use ($request) {
                    $query->whereHas('season', function (Builder $query) use ($request) {
                        $query->where('ss_name', 'like', '%' . $request['search'] . '%');
                    });
                })
                ->paginate(5);
        } else {
            $returnComments = Comment::Paginate(5);
        }

        // Check if admin search for a replycomments
        if ($request['search']) {
            $returnReplycomments = Replycomment::where('rcmt_content', 'like', '%' . $request['search'] . '%')
                ->orWhereHas('user', function (Builder $query) use ($request) {
                    $query->where('username', 'like', '%' . $request['search'] . '%');
                })
                ->orWhereHas('comment', function (Builder $query) use ($request) {
                    $query->whereHas('episode', function (Builder $query) use ($request) {
                        $query->whereHas('season', function (Builder $query) use ($request) {
                            $query->where('ss_name', 'like', '%' . $request['search'] . '%');
                        });
                    });
                })
                ->paginate(5);
        } else {
            $returnReplycomments = Replycomment::Paginate(5);
        }

        // Return admin comments manager
        return View('admin.comments', [
            'comments' => $returnComments,
            'replycomments' => $returnReplycomments
        ]);
    }
}
