


@extends('layouts.cpanel')


                        @section('cpanelNav')
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('marks')}}"> <i class="fa-solid fa-circle-arrow-down   "></i> Marks space</a> </div>                    
                        <div class="col-12 col-sm-6 text-center "><a class="text-left" href="{{route('dashboard')}}"> <i class="fa-solid fa-circle-arrow-left   "></i> Go back to dashboard</a> </div>                    
   @endsection
                        
                
                        @section('cpanelContent')
                        <div class="row">
                        <div class="col-12 col-sm-6 text-center "><b>Normal users List</b></a> 
                            <div class="content">
                                @foreach ($users as $user)
                                <div>
                                    <a title="Add user as a moderator" onclick="return confirm('Are you sure?')" href = {{route('addModerators', ['id' => $user->userId])}}>
                                        <i class="fa-solid fa-circle-plus"></i>
                                        {{$user->firstName}} {{$user->lastName}} 
                                    </a>
                                </div>
                            @endforeach                                </div>
                        </div>   
                                         
                        <div class="col-12 col-sm-6 text-center "><b>Moderators List</b></a> 
                            <div class="content">
                                @foreach ($moderators as $moderator)
                                <div>
                                    @if (count(Auth::user()->superadmins) > 0)
                                        <a title="Remove from moderators list" onclick="return confirm('Are you sure?')" href = {{route('removeModerator', ['id' => $moderator->userId])}}>
                                            <i class="fa-solid fa-circle-minus"></i>
                                        </a>
                                    @endif
                                    {{$moderator->firstName}} {{$moderator->lastName}}
                                </div>
                            @endforeach
                            </div>
                        </div> 

                        </div>
                        @endsection
                  





