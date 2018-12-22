@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-4">
            <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h4>Welcome, {{$name}} </h4>
                    </div>
                    <a id="navbarDropdown" class="nav-bar" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="far fa-bell fa-2x"></i><span class="badge badge-light"><h5>{{ auth()->user()->unreadNotifications->count() }}</h5></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <div class="card">
                            <div class="card-header card-title">
                                <h5><a style="color: #1b1e21" href="{{ route('userAllMark') }}">Mark all as Read</a> </h5>
                            </div>
                            <div class="card-body">
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                    <a style="background-color: #ced4da" class="dropdown-item" href="{{ url('notifications/'.$notification->id) }}">
                                        {{ $notification->data['data'] }}
                                    </a>
                                @endforeach
                                @foreach(auth()->user()->readNotifications as $notification)
                                    <a class="dropdown-item" href="#">
                                        {{ $notification->data['data'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div>
        </div>
        <div class="col-md-8">
            @if(isset($message))
                <h5 class="alert-success">{{ $message }}</h5>
                {{--<a class="btn btn-outline-dark" href="{{ route('rate') }}" id="Rate7G">Rate 7G</a>--}}
                <a class="btn btn-outline-dark" href="{{ route('rate') }}" id="RateClient">Rate Client</a>
            @endif
        </div>
    </div> <br>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h4>Dashboard</h4></div>
                <div class="card-body">
                    <h5>Your point:</h5>
                    <div class="progress" style="height: 40px;">
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{ $userPoint/10 }}%" aria-valuenow="{{ $userPoint }}" aria-valuemin="0" aria-valuemax="1000"><h6>{{ $userPoint }}/1000</h6></div>
                    </div>
                    <ul class="list-group">
                        {{--<li class="list-group-item">You got your first 250 points by signing up to 7G</li>--}}
                        <li class="list-group-item">Purchase from a nearby stores that are members of 7G
                            to get extra points and more advertisement releases to get another more points.</li>
                        <li class="list-group-item">By viewing more advertisements, you will get more points</li>
                        {{--<li>{{ $dateInterval }}</li>--}}
                    </ul> <br>
                    <h5>Advertisements:</h5>
                    <div class="row">
                        @if(isset($beforePreviousAd))
                            <div class="col-md-4">
                                {{--@if(isset($previousAd))--}}
                                @foreach($beforePreviousAd as $advert)
                                    <a href="{{ url('ViewAd/'.$advert->id) }}">
                                        <img style="width: 100%" src="storage/logos/{{ $advert->introImage }}">
                                        {{ $advert->companyName }}
                                    </a>
                                @endforeach
                                {{--@endif--}}
                            </div>
                        @endif
                        @if(isset($previousAd))
                            <div class="col-md-4">
                                {{--@if(isset($previousAd))--}}
                                    @foreach($previousAd as $advert)
                                        <a href="{{ url('ViewAd/'.$advert->id) }}">
                                            <img style="width: 100%" src="storage/logos/{{ $advert->introImage }}">
                                            {{ $advert->companyName }}
                                        </a>
                                    @endforeach
                                {{--@endif--}}
                            </div>
                        @endif
                        <div class="col-md-4">
                            @if(isset($advertOne))
                                @foreach($advertOne as $advert)
                                    <a href="{{ url('ViewAd/'.$advert->id) }}">
                                        <img style="width: 100%" src="storage/logos/{{ $advert->introImage }}">
                                        {{ $advert->companyName }}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md-4">
            <div class="card justify-content-center">
                <div class="card-header"><h4>Purchase History</h4></div>
                <div class="card-body">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th><h5>Date</h5></th>
                                <th><h5>From</h5></th>
                                <th><h5>Amount</h5></th>
                            </tr>
                        </thead>
                        @foreach($purchaseHistory as $history)
                            <tr>
                                <td>{{$history->purchase_date}}</td>
                                <td>{{$history->companyName}}</td>
                                <td>{{$history->amount}}</td>
                            </tr>
                        @endforeach
                    </table> <br>
                    @foreach (LaraFlash::all() as $notification)
                        <div class="alert alert-{{ $notification->type }}" role="alert">
                            <h6>{{ $notification->title }}</h6>
                            <p>{{ $notification->content }}</p>
                        </div>
                    @endforeach
                    {{--<p>{{ LaraFlash::all() }}</p>--}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h4>7G member stores</h4></div>
            </div> <br>
            <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                     <strong>Boutiques</strong>
                  </div>
                  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                    </div>
                  </div>
                </div>
            </div> 
            <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <strong>Small Shops</strong>
                  </div>
                  <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                    </div>
                  </div>
                </div>
            </div>
            <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                    <strong>Mobile Stores</strong>
                  </div>
                  <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                    </div>
                  </div>
                </div>
            </div> 
            <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                    <strong>Cafes & Restaurants</strong>
                  </div>
                  <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordion">
                    <div class="card-body">
                        <ul class="list-group list-group-flush" id="list-tab" role="tablist">
                            @foreach($cafe as $cafes)
                                <a class="list-group-item list-group-item-action">{{ $cafes->companyName }}</a>
                            @endforeach
                        </ul>
                    </div>
                  </div>
                </div>
            </div> 
            <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseOne">
                    <strong>Hotels</strong>
                  </div>
                  <div id="collapseFive" class="collapse show" aria-labelledby="headingFive" data-parent="#accordion">
                    <div class="card-body">
                    </div>
                  </div>
                </div>
            </div>                 
        </div>
    </div> <br>
    <div class="row">
        <div class="col-md-4">
            <h5>Sharing 7G to your friends will increase advertisement relases to view:</h5>
        </div>
        @include('components.share', ['url' => 'http://praise.com.et/'])
    </div>
</div>
@endsection
