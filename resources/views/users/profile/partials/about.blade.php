<div class="about" id="aboutClout" style="margin-top:-20px;">
	<h3><i class="fa fa-square"></i> Bio</h3>
	<p>
	Your Profile
	</p>
	<form>
		<textarea class="form-control" id="aboutbox" name="aboutbox" style="resize:none;height:200px;">{{ Auth::user()->profile->about }}</textarea>
		<div>
			<br>
			<p><a class="save" id="saveAbout" href="#"><i class="fa fa-check"></i> Save Changes</a></p>
		</div>
	</form>
</div>