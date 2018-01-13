@extends('layouts.app')

@section('page-title')
- Know your leaders
@endsection

@section('content')
<style>
	.profile-status-offline {
		font-size: 0.75em;
		padding-left: 12px;
		margin-top: -10px;
		padding-bottom: 10px;
		color: #c7571d;
	}
</style>
<div class="container">
	<div style="margin-top: 20px;">
		<input type="hidden" name="parser" id="parser" value="{{ csrf_token() }}">
	</div>
	<div class="col-md-10 col-md-offset-1">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<header class="text-center">
						<?php $names = explode(' ', \Auth::user()->name); ?>
						Welcome {{ $names[0] }}, here are your leaders.
					</header>
				</div>
			</div>
		</div>
		<?php

			$president_name		=	"President";
			$governor_name		=	"Governor";
			$senator_name		=	"Senator";
			$ward_leader_name	=	"Councillor";
			$lga_name			=	"Local Govt. Chairman";
			$federal_rep_name	=	"Federal Representative";
			$state_rep_name		=	"State Representative";

			if($president == "not defined"):
			$lnames['president']=	"N/A";
			$president_image	=	"public/defaults/avatars/male.jpg";
			else:
			$lnames['president']=	$president->name;
			$president_image	=	$president->avatar;
			endif;

			if($governor == "not defined"):
			$lnames['governor']	=	"N/A";
			$governor_image		=	"public/defaults/avatars/male.jpg";
			else:
			$lnames['governor']	=	$governor->name;
			$governor_image		=	$governor->avatar;
			endif;

			if($senator == "not defined"):
			$lnames['senator']	=	"N/A";
			$senator_image		=	"public/defaults/avatars/male.jpg";
			else:
			$lnames['senator']	=	$senator->name;
			$senator_image		=	$senator->avatar;
			endif;
			
			if($ward == "not defined"):
			$lnames['ward']		=	"N/A";
			$ward_leader_image	=	"public/defaults/avatars/male.jpg";
			else:
			$lnames['ward']		=	$ward->name;
			$ward_leader_image	=	$ward->avatar;
			endif;
			
			if($lga == "not defined"):
			$lnames['lga']		=	"N/A";
			$lga_image			=	"public/defaults/avatars/male.jpg";
			else:
			$lnames['lga']		=	$lga->name;
			$lga_image			=	$lga->avatar;
			endif;
			
			if($federal == "not defined"):
			$lnames['federal']	=	"N/A";
			$federal_rep_image	=	"public/defaults/avatars/male.jpg";
			else:
			$lnames['federal']	=	$federal->name;
			$federal_rep_image	=	$federal->avatar;
			endif;
			
			if($state == "not defined"):
			$lnames['state']	=	"N/A";
			$state_rep_image	=	"public/defaults/avatars/male.jpg";
			else:
			$lnames['state']	=	$state->name;
			$state_rep_image	=	$state->avatar;
			endif;
		?>
		<div class="col-md-12">
			<div class="row" id="user-profile">
				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$president_name}}.</h2>
							<h5>{{ $lnames['president'] }}</h5>
							<small>Nigerian President</small>
							<img src="{{ Storage::url($president_image) }}" title="{{$president_name}}" alt="" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>

				@if (\Auth::user()->profile->state_id)
				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$governor_name}}.</h2>
							<h5>{{ $lnames['governor'] }}</h5>
							<small>
								{{ $user_state }} State
							</small>
							<img src="{{ Storage::url($governor_image) }}" alt="" title="{{$governor_name}}" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>
				
				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$lga_name}}.</h2>
							<h5>{{ $lnames['lga'] }}</h5>
							<small>
								{{ $area }} Local Govt. Area
							</small>
							<img src="{{ Storage::url($lga_image) }}" alt="" title="{{$lga_name}}" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>
				
				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$senator_name}}.</h2>
							<h5>{{ $lnames['senator'] }}</h5>
							<small>
								Senator, {{ $user_state }}
							</small>
							<img src="{{ Storage::url($senator_image) }}" alt="" title="{{$senator_name}}" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>
				@endif

				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$federal_rep_name}}.</h2>
							<h5>{{ $lnames['federal'] }}</h5>
							<small>Nigerian Federal Representative</small>
							<img src="{{ Storage::url($federal_rep_image) }}" alt="" title="{{$federal_rep_name}}" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>

				@if (\Auth::user()->profile->state_id)
					
				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$state_rep_name}}.</h2>
							<h5>{{ $lnames['state'] }}</h5>
							<small>
								{{ $user_state }} State Representative
							</small>
							<img src="{{ Storage::url($state_rep_image) }}" alt="" title="{{$state_rep_name}}" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>
				
				<div class="col-md-4 col-md-offset-4" style="height:300px;">
					<br>
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$ward_leader_name}}.</h2>
							<h5>{{ $lnames['ward'] }}</h5>
							<small>Ward Councillor</small>
							<img src="{{ Storage::url($ward_leader_image) }}" alt="" title="{{$ward_leader_name}}" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<br>
				<center>
					<button class="btn ink-reaction btn-primary" id="submit-profile">Continue</button>
				</center>
				<br>
			</div>
		</div>
		<div style="height: 70px;">

		</div>
	</div>
</div>
<script src="{{ asset('js/jquery.1.11.1.min.js') }}"></script>
<script type="text/javascript">
	
	$(function() {
		$("#submit-profile").click( function() {
			new Noty({
                type: "success",
                layout: 'topRight',
                text: "Welcome to Governance clout."
			}).show();
			window.location="/home"
		});
	});
</script>
@endsection