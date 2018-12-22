@extends('layouts.app')
@section('content')
    <script type="text/javascript">

        $("#input-id").rating();

    </script>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h2>Rating</h2></div>
                    <div class="card-body">
                        {!!Form::open(['action' => 'HomeController@rateClient', 'method'=>'POST']) !!}
                        <div class="container">

                            <div class="row">

                                @foreach($client_info as $info)

                                    <div class="col-md-2">
                                        <img style="width: 100%" src="storage/logos/{{$info->logo}}">
                                    </div>
                                    <div class="col-md-8">
                                        <h4>Name: {{ $info->companyName }} </h4>
                                        <h4>Category: {{ $info->categories }} </h4>
                                        <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $averageRating }}" data-size="xs" disabled="">
                                    </div>

                                @endforeach

                            </div><br>
                            <div class="rating">
                                <p style="font-size: medium;">Use these stars below and rate the service you get:</p>
                                <input id="input-1" name="rate" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="{{ $averageRating }}" data-size="xs">
                                <input type="hidden" name="id" required="" value="{{ $client_id }}">
                                {{--<span class="review-no">422 reviews</span>--}}
                                <br/>
                                <button class="btn btn-lg btn-success">Submit</button>

                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection