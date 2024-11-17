<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
       
    </head>
    <body>
        <div id="app">
            <header>
                <!-- Navigation Bar (if any) -->
            </header>

            <!-- Page Content -->
            <main>
                <div class="flex-center position-ref full-height">
                    <div class="content">
                        <div class="title m-b-md">
                            Welcome to {{ config('app.name', 'Laravel') }}
                        </div>

                        <div class="links">
                            <a href="https://laravel.com/docs">Documentation</a>
                            <a href="https://laracasts.com">Laracasts</a>
                            <a href="https://laravel-news.com">News</a>
                            <a href="https://blog.laravel.com">Blog</a>
                            <a href="https://nova.laravel.com">Nova</a>
                            <a href="https://forge.laravel.com">Forge</a>
                            <a href="https://vapor.laravel.com">Vapor</a>
                            <a href="https://github.com/laravel/laravel">GitHub</a>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Scripts -->
      
    </body>
</html>