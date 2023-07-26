




@extends('layouts.cpanel')

                        @section('cpanelNav')
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('users')}}"> <i class="fa-solid fa-circle-arrow-down   "></i> Users' space</a> </div>                    
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('dashboard')}}"> <i class="fa-solid fa-circle-arrow-left   "></i> Go back to dashboard</a> </div>                    
   @endsection
                
                        @section('cpanelContent')
                        <div class="row">
                                         
                            <div class="col-12 text-center">
                                <h4> The number of users is : {{ $usersCount }} </h4> <br/>
                                <table class="table tableDark">
                                    <thead>
                                      <tr>
                                        <th scope="col">User name</th>
                                        <th scope="col">Registering date</th>
        
                                      </tr>
                
                                    </thead>
                
                                    <tbody>
                                @foreach ($users as $user)

                                          <tr id="element">
                                              <td>{{$user->firstName}} {{$user->lastName}}</td>
                                              <td> {{$user->created_at->format('m/d/Y h:m:s A')}}</td>
                                            </tr>
                                @endforeach

                                    </tbody>
                                  </table>
                            </div>
                        </div>
                        @endsection
                  


                        
        


