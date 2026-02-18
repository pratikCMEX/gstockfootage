<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @isset($css)
        <link rel="stylesheet" href="{{ asset('assets') }}/front/css/{{ $css }}" />
    @endisset

    @isset($css1)
        <link rel="stylesheet" href="{{ asset('assets') }}/front/css/{{ $css1 }}" />
    @endisset
    @isset($common_css)
        <link rel="stylesheet" href="{{ asset('assets') }}/front/css/{{ $common_css }}" />
    @endisset
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-front.header title="{{ $title }}" page={{ $page }} />


</head>

<body>
    <main>

        <div class="loader" id="home_loader" style="display: none;">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        @include($page)

    </main>
    <div class="loader-wrap d-none">
        <svg viewBox="0 0 240 240" height="240" width="240" class="pl">
            <circle stroke-linecap="round" stroke-dashoffset="-330" stroke-dasharray="0 660" stroke-width="20"
                stroke="#eb3349" fill="none" r="105" cy="120" cx="120" class="pl__ring pl__ring--a">
            </circle>
            <circle stroke-linecap="round" stroke-dashoffset="-110" stroke-dasharray="0 220" stroke-width="20"
                stroke="#eb3349" fill="none" r="35" cy="120" cx="120" class="pl__ring pl__ring--b">
            </circle>
            <circle stroke-linecap="round" stroke-dasharray="0 440" stroke-width="20" stroke="#eb3349" fill="none"
                r="70" cy="120" cx="85" class="pl__ring pl__ring--c"></circle>
            <circle stroke-linecap="round" stroke-dasharray="0 440" stroke-width="20" stroke="#eb3349" fill="none"
                r="70" cy="120" cx="155" class="pl__ring pl__ring--d"></circle>
        </svg>
    </div>
    <x-front.footer :js="$js ?? []" page="{{ $page }}" />
