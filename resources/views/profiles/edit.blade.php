@extends('layouts.app')

@section('content')
<?php 
    $uname = \Auth::user()->username;
?>
<div class="col-md-10 col-md-offset-1">
	<!-- NAV TABS -->
	<ul class="nav nav-tabs nav-tabs-custom-colored tabs-iconized">
		<li class="active"><a href="#profile-tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-user"></i> Profile</a></li>
		<li class=""><a href="#settings-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> Settings</a></li>
	</ul>
	<!-- END NAV TABS -->
	<div class="tab-content profile-page" style="background: white">
		<!-- PROFILE TAB CONTENT -->
		<div class="tab-pane profile active" id="profile-tab">
			<div class="row">
				<div class="col-md-3">
					<div class="user-info-left">
						<img src="{{ Auth::user()->avatar }}" alt="Profile Picture" style="width: 110px;height: 110px;">
						<h2>{{ Auth::user()->name }}</h2>
						<div class="contact">
							<p>
								<span class="file-input btn btn-azure btn-file">
									<a data-toggle="modal" data-target="#uploadAvatarBox" style="color:white">Update Picture</a>
								</span>
							</p>
							<p>
								<span class="file-input btn btn-azure btn-file">
									<a data-toggle="modal" data-target="#uploadCoverBox" style="color:white">Update Cover Photo</a>
								</span>
							</p>
							<ul class="list-inline social">
								<li><a href="#" title="Facebook"><i class="fa fa-facebook-square"></i></a></li>
								<li><a href="#" title="Twitter"><i class="fa fa-twitter-square"></i></a></li>
								<li><a href="#" title="Google Plus"><i class="fa fa-google-plus-square"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="user-info-right">
						<input type="hidden" name="_parser" id="_parser" value="{{ csrf_token() }}">
						@include('users.profile.partials.basic')
						@include('users.profile.partials.contact')
						@include('users.profile.partials.address')
						@include('users.profile.partials.others')
						@include('users.profile.partials.about')
						@include('users.profile.partials.change-avatar')
						@include('users.profile.partials.change-cover')
					</div>
				</div>
			</div>
		</div>
		<!-- END PROFILE TAB CONTENT -->

		<!-- ACTIVITY TAB CONTENT -->
		@include('users.profile.partials.activity-notification-tab')
		<!-- END ACTIVITY TAB CONTENT -->

		<!-- SETTINGS TAB CONTENT -->
		@include('users.profile.partials.settings-tab')
        <!-- END SETTINGS TAB CONTENT -->
        <profile-edit></profile-edit>
	</div>
</div>   
@endsection