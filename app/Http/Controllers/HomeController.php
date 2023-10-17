<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Season;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    // Homepage
    public function index(Request $request)
    {
        if ($request['search']) {
            $returnSeries = Serie::where('sr_name', 'like', '%' . $request['search'] . '%')->get();

            $returnSeasons = Season::where('ss_name', 'like', '%' . $request['search'] . '%')->get();
            return view('home.search', [
                'series' => $returnSeries,
                'seasons' => $returnSeasons
            ]);
        }

        $seasons = Episode::withCount('views')->get()->groupBy('ss_id')->take(10);
        foreach ($seasons as $item) {
            $item['total_views'] = $item->sum('views_count');
        }
        return view('home.index', [
            'episodes_new' => Episode::all()->sortByDesc('updated_at')->take(10),
            'seasons_random' => Season::inRandomOrder()->get()->take(12),
            'seasons_by_view' => $seasons->sortByDesc('total_views')
        ]);
    }
}
