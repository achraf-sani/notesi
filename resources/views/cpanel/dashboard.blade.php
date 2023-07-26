
@extends('layouts.app')

@section('content')


<style>

            .btnC{
                /* background-color: #ec7208;  */
                width: 100%;
                height: 150%;
                margin: 0 0 20% 0;
                color: white;
                /* border:  white 1px solid; */
            }
            a{
                color: #F5831F;
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


            @media screen and (max-width: 580px)) {
                .btn{
                background-color: #ec7208;
                width: 150px;
                margin-bottom: 10%;
            }

            .btnC{
                background-color: red;
                /* width: 20%;
                height: 50%; */
                margin: 0 0 90% 0;
                color: white;
            }

            .logo{
                width:85%;
                height:100%;
                margin-bottom:5%;
            }





}

        </style>





        <div class="relative flex items-top justify-center  sm:items-center py-17 sm:pt-0">


            <div class="row justify-content-center">


                <div class="text-center"><a href="{{route('dashboard')}}" ><img class="logo" src='https://svgshare.com/i/euy.svg' title='' /></a></div> 
                <div class="col-md-8">
                    


                    <div class="row text-center ik">


                        <div class="col-12 col-sm"><a href="{{route('majors')}}"><button type="button" title="Majors" class="btn btn-lg btnC"><i class="fa-solid fa-code-branch fa-2xl">  </i></button></a></div>
                        <div class="col-12 col-sm"><a href="{{route('modules')}}"><button type="button" title="Modules" class="btn btn-lg btnC"><i class="fa-solid fa-cubes fa-2xl">  </i></button></a></div>
                        <div class="col-12 col-sm"><a href="{{route('courses')}}"><button type="button" title="Courses" class="btn btn-lg btnC"><i class="fa-solid fa-cube cover fa-2xl">  </i></button></a></div>
                        <div class="col-12 col-sm"><a href="{{route('students')}}"><button type="button" title="Students" class="btn btn-lg btnC"><i class="fa-solid fa-users fa-2xl"> </i></button></a></div>


                        <div class="w-10"></div>
                        <br/>
                        <br/>
                        <br/>

                        <div class="col-12 col-sm"><a href="{{route('marks')}}"><button type="button" title="Marks" class="btn btn-lg btnC"><i class="fa-solid fa-diamond fa-2xl">  </i></button></a></div>
                        <div class="col-12 col-sm"><a href="{{route('users')}}"><button type="button" title="Users" class="btn btn-lg btnC"><i class="fa-solid fa-user-pen fa-2xl">  </i></button></a></div>

                        @if (count(Auth::user()->superadmins) > 0)<!--only superadmins can add superadmins & moderators-->

                        <div class="col-12 col-sm"><a href="{{route('superadmins')}}"><button type="button" title="Admins" class="btn btn-lg btnC"><i class="fa-solid fa-brain fa-2xl">  </i></button></a></div>
                        <div class="col-12 col-sm"><a href="{{route('moderators')}}"><button type="button" title="Mods" class="btn btn-lg btnC"><i class="fa-solid fa-id-card-clip fa-2xl"> </i></button></a></div>

                        <div class="col-12 col-sm"><a href="{{route('our_backup_database')}}" ><button type="button" title="Backup" class="  btn btn-lg btnC"><i class="fa-solid fa-file-arrow-down fa-2xl" >  </i></button></a></div>
                        @endif

                      </div>
                    </div>
                </div>
            </div>


        </div>



@endsection
