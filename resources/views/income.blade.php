@extends('layout.app') @section('title','Incomes') @section('content')
@php
$endDate = date('Y-m-d');
$startDate = date('Y-m-d', strtotime("-1 year", strtotime($endDate)));
@endphp
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="title-5 m-b-35">Incomes</h3>
            <form class="row float-right" style="    display: flex;
    align-items: baseline;" method="GET" action="/income">
                <label>Start Date:</label>
                <input type="date" class="date" name="start_date" id="start_date" onchange="date()" value="{{$start_date ?? $startDate}}">
                &nbsp;&nbsp;&nbsp;
                <label>End Date:</label>
                <input type="date" class="date" name="end_date" id="end_date" onchange="date()" value="{{$end_date ?? $endDate}}">
                &nbsp;&nbsp;&nbsp;

                <button type="submit" class="btn btn-large btn-primary">Apply</button>
            </form>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Ref No</th>
                        <th>Referance</th>
                        <th>Amount</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $serial = 1;
                    @endphp
                    @foreach ($income as $row)
                    <tr class="tr-shadow">
                        <td>
                            {{$serial}}
                        </td>
                        <td><span class="block-email">{{$row->category_id}}</span< /td>
                        <td><span class="block-email">{{$row->category}}</span></td>
                        <td>
                            <span class="status--process">{{$row->amount}}</span>
                        </td>
                        <td>{{$row->created_at}}</td>
                    </tr>
                    @php
                    $serial++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


</div>

@endsection