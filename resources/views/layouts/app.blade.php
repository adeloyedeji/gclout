<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>{{ config('app.name', 'Laravel') }} @yield('page-title')</title>
    <!-- Bootstrap core CSS -->
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/gif" sizes="16x16">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/timeline.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cover.css') }}" rel="stylesheet">
    <link href="{{ asset('css/forms.css') }}" rel="stylesheet">
    <link href="{{ asset('css/buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/themes/bootstrap.css') }}" rel="stylesheet">
    @if( active('profiles/clout-profile-edit') || active('profile/edit/*') )
    <link href="{{ asset('css/edit_profile.css') }}" rel="stylesheet">
    @elseif( active('friends/*') || active('clouts/*') )
    <link href="{{ asset('css/friends.css') }}" rel="stylesheet">
    @elseif( active('posts/photos') || active('photos/*'))
    <link href="{{ asset('css/photos2.css') }}" rel="stylesheet">
    @elseif( active('notifications/me') || active('notifications/clout-requests') )
    <link href="{{ asset('css/list_posts.css') }}" rel="stylesheet">
    @elseif( active('messages/me')  ||  active('messaging/*') )
    <link href="{{ asset('css/messages1.css') }}" rel="stylesheet">
    <link href="{{ asset('css/timeline.css') }}" rel="stylesheet">
    @elseif( active('intro/know-your-leaders') )
    <link href="{{ asset('css/profile2.css') }}" rel="stylesheet">
    @elseif( active('profile/about/*') )
    <link href="{{ asset('css/user_detail.css') }}" rel="stylesheet">
    @endif
    <link href="{{ asset('css/gclout.css') }}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        window.Laravel = {!! 
            json_encode([
                'csrfToken' => csrf_token(),
                'url'  =>  'gclout'
            ]); 
        !!}
    </script>
    <style>
        .txt-wrap {
            float: right;
            margin: 10px;
        }
        .txt-wrap-left {
            float: left;
            margin: 10px;
        }
    </style>
    <script src="{{ asset('js/autocomplete.min.js') }}"></script>
