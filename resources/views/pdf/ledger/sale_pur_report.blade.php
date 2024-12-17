@extends('pdf.ledger.app') @section('pdf_content')
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
        $startDate = session()->get('Data')['startDate'] ?? null;
        $endDate = session()->get('Data')['endDate'] ?? null;
        // $total_amount = session()->get('Data')['total_amount'] ?? null;
        // $balance_amount = session()->get('Data')['balance_amount'] ?? null;
        // $credit = session()->get('Data')['credit'] ?? null;
        $type = session()->get('Data')['type'] ?? null;
        // $qty_total = session()->get('Data')['qty_total'] ?? null;
        // $dis_total = session()->get('Data')['dis_total'] ?? null;
        // $amount_total = session()->get('Data')['amount_total'] ?? null;
        if (isset(session()->get('Data')['chickenData'])) {
            $chickenData = session()->get('Data')['chickenData'];
        } else {
            $chickenData = [];
        }
        if (isset(session()->get('Data')['chickData'])) {
            $chickData = session()->get('Data')['chickData'];
        } else {
            $chickData = [];
        }
        if (isset(session()->get('Data')['feedData'])) {
            $feedData = session()->get('Data')['feedData'];
        } else {
            $feedData = [];
        }

        $customerCompany = session()->get('Data')['customerCompany'] ?? null;
        $supplierCompany = session()->get('Data')['supplierCompany'] ?? null;

        // dd($chickenData);
        // $grand_total = 0;
        $total_amount = 0;
        $total_sale_amount = 0;
    @endphp
    <style>
        .invoice {
            width: 1170px !important;
        }
    </style>
    <div class="invoice-header">
        <div class="ui left aligned grid">
            <div class="row">
                <div class="left floated left aligned six wide column">
                    <div class="ui">
                        <h1 class="ui header pageTitle">Customer + Supplier Report
                        </h1>
                        <h4 class="ui sub header invDetails">FROM:
                            {{ (new DateTime($startDate))->format('d-m-Y') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TO:
                            {{ (new DateTime($endDate))->format('d-m-Y') }}</h4>
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
        @if ($customerCompany || $supplierCompany)
            <div class="ui card customercard">
                <div class="content">
                    <div class="header">Party Details</div>
                </div>
                @if ($customerCompany && $supplierCompany)
                    <div class="content">
                      <strong>Customer:</strong>  {{ $customerCompany->company_name }}
                    </div>
                    <div class="content">
                        <strong>Supplier:</strong> {{ $supplierCompany->company_name }}
                    </div>
                @elseif ($customerCompany)
                    <div class="content">
                        <strong>Customer:</strong>  {{ $customerCompany->company_name }}
                    </div>
                @elseif($supplierCompany)
                    <div class="content">
                        <strong>Supplier:</strong>   {{ $supplierCompany->company_name }}
                    </div>
                @endif
            </div>
        @endif

        <div class="ui segment itemscard">
            <div class="content">
                @if (count($chickenData) > 0)
                    <h4><b>Chickens</b></h4>
                    <table class="ui celled table" id="invoice-table">
                        <thead>
                            <tr>
                                <th class="text-center colfix date-th">Date</th>
                                <th class="text-center colfix">Invoice No</th>
                                <th class="text-center colfix">Hen Qty</th>
                                <th class="text-center colfix">Avg Weight</th>
                                <th class="text-center colfix">Customer Name</th>
                                <th class="text-center colfix">Crate Qty</th>
                                <th class="text-center colfix">Gross Weight</th>
                                <th class="text-center colfix">Net Weight</th>
                                <th class="text-center colfix">Rate</th>
                                <th class="text-center colfix">Amount</th>

                                <th class="text-center colfix">Supplier Name</th>
                                <th class="text-center colfix">Net Weight</th>
                                <th class="text-center colfix">Rate</th>
                                <th class="text-center colfix">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chickenData as $row)
                                <tr style="text-align: center;">
                                    <td class="text-right" style="width: 100px;">
                                        <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ Route('edit_invoice_chicken', $row->unique_id) }}"
                                            target="__blank"><span>CH-{{ $row->unique_id }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        <span>{{ $row->hen_qty }}</span>
                                    </td>
                                    <td class="text-right">
                                        <span>{{ $row->avg }}</span>
                                    </td>
                                    <td style="text-align: left
                ;">
                                        <span>{{ $row->customer->company_name }}</span>
                                    </td>
                                    <td class="text-right">
                                        <span>{{ $row->crate_qty }}</span>
                                    </td>
                                    <td class="text-right">
                                        <span>{{ $row->gross_weight }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ $row->sale_net_weight }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ $row->sale_rate }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ number_format($row->sale_amount,2) }}</span>
                                        @php $total_sale_amount += $row->sale_amount; @endphp
                                    </td>


                                    <td style="text-align: left
                ;">
                                        <span>{{ $row->supplier->company_name }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ $row->net_weight }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ $row->rate }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ number_format($row->amount,2) }}</span>
                                        @php $total_amount += $row->amount; @endphp
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot class="full-width">
                            <tr>
                                <th colspan="1"></th>
                                <th> Total: </th>
                                <th colspan="1" style="text-align: center;">{{ $chickenData->sum('hen_qty') }}</th>
                                <th colspan="1" style="text-align: center;">
                                    {{ number_format($chickenData->sum('gross_weight') / $chickenData->sum('hen_qty'), 2) }}
                                </th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1" style="text-align:right;"></th>
                                <th colspan="1">{{ $total_sale_amount }}</th>
                                <th colspan="1" style="text-align:right;"> </th>
                                <th colspan="1" style="text-align:right;"> </th>
                                <th colspan="1" style="text-align:right;"> </th>
                                <th colspan="1" style="text-align:right;" id="balance"> {{ $total_amount }} </th>
                            </tr>
                        </tfoot>
                    </table>
                @endif
                @php
                    $total_amount = 0;
                    $total_sale_amount = 0;
                @endphp
                @if (count($chickData) > 0)
                    <h4><b>Chicks</b></h4>
                    <table class="ui celled table" id="invoice-table">
                        <thead>
                            <tr>
                                <th class="text-center colfix date-th">Date</th>
                                <th class="text-center colfix">Invoice No</th>
                                <th class="text-center colfix">Customer Name</th>
                                <th class="text-center colfix">Product</th>
                                <th class="text-center colfix">Rate</th>
                                <th class="text-center colfix">Quantity</th>
                                <th class="text-center colfix">Amount</th>

                                <th class="text-center colfix">Supplier Name</th>
                                <th class="text-center colfix">Rate</th>
                                <th class="text-center colfix">Quantity</th>
                                <th class="text-center colfix">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chickData as $row)
                                <tr style="text-align: center;">
                                    <td class="text-right" style="width: 100px;">
                                        <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ Route('edit_invoice_chick', $row->unique_id) }}"
                                            target="__blank"><span>C-{{ $row->unique_id }}
                                            </span>
                                        </a>
                                    </td>
                                    <td style="text-align: left
                ;">
                                        <span>{{ $row->customer->company_name }}</span>
                                    </td>
                                    <td style="text-align: left
                ;">
                                        <span>{{ $row->product->product_name }}</span>
                                    </td>
                                    <td class="text-right">
                                        <span>{{ $row->sale_rate }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ $row->sale_qty }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ number_format($row->sale_amount,2) }}</span>
                                        @php $total_sale_amount += $row->sale_amount; @endphp
                                    </td>

                                    <td style="text-align: left
                ;">
                                        <span>{{ $row->supplier->company_name }}</span>
                                    </td>
                                    <td class="text-right">
                                        <span>{{ $row->rate }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ $row->qty }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ number_format($row->amount,2) }}</span>
                                        @php $total_amount += $row->amount; @endphp
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot class="full-width">
                            <tr>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th> Total: </th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1">{{ $total_sale_amount }}</th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1" style="text-align:right;"></th>
                                <th colspan="1" style="text-align:right;" id="balance"> {{ $total_amount }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                @endif
                @php
                    $total_amount = 0;
                    $total_sale_amount = 0;
                @endphp
                @if (count($feedData) > 0)
                    <h4><b>Feed</b></h4>
                    <table class="ui celled table" id="invoice-table">
                        <thead>
                            <tr>
                                <th class="text-center colfix date-th">Date</th>
                                <th class="text-center colfix">Invoice No</th>
                                <th class="text-center colfix">Customer Name</th>
                                <th class="text-center colfix">Product</th>

                                <th class="text-center colfix">Rate</th>
                                <th class="text-center colfix">Quantity</th>
                                <th class="text-center colfix">Amount</th>

                                <th class="text-center colfix">Supplier Name</th>
                                <th class="text-center colfix">Rate</th>
                                <th class="text-center colfix">Quantity</th>
                                <th class="text-center colfix">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feedData as $row)
                                <tr style="text-align: center;">
                                    <td class="text-right" style="width: 100px;">
                                        <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ Route('edit_invoice_feed', $row->unique_id) }}"
                                            target="__blank"><span>F-{{ $row->unique_id }}
                                            </span>
                                        </a>
                                    </td>
                                    <td style="text-align: left
                ;">
                                        <span>{{ $row->customer->company_name }}</span>
                                    </td>
                                    <td style="text-align: left
                ;">
                                        <span>{{ $row->product->product_name }}</span>
                                    </td>
                                    <td class="text-right">
                                        <span>{{ $row->sale_rate }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ $row->sale_qty }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ number_format($row->sale_amount,2) }}</span>
                                        @php $total_sale_amount += $row->sale_amount; @endphp
                                    </td>

                                    <td style="text-align: left
                            ;">
                                        <span>{{ $row->supplier->company_name }}</span>
                                    </td>
                                    <td class="text-right">
                                        <span>{{ $row->rate }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ $row->qty }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ number_format($row->amount,2) }}</span>
                                        @php $total_amount += $row->amount; @endphp
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot class="full-width">
                            <tr>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th> Total: </th>
                                <th colspan="1"></th>
                                <th colspan="1" style="text-align:right;">
                                    {{ number_format($feedData->sum('sale_qty'), 2) }}</th>
                                <th colspan="1" style="text-align:right;">{{ number_format($total_sale_amount, 2) }}
                                </th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th colspan="1" style="text-align:right;">
                                    {{ number_format($feedData->sum('qty'), 2) }}</th>
                                <th colspan="1" style="text-align:right;">{{ number_format($total_amount, 2) }}
                                </th>
                                </th>
                            </tr>
                        </tfoot>
                        <h4><b>Feed (In Details)</b></h4>
                        <table class="ui celled table" id="invoice-table">
                            <thead>
                                <tr>
                                    <th class="text-center colfix">Product</th>
                                    <th class="text-center colfix">Purchase Quantity</th>
                                    <th class="text-center colfix">Sale Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($feedData->groupBy('item') as $row)
                                    <tr style="text-align: center;">
                                        <td style="text-align: left
                ;">
                                            <span>{{ $row->first()->product->product_name }}</span>
                                        </td>
                                        <td style="text-align:right;">
                                            <span>{{ $row->sum('qty') }}</span>
                                        </td>
                                        <td style="text-align:right;">
                                            <span>{{ $row->sum('sale_qty') }}</span>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </table>
                @endif
            </div>
        </div>

    </div>
    </div>

    <script></script>
@endsection
