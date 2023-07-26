<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- fontawesome -->
<script src="https://kit.fontawesome.com/e139f26dc1.js" crossorigin="anonymous"></script>

<!-- Analytics -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-92R27MB5NL"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-92R27MB5NL');
</script>

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="icon" type="image/png" sizes="32x32" href="https://f.top4top.io/p_22559fhst1.png">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- CSS only -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">




</head>
<body>

    <style>
        body{
            background-color: #051824;
            color: white;
            overflow-x: hidden;
        }
        .navbar{
            background-color: #051824;
            color: #fff;
        }
        a{
            color:#ec7208;
            text-decoration: none;
        }

        a:hover{
            color:#ec7208;
        }
        #grey{
            color: rgb(194, 194, 194) ;
        }
        #elementName{
            font-size:12px;
        }
        .border{
            border: red 2ch;
            padding: 2%;
            font-size: 20px;
            margin-bottom: 5%;
            text-align: center;
        }
        .homeHeader{
            padding: 5% 0 2% 0;
        }
        .homeHeaderBot{
            justify-content: space-evenly;
        }

        #module{
            background-color: #ca6004;
        }

            footer{
                text-align: center;
                color: white;
                padding: 2% 0 3% 0;
            }

        .btnInu{
            /* background-color: white;  */
            color: white;
            font-weight: bold;
            border: white 1px solid;
        }
        .btnInu:hover{
            background-color: #ec7208;

        }

        .tableDark{
            background-color: #051824;
            color: white;
            border-color: #ec7208;

        }
        button{
            border: none;
        }
        .fa-arrow-right-from-bracket{ 
            color: white; 
        }

        .child{/*lwl w tani*/
            display: inline-block;
            
        }
        

        #parent{/*bahum*/
            white-space: nowrap;
            font-size: 16px;
            margin-left: 3%;
        }
        .childButton{/*talt*/
            display: inline-block;
        }
    
        @media screen and (max-device-width: 600px) {
            .navbar-toggler:focus,
            .navbar-toggler:active,
            .navbar-toggler-icon:focus {
                outline: none;
                box-shadow: none;
            }

            .child{/*lwl w tani*/
                display: inline-block;
                font-size: 16px;
            }
            #parent{/*bahum*/
                white-space: nowrap;
                margin-left: 4%;
            }
            .childButton{/*talt*/
                padding-top: 2.5%;
            }

        }

   

            /* @media screen and (max-width: 600px) {

               

            footer{
                font-size: 75%;
            }} */
    </style>

    <div id="app">
        <nav class="navbar navbar-expand-md  shadow-sm " style="padding-top:2%;">
            <div class="container">
                <div class = "row">
                    <div class = "col-4" id="parent" >
                        <div class="child"> 
                            @if (Auth::check())
                                @if (Auth::user()->students()->dontCache()->first()->currentSemester != null) 
                                    <a class="navbar-brand" href="{{route('home', [Auth::user()->students()->dontCache()->first()->currentSemester])}}">
                                        NOTESI
                                    </a>    
                                @endif
                            @endif                
                        </div>      
                    </div>
                    <div class="col-4 child">
                        @if (Auth::check())
                            @if (count(Auth::user()->superadmins) > 0 || count(Auth::user()->moderators) > 0)
                                <a class="navbar-brand" href="{{route('dashboard')}}">|| &nbsp; Dashboard</a> 
                            @endif
                        @endif
                    </div>


                    
                </div>
                

                <div class="childButton">
                    <button class="navbar-toggler" id="buttonTog" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"> <i class="fa-solid fa-arrow-right-from-bracket"></i>  </span>
                    </button>
                </div>
        
                </div>

            



                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 5%">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav row mr-auto ">
                        <li class="nav-item col-md-auto child ">
                            @if (Auth::check())
                                {{Auth::user()->firstName}} {{Auth::user()->lastName}} 
                            @endif
                        </li>
                        <li class="nav-item col child">
                            @guest
                            @if (Route::has('login'))
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @endif
                            @else
                                <div class="" aria-labelledby="">
                                    <a class="" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }} <i class="fa-solid fa-arrow-right-from-bracket"></i>  
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            @endguest   
                        </li>                
                    </ul>
                </div>
            </div>
        </nav>
        <!---->

        <main class="py-4">
            @yield('content')
        </main>
<footer class="fo">Made with ❤️ by <a href="https://www.linkedin.com/in/Khalid9ASSI">Khalid KASSI</a> & <a href="https://www.linkedin.com/in/adnane-benazzou-b949381a3/">Adnane BENAZZOU</a><br>Maintained by <a href="https://www.linkedin.com/in/achraf-sani/">Achraf SANI<a/></footer>

    </div>
</body>
</html>
