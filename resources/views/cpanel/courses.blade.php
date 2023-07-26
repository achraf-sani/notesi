

@extends('layouts.cpanel')


                        @section('cpanelNav')
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('courses')}}"> <i class="fa-solid fa-circle-arrow-down   "></i> Courses space</a> </div>                    
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('dashboard')}}"> <i class="fa-solid fa-circle-arrow-left   "></i> Go back to dashboard</a> </div>                    
                        @endsection
                        
                
                        @section('cpanelContent')

                            <form  action = "{{route('addCourses')}}" method = "post" enctype = "multipart/form-data">
                                @csrf
                                <!--<input type="file" name="file" accept=".csv" required>-->
                                <input type="file" name="files[]" accept=".csv" multiple required>
                                <input type = "submit" name = "submit" value = "Update Courses">
                            </form>
                            <hr>
                        
                           
                        

                        <table class="table tableDark">
                            <thead>
                              <tr>
                                <th scope="col">Course ID</th>
                                <th scope="col">Module ID</th>
                                <th scope="col">Course name</th>
                                <th scope="col">Course Abbrev.</th>
                                <th scope="col">Course Coeff.</th>
                              </tr>
                            </thead>
        
                            <tbody>
                                <tr>
                                    <td>
                                @if(isset($updated))
                                <h2 style="color:rgb(6, 156, 6)">updated Successfully</h2>        
            
                                @endif 
                                    </td>
                                </tr>
            
                                @if(isset($updated))
                                @foreach ($updated as $update)

                                  <tr id="element">
                                    <td>{{$update->courseId}}</td>
                                    <td>{{$update->moduleId}}</td>
                                    <td>{{utf8_decode($update->courseName)}}</td>
                                    <td>{{$update->courseAbbreviation}}</td>
                                    <td>{{$update->courseCoeff}}</td>
                                    </tr>
                                @endforeach
                                @endif
                                <tr>
                                    <td>
                                @if(isset($created))
                                <h2 style="color:rgb(6, 156, 6)">Created Successfully</h2>        
            
                                @endif 
                                    </td>
                                </tr>
                                @if(isset($created))
                                    @foreach ($created as $create)

                                    <tr id="element">
                                        <td>{{$create->courseId}}</td>
                                        <td>{{$create->moduleId}}</td>
                                        <td>{{utf8_decode($create->courseName)}}</td>
                                        <td>{{$create->courseAbbreviation}}</td>
                                        <td>{{$create->courseCoeff}}</td>
                                        </tr>
                                    @endforeach
                                @endif


                            </tbody>
                          </table>

                @endsection

