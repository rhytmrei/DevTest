<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name') }}</title>

        @vite(['resources/js/app.js','resources/css/app.css'])
    </head>
    <body>
    <div id="app" class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white rounded-lg shadow-lg p-8 w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2">
            <router-view></router-view>
        </div>
    </div>
    </body>
</html>
