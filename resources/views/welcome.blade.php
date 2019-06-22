<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>
        <link rel="icon" href="{!! asset('images/icons/logo.png') !!}"/>
        <title>PCModz</title>

        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    </head>
    <body>
        <div id="app">
            <main_vue></main_vue>
        </div>

          <script src="{{ asset('js/app.js') }}"></script> 
    </body>
</html>
