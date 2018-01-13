<div class="basic-info" style="margin-top:-20px;">
	<form class="form-horizontal" role="form">
		<fieldset>
			<h3><i class="fa fa-square"></i> Contact Information</h3>
			<div id="integration-list" style="margin-top:-25px;">
				<ul>
					<li>
						<a class="contactexpand expand">
							<div class="right-arrow">+</div>
							<div>
								<h2>Mobile Phone</h2>
								<span>Primary Contact: {{ Auth::user()->profile->phone_number ? Auth::user()->profile->phone_number : 'set up mobile phone' }}
									<p>
										Your information is private and will not be shared with any third party without your consent.
										<p>
											This is only required as back up security to reactivate or unlock your account.
										</p>
									</p>
								</span>
							</div>
						</a>

						<div class="detail" id="contactacc">
							<div id="left" style="width:15%;float:left;height:100%;">
								<div id="sup">
									<!-- <img src="http://www.ciagent.com/ciagent/cialogo4.png" width="100%" /> -->
									<i class="fa fa-4x fa-phone"></i>
								</div>
							</div>
							<div id="right" style="width:85%;float:right;height:100%;padding-left:20px;">
								<div id="sup">
									<div>
										<span>
											<div class="form-group">
												<label for="phone" class="col-sm-3 control-label">Phone</label>
												<div class="col-sm-9">
													<input type="text" id="phone" name="phone" class="form-control" 
													value="{{ Auth::user()->profile->phone_number ? Auth::user()->profile->phone_number : '' }}">
												</div>
											</div>
											<div class="form-group">
												<label for="vphone" class="col-sm-3 control-label">Confirm Mobile Number</label>
												<div class="col-sm-9">
													<input type="text" id="vphone" name="vphone" class="form-control" 
													value="{{ Auth::user()->profile->phone_number ? Auth::user()->profile->phone_number : '' }}">
												</div>
											</div>
											<div>
												<div class="form-group">
													<div class="col-sm-3">

													</div>
													<div class="col-md-9">
														<a class="save" id="savecontact" href="#"><i class="fa fa-check"></i> Save Changes</a>
														<a id="contactclose" href="#"><i class="fa fa-close"></i> Cancel</a>
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