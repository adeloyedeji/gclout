@extends('layouts.app')

@section('page-title')
- Profile Setup
@endsection

@section('content')
<div class="container" style="margin-top: 5em;">
	<div>
		<input type="hidden" name="parser" id="parser" value="{{ csrf_token() }}">
	</div>
	<profile-setup></profile-setup>
</div>
</div>
<script src="{{ asset('js/jquery.1.11.1.min.js') }}"></script>
<script type="text/javascript">
	$(function() {
		$("#residence").change(function() {
			if($(this).val() == 149) {
				$("#tiwatiwa").slideDown(200);
			} else {
				$("#tiwatiwa").slideUp(200);
			}
		});
		$("#nationality").change(function() {
			if($(this).val() == 149) {
				$("#tiwatiwa").slideDown(200);
			} else {
				$("#tiwatiwa").slideUp(200);
			}
		});
		$("#state").change(function() {
			var state = $(this).val();
			$.get("/get_lgas/bystate/" + state, function(data, status, xhr) {
				var option = '';
				var state;
				$.each(data, function(index, item) {
					state = item.state.state
					option += "<option value='"+item.id+"'>"+item.lga+"</option>";
				});
				console.log(option)
				$("#lga").html("").append(option);
				new Noty({
                    type: 'success',
                    layout: 'bottomLeft',
                    text: 'We found ' + data.length + " local government areas within " + state + " state!"
                }).show();
			});
		});
	});
</script>
@endsection