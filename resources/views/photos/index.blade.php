@extends('layouts.app')

@section('content')

<!-- Begin page content -->
<div class="col-md-8 col-md-offset-2" style="margin-top: 4.2em;">
	<div class="row">
		<div class="col-md-12">
			<div class="cover profile">
				<div class="wrapper">
					<div class="image">
						<img src="{{ $user->cover }}" class="show-in-modal" alt="people">
					</div>
					<ul class="friends">
                            @php

                            $president_name		=	"President";
                            $governor_name		=	"Governor";
                            $senator_name		=	"Senator";
                            $ward_leader_name	=	"Councillor";
                            $lga_name			=	"Local Govt. Chairman";
                            $federal_rep_name	=	"Federal Representative";
                            $state_rep_name		=	"State Representative";
                
                            if($president == "not defined"):
                            $lnames['president']=	"N/A";
                            $president_profile  =   "javascript:void(0)";
                            $president_image	=	\Storage::url("public/defaults/avatars/male.jpg");
                            else:
                            $lnames['president']=	$president->name;
                            $president_profile  =   "/profile/" . $president->username;
                            $president_image	=	$president->avatar;
                            endif;
                
                            if($governor == "not defined"):
                            $lnames['governor']	=	"N/A";
                            $governor_profile   =   "javascript:void(0)";
                            $governor_image		=	\Storage::url("public/defaults/avatars/male.jpg");
                            else:
                            $lnames['governor']	=	$governor->name;
                            $governor_profile   =   "/profile/" . $governor->username;
                            $governor_image		=	$governor->avatar;
                            endif;
                
                            if($senator == "not defined"):
                            $lnames['senator']	=	"N/A";
                            $senator_profile    =   "javascript:void(0)";
                            $senator_image		=	\Storage::url("public/defaults/avatars/male.jpg");
                            else:
                            $lnames['senator']	=	$senator->name;
                            $senator_profile    =   "/profile/" . $senator->username;
                            $senator_image		=	$senator->avatar;
                            endif;
                            
                            if($ward == "not defined"):
                            $lnames['ward']		=	"N/A";
                            $ward_profile       =   "javascript:void(0)";
                            $ward_leader_image	=	\Storage::url("public/defaults/avatars/male.jpg");
                            else:
                            $lnames['ward']		=	$ward->name;
                            $ward_profile       =   "/profile/" . $ward->username;
                            $ward_leader_image	=	$ward->avatar;
                            endif;
                            
                            if($lga == "not defined"):
                            $lnames['lga']		=	"N/A";
                            $lga_profile        =   "javascript:void(0)";
                            $lga_image			=	\Storage::url("public/defaults/avatars/male.jpg");
                            else:
                            $lnames['lga']		=	$lga->name;
                            $lga_profile        =   "/profile/" . $lga->username;
                            $lga_image			=	$lga->avatar;
                            endif;
                            
                            if($federal == "not defined"):
                            $lnames['federal']	=	"N/A";
                            $federal_profile    =   "javascript:void(0)";
                            $federal_rep_image	=	\Storage::url("public/defaults/avatars/male.jpg");
                            else:
                            $lnames['federal']	=	$federal->name;
                            $federal_profile    =   "/profile/" . $federal->username;
                            $federal_rep_image	=	$federal->avatar;
                            endif;
                            
                            if($state == "not defined"):
                            $lnames['state']	=	"N/A";
                            $state_profile      =   "javascript:void(0)";
                            $state_rep_image	=	\Storage::url("public/defaults/avatars/male.jpg");
                            else:
                            $lnames['state']	=	$state->name;
                            $state_profile      =   "/profile/" . $state->username;
                            $state_rep_image	=	$state->avatar;
                            endif;
                        @endphp
						<li>
                            <a href="{{ $president_profile }}">
                                <img src="{{ $president_image }}" alt="{{$lnames['president']}}" class="img-responsive" style="height:81px;">
                            </a>
						</li>
						<li>
                            <a href="{{ $governor_profile }}">
                                <img src="{{ $governor_image }}" alt="{{$lnames['governor']}}" class="img-responsive" style="height:81px;">
                            </a>
						</li>
						<li>
                            <a href="{{ $senator_profile }}">
                                <img src="{{ $senator_image }}" alt="{{$lnames['senator']}}" class="img-responsive" style="height:81px;">
                            </a>
						</li>
						<li>
                            <a href="{{ $ward_profile }}">
                                <img src="{{ $ward_leader_image }}" alt="{{$lnames['ward']}}" class="img-responsive" style="height:81px;">
                            </a>
						</li>
						<li>
                            <a href="{{ $lga_profile }}">
                                <img src="{{ $lga_image }}" alt="{{$lnames['lga']}}" class="img-responsive" style="height:81px;">
                            </a>
						</li>
						<li>
                            <a href="{{ $federal_profile }}">
                                <img src="{{ $federal_rep_image }}" alt="{{$lnames['federal']}}" class="img-responsive" style="height:81px;">
                            </a>
						</li>
						<li>
                            <a href="{{ $state_profile }}">
                                <img src="{{ $state_rep_image }}" alt="{{$lnames['state']}}" class="img-responsive" style="height:81px;">
                            </a>
						</li>
						<li><a href="#" class="group"><i class="fa fa-group"></i></a></li>
					</ul>
				</div>
				<div class="cover-info">
					<div class="avatar">
						<img src="{{ $user->avatar }}" alt="people" class="show-in-modal">
					</div>
					<div class="name">
						@if($user['id'] == Auth::user()->id)
							<a href="{{ url('profile') }}/edit/{{ $user->username}}">{{ Auth::user()->name }}</a>
						@else
							<a href="javascript::void(0)">{{ $user['name'] }}</a>
						@endif
					</div>
					<ul class="cover-nav">
						<li><a href="{{ url('profile', ['profile' => $user->username]) }}"><i class="fa fa-fw fa-bars"></i> Timeline</a></li>
						<li><a href="{{ url('profile/about', ['profile' => $user->username]) }}"><i class="fa fa-fw fa-user"></i> About</a></li>
						<li><a href="{{ url('clouts/list', ['profile' => $user->username]) }}"><i class="fa fa-fw fa-users"></i> Clouts</a></li>
						<li class="active"><a href="{{ url('photos', ['profile' => $user->username]) }}"><i class="fa fa-fw fa-image"></i> Photos</a></li>
						<li>
							@if($user->id == Auth::user()->id)
							<a href="{{ url('profile/edit/profile') }}">
								<i class="fa fa-fw fa-edit"></i> Edit Profile
							</a>
							@endif
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
        <div class="col-md-12">
            <photos :id="{{$user->id}}"
                    :username="'{{$user->username}}'">
            </photos>
        </div>
    </div>
    <div style="height:5em;"></div>

    <!-- Modal -->
    <div class="modal fade" id="modalShow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">View Photo</h4>
                </div>
                <div class="modal-body text-centers">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection