@extends('layouts.app')

@section('content')


<div class="relative flex items-top justify-center  sm:items-center py-17 sm:pt-0">





    <div class="row justify-content-center">





        <div class="col-md-8">
            <div class=" ">

               
                <div class="relative flex items-top justify-center   sm:items-center" style="text-align: center; padding-top:20%;">
                
                @if(isset($availableSemesters))
                    @for ($i = 0; $i < sizeof($availableSemesters) ; $i++)
                    <a href="{{ route('currentSemester', ['id'=>$availableSemesters[$i]]) }}" class="btn  btnInu my-2">S{{$availableSemesters[$i]}}</a>
                    @endfor
                @endif
                  <br/>
                        <br/>
            </div>

            <div class="container">
            @if($errors->any())
            <h4>{{$errors->first()}}</h4>
            @endif
            <hr/>

            A kind reminder 🥰🥰🥰 <br/>
            You can donate to keep the platform running 🥰

            </div>  
        </div>  
    </div>

    <div class="brr"><br/><br/><br/> </div>

</div>


                    
                   
                   

@endsection