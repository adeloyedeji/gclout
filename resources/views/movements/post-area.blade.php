<link rel="stylesheet" type="text/css" href="{{ asset('css/dropzone.css') }}">
<script src="{{ asset('js/jquery.1.11.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>
<div class="box profile-info n-border-top">
	<form id="postForm">
		<textarea class="form-control input-lg p-text-area" id="postarea" rows="2" placeholder="Whats in your mind today?" style="resize: none;padding:25px;"></textarea>
		<div class="dropzone" id="postImgBlock" style="border: 0px;display:none;"></div>
       </form>
       <div class="box-footer box-form">
		<button type="button" class="btn btn-azure pull-right" id="postBtn">Post</button>
              	<ul class="nav nav-pills">
                		<li class="dropdown">
                  			<a href="#" id="location" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    				<i class="fa fa-map-marker"></i>
                  			</a>
                  			<ul class="dropdown-menu" style="padding: 20px;width:300px;">
                    				<li>Add Location</li>
                    				<li>
                      				<input type="text" class="form-control" id="locationBox" name="locationBox">
                    				</li>
                  			</ul>
                		</li>
                		<li class="dropdown">
                  			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    				Audience <span class="caret"></span>
                  			</a>
                  			<ul class="dropdown-menu" style="padding: 20px;width:200px;">
                    				<li>
                      				<div class="radio">
                        					<label>
                          						<input name="form-field-radio" type="radio" class="colored-blue" checked="checked" value="1">
                          						<span class="text"> Public</span>
                        					</label>
                      				</div>
                    				</li>
                    			<li>
                      			<div class="radio">
                        				<label>
                          					<input name="form-field-radio" type="radio" class="colored-blue" value="2">
                          					<span class="text"> My Clouts</span>
                        				</label>
                      			</div>
                    			</li>
                  		</ul>
                	</li>
                	<li><a href="#" id="camera"><i class="fa fa-camera"></i></a></li>
              </ul>
       </div>
</div>

<script>
    $(function() {
	 $("#camera").click(function() {
		 $("#postImgBlock").slideToggle(200);
	 });
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#postImgBlock", {
                url:'{{ url('posts') }}',
                autoProcessQueue:false,
                acceptedFiles:'image/png,image/jpeg,image/jpg',
                uploadMultiple:false,
                maxFiles:1,
                dictDefaultMessage:"Click or drag a picture here.",
                addRemoveLinks:'dictCancelUpload',
                parallelUploads:1,
                dictInvalidFileType:"Profile Picture Must Be An Image",
                maxFilesize:5,
                dictFileTooBig: 'Warning: Image is Larger than 62kb'
        });

        myDropzone.on("sending", function(file,xhr,formData) {
            formData.append("status", $("#postarea").val() ? $("#postarea").val() : '');
	     	formData.append("location", $("#locationBox").val() ? $("#locationBox").val() : '')
	     	formData.append("audience", $("input[name=form-field-radio]:checked").val())
	     	formData.append("opcode", 1)
            formData.append("_token", $("#parser").val());
        });

	myDropzone.on("success", function(file,response) {
	    console.log(response);
           if(response == 1)
           {
	        toastr.options = {
		     "closeButton": true,
		     "progressBar": false,
		     "debug": false,
		     "positionClass": "toast-bottom-right",
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
		 toastr["success"]("Update successful.", "Success.")
		 var postBlock = '<div class="box box-widget">'+
            '<div class="box-header with-border">'+
            '<div class="user-block">'+
            '<img class="img-circle" src="{{ asset('storage/'.Auth::user()->image) }}" alt="User image">'+
            '<span class="username"><a href="#">{{ Auth::user()->name }}</a></span>'+
            '<span class="description">Shared publicly - 7:30 PM {{ Auth::user()->created_at->diffForHumans() }}</span>'+
            '</div>'+
            '</div>'+
            '<div class="box-body" style="display:block;">'+
            '<img class="img-responsiv show-in-modal" src="" alt="Photo">'+
            '<p></p>'+
            '<button type="button" class="btn btn-default btn-xs">'+
            '<i class="fa fa-share"></i> Share'+
            '</button>'+
            '<button type="button" class="btn btn-default btn-xs">'+
            '<i class="fa fa-thumbs-o-up"></i> Like'+
            '</button>'+
            '</div>'+
            '<div class="box-footer" style="display: block;">'+
            '<form action="#" method="post">'+
            '<img class="img-responsive img-circle img-sm" src="{{ asset('storage/'.Auth::user()->image) }}" alt="Alt Text">'+
            '<div class="img-push">'+
            '<input type="text" class="form-control input-sm" placeholder="Press enter to post comment">'+
            '</div>'+
            '</form>'+
            '</div>'+
            '</div>';
			$("#postForm").insertAfter($postBlock);
	     }
            else
            {
				if(data.post)
				{
					toastr.options = {
						"closeButton": true,
						"progressBar": false,
						"debug": false,
						"positionClass": "toast-bottom-right",
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
					toastr["warning"]("Post not valid.", "Warning.")
					return false;
				}
				if(data.location)
				{
					toastr.options = {
						"closeButton": true,
						"progressBar": false,
						"debug": false,
						"positionClass": "toast-bottom-right",
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
					toastr["warning"]("Unknown location.", "Warning.")
					return false;
				}
				if(data.photo)
				{
					toastr.options = {
						"closeButton": true,
						"progressBar": false,
						"debug": false,
						"positionClass": "toast-bottom-right",
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
					toastr["warning"]("Invalid photo path.", "Warning.")
					return false;
				}
				if(data.audience)
				{
					toastr.options = {
						"closeButton": true,
						"progressBar": false,
						"debug": false,
						"positionClass": "toast-bottom-right",
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
					toastr["warning"]("Unknown audience.", "Warning.")
					return false;
				}
            }
        });

	    myDropzone.on("error", function(file, response) {
               console.log(response);
               toastr.options = {
		    		"closeButton": true,
		    		"progressBar": false,
		    		"debug": false,
		    		"positionClass": "toast-bottom-right",
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
		 		toastr["warning"]("Please reload page and try again.", "Updated not complete.")
            	myDropzone.removeFile(file);
        });

        myDropzone.on("complete", function(file) {
            myDropzone.removeFile(file);
        });

        $("#postBtn").click(function(){
	     if(myDropzone.files.length)
	     {
		     myDropzone.processQueue();
	     }
	     else
	     {
		     alert("Post does not contain image");
		     var status 	= 	$("#postarea").val() ? $("#postarea").val() : '';
		     var location	=	$("#locationBox").val() ? $("#locationBox").val() : '';
		     var audience	=	$("input[name=form-field-radio]:checked").val();
		     
		     var formData = {
			     'status':status, 
			     'location':location, 
			     'audience':audience, 
			     'opcode':1, 
			     "_token":$("#parser").val()
		     };
		     console.log(formData);
		     $.ajax({
			     url: "{{ url('posts') }}",
			     type: "POST",
			     dataType: "JSON",
			     data:formData,
			     success: function(data) {
				     console.log(data);
			     }, 
			     fail: function(data) {
				     console.log(data);
				     toastr.options = {
					"closeButton": true,
					"progressBar": false,
					"debug": false,
					"positionClass": "toast-bottom-right",
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
				    toastr["warning"]("Please reload page and try again.", "Updated not complete.")
				    return false;
			    }
		     });
	     }
        });
});
</script>