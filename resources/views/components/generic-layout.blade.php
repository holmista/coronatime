<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    {{-- <style>
        * {
            overflow-x: hidden;
        }
    </style> --}}

</head>

<body>
    {{ $slot }}
</body>

</html>
