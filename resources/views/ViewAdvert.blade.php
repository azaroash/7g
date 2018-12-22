@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
                @if(isset($advert))
                    @foreach($advert as $ad)
                        <div class="col-md-6">
                            <img style="width: 100%" src="storage/logos/{{ $ad->bigImage }}">
                        </div>
                        <div class="col-md-6">
                            <p>
                                {{ $ad->description }}
                            </p>
                            <a class="btn btn-outline-secondary btn-lg" href="{{ route('viewAdDone') }}"role="button">Done</a>
                        </div>
                    @endforeach
                @endif
        </div>
    </div>
@endsection