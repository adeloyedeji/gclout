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
						Welcome {{ Auth::user()->name}}, here are your leaders.
					</header>
				</div>
			</div>
		</div>
		<?php
			$president		=	Helper::getPresident();
			$governor		=	Helper::getLeadersPhoto(\Auth::user()->state, 3);
			$senator		= 	Helper::getLeadersPhoto(\Auth::user()->state, 4);
			$ward_leader	=	Helper::getLeadersPhoto(\Auth::user()->state, 5);
			$lga			=	Helper::getLeadersPhoto(\Auth::user()->state, 6);
			$federal_rep	=	Helper::getLeadersPhoto(\Auth::user()->state, 7);
			$state_rep		=	Helper::getLeadersPhoto(\Auth::user()->state, 8);

			$president_name		=	$president['name'] ? $president['name'] : "President";
			$president_image	=	$president['image'] ? $president['image'] : "img/Profile/default.png";

			$governor_name		=	$governor['name'] ? $governor['name'] : "Governor";
			$governor_image		=	$governor['image'] ? $governor['image'] : "img/Profile/default.png";

			$senator_name		=	$senator['name'] ? $senator['name'] : "Senator";
			$senator_image		=	$senator['image'] ? $senator['image'] : "img/Profile/default.png";

			$ward_leader_name	=	$ward_leader['name'] ? $ward_leader['name'] : "Councillor";
			$ward_leader_image	=	$ward_leader['image'] ? $ward_leader['image'] : "img/Profile/default.png";

			$lga_name			=	$lga['name'] ? $lga['name'] : "Local Govt. Chairman";
			$lga_image			=	$lga['image'] ? $lga['image'] : "img/Profile/default.png";

			$federal_rep_name	=	$federal_rep['name'] ? $federal_rep['name'] : "Federal Representative";
			$federal_rep_image	=	$federal_rep['image'] ? $federal_rep['image'] : "img/Profile/default.png";

			$state_rep_name		=	$state_rep['name'] ? $state_rep['name'] : "State Representative";
			$state_rep_image	=	$state_rep['image'] ? $state_rep['image'] : "img/Profile/default.png";
		?>
		<div class="col-md-12">
			<div class="row" id="user-profile">
				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$president_name}}.</h2>
							@if($president)
								@if($president['online_status'] == 1)
									<div class="profile-status">
										<i class="fa fa-check-circle"></i> Online
									</div>
								@else
									<div class="profile-status-offline">
										<i class="fa fa-check-circle"></i> Offline
									</div>
								@endif
							@else
							<div class="profile-status-offline">
								<i class="fa fa-check-circle"></i> Offline
							</div>
							@endif
							<img src="{{ asset('storage/'.$president_image) }}" title="{{$president_name}}" alt="" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>
				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$governor_name}}.</h2>
							@if($governor)
								@if($governor['online_status'] == 1)
									<div class="profile-status">
										<i class="fa fa-check-circle"></i> Online
									</div>
								@else
									<div class="profile-status-offline">
										<i class="fa fa-check-circle"></i> Offline
									</div>
								@endif
							@else
							<div class="profile-status-offline">
								<i class="fa fa-check-circle"></i> Offline
							</div>
							@endif
							<img src="{{ asset('storage/'.$governor_image) }}" alt="" title="{{$governor_name}}" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>
				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$senator_name}}.</h2>
							@if($senator)
								@if($senator['online_status'] == 1)
									<div class="profile-status">
										<i class="fa fa-check-circle"></i> Online
									</div>
								@else
									<div class="profile-status-offline">
										<i class="fa fa-check-circle"></i> Offline
									</div>
								@endif
							@else
							<div class="profile-status-offline">
								<i class="fa fa-check-circle"></i> Offline
							</div>
							@endif
							<img src="{{ asset('storage/'.$senator_image) }}" alt="" title="{{$senator_name}}" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>
				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$ward_leader_name}}.</h2>
							@if($ward_leader)
								@if($ward_leader['online_status'] == 1)
									<div class="profile-status">
										<i class="fa fa-check-circle"></i> Online
									</div>
								@else
									<div class="profile-status-offline">
										<i class="fa fa-check-circle"></i> Offline
									</div>
								@endif
							@else
							<div class="profile-status-offline">
								<i class="fa fa-check-circle"></i> Offline
							</div>
							@endif
							<img src="{{ asset('storage/'.$ward_leader_image) }}" alt="" title="{{$ward_leader_name}}" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>
				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$lga_name}}.</h2>
							@if($lga)
								@if($lga['online_status'] == 1)
									<div class="profile-status">
										<i class="fa fa-check-circle"></i> Online
									</div>
								@else
									<div class="profile-status-offline">
										<i class="fa fa-check-circle"></i> Offline
									</div>
								@endif
							@else
							<div class="profile-status-offline">
								<i class="fa fa-check-circle"></i> Offline
							</div>
							@endif
							<img src="{{ asset('storage/'.$lga_image) }}" alt="" title="{{$lga_name}}" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>
				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$federal_rep_name}}.</h2>
							@if($federal_rep)
								@if($federal_rep['online_status'] == 1)
									<div class="profile-status">
										<i class="fa fa-check-circle"></i> Online
									</div>
								@else
									<div class="profile-status-offline">
										<i class="fa fa-check-circle"></i> Offline
									</div>
								@endif
							@else
							<div class="profile-status-offline">
								<i class="fa fa-check-circle"></i> Offline
							</div>
							@endif
							<img src="{{ asset('storage/'.$federal_rep_image) }}" alt="" title="{{$federal_rep_name}}" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>
				<div class="col-md-4 col-xs-12" style="height:300px;">
					<div class="row-xs">
						<div class="main-box clearfix">
							<h2>{{$state_rep_name}}.</h2>
							@if($state_rep)
								@if($state_rep['online_status'] == 1)
									<div class="profile-status">
										<i class="fa fa-check-circle"></i> Online
									</div>
								@else
									<div class="profile-status-offline">
										<i class="fa fa-check-circle"></i> Offline
									</div>
								@endif
							@else
							<div class="profile-status-offline">
								<i class="fa fa-check-circle"></i> Offline
							</div>
							@endif
							<img src="{{ asset('storage/'.$state_rep_image) }}" alt="" title="{{$state_rep_name}}" class="profile-img img-responsive img-circle center-block show-in-modal" style="width:150px;height:150px;">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-5 col-md-offset-4">
				<br>
				<button class="btn btn-block ink-reaction btn-primary" id="submit-profile">Continue</button>
				<br>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('js/jquery.1.11.1.min.js') }}"></script>
