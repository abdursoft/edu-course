<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
           <link rel="stylesheet" href="{{asset('css/index.css')}}">
        @endif

        <!-- SWEET ALERT CSS -->
        <link rel="stylesheet" type="text/css" href="{{asset('css/sweet.css')}}" />

        <!-- JQUERY SCRIPT START -->
        <script src="{{asset('js/jquery.min.js')}}"></script>
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        @yield('content')



        <!-- ICONIFY BUNDLE SCRIPT START -->
        <script src="{{asset('js/icons.js')}}"></script>
        <!--SWEET ALERT SCRIPT START -->
        <script src="{{asset('js/sweet.js')}}"></script>
        <!-- AXIOS CLIENT SCRIPT START -->
        <script src="{{asset('js/axios/index.js')}}"></script>
        <!-- AXIOS HELPER SCRIPT START -->
        <script src="{{asset('js/axios/script.js')}}"></script>
        <!-- MAIN SCRIPT START -->
        <script src="{{asset('js/main.js')}}"></script>
    </body>
</html>
