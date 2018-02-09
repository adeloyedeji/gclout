@extends('layouts.app')

@section('page-title')
    -- Your Movement
@endsection

@section('content')

    <section class="full-bleed">
        <div class="section-body style-default-dark force-padding text-shadow">
            <div class="img-backdrop" style="background-image: url({{asset('img/img16.jpg')}})"></div>
            <div class="overlay overlay-shade-top stick-top-left height-3"></div>
            <div class="row">
                <div class="col-md-3 col-xs-5">
                    <img class="img-circle border-white border-xl img-responsive auto-width" src="{{asset('img/avatar1.jpg?1403934956')}}" alt="">
                    <h3>{{Auth::user()->name}}<br><small>Consultant at CodeCovers</small></h3>
                </div><!--end .col -->
                <div class="col-md-9 col-xs-7">
                    <div class="width-3 text-center pull-right">
                        <strong class="text-xl">7</strong><br>
                        <span class="text-light opacity-75"></span>
                    </div>
                    <div class="width-3 text-center pull-right">
                        <strong class="text-xl">500</strong><br>
                        <span class="text-light opacity-75">Clouts</span>
                    </div>
                    <div class="width-3 text-center pull-right">
                        <strong class="text-xl">1537</strong><br>
                        <span class="text-light opacity-75">Cycles</span>
                    </div>
                </div><!--end .col -->
            </div><!--end .row -->
            <div class="overlay overlay-shade-bottom stick-bottom-left force-padding text-right">
                <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Contact me"><i class="fa fa-envelope"></i></a>
                <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Follow me"><i class="fa fa-twitter"></i></a>
                <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Personal info"><i class="fa fa-facebook"></i></a>
            </div>
        </div><!--end .section-body -->
    </section>

    <section>
        <div class="section-body no-margin">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body no-padding">
                            <ul class="list divider-full-bleed">
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
                    <ul class="timeline collapse-lg timeline-hairline">

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
                </div>


            </div>
        </div>
    </section>
@endsection

