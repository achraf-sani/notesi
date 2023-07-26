



@extends('layouts.cpanel')


                        @section('cpanelNav')
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('modules')}}"> <i class="fa-solid fa-circle-arrow-down   "></i> Modules space</a> </div>                    
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('dashboard')}}"> <i class="fa-solid fa-circle-arrow-left   "></i> Go back to dashboard</a> </div>                    
    @endsection
                        
                
                        @section('cpanelContent')
                        <form  action = "{{route('addStudents')}}" method = "post" enctype = "multipart/form-data">
                            @csrf
                            <!--<input type="file" name="file" accept=".csv" required>-->
                            <input type="file" name="files[]" accept=".csv" multiple required>
                            <input type = "submit" name = "submit" value = "Update Students">
                        </form>
                        <hr>

                       
                   
                    

                    <table class="table tableDark">

                        <thead>
                          <tr>
                            <th scope="col">Student ID</th>
                            <th scope="col">Current Semester </th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Student Promo</th>
                            <th scope="col">Student Group</th>
                            <th scope="col">Student Major</th>
                         
                          </tr>
                        </thead>
    
                        <tbody>
                            <tr>
                                <td>
                                    @if(isset($created))
                                    <h2 style="color:rgb(6, 156, 6)">Created Successfully</h2>        
                                    @endif
                                </td>              
                            </tr>
                            

                            @if(isset($created))
                            @foreach ($created as $create)
                            <tr id = "element">
                                <td>{{$create->studentId}}</td>
                                <!-- <td>{{$create->currentSemester}}</td> -->
                                <td>{{utf8_decode($create->firstName)}}</td>
                                <td>{{utf8_decode($create->lastName)}}</td>
                                <td>{{utf8_decode($create->fullName)}}</td>
                                <td>{{$create->userId}}</td>
                                <td>{{$create->studentPromo}}</td>
                                <td>{{$create->studentGroup}}</td>
                                <td>{{$create->studentMajor}}</td>
                            </tr>
                            @endforeach
                        @endif

                        <tr>
                            <td>
                                @if(isset($updated))
                                <h2 style="color:rgb(6, 156, 6)">updated Successfully</h2>        
                                @endif
                            </td>
                        </tr>

                        @if(isset($updated))
                        @foreach ($updated as $update)
                            <tr id = "element">
                                <td>{{$update->studentId}}</td>
                                <td>{{$update->currentSemester}}</td>
                                <td>{{utf8_decode($update->firstName)}}</td>
                                <td>{{utf8_decode($update->lastName)}}</td>
                                <td>{{utf8_decode($update->fullName)}}</td>
                                <td>{{$update->userId}}</td>
                                <td>{{$update->studentPromo}}</td>
                                <td>{{$update->studentGroup}}</td>
                                <td>{{$update->studentMajor}}</td>
                            </tr>
                        @endforeach
                    @endif


                        </tbody>
                      </table>















                        @endsection
                  





