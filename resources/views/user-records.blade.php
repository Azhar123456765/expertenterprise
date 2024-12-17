@extends('layout.app')  @section('title','User Records')  @section('content')

<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            @foreach ($users as $row)
            <h3 class="title-5 m-b-35">{{$row->username}} Records</h3>
            @endforeach
        </div>

        <div class="card-body">
            <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>title</th>
                        <th>Invoice No</th>
                        <th>Amount</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                        @php
                        $serial = 1;
                        @endphp
                        @foreach ($sale_invoice as $row)


                        <tr class="tr-shadow">
                            <td>
                                {{$serial}}
                            </td>
                            <td><a href="/es_med_invoice_id={{$row->unique_id}}"><span class="block-email">Sale Invoice</span></a></td>
                            <td><a href="/es_med_invoice_id={{$row->unique_id}}"><span class="block-email">{{$row->unique_id}}</span></a></td>
                            <td>
                                <span class="status--process">{{$row->balance_amount}}</span>
                            </td>
                            <td>{{$row->created_at}}</td>
                            <td>
                                <div class="table-data-feature">
                                    <a href="/es_med_invoice_id={{$row->unique_id}}" class="item" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="/sale_invoice_pdf_{{$row->unique_id}}" class="item" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="PDF">
                                        <i class="fa fa-solid fa-file-pdf"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @php
                        $serial++;
                        @endphp
                        @endforeach

                        @foreach ($purchase_invoice as $row)
                        <tr class="tr-shadow table">
                            <td>{{$serial}}</td>
                            <td><a href="/ep_med_invoice_id={{$row->unique_id}}"><span class="block-email">Purchase Invoice</span></a></td>
                            <td><a href="/ep_med_invoice_id={{$row->unique_id}}"><span class="block-email">{{$row->unique_id}}</span></a></td>
                            <td><span class="status--process">{{$row->amount_total}}</span></td>
                            <td>{{$row->created_at}}</td>
                            <td>
                                <div class="table-data-feature">
                                    <a href="/ep_med_invoice_id={{$row->unique_id}}" class="item" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="/purchase_invoice_pdf_{{$row->unique_id}}" class="item" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="PDF">
                                        <i class="fa fa-solid fa-file-pdf"></i>
                                    </a>
                                </div>
                            </td>
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