<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-slate-800 text-white p-4 shadow-lg mb-6">
        <div class="container mx-auto flex space-x-6">
            <a href="/title" class="hover:text-yellow-400 font-semibold">Title</a>
            <a href="/staff" class="hover:text-yellow-400 font-semibold">Staff</a>
            <a href="/organization" class="hover:text-yellow-400 font-semibold">Organization</a>
            <a href="/community" class="hover:text-yellow-400 font-semibold">Community</a>
            <a href="/activities" class="hover:text-yellow-400 font-semibold">Activities</a>
        </div>
    </nav>
    <div class="container mx-auto px-4 py-6">
        @yield('header')
        @yield('content')
    </div>
</body>
</html>