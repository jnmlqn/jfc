<!DOCTYPE html>  
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">  
<head>  
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
  
    <title inertia>{{ config('app.name', 'Laravel') }}</title>  
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Fonts -->  
    <link rel="preconnect" href="https://fonts.bunny.net">  
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />  
  
    <!-- Scripts -->  
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])  
    @inertiaHead  
</head>  
<body class="font-sans antialiased h-full">  
    <div class="container p-5">
        <div class="border rounded">
            <div class="m-4" style="overflow: auto;">
                @inertia
            </div>
        </div>
    </div>
</body>  
</html>