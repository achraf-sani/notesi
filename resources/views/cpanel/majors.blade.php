




@extends('layouts.cpanel')


                        @section('cpanelNav')
                        
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('majors')}}"> <i class="fa-solid fa-circle-arrow-down   "></i> Majors space</a> </div>                    
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('dashboard')}}"> <i class="fa-solid fa-circle-arrow-left   "></i> Go back to dashboard</a> </div>                    
       @endsection
                        
                
                        @section('cpanelContent')

                        <form  action = "{{route('addMajors')}}" method = "post" enctype = "multipart/form-data">
                            @csrf

                            <input type="file" name="file" accept=".csv" required>
                            <input type = "submit" name = "submit"  value = "Update Majors">
                        </form>

                        <hr>
                        
                    
                    

                  

                        
                        

                        <table class="table tableDark">
                            <thead>
                              <tr>
                                <th scope="col">Major ID</th>
                                <th scope="col">Semester ID</th>
                                <th scope="col">Major name</th>
                                <th scope="col">Major Abbrev.</th>
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
                                        <td>{{$create->majorId}}</td>
                                        <td>{{$create->semesterId}}</td>
                                        <td>{{utf8_decode($create->majorName)}}</td>
                                        <td>{{$create->majorAbbreviation}}</td>
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
                                        <td>{{$update->majorId}}</td>
                                        <td>{{$update->semesterId}}</td>
                                        <td>{{utf8_decode($update->majorName)}}</td>
                                        <td>{{$update->majorAbbreviation}}</td>
                                    </tr>
                                    @endforeach
                                @endif


                            </tbody>
                          </table>


                          @endsection
