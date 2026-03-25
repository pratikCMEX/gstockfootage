<script src="{{ asset('assets/admin/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/admin/js/app.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('assets/admin/js/dashboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

<script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/additional-methods.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/toastr.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/dataTables.responsive.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<!-- toast js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- datatable button -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
@if (isset($js))
    @foreach ($js as $value)
        <script src="{{ asset('assets/admin') }}/js/{{ $value }}.js"></script>
    @endforeach
@endif

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


    $(document).ready(function () {
        $('.searchable').select2({
            width: 'resolve',
            minimumResultsForSearch: 0, // always show search box
            placeholder: function () {
                return $(this).data('placeholder') || "Type to search...";
            },
            allowClear: true
        });

        $(document).on('select2:open', function () {
            $('.select2-search__field').attr('placeholder', 'Type to search...');
        });
    });

    //  Global placeholder capitalizer — add once in main JS file
    $('input, textarea').each(function () {
        let placeholder = $(this).attr('placeholder');
        if (placeholder) {
            // Capitalize first letter of each word
            let capitalized = placeholder.replace(/\b\w/g, function (char) {
                return char.toUpperCase();
            });
            $(this).attr('placeholder', capitalized);
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        //  Find every video element that has an HLS path
        document.querySelectorAll('video[data-hls]').forEach(function (videoEl) {

            var hlsPath = videoEl.getAttribute('data-hls');
            var fallback = videoEl.getAttribute('data-fallback');

            //  Skip if no HLS path set
            if (!hlsPath || hlsPath === '') {
                if (fallback) videoEl.src = fallback;
                return;
            }

            if (Hls.isSupported()) {
                var hls = new Hls({
                    autoStartLoad: false, //  Don't load until user plays — saves bandwidth
                    startLevel: -1, // auto quality
                });

                hls.loadSource(hlsPath);
                hls.attachMedia(videoEl);

                //  Only start loading when user hits play
                videoEl.addEventListener('play', function () {
                    hls.startLoad();
                }, {
                    once: true
                });

                hls.on(Hls.Events.ERROR, function (event, data) {
                    if (data.fatal) {
                        console.warn('HLS fatal error, falling back to direct source', data);
                        hls.destroy();
                        //  Fallback to mid/original if HLS fails
                        if (fallback) {
                            videoEl.src = fallback;
                            videoEl.load();
                        }
                    }
                });

            } else if (videoEl.canPlayType('application/vnd.apple.mpegurl')) {
                //  Native Safari HLS
                videoEl.src = hlsPath;

            } else {
                //  Browser doesn't support HLS at all — use mp4 fallback
                if (fallback) videoEl.src = fallback;
            }
        });

    });
</script>