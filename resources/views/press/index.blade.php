@extends('layouts.app')

@section('page-title')
    | Press
@endsection

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
                <press-component :user_id="{{Auth::id()}}"
                                 :toki="'{{csrf_token()}}'"
                                 :id="'press-section'"
                                 :url="'{{ url('press/store') }}'">
                </press-component>
                <press-feed-component :id="{{ Auth::id() }}">
                </press-feed-component>
            </div>
            <div class="col-md-3">
                <activity-feed :id="{{Auth::id()}}"></activity-feed>

                <people-you-may-know></people-you-may-know>
            </div>
        </div>
    </div>
    <active-users :user_id="{{Auth::id()}}"></active-users>
@endsection