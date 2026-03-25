<video id="video" controls></video>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    var video = document.getElementById('video');
    var hlsUrl =
        'https://d3cz6emnvl4l6h.cloudfront.net/batch/videos/hls/d5fed764-1422-40b9-9eab-b01e0a57b58e/index.m3u8';

    if (Hls.isSupported()) {
        var hls = new Hls();
        hls.loadSource(hlsUrl);
        hls.attachMedia(video);
    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
        video.src = hlsUrl;
    }
</script>
