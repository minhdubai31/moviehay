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
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
        return view('series.create');
    }

    // Store new seri
    public function store(Request $request)
    {
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
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

        if ($request->hasFile('sr_poster')) {
            $image_path = '/images/' . $request->file('sr_poster')->getClientOriginalName() . time() . 'thumb.jpg';
            Image::make($request->file('sr_poster'))->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/' . $image_path));

            $formData['sr_poster'] = $image_path;
        }

        Serie::create($formData);
        return redirect('/admin/films')->with('message', 'Seri phim mới đã được thêm');
    }

    // Delete an seri
    public function drop(Serie $seri)
    {
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
        $seri->delete();
        return back()->with('message', 'Seri phim đã được xóa');
    }

    // Edit a seri
    public function edit(Serie $seri)
    {
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
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
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
