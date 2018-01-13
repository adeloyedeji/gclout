<div class="basic-info" style="margin-top:-20px;">
	<form class="form-horizontal" role="form">
		<fieldset>
			<h3><i class="fa fa-square"></i> Others</h3>
			<div id="integration-list" style="margin-top:-25px;">
				<ul>
					<li>
						<a class="othersexpand expand">
							<div class="right-arrow">+</div>
							<div>
								<h2>Other Information</h2>
								<div></div>
								<span>
									<br>
									<p>
										Gender:
										@if(Auth::user()->gender)
										Male
										@else
										Female
										@endif
									</p>
									<p>
										Date of Birth: 
										{{ Auth::user()->profile->date_of_birth ? Auth::user()->profile->date_of_birth : 'no data found' }}
									</p>
									<p>
										Occupation: 
										{{ Auth::user()->profile->job ? Auth::user()->profile->job : 'no data found' }}
									</p>
								</span>
							</div>
						</a>

						<div class="detail" id="othersacc">
							<div id="left" style="width:15%;float:left;height:100%;">
								<div id="sup">
									<!-- <img src="http://www.ciagent.com/ciagent/cialogo4.png" width="100%" /> -->
									<i class="fa fa-4x fa-street-view"></i>
								</div>
							</div>
							<div id="right" style="width:85%;float:right;height:100%;padding-left:20px;">
								<div id="sup">
									<div>
										<span>
											<div class="form-group">
												<label for="phone" class="col-sm-3 control-label">Gender</label>
												<div class="col-sm-9">
													<select class="form-control" id="genderSelect" name="genderSelect">
														<option value="">-Select Gender-</option>
														<option @if(Auth::user()->gender) selected="selected" @endif value="1">Male</option>
														<option @if(!Auth::user()->gender) selected="selected" @endif value="0">Female</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label for="vphone" class="col-sm-3 control-label">Date of Birth</label>
												<div class="col-sm-9">
													<input type="date" id="dob" name="dob" value="{{Auth::user()->profile->date_of_birth}}" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label for="vphone" class="col-sm-3 control-label">Occupation</label>
												<div class="col-sm-9">
													<input type="text" id="job" name="job" value="{{Auth::user()->profile->job}}" class="form-control">
												</div>
											</div>
											<div>
												<div class="form-group">
													<div class="col-sm-3">

													</div>
													<div class="col-md-9">
														<a class="save" id="saveothersBtn" href="javascript:void(0)"><i class="fa fa-check"></i> Save Changes</a>
														<a id="othersclose" href="#"><i class="fa fa-close"></i> Cancel</a>
													</div>
												</div>
											</div>
										</span>
										<br />
										<br />
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</fieldset>
	</form>
</div>