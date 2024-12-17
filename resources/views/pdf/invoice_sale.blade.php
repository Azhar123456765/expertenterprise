@extends('pdf.farm.app') @section('pdf_content')
    @php

        $single_data = session()->get('single_pdf_data');
        $data = session()->get('pdf_data');
        // dd($data);
        $org = App\Models\Organization::all();
        foreach ($org as $key => $value) {
            $logo = $value->logo;
            $address = $value->address;
            $name = $value->organization_name;
            $phone_number = $value->phone_number;
            $email = $value->email;
        }
    @endphp
    {{-- <style>
         body{
            trans
         }
    </style> --}}
    <style>
         @page {
      size: 80mm 2100mm;
      margin: 0;
    }

    /* Set the content size for the page */
    body {
      width: 80mm;
      height: 2100mm;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    /* Example styling */
    body {
      font-family: Arial, sans-serif;
      padding: 10mm;
      line-height: 1.5;
    }
    </style>
    <div class="invoice-header">
        <div class="ui left aligned grid">
            <div class="row">
                <div class="left floated left aligned six wide column">
                    <div class="ui">
                        <h1 class = "ui header pageTitle">Sale Invoice
                        </h1>
                        <h4 class="ui sub header invDetails">NO: SI-{{ $single_data['unique_id'] }} | Date:
                            {{ (new DateTime($single_data['date']))->format('d-m-Y') }}</h4>
                    </div>
                </div>
                <div class="right floated left aligned six wide column">
                    <div class="ui">
                        <div class="column two wide right floated">
                            <img class="logo"
                                src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($logo))) }}" />
                            <ul class="">
                                <li><strong>{{ $name }}</strong></li>
                                <li>{{ $phone_number }}</li>
                                <li>{{ $address }}</li>
                                <li>{{ $email }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui segment cards">
        <div class="ui card customercard">
            <div class="content">
                <div class="header">Customer Details</div>
            </div>
            <div class="content">
                <ul>
                    <li> <strong> Name: {{ $single_data->customer->company_name }} </strong> </li>
                    <li><strong> Address: </strong> {{ $single_data->customer->address }}</li>
                    <li><strong> Phone: </strong> {{ $single_data->customer->phone_number }}</li>
                    <li><strong> Email: </strong> {{ $single_data->customer->email }}</li>
                </ul>
            </div>
        </div>

        <div class="ui segment itemscard">
            <div class="content">
                <table class="ui celled table">
                    <thead>
                        <tr>
                            <th>Item / Details</th>
                            <th class="text-center colfix">Quantity</th>
                            <th class="text-center colfix">Price</th>
                            <th class="text-center colfix">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>
                                    {{ $row->product->product_name }}
                                    <br>
                                    <small class="text-muted"></small>
                                </td>
                                <td class="text-right">
                                    <span class="mono">{{ $row->qty }}</span>
                                    <br>
                                </td>
                                <td class="text-right">
                                    <span class="mono">{{ $row->price }}</span>
                                    <br>
                                </td>
                                <td class="text-right">
                                    <span class="mono">{{ number_format($row->amount, 2) }}</span>
                                    <br>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="full-width">
                        <tr>
                            <th colspan="3" class="text-right" style="background: transparent !important; border: none !important;"> Discount: </th>
                            <th colspan="1" class="text-right"> {{ $single_data['discount'] }} </th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right" style="background: transparent !important; border: none !important;"> Cash Receive: </th>
                            <th colspan="1" class="text-right"> {{ $single_data['cash_receive'] }} </th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right" style="background: transparent !important; border: none !important;"> Remaining Balance: </th>
                            <th colspan="1" class="text-right"> {{ $single_data['remaining_balance'] }} </th>
                        </tr>
                    </tfoot>
                    <tfoot class="full-width">
                        <tr>
                            <th> Total: </th>
                            <th colspan="1" class="text-right"> {{ $single_data['qty_total'] }} </th>
                            <th colspan="1"></th>
                            <th colspan="1" class="text-right"> {{ $single_data['amount_total'] }} </th>
                        </tr>
                    </tfoot>
                   
                </table>

            </div>
        </div>
        <h4 class="my-5 fw-bolder" style="width: 100%">
           Total Amount Inwords: &nbsp;&nbsp;&nbsp;
            {{ (new NumberToWords\NumberToWords())->getNumberTransformer('en')->toWords($single_data['amount_total']) }}
        </h4>
        <h5 class="my-5 fw-bold" style="width: 100%">Remarks: &nbsp;&nbsp;&nbsp; {{ $single_data['remark'] }}</h5>
        @isset($single_data['attachment'])
            <h5 class="my-5 fw-bold">Attachment:</h5>
            <div class="box w-100" style="border: 1px solid;width: 100%;padding: 30px;">
                <img class="img-fluid"
                    style="object-fit: contain;margin: auto;display: flex;width: 100%;max-width: 550px;max-height: 550px;height:100%;justify-content: center;align-items: center;"
                    src="{{ asset($single_data['attachment']) }}">
            </div>
        @endisset
    </div>
@endsection
