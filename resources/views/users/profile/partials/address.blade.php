<div class="basic-info" style="margin-top:-20px;">
	<form class="form-horizontal" role="form">
		<input type="hidden" id="uga" name="uga" value="{{ Auth::user()->profile->lga_id ? Auth::user()->profile->lga_id : 0}}">
		<input type="hidden" id="ust" name="ust" value="{{ Auth::user()->profile->state_id ? Auth::user()->profile->state_id : 0}}">
		<fieldset>
			<h3><i class="fa fa-square"></i> Location</h3>
			<div id="integration-list" style="margin-top:-25px;">
				<ul>
					<li>
						<a class="addressexpand expand">
							<div class="right-arrow">+</div>
							<div>
								<h2>Address</h2>
								<span>
									@if ( \Auth::user()->profile->state_id )
										Current Location: {{ \Auth::user()->profile->state->state . ', ' . \Auth::user()->profile->country->country }}
									@else
									Current Location: {{ \Auth::user()->profile->country->country }}
									@endif
									<p>
										Find friends and other people nearby by adding sharing your contact location and let others know you're here.
									</p>
								</span>
							</div>
						</a>

						<div class="detail" id="addressacc">
							<div id="left" style="width:15%;float:left;height:100%;">
								<div id="sup">
									<!-- <img src="http://www.ciagent.com/ciagent/cialogo4.png" width="100%" /> -->
									<i class="fa fa-4x fa-globe"></i>
								</div>
							</div>
							<div id="right" style="width:85%;float:right;height:100%;padding-left:20px;">
								<div id="sup">
									<div>
										<span>
											<div class="form-group">
												<label for="street" class="col-sm-3 control-label">Address</label>
												<div class="col-sm-9">
													<input type="text" id="street" name="street" class="form-control"  value="{{ Auth::user()->profile->address }}">
												</div>
											</div>
											<div class="form-group">
												<label for="ward" class="col-sm-3 control-label">Ward</label>
												<div class="col-sm-9">
													<input type="text" id="ward" name="ward" class="form-control" value="{{ Auth::user()->profile->ward }}">
												</div>
											</div>
											<div class="form-group">
												<label for="statesContainer" class="col-sm-3 control-label">State</label>
												<div class="col-sm-9">
													<select class="form-control" id="statesContainer">
														<option value="0">-Select State-</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label for="lgaContainer" class="col-sm-3 control-label">Local Government Area</label>
												<div class="col-sm-9">
													<select class="form-control" id="lgaContainer">
														<option value="0">-Select LGA-</option>
													</select>
												</div>
											</div>
											<div>
												<div class="form-group">
													<div class="col-sm-3">

													</div>
													<div class="col-md-9">
														<a class="save" id="saveAddress" href="#"><i class="fa fa-check"></i> Save Changes</a>
														<a id="addressclose" href="#"><i class="fa fa-close"></i> Cancel</a>
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