@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                
<style>
  :target {
    background-color: yellow;
}
</style>
            <div class="homeHeader">
             
             
                  
<hr/>




                <div class="text-center">
                <b>Major: </b> {{ $major }} <br/>

                @for ($i = 0; $i < sizeof($availableSemesters) ; $i++)
                <a href="{{ route('currentSemester', ['id'=>$availableSemesters[$i]]) }}" class="btn  btnInu my-2">S{{$availableSemesters[$i]}}</a>
                @endfor
              </div><hr/>
                <div class="border">{{ $semester['semesterName'] }}'s mark:<b> {{ $semester['semesterMark'] }}</b> &nbsp; ||&nbsp;  your rank: <b>{{ $rank }}</b> &nbsp; ||&nbsp;   your class's mean: <b>{{ $classMean }}</b> </div> 
            </div>

         
         
                <table class="table tableDark">
                    <thead>

                      <tr>
                        <th scope="col">Modules & Elements</th>
                        <th scope="col"></th>
                        <th scope="col">%</th>
                        <th scope="col">Marks</th>
                      </tr>

                    </thead>

                    <tbody>
                        @foreach ($modules as $module)
                        <tr id="module">
                            <th scope="row">{{ $module['moduleName'] }}</th>
                            <td></td>
                            <td></td>
                            @if($module['moduleMark']<12)
                              <td><div style="color:rgb(138, 6, 6);"><b>{{$module['moduleMark']    }}</b></div></td>
                              @else 
                                @if($module['isRatt'])
                                  <td><div style="color:#f9ff00;"><b>{{$module['moduleMark']    }}</b></div></td>
                                @else
                                  <td><div style="color:#;"><b>{{$module['moduleMark']    }} </b></div></td>
                                @endif
                              @endif
                          </tr>
                          

                          @foreach ($module['courses'] as $course)
                          <tr id="element">
                              <th scope="row" id="elementName">{{ $course['courseName'] }}</th>
                              <td></td>
                              <td id="grey">{{  $course['courseCoeff']  }}%</td>
                              @if ($master)
                                @if($course['courseMark']<10)
                                <td><div style="color:rgb(138, 6, 6);"><b>{{ $course['courseMark']}}</b></div></td>
                                @else 
                                <td><div style="color:#;"><b>{{ $course['courseMark']}}</b></div></td>
                                @endif
                              @else
                                @if($course['courseMark']<12)
                                <td><div style="color:rgb(138, 6, 6);"><b>{{ $course['courseMark']}}</b></div></td>
                                @else 
                                <td><div style="color:#;"><b>{{ $course['courseMark']}}</b></div></td>
                                @endif
                              @endif
                          
                             
                            </tr>
  
                            
                          @endforeach

                        @endforeach 

                    </tbody>
                  </table>





            </div>
        </div>
</div>





@endsection 