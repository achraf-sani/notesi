@extends('layouts.app')

@section('content')
    
<!DOCTYPE html>
<html>
<head>


    <style>
         .btn{
                background-color: #ec7208; 
                width: 200px;
                height: 200px;
                margin: 2%;
                color: white;
            }
            a{
                color: white;
            }

            a:hover{
                color: white;
            }

            .btn:hover{
                background-color: #7e3e06;
            }
      
            .logo{
                width:50%;
                height:100%;
                margin-bottom:5%;
            }

            button:after {
   content:' ' attr(title);
   visibility:hidden;
   opacity:0;
   transition:visibility 0s linear 0.5s, opacity 0.5s linear, font 0.05s linear;
   font-size:0;
}

button:hover:after {
   content:'   '  attr(title);
   visibility:visible;
   opacity:1;
   transition-delay:0s;
   font-size:20px;
   font-weight: bold;
   color: white;
}
            

            @media screen and (max-width: 600px) {
                .btn{
                background-color: #ec7208; 
                width: 150px;
                margin-bottom: 10%;
            }
            

            .logo{
                width:85%;
                height:100%;
                margin-bottom:5%;
            }



        
}

    </style>
</head>
<body>




    <div class="relative flex items-top justify-center  sm:items-center py-17 sm:pt-0">
        <div class="row justify-content-center">
            <div class="text-center"><a href="{{route('dashboard')}}" ><img class="logo" src='https://note.esihub.net/logo.svg' title='' /></a></div> 
            
            <div class="col-md-8">


                <div class="row">

                   @yield('cpanelNav')
                   <br/> <br/> <hr> <br/>

                    <div class="col-12 text-center ">
                        @yield('cpanelContent')
                </div>
                  </div>
                </div>
            </div>
        </div>


    </div>
<br/> <br/>  <br/> 

@yield('content2')
</body>
</html>


     

        
        


@endsection('content')