<script type="text/javascript">
	function followState(id, name)
	{
		$.get("{{url('intro')}}/follow?id="+id+"&fcode=1", function(data, xhr, status) {
			if(data == 1)
			{
				$("#stateNews"+ id).fadeIn("slow").remove();
				toastr.options = {
					"closeButton": true,
					"progressBar": false,
					"debug": false,
					"positionClass": "toast-top-right",
					"showDuration": "330",
					"hideDuration": "330",
					"timeOut":  "5000",
					"extendedTimeOut": "1000",
					"showEasing": "swing",
					"hideEasing": "swing",
					"showMethod": "slideDown",
					"hideMethod": "slideUp",
					"preventDuplicates": true,
					"onclick": null
				}
				toastr["success"](name + " state.", "Now Following.")
				return true;
			}
			else
			{
				toastr.options = {
					"closeButton": true,
					"progressBar": false,
					"debug": false,
					"positionClass": "toast-top-right",
					"showDuration": "330",
					"hideDuration": "330",
					"timeOut":  "5000",
					"extendedTimeOut": "1000",
					"showEasing": "swing",
					"hideEasing": "swing",
					"showMethod": "slideDown",
					"hideMethod": "slideUp",
					"preventDuplicates": true,
					"onclick": null
				}
				toastr["info"]("Please try again ", "Unable to follow.")
				return true;
			}
		});
	}
	$(function() {
		$("#submit-profile").click(function() {
			$.get("{{ url('intro') }}/finish", function(data, xhr, status) {
				if(data == 1)
				{
					toastr.options = {
						"closeButton": true,
						"progressBar": false,
						"debug": false,
						"positionClass": "toast-top-right",
						"showDuration": "330",
						"hideDuration": "330",
						"timeOut":  "5000",
						"extendedTimeOut": "1000",
						"showEasing": "swing",
						"hideEasing": "swing",
						"showMethod": "slideDown",
						"hideMethod": "slideUp",
						"preventDuplicates": true,
						"onclick": null
					}
					toastr["info"]("Welcome to Governance Clout.", "Welcome.")
					window.location.href="{{url('home')}}";
				}
				else
				{
					toastr.options = {
						"closeButton": true,
						"progressBar": false,
						"debug": false,
						"positionClass": "toast-top-right",
						"showDuration": "330",
						"hideDuration": "330",
						"timeOut":  "5000",
						"extendedTimeOut": "1000",
						"showEasing": "swing",
						"hideEasing": "swing",
						"showMethod": "slideDown",
						"hideMethod": "slideUp",
						"preventDuplicates": true,
						"onclick": null
					}
					toastr["info"]("Please try again ", "Unable to complete.")
					return true;
				}
			});
		});
	});
</script>
@endsection