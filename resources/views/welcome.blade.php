<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Redirect to Login -->
    <script>
        window.onload = function() {
            window.location.href = "{{ route('login') }}";
        };
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        /* Tambahkan CSS di sini jika diperlukan */
    </style>
</head>

<body>
    <!-- Konten halaman yang ada tidak akan ditampilkan karena halaman akan langsung diarahkan ke login -->
</body>

</html>
