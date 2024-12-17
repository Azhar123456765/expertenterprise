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
    <div class="invoice-header">
        <div class="ui left aligned grid">
            <div class="row">
                <div class="left floated left aligned six wide column">
                    <div class="ui">
                        <h1 class = "ui header pageTitle">{{ $method == 0 ? 'Sale' : 'Purchase' }} Invoice
                        </h1>
                        <h4 class="ui sub header invDetails">NO: CH-{{ $single_data['unique_id'] }} | Date:
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
    @if ($method == 0)
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
                        <div style="display:flex; justify-content:space-between;">
                            <b>Actual Rate:&nbsp;&nbsp;{{ $single_data->actual_rate }}</b>
                            <b>Avg Weight:&nbsp;&nbsp;{{ $single_data->avg }}</b>
                            <b>Cut Rate:&nbsp;&nbsp;{{ $single_data->rate_diff }}</b>
                        </div>
                        <thead>
                            <tr>
                                <th>Item / Details</th>
                                <th class="text-center colfix">Rate</th>
                                <th class="text-center colfix">Vehicle#</th>
                                <th class="text-center colfix">Crate Qty</th>
                                <th class="text-center colfix">Gross Weight</th>
                                <th class="text-center colfix">Feed</th>
                                <th class="text-center colfix">Mor</th>
                                <th class="text-center colfix">Crate</th>
                                <th class="text-center colfix">Net Weight</th>
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
                                        <span class="mono">{{ $row->sale_rate }}</span>
                                        <br>
                                        {{-- <small class="text-muted">Before Tax</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->vehicle_no }}</span>
                                        <br>
                                        {{-- <small class="text-muted">18 Units</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->crate_qty }}</span>
                                        <br>
                                        {{-- <small class="text-muted">Special -10%</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->gross_weight }}</span>
                                        <br>
                                        {{-- <small class="text-muted">VAT 20%</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->sale_feed_cut }}</span>
                                        <br>
                                        {{-- <small class="text-muted">VAT 20%</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->sale_more_cut }}</span>
                                        <br>
                                        {{-- <small class="text-muted">VAT 20%</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->sale_crate_cut }}</span>
                                        <br>
                                        {{-- <small class="text-muted">VAT 20%</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->sale_net_weight }}</span>
                                        <br>
                                        {{-- <small class="text-muted">VAT 20%</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ number_format($row->sale_amount,2) }}</span>
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
                                <th colspan="1"> {{ $single_data['crate_qty_total'] }} </th>
                                <th colspan="1"> {{ $single_data['gross_weight_total'] }} </th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"> {{ $single_data['sale_n_weight_total'] }} </th>
                                <th colspan="1"> {{ $single_data['sale_amount_total'] }} </th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
            <h4 class="my-5 fw-bolder" style="width: 100%">
                Inwords: &nbsp;&nbsp;&nbsp;
                {{ (new NumberToWords\NumberToWords())->getNumberTransformer('en')->toWords($single_data['sale_amount_total']) }}
            </h4>
            <h5 class="my-5 fw-bold" style="width: 100%">Remarks: &nbsp;&nbsp;&nbsp; {{ $single_data['remark'] }}</h5>
            <h5 class="my-5 fw-bold">Attachment:</h5>
            <div class="box w-100" style="border: 1px solid;width: 100%;padding: 30px;">
                <img class="img-fluid"
                    style="object-fit: contain;margin: auto;display: flex;width: 100%;max-width: 550px;max-height: 550px;height:100%;justify-content: center;align-items: center;"
                    src="{{ asset($single_data['attachment']) }}">
            </div>
        </div>
    @elseif($method == 1)
        <div class="ui segment cards">
            {{-- <div class="ui card">
                    <div class="content">
                        <div class="header">Company Details</div>
                    </div>
                    <div class="content">
                        <ul>
                            <li> <strong> Name: RCJA </strong> </li>
                            <li><strong> Address: </strong> 1 Unknown Street VIC</li>
                            <li><strong> Phone: </strong> (+61)404123123</li>
                            <li><strong> Email: </strong> admin@rcja.com</li>
                            <li><strong> Contact: </strong> John Smith</li>
                        </ul>
                    </div>
                </div> --}}
            <div class="ui card customercard">
                <div class="content">
                    <div class="header">Supplier Details</div>
                </div>
                <div class="content">
                    <ul>
                        <li> <strong> Name: {{ $single_data->supplier->company_name }} </strong> </li>
                        <li><strong> Address: </strong> {{ $single_data->supplier->address }}</li>
                        <li><strong> Phone: </strong> {{ $single_data->supplier->phone_number }}</li>
                        <li><strong> Email: </strong> {{ $single_data->supplier->email }}</li>
                    </ul>
                </div>
            </div>

            <div class="ui segment itemscard">
                <div class="content">
                    <table class="ui celled table">
                        <div style="display:flex; justify-content:space-between;">
                            <b>Actual Rate:&nbsp;&nbsp;{{ $single_data->actual_rate }}</b>
                            <b>Avg Weight:&nbsp;&nbsp;{{ $single_data->avg }}</b>
                            <b>Cut Rate:&nbsp;&nbsp;{{ $single_data->rate_diff }}</b>
                        </div>
                        <thead>
                            <tr>
                                <th>Item / Details</th>
                                <th class="text-center colfix">Rate</th>
                                <th class="text-center colfix">Vehicle#</th>
                                <th class="text-center colfix">Crate Qty</th>
                                <th class="text-center colfix">Gross Weight</th>
                                <th class="text-center colfix">Feed</th>
                                <th class="text-center colfix">Mor</th>
                                <th class="text-center colfix">Crate</th>
                                <th class="text-center colfix">Net Weight</th>
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
                                        <span class="mono">{{ $row->rate }}</span>
                                        <br>
                                        {{-- <small class="text-muted">Before Tax</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->vehicle_no }}</span>
                                        <br>
                                        {{-- <small class="text-muted">18 Units</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->crate_qty }}</span>
                                        <br>
                                        {{-- <small class="text-muted">Special -10%</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->gross_weight }}</span>
                                        <br>
                                        {{-- <small class="text-muted">VAT 20%</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->feed_cut }}</span>
                                        <br>
                                        {{-- <small class="text-muted">VAT 20%</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->more_cut }}</span>
                                        <br>
                                        {{-- <small class="text-muted">VAT 20%</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->crate_cut }}</span>
                                        <br>
                                        {{-- <small class="text-muted">VAT 20%</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ $row->net_weight }}</span>
                                        <br>
                                        {{-- <small class="text-muted">VAT 20%</small> --}}
                                    </td>
                                    <td class="text-right">
                                        <span class="mono">{{ number_format($row->amount,2) }}</span>
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
                                <th colspan="1"> {{ $single_data['crate_qty_total'] }} </th>
                                <th colspan="1"> {{ $single_data['gross_weight_total'] }} </th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"> {{ $single_data['n_weight_total'] }} </th>
                                <th colspan="1"> {{ $single_data['amount_total'] }} </th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
            <h4 class="my-5 fw-bolder" style="width: 100%">
                Inwords: &nbsp;&nbsp;&nbsp;
                {{ (new NumberToWords\NumberToWords())->getNumberTransformer('en')->toWords($single_data['amount_total']) }}
            </h4>
            <h5 class="my-5 fw-bold" style="width: 100%">Remarks: &nbsp;&nbsp;&nbsp; {{ $single_data['remark'] }}</h5>
            <h5 class="my-5 fw-bold">Attachment:</h5>
            <div class="box w-100" style="border: 1px solid;width: 100%;padding: 30px;">
                <img class="img-fluid"
                    style="object-fit: contain;margin: auto;display: flex;width: 100%;max-width: 550px;max-height: 550px;height:100%;justify-content: center;align-items: center;"
                    src="{{ asset($single_data['attachment']) }}">
            </div>
        </div>
    @endif
@endsection
