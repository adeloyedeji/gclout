@extends('layouts.app')
<!-- center posts -->
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
@section('content')
<div class="container page-content" style="margin-top:55px">
    <div class="row">
        <div class="col-md-3">
            <appsidebar :url="'{{ env('APP_URL') }}'" 
                :profile_username="'{{ Auth::user()->username }}'" 
                :profile_name="'{{ Auth::user()->name }}'" 
                :profile_avatar="'{{ Auth::user()->avatar }}'">
            </appsidebar>
        </div>
        <div class="col-md-6">
            <div class="row">
                <!-- left posts-->
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- post state form -->
                            <div class="box profile-info n-border-top">
                                <form>
                                    <input id="_token" type="hidden" name="_token" value="{{csrf_token()}}">
                                    <textarea id="real_post" class="form-control input-lg p-text-area" rows="4" placeholder="Whats on your mind today?" style="resize: none;"></textarea>
                                    <div class="dropzone" id="dropzonediv" style="border:0px;display:none;"></div>
                                </form>
                                <div class="box-footer box-form">
                                    <button id="postData" type="button" class="btn btn-azure pull-right">Post</button>
                                    <ul class="nav nav-pills">
                                        <li id="excelfile"><a href="#"><i class="fa fa-camera"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- end post state form -->
                            <div id="postvalue">
                                @foreach($movements as $movement)
                                    <!--   posts -->
                                    <div class="box box-widget">
                                        <div class="box-header with-border">
                                            <div class="user-block">
                                                <img class="img-circle" src="{{ asset($movement->image) }}" alt="User Image">
                                                <span class="username"><a href="{{url('profile')}}/{{$movement->user_id}}">{{$movement->name}}</a></span>
                                                <span class="description">
                                                    Shared publicly - {{\Carbon\Carbon::parse($movement->press_created_at)->format('d/m/Y')}}
                                                </span>
                                            </div>
                                        </div>
                                        <?php $like_check = app('App\Http\Controllers\PressReleaseController')->check_like($movement->press_id) ?>
                                        <div class="box-body" style="display: block;">
                                            @if($movement->press_img_path !== null)
                                                <img class="img-responsive show-in-modal" src="{{ asset('storage/'.$movement->press_img_path)}}" alt="Photo">
                                            @endif
                                            <p>{{$movement->press_body}}</p><br>
                                            <span class="pull-left text-muted description" id="likes">
                                                <?php echo app('App\Http\Controllers\PressReleaseController')->press_like($movement->press_id) ?> Likes
                                            </span><hr>
                                            <button @if($like_check>0) disabled="disabled" @endif type="button" onclick="otherfunc({{$movement->press_id}},1)" class="btn btn-default btn-xs">
                                                <i class="fa fa-thumbs-o-up"></i>{{$movement->number_view}} Like
                                            </button>
                                            <a href="{{url('press')}}/{{$movement->press_id}}?op=2" type="button" class="btn btn-default btn-xs">
                                                <i class="fa fa-share"></i> Read More
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!--  end posts-->
                        </div>
                    </div>
                </div>
                <!-- end left posts-->
            </div>
        </div>
        <div class="col-md-3">
            <extras-component :current_loc="'press'"></extras-component>

            <people-you-may-know></people-you-may-know>
        </div>
    </div>
</div>
<!-- end  center posts -->

<!--Modal Class and JS Area -->
@endsection