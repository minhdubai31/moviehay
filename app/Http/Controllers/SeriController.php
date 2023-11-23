<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SeriController extends Controller
{
    // Create new seri
    public function create()
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
        return view('series.create');
    }

    // Store new seri
    public function store(Request $request)
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        // Validate request data
        $formData = $request->validate([
            'sr_name' => 'required|min: 3',
            'sr_country' => 'required',
            'sr_poster' => 'required',
        ], [
            'sr_name.required' => 'Vui lòng nhập tên seri phim.',
            'sr_name.min' => 'Tên seri phim phải có tối thiểu :min ký tự.',
            'sr_country.required' => 'Vui lòng nhập quốc gia của seri phim này.',
            'sr_poster.required' => 'Vui lòng thêm poster.',
        ]);

        // Save poster to storage
        if ($request->hasFile('sr_poster')) {
            $image_path = '/images/' . $request->file('sr_poster')->getClientOriginalName() . time() . 'thumb.jpg';
            Image::make($request->file('sr_poster'))->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/' . $image_path));

            // Set image path to form data
            $formData['sr_poster'] = $image_path;
        }

        Serie::create($formData);
        return redirect('/admin/films')->with('message', 'Seri phim mới đã được thêm');
    }

    // Delete an seri
    public function drop(Serie $seri)
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        // Delete all relative files from storage
        Storage::disk('public')->delete($seri->sr_poster);

        foreach ($seri->seasons as $season) {
            Storage::disk('public')->delete($season->ss_bg);
            Storage::disk('public')->delete($season->ss_poster);
    
            foreach ($season->episodes as $episode) {
                Storage::disk('public')->delete($episode->ep_thumbnail);
                foreach ($episode->videos as $video) {
                    Storage::disk('public')->delete($video->v_path);
                }
            }
        }

        $seri->delete();
        return back()->with('message', 'Seri phim đã được xóa');
    }

    // Edit a seri
    public function edit(Serie $seri)
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        return view('series.edit',[
            'this_sr' => $seri
        ]);
    }

    // Update a seri
    public function update(Request $request, Serie $seri)
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        // Same with create new seri
        $formData = $request->validate([
            'sr_name' => 'required|min: 3',
            'sr_country' => 'required',
        ], [
            'sr_name.required' => 'Vui lòng nhập tên seri phim.',
            'sr_name.min' => 'Tên seri phim phải có tối thiểu :min ký tự.',
            'sr_country.required' => 'Vui lòng nhập quốc gia của seri phim này.',
        ]);

        if ($request->hasFile('sr_poster')) {
            $image_path = '/images/' . $request->file('sr_poster')->getClientOriginalName() . time() . 'thumb.jpg';
            Image::make($request->file('sr_poster'))->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/' . $image_path));

            if($seri->sr_poster != null)
                Storage::disk('public')->delete($seri->sr_poster);
            $formData['sr_poster'] = $image_path;
        }

        $seri->update($formData);
        return redirect('/admin/films')->with('message', 'Seri phim đã được cập nhật');
    }
}
