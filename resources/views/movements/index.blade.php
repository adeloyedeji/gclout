@extends('layouts.app')
<!-- center posts -->
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
                <div class="box profile-info n-border-top">
                    <div class="box-footer box-form">
                        <h4>Petitions</h4>              
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div id="postvalue">
                    @foreach($movements as $movement)
                        <div class="box box-widget">
                            <div class="box-header with-border">
                                <div class="user-block">
                                    <img class="img-circle" src="{{ Storage::URL($movement->avatar) }}" alt="User Image">
                                    <span class="username"><a href="#">{{$movement->name}}</a></span>
                                    <span class="description">
                                        Shared publicly - {{\Carbon\Carbon::parse($movement->created_at)->format('d/m/Y')}}
                                    </span>
                                </div>
                            </div>
                            <?php $like_check = app('App\Http\Controllers\MovementController')->check_sign($movement->movement_id) ?>
                            <?php $suppose_sign = app('App\Http\Controllers\MovementController')->suppose_sign($movement->target_arm) ?>
                            <?php $sign = app('App\Http\Controllers\MovementController')->number_signature($movement->movement_id) ?>
                            <div class="box-body" style="display: block;">
                                <p>{{$movement->movement_body}}</p>
                                @if($movement->img_path !== null)
                                    <img class="img-responsive show-in-modal" src="{{asset('storage/'.$movement->img_path)}}" alt="Photo"> <hr>
                                @endif
            
                                <button @if($like_check > 0) disabled="disabled" @endif href="#" onclick="otherfunc({{$movement->movement_id}},1)" type="button" class="btn btn-default btn-xs">
                                    <i class="fa fa-thumbs-o-up"></i> Sign Petition
                                </button>
                                <a href="{{url('movements')}}/{{$movement->movement_id}}" type="button" class="btn btn-default btn-xs">
                                    <i class="fa fa-share"></i> View Petition
                                </a>
                                <span class="pull-md-left">
                                    <?php echo "<span id='like_ch'>$like_check</span> out of 5000 signed" ?>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <extras-component :current_loc="'movements'"></extras-component>

            <people-you-may-know></people-you-may-know>
        </div>
    </div>
</div>

<!--Modal Class and JS Area -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Create Petition</h4>
            </div>
            <div class="modal-body">
                <div class="widget-body">
                    <div class="collapse in">
                        <form role="form">
                            <div class="form-group">
                                <label for="definpu">Petition Title</label>
                                <input type="text" class="form-control" placeholder="Petition Title" id="movement_title" name="movement_title">
                            </div>
                            <div class="form-group">
                                <label for="definpu">Petition Body</label>
                                <textarea cols="20" rows="4" class="form-control" placeholder="Petition Body" id="movement_body" name="movement_body"></textarea>
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
                            <div class="dropzone" id="dropzonediv" style="border:0px;display:none;"></div>
                            <div id="excelfile"><span class="file-input btn btn-block btn-default btn-file">Attach Image</span></div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="postData">Create Petition</button>
                            </div>
                            <input id="_token" type="hidden" name="_token" value="{{csrf_token()}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection