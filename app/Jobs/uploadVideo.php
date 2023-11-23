<?php

namespace App\Jobs;

use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class uploadVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $file_path;
    private $height;
    /**
     * Create a new job instance.
     */
    public function __construct($file_path, $height)
    {
        $this->file_path = $file_path;
        $this->height = $height;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $lowBitrate = (new X264)->setKiloBitrate(300);
        $midBitrate = (new X264)->setKiloBitrate(700);
        if ($this->height > 480) {
            FFMpeg::fromDisk('public')
                ->open($this->file_path)
                ->addFilter(function (VideoFilters $filters) {
                    $filters->resize(new \FFMpeg\Coordinate\Dimension(854, 480));
                })
                ->export()
                ->inFormat($lowBitrate)
                ->save($this->file_path . "480p.mp4");
        }

        if ($this->height > 720) {
            FFMpeg::fromDisk('public')
                ->open($this->file_path)
                ->addFilter(function (VideoFilters $filters) {
                    $filters->resize(new \FFMpeg\Coordinate\Dimension(1280, 720));
                })
                ->export()
                ->inFormat($midBitrate)
                ->save($this->file_path . "720p.mp4");
        }
    }
}
