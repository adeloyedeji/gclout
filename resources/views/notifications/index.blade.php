@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Notifications</div>

                <div class="panel-body">
                    <ul class="list-group">
                        @foreach ($notifications as $notification)
                            <li class="list-group-item">
                                {{ $notification->data['name'] }} {{ $notification->data['message'] }} 
                                <span class="pull-right">{{ $notification->created_at->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
