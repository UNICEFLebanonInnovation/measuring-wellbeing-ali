<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Measuring Well-Being - Strengths and Difficulties Questionnaire platform">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title inertia>{{ config('app.name') }}</title>
    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="min-h-screen">
    @inertia
</body>
</html>
