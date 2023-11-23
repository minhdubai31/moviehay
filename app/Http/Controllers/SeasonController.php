<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SeasonController extends Controller
{
    // Show the movie season info
    public function show(Season $season)
    {
        return view('seasons.show', [
            'season' => $season,
            'episodes' => $season->episodes,
            'seri' => $season->seri
        ]);
    }

    // Get all seasons of a seri
    public function get_from_seri(Serie $seri)
    {
        return response($seri->seasons);
    }

    // Create new season
    public function create()
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
        return view('seasons.create', [
            'series' => Serie::all()
        ]);
    }


    // Store new season
    public function store(Request $request)
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        // Validate request data
        $formData = $request->validate([
            'sr_id' => 'required',
            'ss_name' => 'required|min: 3',
            'ss_description' => 'required|min: 20',
            'ss_tag' => 'required',
            'ss_poster' => 'required',
            'ss_categories' => 'required',
            'ss_bg' => 'required',
        ], [
            'sr_id.required' => 'Vui lòng chọn seri phim.',
            'ss_name.required' => 'Vui lòng nhập tên season phim.',
            'ss_name.min' => 'Tên season phim phải có tối thiểu :min ký tự.',
            'ss_description.required' => 'Vui lòng thêm thông tin phim.',
            'ss_description.min' => 'Mô tả phim phải có tối thiểu :min ký tự.',
            'ss_tag.required' => 'Vui lòng nhập tag của season này.',
            'ss_poster.required' => 'Vui lòng thêm poster.',
            'ss_categories.required' => 'Vui lòng nhập thể loại.',
            'ss_bg.required' => 'Vui lòng thêm ảnh bìa.'
        ]);

        // Not require fields
        $formData['ss_release_date'] = $request['ss_release_date'];
        $formData['ss_director'] = $request['ss_director'];
        $formData['ss_single'] = $request->has('ss_single');

        // Save poster to storage
        if ($request->hasFile('ss_poster')) {
            $image_path = '/images/' . $request->file('ss_poster')->getClientOriginalName() . time() . 'thumb.jpg';
            Image::make($request->file('ss_poster'))->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/' . $image_path));

            // Save poster path to form data
            $formData['ss_poster'] = $image_path;
        }

        // Save background image to storage
        if ($request->hasFile('ss_bg')) {
            $formData['ss_bg'] = $request->file('ss_bg')->store('images', 'public');
        }

        Season::create($formData);
        return redirect('/admin/films')->with('message', 'Season phim mới đã được thêm');
    }

    // Show random seasons
    public function random()
    {
        return view('seasons.random', [
            'seasons' => Season::inRandomOrder()->paginate(12)
        ]);
    }

    // Show all single movies
    public function single()
    {
        return view('seasons.single', [
            'singlemovies' => Season::where('ss_single', '=', '1')->orderBy('ss_release_date', 'desc')->paginate(12)
        ]);
    }

    // Show all single movies
    public function series()
    {
        return view('seasons.series', [
            'seriesmovies' => Season::where('ss_single', '=', '0')->orderBy('ss_release_date', 'desc')->paginate(12)
        ]);
    }

    // Delete a season
    public function drop(Season $season)
    {
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        // Delete all relative files from storage
        Storage::disk('public')->delete($season->ss_bg);
        Storage::disk('public')->delete($season->ss_poster);
        foreach ($season->episodes as $episode) {
            Storage::disk('public')->delete($episode->ep_thumbnail);
            foreach ($episode->videos as $video) {
                Storage::disk('public')->delete($video->v_path);
            }
        }

        $season->delete();
        return back()->with('message', 'Season phim đã được xóa');
    }

    // Edit a season
    public function edit(Season $season)
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
        return view('seasons.edit', [
            'this_ss' => $season
        ]);
    }

    // Update a season
    public function update(Request $request, Season $season)
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        // Validate request data
        $formData = $request->validate([
            'ss_name' => 'required|min: 3',
            'ss_description' => 'required|min: 20',
            'ss_tag' => 'required',
            'ss_categories' => 'required',
        ], [
            'ss_name.required' => 'Vui lòng nhập tên season phim.',
            'ss_name.min' => 'Tên season phim phải có tối thiểu :min ký tự.',
            'ss_description.required' => 'Vui lòng thêm thông tin phim.',
            'ss_description.min' => 'Mô tả phim phải có tối thiểu :min ký tự.',
            'ss_tag.required' => 'Vui lòng nhập tag của season này.',
            'ss_categories.required' => 'Vui lòng nhập thể loại.',
        ]);

        // Same with create new season
        $formData['ss_release_date'] = $request['ss_release_date'];
        $formData['ss_director'] = $request['ss_director'];
        $formData['ss_single'] = $request->has('ss_single');


        if ($request->hasFile('ss_poster')) {
            $image_path = '/images/' . $request->file('ss_poster')->getClientOriginalName() . time() . 'thumb.jpg';
            Image::make($request->file('ss_poster'))->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/' . $image_path));

            if ($season->ss_poster != null)
                Storage::disk('public')->delete($season->ss_poster);
            $formData['ss_poster'] = $image_path;
        }

        if ($request->hasFile('ss_bg')) {
            if ($season->ss_bg != null)
                Storage::disk('public')->delete($season->ss_bg);
            $formData['ss_bg'] = $request->file('ss_bg')->store('images', 'public');
        }

        $season->update($formData);
        return redirect('/admin/films')->with('message', 'Season phim đã được cập nhật');
    }
}
