<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
        .body{
            background-position: center;
          
        }
        .glass-effect {
        background: rgba(255, 255, 255, 0.1); /* Semi-transparent background */
        backdrop-filter: blur(10px); /* Blur effect */
        -webkit-backdrop-filter: blur(10px); /* Blur effect for Safari */
        border: 1px solid rgba(255, 255, 255, 0.3); /* Optional border */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Shadow for depth */
    }
            </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-100" style="background-image: url('images/bg.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center; background-attachment: fixed;">
            
                    <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg glass-effect">

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
