<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,900&display=swap" rel="stylesheet">
</head>
<body>
    <div id="app">
        <router-link :to="{name: 'welcome'}">Home</router-link>
        <router-link :to="{name: 'home'}">Dashboard</router-link>
        <router-link :to="{name: 'login'}">login</router-link>
        <router-link :to="{name: 'register'}">register</router-link>
        <router-view></router-view>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
