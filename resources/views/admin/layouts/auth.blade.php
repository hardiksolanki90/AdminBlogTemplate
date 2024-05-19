<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardik Solanki Blog</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script type="text/javascript">
        const CSRF = '{{ csrf_token() }}';
        const CURRENT_URL = '{{ url()->current() }}';
    </script>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="p-5 bg-white dark:bg-gray-900 antialiased !p-0">
    <div id="app">
        <main class="main-app p-4 sm:ml-64 bg-gray-50">
            <div class="dark:border-gray-700 mt-14 min-h-screen">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>