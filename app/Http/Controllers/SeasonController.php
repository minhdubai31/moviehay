<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeasonController extends Controller
{
    // Show the movie season info
    public function show(Season $season) {
        $episodes_list = DB::table('episodes')->where('season_id', $season->id)->get();

        return view('seasons.show', [
            'season' => $season,
            'episodes_list' => $episodes_list
        ]);
    }
}
