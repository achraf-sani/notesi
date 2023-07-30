







@extends('layouts.cpanel')


                        @section('cpanelNav')
                        
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('marks')}}"> <i class="fa-solid fa-circle-arrow-down   "></i> Marks space</a> </div>                    
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('dashboard')}}"> <i class="fa-solid fa-circle-arrow-left   "></i> Go back to dashboard</a> </div>                    
    @endsection
                        
                
                        @section('cpanelContent')

                        <form  action = "{{route('addMarks')}}" method = "post" enctype = "multipart/form-data">
                            @csrf
                            <!--<input type="file" name="file" accept=".csv" required>-->
                            <input type="file" name="files[]" accept=".csv" multiple required>
                            <input type = "submit" name = "submit" value = "Update Marks">
                            <label for="fname">Ratt Marks</label>
                            <input type="hidden" name="isRatt" value="0" />
                            <input type = "checkbox" name="isRatt" value="1" >
                        </form>

                        <hr>

                        

                        

                        <table class="table tableDark">
                            <thead>
                              <tr>
                                <th scope="col">Mark ID</th>
                                <th scope="col">Student ID</th>
                                <th scope="col">Course name</th>
                                <th scope="col">Mark</th>
                                <th scope="col">Ratt</th>
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
                                    <tr id ="element">
                                        <td>{{$create->markId}}</td>
                                        <td>{{$create->studentId}}</td>
                                        <td>{{$create->courseId}}</td>
                                        <td>{{$create->mark}}</td>
                                        <td>{{$create->ratt}}</td>
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
                                        <td>{{$update->markId}}</td>
                                        <td>{{$update->studentId}}</td>
                                        <td>{{$update->courseId}}</td>
                                        <td>{{$update->mark}}</td>
                                        <td>{{$update->ratt}}</td>
                                    </tr>
                                    @endforeach
                                @endif  


                            </tbody>
                          </table>




@endsection
