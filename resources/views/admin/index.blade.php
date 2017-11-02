<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="{{ mix('/statics/admin/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app"></div>
<script src="{{ mix('/statics/admin/js/manifest.js') }}"></script>
<script src="{{ mix('/statics/admin/js/vendor.js') }}"></script>
<script src="{{ mix('/statics/admin/js/app.js') }}"></script>
</body>
</html>
