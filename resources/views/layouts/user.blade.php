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
    <body class="bg-[#f1f1f1] flex p-6 lg:p-8 min-h-screen flex-col">

        <div class="flex flex-col md:flex-row w-full h-full min-h-[90vh]">
            <div class="w-full md:flex md:w-1/5 bg-slate-200 p-2">
                <div class="flex flex-row justify-between md:justify-start md:flex-col gap-2 w-full">
                    <h3 class="hidden md:flex text-2xl border-b-1 w-full mb-3">{{ $user['username'] }}</h3>
                    <a href="{{ route('user.dashboard') }}">Dashboard</a>
                    <a href="{{ route('user.course') }}">Add course</a>
                </div>
            </div>
            <div class="w-full md:w-4/5 bg-white p-4">
                @yield('content')
            </div>
        </div>

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
