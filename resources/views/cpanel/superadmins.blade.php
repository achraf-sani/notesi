


@extends('layouts.cpanel')


                        @section('cpanelNav')
                        
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('superadmins')}}"> <i class="fa-solid fa-circle-arrow-down   "></i> Super admins space</a> </div>                    
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('dashboard')}}"> <i class="fa-solid fa-circle-arrow-left   "></i> Go back to dashboard</a> </div>                    
     @endsection
                        
                
                        @section('cpanelContent')
                        <div class="row">
                            <div class="col-12 col-sm-4 text-center "><b>Super admins</b> </a> 
                                <hr> 

                                <div class="content">
                                    @foreach ($superadmins as $superadmin)
                                        <div>
                                            {{$superadmin->firstName}} {{$superadmin->lastName}}
                                        </div>
                                    @endforeach
                                 </div>
                            </div>   
                                       
                            
                            <div class="col-12 col-sm-4 text-center "><b>Moderators</b> </a>
                                <hr> 
                                <div class="content">
                                    @foreach ($moderators as $moderator)
                                    <div>
                                        <a title="Upgrade to superadmin" onclick="return confirm('Are you sure?')" href = {{route('addSuperadmins', ['id' => $moderator->userId])}}>
                                            <i class="fa-solid fa-circle-plus"></i>
                                        </a>
                                        <a title="Remove from moderators list" onclick="return confirm('Are you sure?')" href = {{route('removeModerator', ['id' => $moderator->userId])}}>
                                            <i class="fa-solid fa-circle-minus"></i>
                                        </a>
                                        {{$moderator->firstName}} {{$moderator->lastName}}
                                    </div>
                                @endforeach
                                 </div>
                            </div>  


                            <div class="col-12 col-sm-4 text-center "><b>Regular users  </b></a> 
                                <hr> 
                                
                                <div class="content">
                                    @foreach ($users as $user)
                                    <div>
                                        <a title="Upgrade to superadmin"  onclick="return confirm('Are you sure?')" href = {{route('addSuperadmins', ['id' => $user->userId])}}>
                                            <i class="fa-solid fa-circle-plus"></i> 
                                        </a>
                                        {{$user->firstName}} {{$user->lastName}} 
                                    </div>
                                @endforeach
                                 </div>
                            </div>  
                        </div>
                        @endsection
                  








