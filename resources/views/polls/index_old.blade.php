@extends('layouts.app')

@section('page-title')
    -- Your Movement
@endsection

{!! Charts::assets() !!}
@section('content')

    <section class="full-bleed">
        <div class="section-body style-default-dark force-padding text-shadow" id="cover_photo">
        <div class="img-backdrop" style="background-image: url('{{ asset('img/users/cover_images')  }}/{{ Auth::user()->cover_image }}')"></div>
        <div class="overlay stick-top-left height-3"></div>
        <div class="row">
            <div class="col-md-3 col-xs-5">
                <img class="img-circle border-white border-xl img-responsive auto-width" src="{{ asset('img/users') }}/{{Auth::user()->image}}" alt=""  style="width: 140px;height: 140px;">
                <h3>{{Auth::user()->name}}<br><small>{{ Auth::user()->gclout_name }}</small></h3>
            </div><!--end .col -->
            <div class="col-md-9 col-xs-7">
                <?php
                $followme   = app('App\Http\Controllers\UserController')->getFollowersCount(\Auth::user()->id);
                $youfollow  = app('App\Http\Controllers\UserController')->getFollowingCount(\Auth::user()->id);
                $clouts     = app('App\Http\Controllers\FriendController')->getFriendsCount(\Auth::user()->id);
                ?>
                <div class="width-3 text-center pull-right">
                    <strong class="text-xl">{{ $followme }}</strong><br/>
                    <span class="text-light opacity-75">followers</span>
                </div>
                <div class="width-3 text-center pull-right">
                    <strong class="text-xl">{{ $youfollow }}</strong><br/>
                    <span class="text-light opacity-75">following</span>
                </div>
                <div class="width-3 text-center pull-right">
                    <strong class="text-xl">{{ $clouts }}</strong><br/>
                    <span class="text-light opacity-75">clouts</span>
                </div>
            </div><!--end .col -->
        </div><!--end .row -->
        <div class="overlay overlay-shade-bottom stick-bottom-left force-padding text-right">
            <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Contact me"><i class="fa fa-envelope"></i></a>
            <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Follow me"><i class="fa fa-twitter"></i></a>
            <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Personal info"><i class="fa fa-facebook"></i></a>
        </div>
    </div><!--end .section-body -->    </section>

    <section>
        <div class="section-body no-margin">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body no-padding">
                            <ul class="list divider-full-bleed">
                                <li class="tile">
                                    <a class="tile-content ink-reaction" href="#offcanvas-size3" data-toggle="offcanvas">
                                        <div class="tile-icon">
                                            <i class="fa fa-plus"></i>
                                        </div>
                                        <div class="tile-text">
                                           Create Poll
                                        </div>
                                    </a>

                                </li>
                                <li class="tile">
                                    <a class="tile-content ink-reaction">
                                        <div class="tile-icon">
                                            <i class="fa fa-inbox"></i>
                                        </div>
                                        <div class="tile-text">
                                            Economy
                                        </div>
                                    </a>
                                </li>
                                <li class="tile">
                                    <a class="tile-content ink-reaction">
                                        <div class="tile-icon">
                                            <i class="fa fa-send"></i>
                                        </div>
                                        <div class="tile-text">
                                            Politics
                                        </div>
                                    </a>
                                </li>
                                <li class="tile">
                                    <a class="tile-content ink-reaction">
                                        <div class="tile-icon">
                                            <i class="fa fa-trash"></i>
                                        </div>
                                        <div class="tile-text">
                                            Education
                                        </div>
                                    </a>
                                </li>
                                <li class="tile">
                                    <a class="tile-content ink-reaction">
                                        <div class="tile-icon">
                                            <i class="fa fa-warning"></i>
                                        </div>
                                        <div class="tile-text">
                                            Technology
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div><!--end .card-body -->
                    </div>
                </div>

                <div class="col-lg-6">
                    <h2 class="text-light text-center">Polls</h2>
                    @if(session()->has('message') or session('message')!='')
                    <div class="alert alert-success" role="alert">
                        <strong>{{session('message')}}</strong>
                    </div>
                    @endif
                    <ul class="timeline collapse-lg timeline-hairline">
                        @foreach($polls as $poll)
                            <?php $checked_answered = app('App\Http\Controllers\PollController')->check_answered($poll->id,Auth::user()->id) ?>
                        @if($checked_answered=="empty")

                                    <li class="timeline-inverted" id="{{$poll->id}}_poll">
                                        <div class="timeline-circ circ-xl style-primary"><span class="glyphicon glyphicon-asterisk"></span></div>
                                        <div class="timeline-entry">
                                            <div class="card style-default-bright">
                                                <div class="card-body small-padding">
                                                    <img class="img-circle img-responsive pull-left width-1" src="img/avatar9.jpg?1404026744" alt="">
                                                    <span class="text-center">{{$poll->poll_title}} By <a class="text-primary" href="../../html/mail/inbox.html"></a> </span><br>
                                                    <span class="text-medium">{{$poll->poll_body}}</span>...  <br>
                                                    <span class="opacity-50">
                                            @if($poll->answers = 1)
                                                            <form method="post">
                                                    <div class="form-group">
                                                        <div class="col-sm-9">
                                                            <label class="radio-inline radio-styled radio-success">
														        <input type="radio" name="answer" onclick="poll_answer('yes',{{$poll->id}}_poll)"><span>Yes</span>
													        </label>
                                                            <label class="radio-inline radio-styled radio-primary">
														        <input type="radio" name="answer"><span>No</span>
													        </label>
                                                            <label class="radio-inline radio-styled radio-warning">
														        <input type="radio" name="answer"><span>Undecided</span>
													        </label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" value="{{csrf_token()}}">
                                                </form>
                                                        @else
                                                            <form method="post">
                                                    <div class="form-group">
                                                        <div class="col-sm-9">
                                                            <label class="radio-inline radio-styled radio-success">
														        <input type="radio" name="answer"><span>Agree</span>
													        </label>
                                                            <label class="radio-inline radio-styled radio-primary">
														        <input type="radio" name="answer"><span>Disagree</span>
													        </label>
                                                            <label class="radio-inline radio-styled radio-warning">
														        <input type="radio" name="answer"><span>Indifferent</span>
													        </label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" value="{{csrf_token()}}">
                                                </form>
                                                        @endif
                                        </span>

                                                    <span class="opacity-50 pull-right">
													{{\Carbon\Carbon::parse($poll->created_at)->format('d/m/Y')}}
                                        </span>
                                                </div><!--end .card-body -->
                                            </div><!--end .card -->
                                        </div><!--end .timeline-entry -->
                                    </li>
                                @else
                                    <li class="timeline-inverted">
                                    <div class="timeline-circ circ-xl style-primary"><span class="glyphicon glyphicon-asterisk"></span></div>
                                    <div class="timeline-entry">
                                        <div class="card style-default-bright">
                                            <div class="card-body small-padding">
                                                {!! $checked_answered->render() !!}
                                            </div>
                                        </div>
                                    </div>
                                    </li>
                            @endif

                        @endforeach
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="card card-underline style-accent">
                        <div class="card-head">
                            <header class="opacity-75">
                                <small>Trending</small>
                            </header>
                        </div>

                        <div class="card-body no-padding">
                            <ul class="list">
                                <li class="tile">
                                    <a href="#" class="tile-content ink-reaction">
                                        <div class="tile-icon">
                                            <img src="img/avatar2.jpg?1404026449" alt="">
                                        </div>
                                        <div class="tile-text">Abbey Johnson<small>Lorem ipsum dolor sit amet, consectetur adipisicing</small></div>
                                    </a>
                                </li>
                                <li class="tile">
                                    <a href="#" class="tile-content ink-reaction">
                                        <div class="tile-icon">
                                            <img src="img/avatar2.jpg?1404026449" alt="">
                                        </div>
                                        <div class="tile-text">Abbey Johnson<small>Lorem ipsum dolor sit amet, consectetur adipisicing</small></div>
                                    </a>
                                </li>
                                <li class="tile">
                                    <a href="#" class="tile-content ink-reaction">
                                        <div class="tile-icon">
                                            <img src="img/avatar2.jpg?1404026449" alt="">
                                        </div>
                                        <div class="tile-text">Abbey Johnson<small>Lorem ipsum dolor sit amet, consectetur adipisicing</small></div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card card-underline style-accent">
                        <div class="card-head">
                            <header class="opacity-75">
                                <small>Polls</small>
                            </header>
                        </div>

                        <div class="card-body no-padding">
                            <ul class="list">
                                @foreach($polls as $poll)
                                    <li class="tile">
                                        <a href="{{url('polls')}}/{{$poll->id}}" class="tile-content ink-reaction">
                                            <div class="tile-icon">
                                                <img src="img/avatar2.jpg?1404026449" alt="">
                                            </div>
                                            <div class="tile-text">{{$poll->poll_title}}<small>{{$poll->poll_body}}</small></div>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <!-- Side Pane Data -->
        <div class="offcanvas">
            <div id="offcanvas-size3" class="offcanvas-pane width-10">
                <div class="offcanvas-head">
                    <header>Create Poll</header>
                    <div class="offcanvas-tools">
                        <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                            <i class="md md-close"></i>
                        </a>
                    </div>
                </div>
                <div class="nano has-scrollbar" style="height: 594px;"><div class="nano-content" tabindex="0" style="right: -17px;"><div class="offcanvas-body">

                            <p>&nbsp;</p>
                            <form class="form form-validate" action="#" method="post">
                                <div class="card">
                                    <div class="card-head style-primary">
                                        <header>Create a Poll</header>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-validate" id="poll_title" name="poll_title" required aria-required="true">
                                                    <label for="poll_title">Poll Title</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <textarea type="text" name="poll_body" class="form-control form-validate" id="poll_body" rows="3" required data-rule-minlength="2" maxlength="140" aria-required="true"></textarea>
                                            <label for="movement_body">Poll Question</label>
                                        </div>
                                        {{--<div class="form-group">--}}
                                            {{--<input type="password" class="form-control" id="Password1">--}}
                                            {{--<label for="Password1">Password</label>--}}
                                        {{--</div>--}}
                                        {{--<div class="checkbox checkbox-styled">--}}
                                            {{--<label>--}}
                                                {{--<input type="checkbox" value="">--}}
                                                {{--<span>Send me weekly updates</span>--}}
                                            {{--</label>--}}
                                        {{--</div>--}}
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select id="issues" class="form-control" name="issues">
                                                    <option value="">&nbsp;</option>
                                                    <option value="Political">Political</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                </select>
                                                <label for="issues">Issues</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select id="audience" class="form-control" name="audience">
                                                    <option value="">&nbsp;</option>
                                                    <option value="Political">Political</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                </select>
                                                <label for="audience">Audience</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <select id="answer" class="form-control" name="answer">
                                            <option value="">&nbsp;</option>
                                            <option value="1">Yes/No/Undecided</option>
                                            <option value="2">Agree/Disagree/Indifferent</option>
                                        </select>
                                        <label for="category">Answer</label>
                                    </div>

                                    <div class="card-actionbar">
                                        <div class="card-actionbar-row">
                                            <button type="submit" class="btn btn-flat btn-primary ink-reaction">Post Poll</button>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>
                        </div></div>
                    <div class="nano-pane" style="display: none;"><div class="nano-slider" style="height: 577px; transform: translate(0px, 0px);"></div></div></div>
                           </div>
        </div>
    </section>
<script>
    function poll_answer(answer,id){
        toastr.info(answer);
    }

</script>
@endsection

