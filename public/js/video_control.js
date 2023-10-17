var controls = [
    'play-large', // The large play button in the center
    "rewind", // Rewind by the seek time (default 10 seconds)
    "play", // Play/pause playback
    "fast-forward", // Fast forward by the seek time (default 10 seconds)
    "progress", // The progress bar and scrubber for playback and buffering
    "current-time", // The current time of playback
    "duration", // The full duration of the media
    "mute", // Toggle mute
    "volume", // Volume control
    // 'captions', // Toggle captions
    "settings", // Settings menu
    // 'restart', // Restart playback
    // 'pip', // Picture-in-picture (currently Safari only)
    // 'airplay', // Airplay (currently Safari only)
    "download", // Show a download button with a link to either the current source or a custom URL you specify in your options
    "fullscreen", // Toggle fullscreen
];

origin_size = $(".vid1 > source").first().attr('size');

var player = new Plyr(".vid1", {
    controls,
    i18n: {
        rewind: "Tua lại {seektime}s",
        play: "Phát",
        pause: "Tạm dừng",
        fastForward: "Tua tiếp {seektime}s",
        seek: "Tua",
        seekLabel: "{currentTime} trên {duration}",
        currentTime: "Thời gian hiện tại",
        duration: "Thời lượng",
        volume: "Âm lượng",
        mute: "Tắt âm",
        unmute: "Bỏ tắt âm",
        enableCaptions: "Bật phụ đề",
        disableCaptions: "Tắt phụ đề",
        download: "Tải xuống",
        enterFullscreen: "Toàn màn hình",
        exitFullscreen: "Thoát toàn màn hình",
        frameTitle: "Player for {title}",
        captions: "Phụ đề",
        settings: "Cài đặt",
        pip: "PIP",
        menuBack: "Quay lại menu trước",
        speed: "Tốc độ",
        normal: "Bình thường",
        quality: "Chất lượng",
        loop: "Lặp lại",
        start: "Bắt đầu",
        end: "Cuối",
        all: "Tất cả",
        reset: "Reset",
        disabled: "Tắt",
        enabled: "Bật",
        advertisement: "Ad",
        qualityBadge: {
            4320: "8K",
            2160: "4K",
            1440: "2K",
            1080: "FHD",
            720: "HD",
            576: "SD",
            480: "SD",
        },
    }
});

player.quality = origin_size;

