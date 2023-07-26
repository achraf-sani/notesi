




@extends('layouts.cpanel')


                        @section('cpanelNav')
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('modules')}}"> <i class="fa-solid fa-circle-arrow-down   "></i> Modules space</a> </div>                    
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('dashboard')}}"> <i class="fa-solid fa-circle-arrow-left   "></i> Go back to dashboard</a> </div>                    
   @endsection
                        
                
                        @section('cpanelContent')
                        <form  action = "{{route('addModules')}}" method = "post" enctype = "multipart/form-data">
                            @csrf
                            <!--<input type="file" name="file" accept=".csv" required>-->
                            <input type="file" name="files[]" accept=".csv" multiple required>
                            <input type = "submit" name = "submit" value = "Update Modules">
                        </form>

                        <hr>

                       
                    

                  


                
    
                        

                        <table class="table tableDark">
                            <thead>
                              <tr>
                                <th scope="col">Module ID</th>
                                <th scope="col">Module Name</th>
                                <th scope="col">Module Coefficient</th>
                                <th scope="col">Module Major</th>
                                <th scope="col">Module Abbrev.</th>
                              </tr>
                            </thead>
        
                            <tbody>

                                <tr>
                                    <td>
                                    @if(isset($updated))
                                    <h2 style="color:rgb(6, 156, 6)">updated Successfully</h2>
                                    </td>
                                </tr>       
            
                                @endif 
                                @if(isset($updated))
                                    @foreach ($updated as $update)
                                    <tr id = "element">
                                        <td>{{$update->moduleId}}</td>
                                        <td>{{utf8_decode($update->moduleName)}}</td>
                                        <td>{{$update->moduleCoeff}}</td>
                                        <td>{{$update->moduleMajor}}</td>
                                        <td>{{$update->moduleAbbreviation}}</td>
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
                                    <tr id = "element">
                                    <td>{{$create->moduleId}}</td>
                                    <td>{{utf8_decode($create->moduleName)}}</td>
                                    <td>{{$create->moduleCoeff}}</td>
                                    <td>{{$create->moduleMajor}}</td>
                                    <td>{{$create->moduleAbbreviation}}</td>
                                    </tr>
                                    @endforeach
                                @endif 


                            </tbody>
                          </table>

                        @endsection
