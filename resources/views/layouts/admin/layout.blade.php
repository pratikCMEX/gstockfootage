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
            <div class="spinner-grow text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
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
