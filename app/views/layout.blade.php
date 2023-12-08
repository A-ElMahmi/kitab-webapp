<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Kitab</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/utils.css">
</head>
<body>
    <div class="header-wrapper">
        <header>
            <div>
                <a href="/"><img src="/logo.svg" alt="Kitab Logo"></a>
            </div>
            <nav>
                <ul class="flex-list">
                    @if (isset($loggedIn) && $loggedIn === true)
                    <li><a href="/account">Account</a></li>
                        <li><a href="/logout">Log Out</a></li>
                    @else
                        <li><a href="/signup">Sign Up</a></li>
                        <li><a href="/login">Login</a></li>
                    @endif
                </ul>
            </nav>
        </header>
        
        @yield('search-box')
    </div>
    
    <main>
        @yield('main')
    </main>

    <footer>
        <p>This website was developed by Abderrahmane El Mahmi</p>
        <ul>
            <li><a href="https://github.com/A-ElMahmi/">Github</a></li>
            <li><a href="https://www.linkedin.com/in/abderrahmane-el-mahmi-36a929256/">LinkedIn</a></li>
        </ul>
    </footer>
</body>
</html>