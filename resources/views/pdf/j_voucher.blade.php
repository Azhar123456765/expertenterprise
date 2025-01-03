@extends('pdf.farm.app') @section('pdf_content')
    @php
        $single_data = session()->get('s_journal_vouchers_pdf_data');
        $data = session()->get('journal_vouchers_pdf_data');
        $debit_total = session()->get('debit_total');
        $credit_total = session()->get('credit_total');
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
    <div class="invoice-header">
        <div class="ui left aligned grid">
            <div class="row">
                <div class="left floated left aligned six wide column">
                    <div class="ui">
                        <h1 class = "ui header pageTitle">Journal Voucher
                        </h1>
                        <h4 class="ui sub header invDetails">NO: {{ $single_data['unique_id'] }} | Date:
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
        {{-- <div class="ui card customercard">
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
        </div> --}}

        <div class="ui segment itemscard">
            <div class="content">
                <table class="ui celled table">
                    <thead>
                        <tr>
                            <th class="text-center colfix">Narration</th>
                            <th class="text-center colfix">Cheque No</th>
                            <th class="text-center colfix">Cheque Date</th>
                            <th>From Account</th>
                            <th>To Account</th>
                            <th class="text-center colfix">Debit</th>
                            <th class="text-center colfix">Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td class="text-right">
                                    <span class="mono">{{ $row->narration }}</span>
                                    <br>
                                    {{-- <small class="text-muted">Before Tax</small> --}}
                                </td>
                                <td class="text-right">
                                    <span class="mono">{{ $row->cheque_no }}</span>
                                    <br>
                                    {{-- <small class="text-muted">18 Units</small> --}}
                                </td>
                                <td class="text-right">
                                    <span class="mono">{{ $row->cheque_date }}</span>
                                    <br>
                                    {{-- <small class="text-muted">Special -10%</small> --}}
                                </td>
                                <td class="text-right">
                                    <span class="mono">{{ $row->fromAccount->account_name }}</span>
                                    <br>
                                    {{-- <small class="text-muted">VAT 20%</small> --}}
                                </td>
                                <td class="text-right">
                                    <span class="mono">{{ $row->toAccount->account_name }}</span>
                                    <br>
                                    {{-- <small class="text-muted">VAT 20%</small> --}}
                                </td>
                                <td class="text-right" style="text-align: right;">
                                    <span class="mono">{{ $row->status == 'debit' ? $row->amount : 0.0 }}</span>
                                    <br>
                                    {{-- <small class="text-muted">VAT 20%</small> --}}
                                </td>
                                <td class="text-right" style="text-align: right;">
                                    <span class="mono">{{ $row->status == 'credit' ? $row->amount : 0.0 }}</span>
                                    <br>
                                    {{-- <small class="text-muted">VAT 20%</small> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="full-width">
                        <tr>
                            <th colspan="1"></th>
                            <th colspan="1"></th>
                            <th> Total: </th>
                            <th colspan="1"></th>
                            <th colspan="1"></th>
                            <th colspan = "1" style="text-align: right;"> {{ $debit_total }} </th>
                            <th colspan = "1" style="text-align: right;"> {{ $credit_total }} </th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
        <h5 class="my-5 fw-bold" style="width: 100%">Remarks: &nbsp;&nbsp;&nbsp; {{ $single_data['remark'] }}</h5>
        <h5 class="my-5 fw-bold">Attachment:</h5>
        <div class="box w-100" style="border: 1px solid;width: 100%;padding: 30px;">
            <img class="img-fluid"
                style="object-fit: contain;margin: auto;display: flex;width: 100%;max-width: 550px;max-height: 550px;height:100%;justify-content: center;align-items: center;"
                src="{{ asset($single_data['attachment']) }}">
        </div>
    </div>
@endsection
