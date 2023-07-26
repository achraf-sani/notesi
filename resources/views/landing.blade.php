@extends('layouts.app')

@section('content')


<div class="relative flex items-top justify-center  sm:items-center py-17 sm:pt-0">





    <div class="row justify-content-center">





        <div class="col-md-8">
            <div class=" ">

               
                <div class="relative flex items-top justify-center   sm:items-center" style="text-align: center; padding-top:20%;">
                    Welcome back to NOTESI V2.0
                    please choose your current Semester ! <br/>

                    {{-- currentSemester should be defined in Routes 
                    ( the route to where we save the current semester 
                    for the current user + we display all semester marks )
                    It takes the semester Id as a parameter --}}
                    
                    @for ($i = 0; $i < sizeof($availableSemesters) ; $i++)
                    <a href="{{ route('currentSemester', ['id'=>$availableSemesters[$i]]) }}" class="btn  btnInu my-2">S{{$availableSemesters[$i]}}</a>
                    @endfor
            </div>

            <hr/>

            A kind reminder 🥰🥰🥰 <br/>
            You can donate to keep the platform running 🥰
        </div>
    </div>

    <div class="brr"><br/><br/><br/> </div>

</div>


                    
                   
                   

@endsection