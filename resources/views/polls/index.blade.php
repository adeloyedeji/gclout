@extends('layouts.app')
<!-- center posts -->
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
{!! Charts::styles() !!}
@section('content')
<div class="container page-content" style="margin-top:55px;">
    <div class="row">
        <div class="col-md-3">
            <appsidebar :url="'{{ env('APP_URL') }}'" 
                :profile_username="'{{ Auth::user()->username }}'" 
                :profile_name="'{{ Auth::user()->name }}'" 
                :profile_avatar="'{{ Auth::user()->avatar }}'"
                :role="{{ Auth::user()->profile->role }}">
            </appsidebar>
        </div>
        <div class="col-md-6">
            <div class="col-md-12">
                <!-- post state form -->
                <div class="box profile-info n-border-top">
                    <div class="box-footer box-form">
                        <h4>
                          Your Polls 
                          @php
                              $url = \Request::fullUrl();
                              $split = explode("/", $url);
                              $split = explode("=", end($split));
                              if(end($split) != "polls" && !is_numeric(end($split))) {
                                echo end($split);
                              }
                          @endphp
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                @foreach($polls as $poll)
                <!--   posts -->
                <?php $checked_answered = app('App\Http\Controllers\PollController')->check_answered($poll->poll_id,Auth::user()->id) ?>
                @if($checked_answered=="empty")
                <div class="box box-widget">
                  <div class="box-header with-border">
                    <div class="user-block">
                      <img class="img-circle" src="{{ Storage::URL($poll->avatar) }}" alt="User Image">
                      <span class="username"><a href="#">{{$poll->name}}</a></span>
                      <span class="description">Shared publicly - {{\Carbon\Carbon::parse($poll->created_at)->format('d/m/Y')}}</span>
                    </div>
                  </div>
      
                  <div class="box-body" style="display: block;">
                    @if ($poll->figure1)
                    <img class="img-responsive show-in-modal" src="{{ asset('storage/'.$poll->figure1) }}" alt="Photo">
                    @endif
                    <p>{{$poll->poll_body}}</p>
                    <div class="radio">
                        <label>
                          <input type="radio" name="answer" id="optionsRadios1" value="agree" onclick="answer_click('agree',{{Auth::user()->id}},{{$poll->poll_id}})">
                          Agree
                        </label>
            
                        <label>
                          <input type="radio" name="answer" id="optionsRadios1" value="disagree" onclick="answer_click('disagree',{{Auth::user()->id}},{{$poll->poll_id}})">
                          Disagree
                        </label>
            
                        <label>
                          <input type="radio" name="answer" id="optionsRadios1" value="undecided" onclick="answer_click('undecided',{{Auth::user()->id}},{{$poll->poll_id}})">
                          Undecided
                        </label>
                  </div>
                    <a type="button" href="{{url('polls')}}/sign?poll={{$poll->poll_id}}" class="btn btn-default btn-xs"><i class="fa fa-share"></i> View Poll</a>
                  <input type="hidden" value="{{csrf_token()}}" id="hideme">
                    <span class="pull-right text-muted"> Participated</span>
                  </div>
                 
                </div>
                @else
                <div class="box box-widget">
                  <div class="box-header with-border">
                    <div class="user-block">
                      <img class="img-circle" src="{{ asset('img/Friends/guy-3.jpg') }}" alt="User Image">
                      <span class="username"><a href="#">{{$poll->name}}</a></span>
                      <span class="description">Shared publicly - {{\Carbon\Carbon::parse($poll->created_at)->format('d/m/Y')}}</span>
                    </div>
                  </div>
                  <div class="box-body" style="display: block;">
                    <img class="img-responsive show-in-modal" src="{{ asset('img/Post/young-couple-in-love.jpg') }}" alt="Photo">
                    <p>{{$poll->poll_body}}</p><hr>
                    <p>{!! $checked_answered->render() !!}</p>
                    <a type="button" href="{{url('polls')}}/sign?poll={{$poll->poll_id}}" class="btn btn-default btn-xs"><i class="fa fa-share"></i> View Poll</a>
                    <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button>
                    <span class="pull-right text-muted"> Participated</span>
                  </div>
                  </div>
                 @endif
      
                @endforeach
            </div>
        </div>
        <div class="col-md-3">
            <extras-component :current_loc="'polls'"></extras-component>

            <people-you-may-know></people-you-may-know>
        </div>
    </div>
</div>
<!-- end  center posts -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Poll</h4>
      </div>
      <div class="modal-body">
        <div class="widget-body">
          <div class="collapse in">
            <form role="form" action="{{url('polls/')}}" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="definpu">Poll Title</label>
                <input type="text" class="form-control" placeholder="Poll Title" id="poll_title" name="poll_title">
              </div>
              <div class="form-group">
                <label for="definpu">Poll Body</label>
                <input type="text" class="form-control" placeholder="Poll Body" id="poll_body" name="poll_body">
              </div>
              <div class="form-group">
                <label for="category" class="control-label">Category</label>
                <select id="category_new" class="form-control" name="category">
                  <option value="">&nbsp;</option>
                  <option value="Political">Political</option>
                  <option value="Economy">Economy</option>
                  <option value="Education">Education</option>
                  <option value="Technology">Technology</option>
                  <option value="Power">Power</option>
                  <option value="Corruption">Corruption</option>
                  <option value="Religion">Religion</option>
                  <option value="Sports">Sports</option>
                  <option value="Entertainments">Entertainments</option>
                  <option value="Security">Security</option>
                  <option value="Foreign Relations">Foreign Relations</option>
                  <option value="Justice">Justice</option>
                </select>
              </div>
              <div class="form-group">
                        <div class="col-sm-12">
                        <label for="" class="control-label text-danger" id="need_number"></span>                        
                        </div>
                </div>
              
              <div class="form-group">
                        <label for="category" class="control-label">Political Office Holder</label>
                        <select id="target_arm" class="form-control" name="target_arm">
                            <option value="President">President</option>
                            <option value="Governor">Governor</option>
                            <option value="Senate">Senate</option>
                            <option value="House of Reps">House of Reps</option>
                            <option value="State Reps">State Reps</option>
                            <option value="Local Govt">Local Government Chairman</option>
                        </select>
                </div>
              <div class="form-group">
                        <span class="input-icon">
                            <input type="text" class="form-control input-lg" name="timeframe" id="timeframe">
                            <i class="fa fa-calender info circular"></i>
                        </span>
              </div>
              <div class="form-group">
                        <span class="input-icon">
                          <label>Type of Answer</label>
                            <select id="answers" class="form-control" name="answers">
                              <option value="1">Yes/No/Maybe</option>
                              <option value="1">Agree/Disagree/Undecided</option>
                            </select>
                            <i class="fa fa-calender info circular"></i>
                        </span>
              </div>
              <div class="form-group">
                        <span class="input-icon">
                          <label>Attach Image</label>
                            <input type="file" id="image" class="form-control" name="imagenew">
                            <i class="fa fa-calender info circular"></i>
                        </span>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="postData">Create Poll</button>
              </div>
              <input id="_token" type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{!! Charts::scripts() !!}
@endsection