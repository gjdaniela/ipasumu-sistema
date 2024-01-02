<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <!--<link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> -->

        <!-- Scripts 
        @vite(['resources/css/app.css', 'resources/js/app.js']) -->
        

        <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .container-login100 {
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 15px;
            height: 100%;
            width: 100%;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: relative;
            z-index: 1;
        }

        .container-login100::before {
            content: "";
            display: block;
            position: absolute;
            z-index: -1;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            background-color: rgba(144, 144, 144,0.5);
        }
        
        login100-form {
            width: 100%;
        }
    </style>



                    
      
    </head>
    <body class="font-sans text-gray-900 antialiased" >
    <div class="container-login100" style="background-image: url('https://niv.lv/images/auto/DJI_0946.jpg');">
    
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
            
            </div>
        </div>
</div>
    </body>
</html>



	

