<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Kitab</title>
</head>
<body>
    <header>
        <div>
            <a href="/">kitab</a>
        </div>
        <nav>
            <ul>
                @if ($loggedIn)
                    <li><a href="/logout">Log Out</a></li>
                    <li><a href="/account">Account</a></li>                    
                @else
                    <li><a href="/signup">Sign Up</a></li>
                    <li><a href="/login">Login</a></li>                    
                @endif
            </ul>
        </nav>
    </header>

    <hr>
    
    <main>
        @yield('main')
    </main>
</body>
</html>