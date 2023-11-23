<?php

namespace App\Http\Controllers;


use App\Models\View;
use App\Models\Serie;
use App\Models\Video;
use App\Models\Season;
use App\Models\Episode;
use App\Jobs\uploadVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
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
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
        return view('episodes.create', [
            'series' => Serie::all()
        ]);
    }

    // Get all episodes of a season
    public function get_from_season(Season $season)
    {
        return response($season->episodes);
    }

    // Store new episode
    public function store(Request $request)
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        // Validate request data
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


        // Check if has video file
        if ($request->hasFile('v_origin')) {

            // Get video duration
            $video_dur = FFMpeg::open($request->file('v_origin'))->getDurationInSeconds();

            // Generate random name
            $image_path = '/images/' . $request->file('v_origin')->getClientOriginalName() . time() . 'thumb.jpg';

            // Export random thumbnail from video
            FFMpeg::open($request->file('v_origin'))
                ->getFrameFromSeconds(rand(5, $video_dur - 5))
                ->export()
                ->toDisk('public')
                ->save($image_path);

            // Compress image width to 300px
            Image::make(storage_path('app/public/' . $image_path))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/' . $image_path));
            // Save image path
            $formData['ep_thumbnail'] = $image_path;

            // Insert new episode to database
            $episode = Episode::create($formData);

            // Save video to storage
            $file_path = $request->file('v_origin')->store('videos', 'public');
            
            // Get video height
            $video_height = FFMpeg::open($request->file('v_origin'))
                ->getVideoStream()
                ->getDimensions()->getHeight();
            // Insert original video to database
            Video::create(['v_path' => $file_path, 'v_resolution' => $video_height, 'ep_id' => $episode->ep_id]);

            // Check if video original size bigger than 480p then compress a 480p version of video
            if ($video_height > 480) {
                Video::create(['v_path' => $file_path . "480p.mp4", 'v_resolution' => 480, 'ep_id' => $episode->ep_id]);
            }

            // Check if video original size bigger than 720p then compress a 480p version of video
            if ($video_height > 720) {
                Video::create(['v_path' => $file_path . "720p.mp4", 'v_resolution' => 720, 'ep_id' => $episode->ep_id]);
            }

            // Compress video in background after redirect
            uploadVideo::dispatchAfterResponse($file_path, $video_height);
        }

        // Redirect to admin films manager page
        return redirect('/admin/films')->with('message', 'Tập phim mới đã được thêm và sẽ xuất hiện sau khi đã xử lý xong');
    }

    // Delete an episode
    public function drop(Episode $episode)
    {
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }
        
        // Delete thumbnail and videos files
        Storage::disk('public')->delete($episode->ep_thumbnail);
        foreach ($episode->videos as $video) {
            Storage::disk('public')->delete($video->v_path);
        }

        $episode->delete();
        return back()->with('message', 'Tập phim đã được xóa');
    }

    // Edit an episode
    public function edit(Episode $episode)
    {
        // Check if logged in user is admin
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
        // Check if logged in user is admin
        if(auth()->user()->username != 'admin') {
            return redirect('/');
        }

        // Validate ep_order from request data
        $formData = $request->validate([
            'ep_order' => 'required'
        ], [
            'ep_order.required' => 'Vui lòng nhập thứ tự tập phim.',
        ]);

        // ep_name is not required
        $formData['ep_name'] = $request['ep_name'];

        // Same with create new episode
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
            
            $video_height = FFMpeg::open($request->file('v_origin'))
            ->getVideoStream()
            ->getDimensions()->getHeight();
            
            Video::create(['v_path' => $file_path, 'v_resolution' => $video_height, 'ep_id' => $episode->ep_id]);

            $formData['v_origin_size'] = $video_height;
            if ($video_height > 480) {
                Video::create(['v_path' => $file_path . "480p.mp4", 'v_resolution' => 480, 'ep_id' => $episode->ep_id]);
            }

            if ($video_height > 720) {
                Video::create(['v_path' => $file_path . "720p.mp4", 'v_resolution' => 720, 'ep_id' => $episode->ep_id]);
            }

            uploadVideo::dispatchAfterResponse($file_path, $video_height);
        }

        // Update episode
        $episode->update($formData);
        return redirect('/admin/films')->with('message', 'Tập phim đã được cập nhật và sẽ xuất hiện sau khi đã xử lý xong');
    }
}