</head>
<body class="animated fadeIn">
    <div id="app">
        <nav class="navbar navbar-white navbar-fixed-top" style="height:50px;">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img class="img-circle app-logo" src="{{ asset('img/GCCL.png') }}" style="width:40px;height:40px;margin-top:-20px;">
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right" style="margin-top:-10px;">
                        <li>
                            <search></search>
                        </li>
                        @auth
                        <li>
                            <a href="{{ route('home') }}" title="Home">
                                Feeds
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile', ['username' => \Auth::user()->username]) }}" title="Profile">
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Notifications">
                                <i class="fa fa-bell"></i>
                                <span class="label label-info pull-right r-activity">
                                    {{ count(\Auth::user()->unreadNotifications) }}
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Clout Requests" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-plus"></i>
                                <span class="label label-info pull-right r-activity">
                                    @if (count(\Auth::user()->pending_friends_requests()) > 0)
                                        {{ count(\Auth::user()->pending_friends_requests()) }}
                                    @endif
                                </span>
                            </a>
                            <ul class="dropdown-menu" style="width: 320px;background-color:whitesmoke">
                                
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="nav-controller" title="Active Users">
                                <i class="fa fa-users"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" title="Sign out">
                                    <i class="fa fa-sign-out"></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
        @auth
        <init></init>
        <notification :id="{{ Auth::id() }}"></notification>
        <audio id="noty_audio">
            <source src="{{ asset('audio/notify.mp3') }}">
            <source src="{{ asset('audio/notify.ogg') }}">
            <source src="{{ asset('audio/notify.wav') }}">
        </audio>
        @endauth
    </div>

    <footer class="footer">
        <div class="container">
        <p class="text-muted"> Copyright &copy; Sprucecities - All rights reserved </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @auth
    <script type="text/javascript">
        $(function() {
            Noty.overrideDefaults({
                theme: 'bootstrap-v3',
                closeWith: ['click', 'button'],
            });
        });
        @if (Session::has('success'))
            new Noty({
                type: 'success',
                layout: 'bottomLeft',
                text: '{{ Session::get("success") }}'
            }).show();
        @endif
    </script>
    @endauth

    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    @if( active('home') )
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWT3Ts0ojgLU8RXYIlt-ysZF1N28bmjLs&libraries=places&callback=initializeMap" async defer></script>
        <script>
            function initializeMap()
            {
                //console.log("Map initialized.");
                var input = document.getElementById("locationBox");
                var autoComplete = new google.maps.places.Autocomplete(input);
            }
        </script>
    @elseif( active('profile/edit/*') )
    <script src="{{ asset('js/custom.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            getData("getLga", "lgaContainer", $("#uga").val());
		    getData("getStates", "statesContainer", $("#ust").val());
            $(".bioexpand").on( "click", function() {
                $(this).next().slideToggle(200);
                $expand = $(this).find(">:first-child");
    
                if($expand.text() == "+") {
                    $expand.text("-");
                } else {
                    $expand.text("+");
                }
            });
    
            $("#bioclose").click(function() {
                $("#bioacc").slideToggle(200);
            });
    
            $("#biosave").click(function(e) {
                e.preventDefault();
                var name = $("#name").val();
                var uname = $("#username").val();
    
                var formData = {'name':name, 'uname':uname, 'opcode':1, '_token': $("#_parser").val() };
                $.ajax({
                    url: "{{ url('profile/save/bio') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    success: function(data) {
                        if(data.name)
                        {
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: 'Invalid name! Check your input and try again.'
                            }).show();
                            return false;
                        }
                        if(data.username)
                        {
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: 'Invalid username! Maximum alloawable characters = 16.'
                            }).show();
                            return false;
                        }
                        if(data == 1)
                        {
                            new Noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text: 'Update saved successfully!'
                            }).show();
                            window.location.reload();
                        }
                    }, 
                    fail: function(data) {
                        new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'No internet connection!'
                        }).show();
                        return false;
                    }
                });
            });

            $(".contactexpand").on( "click", function() {
                $(this).next().slideToggle(200);
                $expand = $(this).find(">:first-child");
    
                if($expand.text() == "+") {
                    $expand.text("-");
                } else {
                    $expand.text("+");
                }
            });
    
            $("#contactclose").click(function() {
                $("#contactacc").slideToggle(200);
            });
    
            $("#savecontact").click(function(e) {
                e.preventDefault();
                var phone  = $("#phone").val();
                var vphone = $("#vphone").val();
                var formData = {'phone':phone, 'opcode':2, '_token':$("#_parser").val()};
    
                if(phone === vphone)
                {
                    $.ajax({
                        url: "{{ url('profile/save/contact') }}",
                        type: "POST",
                        dataType: "JSON",
                        data: formData,
                        success: function(data) {
                            if(data.phone_number) 
                            {
                                new Noty({
                                    type: 'error',
                                    layout: 'bottomLeft',
                                    text: 'Enter a valid phone number!'
                                }).show();
                                return false;
                            }
                            else if(data === 1)
                            {
                                new Noty({
                                    type: 'success',
                                    layout: 'bottomLeft',
                                    text: 'Update saved successfully!'
                                }).show();
                                window.location.reload();
                            }
                        }, 
                        fail: function(data) {
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: 'Unable to connect!'
                            }).show();
                            return false;
                        }
                    });
                }
                else
                {
                    new Noty({
                        type: 'error',
                        layout: 'bottomLeft',
                        text: 'Phone Numbers do not match!'
                    }).show();
                    return false;
                }
            });

            function getData(type, container, defaultData)
            {
                var url = "/get_states/all";
                if(type == "getLga") {
                    url = "/get_lgas/bystate/800";
                }
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "JSON",
                    async: false,
                    success: function(data) {
                        var option = '';
                        data.forEach( (item) => {
                            if(type === "getLga") {
                                option += "<option value='"+item.id+"'>"+item.lga+"</option>";
                                if(defaultData == item.id) {
                                    option += "<option selected='selected' value='"+item.id+"'>"+item.lga+"</option>";
                                }
                            } else {
                                option += "<option value='"+item.id+"'>"+item.state+"</option>";
                                if(defaultData == item.id) {
                                    option += "<option selected='selected' value='"+item.id+"'>"+item.state+"</option>";
                                }
                            }
                        })
                        $("#" + container).append(option);
                    }, 
                    fail: function(data) {
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: 'Unable to connect. Check your internet connection.'
                        }).show();
                    }
                });
            }
            $(".addressexpand").on( "click", function() {
                $(this).next().slideToggle(200);
                $expand = $(this).find(">:first-child");

                if($expand.text() == "+") {
                    $expand.text("-");
                } else {
                    $expand.text("+");
                }
            });

            $("#addressclose").click(function() {
                $("#addressacc").slideToggle(200);
            });
            
            $("#saveAddress").click(function(e) {
                e.preventDefault();
                var street 		= 	$("#street").val();
                var ward 		=	$("#ward").val();
                var lga 		=	$("#lgaContainer").val();
                var state 		=	$("#statesContainer").val();

                var formData = {
                    'street':street, 
                    'ward':ward, 
                    'lga':lga, 
                    'state':state, 
                    'opcode':3, 
                    '_token':$("#_parser").val()
                };

                $.ajax({
                    url: "{{ url('profile/save/address') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    success: function (data) {
                        if(data === 1)
                        {
                            new Noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text: 'Update saved successfully'
                            }).show();
                            window.location.reload();
                        }
                        else 
                        {
                            if(data.ward) {
                                new Noty({
                                    type: 'error',
                                    layout: 'bottomLeft',
                                    text: 'You need to update your ward.'
                                }).show();
                            }
                            if(data.state_id) {
                                new Noty({
                                    type: 'error',
                                    layout: 'bottomLeft',
                                    text: 'Invalid state.'
                                }).show();
                            }
                            if(dat.lga_id) {
                                new Noty({
                                    type: 'error',
                                    layout: 'bottomLeft',
                                    text: 'Invalid Local Government Area.'
                                }).show();
                            }
                            return false;
                        }
                    },
                    fail: function (data) {
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: 'Unable to connect. Check your internet connection.'
                        }).show();
                        return false;
                    }
                });
            })

            $(".othersexpand").on( "click", function() {
                $(this).next().slideToggle(200);
                $expand = $(this).find(">:first-child");
    
                if($expand.text() == "+") {
                    $expand.text("-");
                } else {
                    $expand.text("+");
                }
            });
    
            $("#othersclose").click(function() {
                $("#othersacc").slideToggle(200);
            });
    
            $('#dob').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
    
            $("#saveothersBtn").click(function() {
                var gender = $("#genderSelect").val();
                var dob    = $("#dob").val();
                var job    = $("#job").val();
    
                var formData = {'gender':gender, 'dob':dob, 'job':job, 'opcode':4, '_token':$("#_parser").val()};
    
                $.ajax({
                    url: "{{ url('profile/save/others') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    success: function(data) {
                        if(data == 1)
                        {
                            new Noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text: 'Update saved successfully!'
                            }).show();
                            window.location.reload();
                        }
                        else if(data.gender)
                        {
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: 'You need to select your gender!'
                            }).show();
                            return false;
                        }
                        else if(data.date_of_birth)
                        {
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: 'Invalid date of birth!'
                            }).show();
                            return false;
                        }
                        else if(data.job)
                        {
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: 'Unknown job title!'
                            }).show();
                            return false;
                        }
                    },
                    fail: function(data) {
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: 'Unable to connect!'
                        }).show();
                        return false;
                    }
                });
            });
            
            $("#saveAbout").click(function(e) {
                e.preventDefault();
    
                var about = $("#aboutbox").val();
                var formData = {'about':about, 'opcode':5, '_token':$("#_parser").val()};
    
                $.ajax({
                    url: "{{ url('profile/save/about') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    success: function(data){
                        if(data == 1)
                        {
                            new Noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text: 'Update saved successfully!'
                            }).show();
                            window.location.reload();
                        }
                        else 
                        {
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: 'Unable to update profile.'
                            }).show();
                            return false;
                        }
                    }, 
                    fail: function(data) {
                        new Noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'Unable to connect!'
                        }).show();
                        return false;
                    }
                });
            });

            $("#saveSettings").click(function(e) {
                e.preventDefault();
                var oldPassword  = $("#old-password").val();
                var newPassword  = $("#password").val();
                var newPassword2 = $("#password2").val();
    
                var formData = {'oldPassword':oldPassword, 'newPassword':newPassword, 'newPassword2':newPassword2, 'opcode':8, '_token':$("#_parser").val()};
    
                $.ajax({
                    url: "{{ url('profiles') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    success: function(data) {
                        console.log(data);
                        if(data == 1)
                        {
                            new Noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text: 'New Password Saved. Change will take effect on next logon!'
                            }).show();
                            window.location.reload();
                        }
                        else if(data == 'incorrect')
                        {
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: 'Incorrect Old Password. Cannot change password!'
                            }).show();
                            return false;
                        }
                        else if(data.password)
                        {
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: 'Passwords do not match!'
                            }).show();
                            return false;
                        }
                        else
                        {
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: 'New password was not saved. Reverting to current password!'
                            }).show();
                            return false;
                        }
                    }, 
                    fail: function(data) {
                        console.log(data);
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: 'Unable to connct!'
                        }).show();
                        return false;
                    }
                });
            });
        });
    </script>
    @elseif( active('movements') ) 
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(function() {
            $("#excelfile").click(function(){
                $("#dropzonediv").slideToggle(200);
            });
            Dropzone.autoDiscover = false;
    
            var myDropzone = new Dropzone("#dropzonediv", {
                url:"{{ url('movements') }}",
                autoProcessQueue:false,
                acceptedFiles:'image/png,image/jpeg,image/jpg',
                uploadMultiple:false,
                maxFiles:1,
                dictDefaultMessage:"Click or drag a picture here.",
                addRemoveLinks:'dictCancelUpload',
                parallelUploads:1,
                dictInvalidFileType:"Picture Must Be An Image",
                maxFilesize:2,
                dictFileTooBig: 'Warning: Image is Larger than 2Mb'
            });
    
            myDropzone.on("sending", function(file,xhr,formData) {
                formData.append("movement_body", $("#movement_body").val() ? $("#movement_body").val() : '');
                formData.append("movement_title",$("#movement_title").val());
                formData.append("category",$("#category_new").val());
                formData.append("timeframe",$("#timeframe").val());
                formData.append("target_arm",$("#target_arm").val());
                formData.append("targetnumber",$("#targetnumber").val());
                formData.append("_token", $("#_token").val());
            });
            myDropzone.on("success", function(file,response) {
                var data = response;
                console.log(data);
                if(response)
                {
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: 'Update successful'
                    }).show();
                    //console.log(postBlock);
                    $("#postvalue").prepend(response);
                    //console.log(response);
                    window.location.reload()
                }
                else
                {
                    if(data.post)
                    {
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: 'Post not valid'
                        }).show();
                        return false;
                    }
                    if(data.photo)
                    {
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: 'Invalid photo path.'
                        }).show();
                        return false;
                    }
                }
            });
    
            myDropzone.on("error", function(file, response) {
                console.log(response);
                new Noty({
                    type: 'error',
                    layout: 'bottomLeft',
                    text: 'Update not complete. Please reload page and try again.'
                }).show();
                console.log(response);
                myDropzone.removeFile(file);
            });
    
            myDropzone.on("complete", function(file) {
                myDropzone.removeFile(file);
            });
    
            $("#postData").click(function(){
                if(myDropzone.files.length)
                {  
                    myDropzone.processQueue();
                }
                else
                {
                    var movement_title = $("#movement_title").val();
                    var movement_body = $("#movement_body").val();
                    var category = $("#category_new").val();
                    var timeframe = $("#timeframe").val();
                    var targetnumber = $("#targetnumber").val();
                    var target_arm = $("#target_arm").val();
                    var hidden = $('#_token').val();
                    
                    var formData = {
                        'movement_title':movement_title,
                        'movement_body':movement_body,
                        'category':category,
                        'timeframe':timeframe,
                        'targetnumber':targetnumber,
                        'target_arm':target_arm,
                        '_token':hidden
                    }
                    console.log(formData);
                    $.ajax({
                        url:"{{url('movements')}}",
                        type:"POST",
                        dataType:"JSON",
                        data:formData,
                        success:function(data){
                            new Noty({
                                type: 'success',
                                layout: 'bottomLeft',
                                text: 'Movement created successfully.'
                            }).show();
                            window.location.reload()
                        },
                        fail:function(data){
                            console.log(data);
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: data
                            }).show();
                        }
                    });
                }
            });
        });
    
        function otherfunc(id,opcode){
            $.get("{{url('movements')}}/id",{id:id,op:opcode},function(data){
                if(data == 1)
                {
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: "You've Liked this Post."
                    }).show();
                    console.log(data);
                }
                else
                {
                    console.log(data);
                    new Noty({
                        type: 'error',
                        layout: 'bottomLeft',
                        text: "You have already like this post."
                    }).show();
                }
            });
        }
    </script>
    
    <script type="text/javascript">
        $(function(){
            $('#target_arm').on('change',function(){
                var val = $(this).val();
                if(val == "President"){
                $("#need_number").text("You need 5000 People to Sign this Petition");
                }
                else if(val == "Governor")$("#need_number").text("You need 3000 People to Sign this Petition");
                else if(val == "House of Reps"){$("#need_number").text("You need 1000 People to Sign this Petition");}
                else if(val == "Senate"){$("#need_number").text("You need 1500 People to Sign this Petition");}
                else if(val == "State Reps"){$("#need_number").text("You need 750 People to Sign this Petition");}
                else{$("#need_number").text("You need 500 People to Sign this Petition");}
            });
        });
    </script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/dropzone.css')}}">
    <script src="{{asset('js/dropzone.js')}}" type="text/javascript"></script>
    @elseif( active('polls') || active('polls/*') )
    <script type="text/javascript">
        $(function(){
            $('#target_arm').on('change',function(){
              var val = $(this).val();
              if(val == "President"){
                $("#need_number").text("You need 5000 People to Sign this Petition");
              }
              else if(val == "Governor")$("#need_number").text("You need 3000 People to Sign this Petition");
              else if(val == "House of Reps"){$("#need_number").text("You need 1000 People to Sign this Petition");}
              else if(val == "Senate"){$("#need_number").text("You need 1500 People to Sign this Petition");}
              else if(val == "State Reps"){$("#need_number").text("You need 750 People to Sign this Petition");}
              else{$("#need_number").text("You need 500 People to Sign this Petition");}
            });
          });
        
        function answer_click(answer,id,poll_id){
          var hidden = $("#hideme").val();     
          $.post("{{url('polls/')}}",{opcode:2,_token:hidden,answer:answer,id:id,poll_id:poll_id},function(data){
            console.log(data);
          })
          .error(function(data){
            console.log(data);
          });
        }
      </script>
    @elseif( active('press') || active('press/*'))
    {{--  <link rel="stylesheet" type="text/css" href="{{asset('css/dropzone.css')}}">  --}}
    <script type="text/javascript">

        $(function() {
            $("#excelfile").click(function(){
                $("#dropzonediv").slideToggle(200);
            });
            Dropzone.autoDiscover = false;

            var myDropzone = new Dropzone("#dropzonediv", {
                url:"{{ url('press') }}",
                autoProcessQueue:false,
                acceptedFiles:'image/png,image/jpeg,image/jpg',
                uploadMultiple:false,
                maxFiles:1,
                dictDefaultMessage:"Click or drag a picture here.",
                addRemoveLinks:'dictCancelUpload',
                parallelUploads:1,
                dictInvalidFileType:"Picture Must Be An Image",
                maxFilesize:2,
                dictFileTooBig: 'Warning: Image is Larger than 2Mb'
            });

            myDropzone.on("sending", function(file,xhr,formData) {
                formData.append("status", $("#real_post").val() ? $("#real_post").val() : '');
                formData.append("_token", $("#_token").val());
            });

            myDropzone.on("success", function(file,response) {
                var data = response;
                if(response)
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
                    //console.log(postBlock);
                    $("#postvalue").prepend(response);
                    //console.log(response);
                }
                else
                {
                    if(data.post)
                    {
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: "Invalid post."
                        }).show();
                        return false;
                    }

                    if(data.photo)
                    {
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: "Invalid photo path."
                        }).show();
                        return false;
                    }
                }
            });

            myDropzone.on("error", function(file, response) {
                console.log(response);
                new Noty({
                    type: 'error',
                    layout: 'bottomLeft',
                    text: "Please reload page and try again."
                }).show();
                myDropzone.removeFile(file);
            });

            myDropzone.on("complete", function(file) {
                myDropzone.removeFile(file);
            });

            $("#postData").click(function(){
                if(myDropzone.files.length)
                {
                    myDropzone.processQueue();
                }
                else
                {

                    var status 	= 	$("#real_post").val() ? $("#real_post").val() : '';

                    var formData = {
                        'status':status,
                        'opcode':1,
                        "_token":$("#_token").val()
                    };
                    console.log(formData);
                    $.ajax({
                        url: "{{ url('press') }}",
                        type: "POST",
                        dataType: "JSON",
                        data:formData,
                        success: function(data) {
                            alert("Post Successful");
                        },
                        fail: function(data) {
                            console.log(data);
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: "Please reload page and try again."
                            }).show();
                            return false;
                        }
                    });
                }
            });
        });

    </script>
    <script type="text/javascript">
        function otherfunc(id,opcode){
            $.get("{{url('budget')}}/id",{id:id,op:opcode},function(data){
                if(data == 1){
                    new Noty({
                        type: 'success',
                        layout: 'bottomLeft',
                        text: "Post liked!"
                    }).show();
                    console.log(data);
                }
                else{
                    console.log(data);
                    new Noty({
                        type: 'error',
                        layout: 'bottomLeft',
                        text: "You have previously liked this post!"
                    }).show();
                }
            });
        }
    </script>
    {{--  <script src="{{asset('js/dropzone.js')}}" type="text/javascript"></script>  --}}
    @endif
</body>
</html>
