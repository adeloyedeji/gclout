<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <!-- BEGIN META -->
  <meta name="keywords" content="governance clout, gclout, e-governance, monitor nigerian leaders, social governance">
  <meta name="description" content="Short explanation about this website">
  <!-- END META -->
  <link rel="icon" href="{{ asset('img/favicon.png') }}">
  <title>GClout</title>
  <!-- Bootstrap core CSS -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/timeline.css') }}" rel="stylesheet">
  <link href="{{ asset('css/login_register.css') }}" rel="stylesheet">
  <link href="{{ asset('css/forms.css') }}" rel="stylesheet">
  <link href="{{ asset('css/buttons.css') }}" rel="stylesheet">
  <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'url'  =>  'gclout.newlook.com'
        ]); !!}
    </script>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

    <body>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-fixed-top navbar-transparent" role="navigation">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button id="menu-toggle" type="button" class="navbar-toggle">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar bar1"></span>
              <span class="icon-bar bar2"></span>
              <span class="icon-bar bar3"></span>
            </button>
            <a class="navbar-brand" href="profile.html">
              <img src="{{ asset('img/GCCL.png') }}" style="width: 50px;height:50px;">
            </a>
          </div>
        </div>
      </nav>
      <div class="wrapper">
        <div class="parallax filter-black">
          <div class="parallax-image"></div>             
          <div class="small-info">
            <div class="col-sm-10 col-sm-push-1 col-md-6 col-md-push-3 col-lg-6 col-lg-push-3">
              <div class="card-group animated flipInX">
                <div class="card">
                  <div class="card-block">
                    <div class="center">
                      <h4 class="m-b-0"><span class="icon-text">Login</span></h4>
                      <p class="text-muted">Access your account</p>
                      @if( session()->has('type') && session()->get('type') === 0 )
                        @if( $errors->has('email') || $errors->has('password') )
                          @if( $errors->has('email') )
                          <p><span class="text-danger">{{ $errors->first('email') }}</span></p>
                          @endif

                          @if( $errors->has('password') )
                          <p><span class="text-danger">{{ $errors->first('password') }}</span>|</p>
                          @endif
                        @endif

                        @if($message = Session::get('success'))
                        <p><span class="text-success">{{ $message }}</span></p>
                        @endif

                        @if($message = Session::get('warning'))
                        <p><span class="text-danger">{{ $message }}</span></p>
                        @endif
                      @endif
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email Address">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <a href="{{url('password/reset')}}" class="pull-xs-right">
                          <small>Forgot Password?</small>
                        </a>
                        <div class="clearfix"></div>
                      </div>
                      <div class="center">
                        <button class="btn btn-azure" type="submit">Login</button>
                        <a href="{{url('auth/facebook')}}" class="btn btn-primary">
                          <i class="fa fa-facebook"></i> Facebook
                        </a>
                        <a href="{{url('auth/twitter')}}" class="btn btn-blue">
                          <i class="fa fa-twitter"></i> Twitter
                        </a>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card">
                  <div class="card-block center">
                    <h4 class="m-b-0">
                      <span class="icon-text">Sign Up</span>
                    </h4>
                    <p class="text-muted">Create a new account</p>
                    @if( session()->has('type') && session()->get('type') === 1 )


                      @if( $errors->has('email') || $errors->has('password') || $errors->has('phone') || $errors->has('agree') )


                      @if( $errors->has('email') )
                        <p><span class="text-danger">{{ $errors->first('email') }}</span></p>
                      @endif

                      <p></p>

                      @if( $errors->has('password') )
                        <p><span class="text-danger">{{ $errors->first('password') }}</span></p>
                      @endif

                      @if( $errors->has('agree') )
                        <p><span class="text-danger">You must agree to terms and conditions first</span></p>
                      @endif

                      <p></p>

                      @endif
                      @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> {{ Session::get('success') }}
                        </div>
                      @endif
                    @endif
                    <form method="POST" action="{{ route('register') }}">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Full Name">
                      </div>
                      <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Confirm Password">
                      </div>
                      <div class="form-group">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" class="colored-blue" id="agree" name="agree" value="1">
                            <span class="text text-justify" style="color:#b3b3b3">
                              By signing up, you agree to the <a>Terms of Service</a> and <a>Privacy Policy</a>, including <a>Cookie Use</a>, Others will be able to find you by email or phone when provided.
                            </span>
                          </label>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-azure">Register</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <footer class="footer">
          <div class="container">
            <p class="text-muted"> Copyright &copy; Spruceties - All rights reserved </p>
          </div>
        </footer>
      </div>
      <script src="{{ asset('js/jquery.1.11.1.min.js') }}"></script>
      <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    </body>
    </html>