<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/element-ui/1.0.5/theme-default/fonts/element-icons.ttf"/>
        <!-- Styles -->
        <style>
            @font-face{
                font-family:element-icons;
                src:url('fonts/vendor/element-ui/lib/theme-chalk/element-icons.woff?535877f50039c0cb49a6196a5b7517cd') format("woff"),url('fonts/vendor/element-ui/lib/theme-chalk/element-icons.ttf?732389ded34cb9c52dd88271f1345af9') format("truetype");
                font-weight:400;
                font-display:auto;
                font-style:normal
            }
        </style>
    </head>
    <body>
        <div id="app">
            <home-page/>
        </div>
    </body>
    <script src="{{ asset('js/app.js') }}"></script>

</html>
