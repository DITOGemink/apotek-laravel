<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    </head>
<body>
    <header>
        <nav style="background-color: #333; padding: 10px;">
            <a href="/home" style="color: white; margin: 0 10px;">Home</a>
            <a href="/about" style="color: white; margin: 0 10px;">About</a>
            <a href="/education" style="color: white; margin: 0 10px;">Education</a>
            <a href="/project" style="color: white; margin: 0 10px;">Projects</a>
        </nav>
    </header>

    <div class="container" style="padding: 20px;">
        @yield('content')
    </div>

    <footer style="background-color: #f4f4f4; padding: 10px; text-align: center;">
        <p>&copy; 2025 Andhito Abimanyu. All rights reserved.</p>
    </footer>
</body>
</html>