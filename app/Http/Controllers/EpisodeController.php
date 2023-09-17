<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Season;
use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    // Show all episodes
    public function index() {
        return view('episodes.index', [
            'episodes' => Episode::all()
        ]);
    }

    // Show episode info
    public function show() {

    }
}
