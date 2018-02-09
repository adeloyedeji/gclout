@extends('layouts.app')

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
            <div class="col-md-9">
                <chat-component :user_id="{{ Auth::id() }}"></chat-component>
            </div>
        </div>
    </div>
@endsection