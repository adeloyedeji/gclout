@extends('layouts.app')

@section('content')
    <div class="container page-content" style="margin-top:55px;">
        <div class="row">
            <div class="col-md-3">
                <appsidebar :url="'{{ env('APP_URL') }}'" 
                    :profile_username="'{{ Auth::user()->username }}'" 
                    :profile_name="'{{ Auth::user()->name }}'" 
                    :profile_avatar="'{{ Auth::user()->avatar }}'">
                </appsidebar>
            </div>
            <div class="col-md-6">
                <post :id="'droppy'" :url="'{{ url('post/store') }}'" :toki="'{{ csrf_token() }}'" :user_id="{{Auth::user()->id}}"></post>
            
                <feed :id="{{Auth::user()->id}}"></feed>
            </div>
            <div class="col-md-3">
                <activity-feed></activity-feed>

                <people-you-may-know></people-you-may-know>
            </div>
        </div>
    </div>
@endsection
