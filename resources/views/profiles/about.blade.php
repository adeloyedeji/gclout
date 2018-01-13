@extends('layouts.app')

@section('content')
<div class="container page-content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 container-contact">
            <div class="row decor-default">
                <div class="col-md-12">
                    <div class="contact">
                        <div class="controls">
                            <img src="{{ $user->cover }}" alt="cover" class="cover">
                            <div class="cont">
                                <img src="{{ $user->avatar }}" alt="avatar" class="avatar">
                                <div class="name"><span class="s-text">{{ $user->name }}</span></div>
                            </div>
                        </div>
            
                        <div class="row">
                            <div class="col-md-4 col-md-5 col-xs-12">
                                <div class="row">
                                    <div class="col-xs-3">
                                        Email:
                                    </div>
                                    <div class="col-xs-9">
                                        {{ $user->email }}
                                    </div>
                                    <div class="col-xs-3">
                                        Phone: 
                                    </div>
                                    <div class="col-xs-9">
                                        {{ $user->profile->phone_number ? $user->profile->phone_number : '---------' }}
                                    </div>
                                    <div class="col-xs-3">
                                        Address:
                                    </div>
                                    <div class="col-xs-9">
                                        {{ $user->profile->address ? $user->profile->address : '---------' }}
                                    </div>
                                    <div class="col-xs-3">
                                        Birthday:
                                    </div>
                                    <div class="col-xs-9">
                                        {{ $user->profile->date_of_birth ? $user->profile->date_of_birth : '---------' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-7 col-xs-12">
                                <p class="contact-description">
                                    {{ $user->profile->about ? $user->profile->about : "Hi! Unfortunately, I am yet to update my bio. Please check back! :-)" }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection