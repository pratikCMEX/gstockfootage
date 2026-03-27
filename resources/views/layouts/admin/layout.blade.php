<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-admin.header title="{{ $title }}" page={{ $page }} />
    @isset($css)
        <link rel="stylesheet" href="{{ asset('assets') }}/admin/css/{{ $css }}.css" />
    @endisset


</head>

<body>
    <main>

        <div id="loader">
            <!-- From Uiverse.io by Juanes200122 -->
            <svg viewBox="0 0 240 240" height="240" width="240" class="pl">
                <circle stroke-linecap="round" stroke-dashoffset="-330" stroke-dasharray="0 660" stroke-width="20"
                    stroke="#000" fill="none" r="105" cy="120" cx="120" class="pl__ring pl__ring--a">
                </circle>
                <circle stroke-linecap="round" stroke-dashoffset="-110" stroke-dasharray="0 220" stroke-width="20"
                    stroke="#000" fill="none" r="35" cy="120" cx="120" class="pl__ring pl__ring--b">
                </circle>
                <circle stroke-linecap="round" stroke-dasharray="0 440" stroke-width="20" stroke="#000" fill="none"
                    r="70" cy="120" cx="85" class="pl__ring pl__ring--c"></circle>
                <circle stroke-linecap="round" stroke-dasharray="0 440" stroke-width="20" stroke="#000" fill="none"
                    r="70" cy="120" cx="155" class="pl__ring pl__ring--d"></circle>
            </svg>
        </div>
        <div id="ai_loader">
            <!-- From Uiverse.io by Juanes200122 -->
            <svg viewBox="0 0 240 240" height="240" width="240" class="pl">
                <circle stroke-linecap="round" stroke-dashoffset="-330" stroke-dasharray="0 660" stroke-width="20"
                    stroke="#000" fill="none" r="105" cy="120" cx="120" class="pl__ring pl__ring--a">
                </circle>
                <circle stroke-linecap="round" stroke-dashoffset="-110" stroke-dasharray="0 220" stroke-width="20"
                    stroke="#000" fill="none" r="35" cy="120" cx="120" class="pl__ring pl__ring--b">
                </circle>
                <circle stroke-linecap="round" stroke-dasharray="0 440" stroke-width="20" stroke="#000" fill="none"
                    r="70" cy="120" cx="85" class="pl__ring pl__ring--c"></circle>
                <circle stroke-linecap="round" stroke-dasharray="0 440" stroke-width="20" stroke="#000" fill="none"
                    r="70" cy="120" cx="155" class="pl__ring pl__ring--d"></circle>
            </svg>

            <div class="genrate-ai">Generating AI Content</div>
        </div>

        <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
            data-sidebar-position="" data-header-position="fixed">
            <div class="body-wrapper">

                <x-admin.bodyheader title={{ $title }} />

                <x-admin.sidebar />

                <div class="content-area">
                    @include($page)
                </div>


            </div>
        </div>

    </main>

    <x-admin.bodyfooter page="{{ $page }}" />
    <x-admin.footer :js="$js ?? []" page="{{ $page }}" />
    @stack('scripts')
    {{--
    <script>
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 entries"
            },
            infoCallback: function (settings, start, end, max, total) {
                return total === 1
                    ? `Showing ${start} to ${end} of ${total} entry`
                    : `Showing ${start} to ${end} of ${total} entries`;
            }
        }); --}}
    </script>

</body>

</html>
