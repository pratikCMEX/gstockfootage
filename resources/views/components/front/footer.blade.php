<script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/front/js/cart.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/additional-methods.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/admin/js/toastr.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/dataTables.responsive.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<!-- toast js -->

<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('assets/front/js/script.js') }}"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<script>
    var base_url = $("#base_url").val();

    @if (session('msg_error'))
        toastr.error("{{ session('msg_error') }}");
    @endif

    @if (session('msg_success'))
        toastr.success("{{ session('msg_success') }}");
    @endif

    @if (isset($errors) && $errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>
@if (isset($js))
    @foreach ($js as $value)
        <script src="{{ asset('assets/front') }}/js/{{ $value }}.js"></script>
    @endforeach
@endif
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ✅ Find every video element that has an HLS path
        document.querySelectorAll('video[data-hls]').forEach(function(videoEl) {

            var hlsPath = videoEl.getAttribute('data-hls');
            var fallback = videoEl.getAttribute('data-fallback');

            // ✅ Skip if no HLS path set
            if (!hlsPath || hlsPath === '') {
                if (fallback) videoEl.src = fallback;
                return;
            }

            if (Hls.isSupported()) {
                var hls = new Hls({
                    autoStartLoad: false, // ✅ Don't load until user plays — saves bandwidth
                    startLevel: -1, // auto quality
                });

                hls.loadSource(hlsPath);
                hls.attachMedia(videoEl);

                // ✅ Only start loading when user hits play
                videoEl.addEventListener('play', function() {
                    hls.startLoad();
                }, {
                    once: true
                });

                hls.on(Hls.Events.ERROR, function(event, data) {
                    if (data.fatal) {
                        console.warn('HLS fatal error, falling back to direct source', data);
                        hls.destroy();
                        // ✅ Fallback to mid/original if HLS fails
                        if (fallback) {
                            videoEl.src = fallback;
                            videoEl.load();
                        }
                    }
                });

            } else if (videoEl.canPlayType('application/vnd.apple.mpegurl')) {
                // ✅ Native Safari HLS
                videoEl.src = hlsPath;

            } else {
                // ✅ Browser doesn't support HLS at all — use mp4 fallback
                if (fallback) videoEl.src = fallback;
            }
        });

    });
</script>
