<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    </head>
    <body class="">
        <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center pt-6 sm:pt-0 bg-light">
            <div style="max-width: 150px;" class="text-center mb-4">
                <a href="/">
                    <img src="{{ asset('paypal-logo.png') }}" alt="Logo" class="img-fluid" />
                </a>
            </div>

            @isset($prueba)
            <div class="card shadow-sm w-25 p-4 rounded-4">
                {{ $prueba }}
            </div>
            @endisset

        </div>
    </body>
</html>