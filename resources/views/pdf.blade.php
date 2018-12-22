@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10">
        <a class="btn btn-dark" href="{{ route('downloadPDF',['download'=>'pdf']) }}">Download PDF</a>
        <br><br>
        <table class="table table-striped table-sm" cellspacing="0" width="50%">
            <thead>
            <tr>
                <th>Company Name</th>
                <th>Purchase Amount</th>
                <th>Commission For 7G</th>
                <th>Purchase Date</th>
            </tr>
            </thead>
            @foreach($date as $purchase)
                <tr>
                    <td>{{$purchase->companyName}}</td>
                    <td>{{$purchase->amount}}</td>
                    <td>{{$purchase->commission}}</td>
                    <td>{{$purchase->purchase_date}}</td>
                </tr>
            @endforeach
            {{--<tr>--}}
            {{--<td>{{ $date->companyName }}</td>--}}
            {{--</tr>--}}
        </table>
    </div>
</div>
@endsection