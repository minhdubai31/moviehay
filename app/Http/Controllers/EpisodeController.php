<?php

namespace App\Http\Controllers;


use Amp\Future;
use App\Jobs\uploadVideo;
use App\Models\View;
use App\Models\Serie;
use App\Models\Season;
use Spatie\Async\Pool;
use App\Models\Episode;
use function Amp\async;
use function Amp\delay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class EpisodeController extends Controller
{
    // Show all episodes
    public function recent()
    {
        return view('episodes.recent', [
            'episodes' => Episode::orderBy('updated_at', 'desc')->paginate(15)
        ]);
    }

    // Show episode info
    public function show(Episode $episode)
    {
        // Increase views
        $formData = [
            'ep_id' => $episode->ep_id,
            'user_id' => Auth::user()->user_id ?? null
        ];
        View::create($formData);

        return view('episodes.show', [
            'episode' => $episode
        ]);
    }

    // Create new episode
    public function create()
    {
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
        return view('episodes.create', [
            'series' => Serie::all()
        ]);
    }

    public function get_from_season(Season $season)
    {
        return response($season->episodes);
    }

    // Store new episode
    public function store(Request $request)
    {
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
        $formData = $request->validate([
            'sr_id' => 'required',
            'ss_id' => 'required',
            'ep_order' => 'required',
            'v_origin' => 'required'
        ], [
            'sr_id.required' => 'Vui lòng chọn seri phim.',
            'ss_id.required' => 'Vui lòng chọn season phim.',
            'ep_order.required' => 'Vui lòng nhập thứ tự tập phim.',
            'v_origin.required' => 'Vui lòng chọn video.'
        ]);

        unset($formData['sr_id']);
        $formData['ep_name'] = $request['ep_name'];

        if ($request->hasFile('v_origin')) {

            $video_dur = FFMpeg::open($request->file('v_origin'))->getDurationInSeconds();
            $image_path = '/images/' . $request->file('v_origin')->getClientOriginalName() . time() . 'thumb.jpg';
            FFMpeg::open($request->file('v_origin'))
                ->getFrameFromSeconds(rand(5, $video_dur - 5))
                ->export()
                ->toDisk('public')
                ->save($image_path);
            Image::make(storage_path('app/public/' . $image_path))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/' . $image_path));

            $formData['ep_thumbnail'] = $image_path;


            $file_path = $request->file('v_origin')->store('videos', 'public');
            $formData['v_origin'] = $file_path;

            $video_height = FFMpeg::open($request->file('v_origin'))
                ->getVideoStream()
                ->getDimensions()->getHeight();

            $formData['v_origin_size'] = $video_height;
            if ($video_height > 480) {
                $formData['v_sd'] = $file_path . "480p.mp4";
            }

            if ($video_height > 720) {
                $formData['v_hd'] = $file_path . "720p.mp4";
            }

            uploadVideo::dispatchAfterResponse($file_path, $video_height);
        }


        Episode::create($formData);
        return redirect('/admin/films')->with('message', 'Tập phim mới đã được thêm và sẽ xuất hiện sau khi đã xử lý xong');
    }

    // Delete an episode
    public function drop(Episode $episode)
    {
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
        $episode->delete();
        return back()->with('message', 'Tập phim đã được xóa');
    }

    // Edit an episode
    public function edit(Episode $episode)
    {
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
        return view('episodes.edit', [
            'this_ep' => $episode
        ]);
    }

    // Update an episode
    public function update(Request $request, Episode $episode)
    {
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
        $formData = $request->validate([
            'ep_order' => 'required'
        ], [
            'ep_order.required' => 'Vui lòng nhập thứ tự tập phim.',
        ]);

        $formData['ep_name'] = $request['ep_name'];

        if ($request->hasFile('v_origin')) {

            $video_dur = FFMpeg::open($request->file('v_origin'))->getDurationInSeconds();
            $image_path = '/images/' . $request->file('v_origin')->getClientOriginalName() . time() . 'thumb.jpg';
            FFMpeg::open($request->file('v_origin'))
                ->getFrameFromSeconds(rand(5, $video_dur - 5))
                ->export()
                ->toDisk('public')
                ->save($image_path);
            Image::make(storage_path('app/public/' . $image_path))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/' . $image_path));

            if ($episode->ep_thumbnail != null)
                Storage::disk('public')->delete($episode->ep_thumbnail);
            $formData['ep_thumbnail'] = $image_path;


            $file_path = $request->file('v_origin')->store('videos', 'public');
            if ($episode->v_origin != null)
                Storage::disk('public')->delete($episode->v_origin);
            if ($episode->v_hd != null)
                Storage::disk('public')->delete($episode->v_hd);
            if ($episode->v_sd != null)
                Storage::disk('public')->delete($episode->v_sd);
            $formData['v_origin'] = $file_path;

            $video_height = FFMpeg::open($request->file('v_origin'))
                ->getVideoStream()
                ->getDimensions()->getHeight();

            $formData['v_origin_size'] = $video_height;
            if ($video_height > 480) {
                $formData['v_sd'] = $file_path . "480p.mp4";
            }

            if ($video_height > 720) {
                $formData['v_hd'] = $file_path . "720p.mp4";
            }

            uploadVideo::dispatchAfterResponse($file_path, $video_height);
        }

        $episode->update($formData);
        return redirect('/admin/films')->with('message', 'Tập phim đã được cập nhật và sẽ xuất hiện sau khi đã xử lý xong');
    }
}
