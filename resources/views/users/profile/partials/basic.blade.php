<div class="basic-info">
	<form class="form-horizontal" role="form">
		<fieldset>
			<h3><i class="fa fa-square"></i> Basic Information</h3>
			<div id="integration-list" style="margin-top:-25px;">
				<ul>
					<li>
						<a class="bioexpand expand">
							<div class="right-arrow">+</div>
							<div>
								<span>{{ Auth::user()->name }}
									<p>
										Username: {{ \Auth::user()->username }}
									</p>
								</span>
							</div>
						</a>

						<div class="detail" id="bioacc">
							<div id="left" style="width:15%;float:left;height:100%;">
								<div id="sup">
									<i class="fa fa-4x fa-user"></i>
								</div>
							</div>
							<div id="right" style="width:85%;float:right;height:100%;padding-left:20px;">
								<div id="sup">
									<div>
										<span>
											<div class="form-group">
												<label for="name" class="col-sm-3 control-label">Name</label>
												<div class="col-sm-9">
													<input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}">
												</div>
											</div>
											<div class="form-group">
												<label for="username" class="col-sm-3 control-label">Username</label>
												<div class="col-sm-9">
													<input type="text" id="username" name="username" class="form-control" value="{{ Auth::user()->username }}">
												</div>
											</div>
											<div>
												<div class="form-group">
													<div class="col-sm-3">

													</div>
													<div class="col-md-9">
														<a class="save" href="#" id="biosave"><i class="fa fa-check"></i> Save Changes</a>
														<a id="bioclose" href="#"><i class="fa fa-close"></i> Cancel</a>
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