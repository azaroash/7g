@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-10"> <br><br><br>
                <div class="card-group">
                    <div class="card border-secondary mb-3">
                        {{--<div class="card-header"><h3><strong></strong></h3></div>--}}

                        <div class="card-body text-secondary">
                            <h4 class="card-title"><b>Login as a Member</b></h4>
                            <p class="card-text">
                                Login in as a member if you have already registered as a member and an activated account.
                                If you didn't activate your account please go back to your email and activate your account
                                by clicking the link.
                            </p> <br>
                            <a class="btn btn-outline-secondary btn-lg" href="{{ route('login') }}"role="button">Login</a>
                        </div>

                    </div>
                    <div class="card border-secondary mb-3">
                        {{--<div class="card-header"><h3><strong></strong></h3></div>--}}

                        <div class="card-body text-secondary">
                            <h4 class="card-title"><b>Login as a Client</b></h4>
                            <p class="card-text">
                                Login in as a client if you have already registered as a client and an activated account.
                                If you didn't activate your account please go back to your email and activate your account
                                by clicking the link.
                            </p> <br>
                            <a class="btn btn-outline-secondary btn-lg" href="{{ route('client.login') }}"role="button">Login</a>
                        </div>
                    </div>
                </div> <br>
                <a class="btn btn-secondary btn-lg" href="{{ url('/') }}">
                    {{ __('Return') }}
                </a>
            </div>
        </div>
    </div>
@endsection

