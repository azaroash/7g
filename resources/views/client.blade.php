@extends('layouts.app')

@section('content')

<script>
//    function showUser(str) {
//        if (str==''){
//            document.getElementById("txtHint").innerHTML="";
//            return;
//        }
//        if (window.XMLHttpRequest) {
//            xmlhttp = new XMLHttpRequest();
//        }
//        else {
//            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//        }
//        xmlhttp.onreadystatechange=function () {
//            if (this.readyState==4 && this.status==200) {
//                document.getElementById("txtHint").innerHTML=this.responseText;
//            }
//        }
//        xmlhttp.open("GET", "RegisterPurchaseController.php?$id="+str, true);
//        xmlhttp.send();
//    }
//
//    $(function () {
//        $('[data-toggle="popover"]').popover()
//    })
//
//    jQuery(document).ready(function() {
//        jQuery('.hover').popover({
//            title: popoverContent,
//            html: true,
//            placement: 'right',
//            trigger: 'hover'
//        });
//    });
//
//    function popoverContent() {
//        var content = '';
//        var element = $(this);
//        var id = element.attr("id");
//        $.ajax({
//            url: "ClientController.php",
//            method: "POST",
//            async: false,
//            data:{
//                id : id
//            },
//            dataType: "JSON",
//            success:function(data){
//                content = $("#popover_html").html();
//                content = content.replace(/p_fname/g, data.firstName);
//                content = content.replace(/p_lname/g, data.lastName);
//                content = content.replace(/p_phone/g, data.phone);
//            }
//        });
//        return content;
//    }
    {{--$(document).ready(function () {--}}
       {{--$('#userId').keyup(function () {--}}
          {{--var txt = $(this).val();--}}
          {{--if(txt != ''){--}}
              {{--$.ajax({--}}
                 {{--url: "{{ URL::route('getUserData') }}",--}}
                 {{--method: "post",--}}
                 {{--data: {text:txt},--}}
                 {{--dataType: "text",--}}
                 {{--success: function (data) {--}}
                     {{--$('#result').html(data);--}}
                 {{--}--}}
              {{--});--}}
          {{--}--}}
          {{--else {--}}
              {{--$('#result').html('');--}}
          {{--}--}}
       {{--});--}}
    {{--});--}}

</script>

<div class="container">
    <div class="well">
        <div class="row">
            <div class="col-md-2 col-sm-2">
                <img style="width: 100%" src="storage/logos/{{$logo}}">
                {{--<h4>{{ $name }}</h4>--}}
            </div>
            <div class="col-md-4 col-sm-4">
                <h1>{{ $name }}</h1>
                <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $averageRating }}" data-size="xs" disabled="">
                <a id="navbarDropdown" class="nav-bar" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="far fa-bell fa-2x"></i><span class="badge badge-light"><h5>{{ auth()->user()->notifications->count() }}</h5></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @foreach(auth()->guard('client')->user()->notifications as $notification)
                        <a class="dropdown-item" href="#">
                            {{ $notification->data['data'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div> <br>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header"><h5>Register Purchase</h5></div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if ($message = Session::get('warning'))
                        <div class="alert alert-warning">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                <div class="card-body">
                    {{--<div class="col-md-10">--}}
                        {!!Form::open(['action' => 'ClientController@store', 'method'=>'POST']) !!}

                        <div class="form-group row col-md-8">
                            {{--{{Form::label('Id', 'User ID')}}--}}
                            {{Form::text ('userId', '', ['id' => 'search', 'class'=>'form-control', 'placeholder'=>'Enter Member ID'])}}
                            {{--<p class="alert-danger"><small>Please check the member id before you register the purchase.</small></p>--}}

                        </div>

                        <div id="result">
                                {{--<h4 align="center">Search Result</h4>--}}
                                <div class="table-responsive">
                                    {{--<h3 align="center">Total Data : <span id="total_records"></span></h3>--}}
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Phone number</th>
                                                <th>Email Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                        </div> <br>
                        <div class="form-group row col-md-8">
                            {{--{{Form::label('amount', 'Amount')}}--}}
                            {{Form::text ('amount', '', ['class'=>'form-control', 'placeholder'=>'Enter the amount'])}}
                        </div>
    
                        <div class="form-group row col-md-8">
                            {{Form::submit ('Register', ['class'=>'btn btn-dark', 'name'=>'RegisterIt'])}}
                        </div>
    
                        {!! Form::close() !!}
                    {{--</div>--}}
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h5>Sales History</h5></div>
                <div class="card-body">

                    {{--<table id="clientSalesHistory" class="table table-striped table-sm" cellspacing="0" width="100%">--}}
                        {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th><h6><b>Date</b></h6></th>--}}
                                {{--<th><h6><b>Amount</b></h6></th>--}}
                                {{--<th><h6><b>Commission</b></h6></th>--}}
                            {{--</tr>--}}
                        {{--</thead>--}}
                        {{--@foreach($purchaseHistory as $history)--}}

                            {{--<tr>--}}
                                {{--<td>{{$history->purchase_date}}</td>--}}
                                {{--<td>{{$history->location}}</td>--}}
                                {{--<td>{{$history->amount}}</td>--}}
                                {{--<td>{{$history->commission}}</td>--}}
                            {{--</tr>--}}

                        {{--@endforeach--}}
                    {{--</table>--}}
                    <div class="rTable table-striped table-sm">
                        <div class="rTableRow">
                            <div class="rTableHead"><strong>Date</strong></div>
                            <div class="rTableHead"><strong>Amount</strong></div>
                            <div class="rTableHead"><strong>Commission</strong></div>
                        </div>
                        @foreach($purchaseHistory as $history)
                            <div class="rTableRow">
                                <div class="rTableCell">{{$history->purchase_date}}</div>
                                <div class="rTableCell">{{$history->amount}}</div>
                                <div class="rTableCell">{{$history->commission}}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header"><h5>Generate Sales Report</h5></div>
                <div class="card-body">
                    {!!Form::open(['action' => 'ClientController@viewPDF', 'method'=>'GET']) !!}
                        <div class="form-group row col-md-10">
                            {{Form::label('month', 'Select Month')}} <br>
                            {{Form::selectMonth ('month','', ['class' => 'form-control'] )}}
                        </div>

                        <div class="form-group row col-md-10">
                            {{Form::submit ('Generate', ['class'=>'btn btn-dark', 'name'=>'generate'])}}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div> <br>
    <div class="row">
        <p>Share 7G to your friends:</p>
        @include('components.share', ['url' => 'https://www.bbc.com/sport/football'])
    </div>
</div>
<script>
    $(document).ready(function(){

        fetch_customer_data();

        function fetch_customer_data(query = '')
        {
            $.ajax({
                url:"{{ route('getUserData') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('tbody').html(data.table_data);
                    //$('#total_records').text(data.total_data);
                }
            })
        }

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_customer_data(query);
        });
    });
</script>
@endsection
