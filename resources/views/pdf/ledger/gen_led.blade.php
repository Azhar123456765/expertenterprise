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
        $startDate = session()->get('Data')['startDate'];
        $endDate = session()->get('Data')['endDate'];
        $single_data = session()->get('Data')['single_data'];
        $chickenInvoice = session()->get('Data')['chickenInvoice'];
        $chickInvoice = session()->get('Data')['chickInvoice'];
        $feedInvoice = session()->get('Data')['feedInvoice'];
        $payment_voucher = session()->get('Data')['payment_voucher'];
        $receipt_voucher = session()->get('Data')['receipt_voucher'];
        $expense_voucher = session()->get('Data')['expense_voucher'];
        $journal_voucher = session()->get('Data')['journal_voucher'];
        $company = session()->get('Data')['account'];
        $type = session()->get('Data')['type'];

        $head_account = session()->get('Data')['head_account'];
        $sub_head_account = session()->get('Data')['sub_head_account'];
        $accounts = session()->get('Data')['accounts'];
        // dd($head_account);
        $credit = 0;
        $debit = 0;
        $balance = 0;
    @endphp
    <div class="invoice-header">
        <div class="ui left aligned grid">
            <div class="row">
                <div class="left floated left aligned six wide column">
                    <div class="ui">
                        <h1 class="ui header pageTitle">General Ledger
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
        @if ($single_data)
            <div class="ui card customercard">
                <div class="content">
                    <div class="header">Account Details</div>
                </div>
                <div class="content">
                    {{ $single_data->account_name }}
                </div>
            </div>
        @endif
        @if ($type == 1)

            <div class="ui segment itemscard">
                <div class="content">
                    @if ($head_account && isset($sub_head_account) && $accounts && $expense_voucher)
                        @foreach ($sub_head_account as $SubHeadRow)
                            <h4><b>{{ $SubHeadRow->name }}</b></h4>

                            <table class="ui celled table" id="invoice-table">
                                <thead>
                                    <tr>
                                        <th class="text-center colfix date-th">Date</th>
                                        <th class="text-center colfix">Reference</th>
                                        <th class="text-center colfix">Description</th>
                                        <th class="text-center colfix">Debit</th>
                                        <th class="text-center colfix">Credit</th>
                                        <th class="text-center colfix">Balance</th>
                                    </tr>
                                </thead>

                                @foreach ($accounts->where('account_category', $SubHeadRow->id) as $AccountRow)
                                    @php
                                        $filteredVouchers = $expense_voucher->filter(function ($voucher) use (
                                            $AccountRow,
                                        ) {
                                            return $voucher->buyer == $AccountRow->id ||
                                                $voucher->cash_bank == $AccountRow->id;
                                        });
                                    @endphp

                                    <tbody>
                                        @foreach ($chickenInvoice as $row)
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
                                                <td style="text-align: left
                                 ;">
                                                    <span>{{ $row->description }}</span>
                                                </td>
                                                <td style="text-align:right;">
                                                    <span>
                                                        @if (!isset($company) || empty($company))
                                                            {{ $row->buyer ? $row->sale_amount_total : 0.0 }}
                                                        @else
                                                            {{ $row->buyer == $company ? $row->sale_amount_total : 0.0 }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td style="text-align:right;">
                                                    <span>
                                                        @if (!isset($company) || empty($company))
                                                            {{ $row->seller ? $row->amount_total : 0.0 }}
                                                        @else
                                                            {{ $row->seller == $company ? $row->amount_total : 0.0 }}
                                                        @endif
                                                    </span>
                                                </td>


                                                <td style="text-align:right;">
                                                    <span>
                                                        @if (!isset($company) || empty($company))
                                                            {{ $balance += $row->amount_total - $row->sale_amount_total }}
                                                        @else
                                                            {{ $row->seller == $company ? ($balance += $row->amount_total) : '' }}
                                                            {{ $row->buyer == $company ? ($balance += $row->sale_amount_total) : '' }}
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            @if (!isset($company) || empty($company))
                                                @php $credit += $row->amount_total; @endphp
                                            @elseif($row->seller == $company)
                                                @php $credit += $row->amount_total @endphp
                                            @endif

                                            @if (!isset($company) || empty($company))
                                                @php $debit += $row->sale_amount_total; @endphp
                                            @elseif($row->buyer == $company)
                                                @php $debit += $row->sale_amount_total @endphp
                                            @endif
                                        @endforeach
                                        @foreach ($chickInvoice as $row)
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
                                                <span>{{ $row->description }},
                                                    {{ $row->seller == $company ? str_replace('.00', '', $row->qty_total) : str_replace('.00', '', $row->sale_qty_total) }}
                                                    Chicks</span>
                                            </td>
                                            <td style="text-align:right;">
                                                <span>
                                                    @if (!isset($company) || empty($company))
                                                        {{ $row->buyer ? $row->sale_amount_total : 0.0 }}
                                                    @else
                                                        {{ $row->buyer == $company ? $row->sale_amount_total : 0.0 }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td style="text-align:right;">
                                                <span>
                                                    @if (!isset($company) || empty($company))
                                                        {{ $row->seller ? $row->amount_total : 0.0 }}
                                                    @else
                                                        {{ $row->seller == $company ? $row->amount_total : 0.0 }}
                                                    @endif
                                                </span>
                                            </td>
        
        
                                            <td style="text-align:right;">
                                                <span>
                                                    @if (!isset($company) || empty($company))
                                                        {{ $balance += $row->amount_total - $row->sale_amount_total }}
                                                    @else
                                                        {{ $row->seller == $company ? ($balance += $row->amount_total) : '' }}
                                                        {{ $row->buyer == $company ? ($balance += $row->sale_amount_total) : '' }}
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        @if (!isset($company) || empty($company))
                                            @php $credit += $row->amount_total; @endphp
                                        @elseif($row->seller == $company)
                                            @php $credit += $row->amount_total @endphp
                                        @endif
        
                                        @if (!isset($company) || empty($company))
                                            @php $debit += $row->sale_amount_total; @endphp
                                        @elseif($row->buyer == $company)
                                            @php $debit += $row->sale_amount_total @endphp
                                        @endif
                                    @endforeach
                                    @foreach ($feedInvoice as $row)
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
                                                <span>{{ $row->description }},
                                                    {{ $row->seller == $company ? str_replace('.00', '', $row->qty_total) : str_replace('.00', '', $row->sale_qty_total) }}
                                                    Bags</span>
                                            </td>
                                            <td style="text-align:right;">
                                                <span>
                                                    @if (!isset($company) || empty($company))
                                                        {{ $row->buyer ? $row->sale_amount_total : 0.0 }}
                                                    @else
                                                        {{ $row->buyer == $company ? $row->sale_amount_total : 0.0 }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td style="text-align:right;">
                                                <span>
                                                    @if (!isset($company) || empty($company))
                                                        {{ $row->seller ? $row->amount_total : 0.0 }}
                                                    @else
                                                        {{ $row->seller == $company ? $row->amount_total : 0.0 }}
                                                    @endif
                                                </span>
                                            </td>
        
        
                                            <td style="text-align:right;">
                                                <span>
                                                    @if (!isset($company) || empty($company))
                                                        {{ $balance += $row->amount_total - $row->sale_amount_total }}
                                                    @else
                                                        {{ $row->seller == $company ? ($balance += $row->amount_total) : '' }}
                                                        {{ $row->buyer == $company ? ($balance += $row->sale_amount_total) : '' }}
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        @if (!isset($company) || empty($company))
                                            @php $credit += $row->amount_total; @endphp
                                        @elseif($row->seller == $company)
                                            @php $credit += $row->amount_total @endphp
                                        @endif
        
                                        @if (!isset($company) || empty($company))
                                            @php $debit += $row->sale_amount_total; @endphp
                                        @elseif($row->buyer == $company)
                                            @php $debit += $row->sale_amount_total @endphp
                                        @endif
                                    @endforeach


                                    @foreach ($payment_voucher as $row)
                                    <tr style="text-align: center;">
                                        <td class="text-right" style="width: 100px;">
                                            <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ Route('payment_voucher.edit', $row->unique_id) }}"
                                                target="__blank"><span>PV-{{ $row->unique_id }}
                                                </span>
                                            </a>
                                        </td>
                                        <td style="text-align: left
                     ;">
                                            <span>{{ $row->narration }}</span>
                                        </td>
                                        <td style="text-align:right;">
                                            <span>
                                                @if (!isset($company) && empty($single_data))
                                                    {{ $row->company ? $row->amount : 0.0 }}
                                                    @php $debit += $row->amount; @endphp
                                                @elseif($row->company == $company)
                                                    {{ $row->amount ?? 0.0 }}
                                                    @php $debit += $row->amount; @endphp
                                                @else
                                                    0.00
                                                @endif
                                            </span>
                                        </td>
                                        <td style="text-align:right;">
                                            <span>
                                                @if (!isset($company) && empty($single_data))
                                                    {{ $row->cash_bank ? $row->amount : 0.0 }}
                                                    @php $credit += $row->amount; @endphp
                                                @elseif($row->cash_bank == $single_data->id)
                                                    {{ $row->amount ?? 0.0 }}
                                                    @php $credit += $row->amount_total; @endphp
                                                @else
                                                    0.00
                                                @endif
                                            </span>
                                        </td>
    
                                        <td style="text-align:right;">
                                            <span>{{ $balance += $row->amount }}</span>
                                        </td>
                                    </tr>
                                @endforeach


                                        @foreach ($expense_voucher as $row)
                                            <tr style="text-align: center;">
                                                <td class="text-right" style="width: 100px;">
                                                    <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{ Route('expense_voucher.edit', $row->unique_id) }}"
                                                        target="__blank"><span>EV-{{ $row->unique_id }}
                                                        </span>
                                                    </a>
                                                </td>
                                                <td style="text-align: left
                         ;">
                                                    <span>{{ $row->narration }}</span>
                                                </td>

                                                @if ($head_account)
                                                    @if ($head_account->id == 5)
                                                        <td style="text-align:right;">
                                                            <span>{{ number_format($row->amount, 2) }}</span>
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <span>0.00</span>
                                                        </td>
                                                        @php $debit += $row->amount; @endphp
                                                    @elseif($head_account->id == 1)
                                                        <td style="text-align:right;">
                                                            <span>0.00</span>
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <span>{{ number_format($row->amount, 2) }}</span>
                                                        </td>
                                                        @php $credit += $row->amount; @endphp
                                                    @endif
                                                @else
                                                    <td style="text-align:right;">
                                                        <span>{{ number_format($row->amount, 2) }}</span>
                                                    </td>
                                                    <td style="text-align:right;">
                                                        <span>{{ number_format($row->amount, 2) }}</span>
                                                    </td>
                                                @endif

                                                <td style="text-align:right;">
                                                    <span>{{ $balance += $row->amount }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="full-width">
                                        <tr>
                                            <th colspan="1"></th>
                                            <th colspan="1"></th>
                                            <th> Total: </th>
                                            <th colspan="1" style="text-align:right;"> {{ $debit }} </th>
                                            <th colspan="1" style="text-align:right;"> {{ $credit }} </th>
                                            <th colspan="1" style="text-align:right;" id="balance">
                                                {{ $balance }}
                                            </th>
                                        </tr>
                                    </tfoot>
                            </table>
                        @endforeach
                    @endforeach
                @elseif(!$head_account)
                    <table class="ui celled table" id="invoice-table">
                        <thead>
                            <tr>
                                <th class="text-center colfix date-th">Date</th>
                                <th class="text-center colfix">Reference</th>
                                <th class="text-center colfix">Description</th>
                                <th class="text-center colfix">Debit</th>
                                <th class="text-center colfix">Credit</th>
                                <th class="text-center colfix">Balance</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- @php
                                $unique_ids = [];
                                $last_unique_id = null;
                                $last_row_key = null;
                            @endphp --}}
                            @foreach ($chickenInvoice as $row)
                                @if (!$company)
                                    @php
                                        $company;
                                    @endphp
                                @endif
                                {{-- @php
                                    if ($last_unique_id !== $row->unique_id) {
                                        $last_unique_id = $row->unique_id;
                                        $last_row_key = $key;
                                    }
                                    $last_unique_id = $row->unique_id;
                                    $next_key = $key + 1;
                                    $next_unique_id = isset($invoice[$next_key])
                                        ? $invoice[$next_key]->unique_id
                                        : null;
                                @endphp --}}
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
                                    <td style="text-align: left
                     ;">
                                        <span>{{ $row->description }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) || empty($company))
                                                {{ $row->buyer ? $row->sale_amount_total : 0.0 }}
                                            @else
                                                {{ $row->buyer == $company ? $row->sale_amount_total : 0.0 }}
                                            @endif
                                        </span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) || empty($company))
                                                {{ $row->seller ? $row->amount_total : 0.0 }}
                                            @else
                                                {{ $row->seller == $company ? $row->amount_total : 0.0 }}
                                            @endif
                                        </span>
                                    </td>


                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) || empty($company))
                                                {{ $balance += $row->amount_total - $row->sale_amount_total }}
                                            @else
                                                {{ $row->seller == $company ? ($balance += $row->amount_total) : '' }}
                                                {{ $row->buyer == $company ? ($balance += $row->sale_amount_total) : '' }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                @if (!isset($company) || empty($company))
                                    @php $credit += $row->amount_total; @endphp
                                @elseif($row->seller == $company)
                                    @php $credit += $row->amount_total @endphp
                                @endif

                                @if (!isset($company) || empty($company))
                                    @php $debit += $row->sale_amount_total; @endphp
                                @elseif($row->buyer == $company)
                                    @php $debit += $row->sale_amount_total @endphp
                                @endif
                            @endforeach
                            @foreach ($chickInvoice as $row)
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
                                        <span>{{ $row->description }},
                                            {{ $row->seller == $company ? str_replace('.00', '', $row->qty_total) : str_replace('.00', '', $row->sale_qty_total) }}
                                            Chicks</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) || empty($company))
                                                {{ $row->buyer ? $row->sale_amount_total : 0.0 }}
                                            @else
                                                {{ $row->buyer == $company ? $row->sale_amount_total : 0.0 }}
                                            @endif
                                        </span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) || empty($company))
                                                {{ $row->seller ? $row->amount_total : 0.0 }}
                                            @else
                                                {{ $row->seller == $company ? $row->amount_total : 0.0 }}
                                            @endif
                                        </span>
                                    </td>


                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) || empty($company))
                                                {{ $balance += $row->amount_total - $row->sale_amount_total }}
                                            @else
                                                {{ $row->seller == $company ? ($balance += $row->amount_total) : '' }}
                                                {{ $row->buyer == $company ? ($balance += $row->sale_amount_total) : '' }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                @if (!isset($company) || empty($company))
                                    @php $credit += $row->amount_total; @endphp
                                @elseif($row->seller == $company)
                                    @php $credit += $row->amount_total @endphp
                                @endif

                                @if (!isset($company) || empty($company))
                                    @php $debit += $row->sale_amount_total; @endphp
                                @elseif($row->buyer == $company)
                                    @php $debit += $row->sale_amount_total @endphp
                                @endif
                            @endforeach
                            @foreach ($feedInvoice as $row)
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
                                        <span>{{ $row->description }},
                                            {{ $row->seller == $company ? str_replace('.00', '', $row->qty_total) : str_replace('.00', '', $row->sale_qty_total) }}
                                            Bags</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) || empty($company))
                                                {{ $row->buyer ? $row->sale_amount_total : 0.0 }}
                                            @else
                                                {{ $row->buyer == $company ? $row->sale_amount_total : 0.0 }}
                                            @endif
                                        </span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) || empty($company))
                                                {{ $row->seller ? $row->amount_total : 0.0 }}
                                            @else
                                                {{ $row->seller == $company ? $row->amount_total : 0.0 }}
                                            @endif
                                        </span>
                                    </td>


                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) || empty($company))
                                                {{ $balance += $row->amount_total - $row->sale_amount_total }}
                                            @else
                                                {{ $row->seller == $company ? ($balance += $row->amount_total) : '' }}
                                                {{ $row->buyer == $company ? ($balance += $row->sale_amount_total) : '' }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                @if (!isset($company) || empty($company))
                                    @php $credit += $row->amount_total; @endphp
                                @elseif($row->seller == $company)
                                    @php $credit += $row->amount_total @endphp
                                @endif

                                @if (!isset($company) || empty($company))
                                    @php $debit += $row->sale_amount_total; @endphp
                                @elseif($row->buyer == $company)
                                    @php $debit += $row->sale_amount_total @endphp
                                @endif
                            @endforeach
                            @foreach ($payment_voucher as $row)
                                <tr style="text-align: center;">
                                    <td class="text-right" style="width: 100px;">
                                        <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ Route('payment_voucher.edit', $row->unique_id) }}"
                                            target="__blank"><span>PV-{{ $row->unique_id }}
                                            </span>
                                        </a>
                                    </td>
                                    <td style="text-align: left
                 ;">
                                        <span>{{ $row->narration }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) && empty($single_data))
                                                {{ $row->company ? $row->amount : 0.0 }}
                                                @php $debit += $row->amount; @endphp
                                            @elseif($row->company == $company)
                                                {{ $row->amount ?? 0.0 }}
                                                @php $debit += $row->amount; @endphp
                                            @else
                                                0.00
                                            @endif
                                        </span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) && empty($single_data))
                                                {{ $row->cash_bank ? $row->amount : 0.0 }}
                                                @php $credit += $row->amount; @endphp
                                            @elseif($row->cash_bank == $single_data->id)
                                                {{ $row->amount ?? 0.0 }}
                                                @php $credit += $row->amount_total; @endphp
                                            @else
                                                0.00
                                            @endif
                                        </span>
                                    </td>

                                    <td style="text-align:right;">
                                        <span>{{ $balance += $row->amount }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($receipt_voucher as $row)
                                <tr style="text-align: center;">
                                    <td class="text-right" style="width: 100px;">
                                        <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ Route('receipt_voucher.edit', $row->unique_id) }}"
                                            target="__blank"><span>RV-{{ $row->unique_id }}
                                            </span>
                                        </a>
                                    </td>
                                    <td style="text-align: left
                 ;">
                                        <span>{{ $row->narration }}</span>
                                    </td>


                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) && empty($single_data))
                                                {{ $row->cash_bank ? $row->amount : 0.0 }}
                                                @php $debit += $row->amount; @endphp
                                            @elseif($row->cash_bank == $single_data->id)
                                                {{ $row->amount ?? 0.0 }}
                                                @php $debit += $row->amount_total; @endphp
                                            @else
                                                0.00
                                            @endif
                                        </span>
                                    </td>

                                    <td style="text-align:right;">
                                        <span>
                                            @if (!isset($company) && empty($single_data))
                                                {{ $row->company ? $row->amount : 0.0 }}
                                                @php $credit += $row->amount; @endphp
                                            @elseif($row->company == $company)
                                                {{ $row->amount ?? 0.0 }}
                                                @php $credit += $row->amount; @endphp
                                            @else
                                                0.00
                                            @endif
                                        </span>
                                    </td>



                                    <td style="text-align:right;">
                                        <span>{{ $balance -= $row->amount }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($expense_voucher as $row)
                                <tr style="text-align: center;">
                                    <td class="text-right" style="width: 100px;">
                                        <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ Route('expense_voucher.edit', $row->unique_id) }}"
                                            target="__blank"><span>EV-{{ $row->unique_id }}
                                            </span>
                                        </a>
                                    </td>
                                    <td style="text-align: left
                 ;">
                                        <span>{{ $row->narration }}</span>
                                    </td>

                                    @if ($single_data)
                                        @if ($single_data->account_category == 9 || $single_data->account_category == 10 || $single_data->account_category == 11)
                                            <td style="text-align:right;">
                                                <span>{{ number_format($row->amount, 2) }}</span>
                                            </td>
                                            <td style="text-align:right;">
                                                <span>0.00</span>
                                            </td>
                                            @php $debit += $row->amount; @endphp
                                        @else
                                            <td style="text-align:right;">
                                                <span>0.00</span>
                                            </td>
                                            <td style="text-align:right;">
                                                <span>{{ number_format($row->amount, 2) }}</span>
                                            </td>
                                            @php $credit += $row->amount; @endphp
                                        @endif
                                    @else
                                        <td style="text-align:right;">
                                            <span>{{ number_format($row->amount, 2) }}</span>
                                        </td>
                                        <td style="text-align:right;">
                                            <span>{{ number_format($row->amount, 2) }}</span>
                                        </td>
                                    @endif

                                    <td style="text-align:right;">
                                        <span>{{ $balance += $row->amount }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($journal_voucher as $row)
                                <tr style="text-align: center;">
                                    <td class="text-right" style="width: 100px;">
                                        <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ Route('journal-voucher.edit', $row->unique_id) }}"
                                            target="__blank"><span>JV-{{ $row->unique_id }}
                                            </span>
                                        </a>
                                    </td>
                                    <td style="text-align: left
                 ;">
                                        <span>{{ $row->narration }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>
                                            @if ($single_data)
                                                @if ($single_data->id == $row->from_account && $row->status == 'credit')
                                                    {{ $row->amount ?? 0.0 }}
                                                @elseif($single_data->id == $row->to_account && $row->status == 'debit')
                                                    {{ $row->amount ?? 0.0 }}
                                                @endif
                                            @else
                                                {{ $row->amount ?? 0.0 }}
                                            @endif
                                        </span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>
                                            @if ($single_data)
                                                @if ($single_data->id == $row->to_account && $row->status == 'credit')
                                                    {{ $row->amount ?? 0.0 }}
                                                @elseif($single_data->id == $row->from_account && $row->status == 'debit')
                                                    {{ $row->amount ?? 0.0 }}
                                                @elseif($single_data->id == $row->from_account && $row->status == 'debit')
                                                    {{ $row->amount ?? 0.0 }}
                                                @endif
                                            @else
                                                {{ $row->amount ?? 0.0 }}
                                            @endif
                                        </span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span>{{ $balance += $row->amount }}</span>
                                    </td>
                                </tr>
                                @if ($single_data)
                                    @if ($single_data->id == $row->from_account && $row->status == 'credit')
                                        @php $debit += $row->amount; @endphp
                                    @elseif($single_data->id == $row->to_account && $row->status == 'debit')
                                        @php $debit += $row->amount; @endphp
                                    @endif
                                @endif
                                @if ($single_data)
                                    @if ($single_data->id == $row->to_account && $row->status == 'credit')
                                        @php $credit += $row->amount; @endphp
                                    @elseif($single_data->id == $row->from_account && $row->status == 'debit')
                                        @php $credit += $row->amount; @endphp
                                    @elseif($single_data->id == $row->from_account && $row->status == 'debit')
                                        @php $credit += $row->amount; @endphp
                                    @endif
                                @endif
                            @endforeach

                        </tbody>
                        <tfoot class="full-width">
                            <tr>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                                <th> Total: </th>
                                <th colspan="1" style="text-align:right;"> {{ $debit }} </th>
                                <th colspan="1" style="text-align:right;"> {{ $credit }} </th>
                                <th colspan="1" style="text-align:right;" id="balance"> {{ $balance }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
        @endif
    </div>
    </div>
@elseif($type == 2)
    <div class="ui segment itemscard">
        <div class="content">
            <table class="ui celled table" id="invoice-table">
                <thead>
                    <tr>
                        <th class="text-center colfix date-th">Date</th>
                        <th class="text-center colfix">Reference</th>
                        <th class="text-center colfix">Description</th>
                        <th class="text-center colfix">Debit</th>
                        <th class="text-center colfix">Credit</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $unique_ids = [];
                        $last_unique_id = null;
                        $last_row_key = null;
                    @endphp
                    @foreach ($chickenInvoice as $row)
                        @if (!$company)
                            @php
                                $company;

                            @endphp
                        @endif
                        @php
                            $rv_total = 0;
                            $pv_total = 0;
                            $deb_jv_total = 0;
                            $cred_jv_total = 0;
                        @endphp
                        <td colspan="8" style="border: none !important;">&nbsp;</td>
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
                            <td style="text-align: left
                ;">
                                <span>{{ $row->description }}</span>
                            </td>
                            <td style="text-align:right;">
                                <span>
                                    @if (!isset($company) || empty($company))
                                        {{ $row->seller ? $row->amount_total : 0.0 }}
                                    @else
                                        {{ $row->seller == $company ? $row->amount_total : 0.0 }}
                                    @endif
                                </span>
                            </td>

                            <td style="text-align:right;">
                                <span>
                                    @if (!isset($company) || empty($company))
                                        {{ $row->buyer ? $row->sale_amount_total : 0.0 }}
                                    @else
                                        {{ $row->buyer == $company ? $row->sale_amount_total : 0.0 }}
                                    @endif
                                </span>
                            </td>

                        </tr>
                        @if (!isset($company) || empty($company))
                            @php $debit += $row->amount_total; @endphp
                        @elseif($row->seller == $company)
                            @php $debit += $row->amount_total @endphp
                        @endif

                        @if (!isset($company) || empty($company))
                            @php $credit += $row->sale_amount_total; @endphp
                        @elseif($row->buyer == $company)
                            @php $credit += $row->sale_amount_total @endphp
                        @endif


                        @foreach ($payment_voucher->where('invoice_no', 'CH-' . $row->unique_id) as $row2)
                            <tr style="text-align: center;">
                                <td class="text-right" style="width: 100px;">
                                    <span>{{ (new DateTime($row2->date))->format('d-m-Y') }}</span>
                                </td>
                                <td class="text-right">
                                    <span>PV-{{ $row2->unique_id }}</span>
                                </td>
                                <td style="text-align: left
            ;">
                                    <span>{{ $row2->narration }}</span>
                                </td>
                                <td style="text-align:right;">
                                    <span>0.00</span>
                                </td>
                                <td style="text-align:right;">
                                    <span>{{ $row2->amount }}</span>
                                </td>

                            </tr>
                            @php
                                $credit += $row2->amount_total;
                                $pv_total += $row2->amount;
                            @endphp
                        @endforeach
                        @foreach ($receipt_voucher->where('invoice_no', 'CH-' . $row->unique_id) as $row2)
                            <tr style="text-align: center;">
                                <td class="text-right" style="width: 100px;">
                                    <span>{{ (new DateTime($row2->date))->format('d-m-Y') }}</span>
                                </td>
                                <td class="text-right">
                                    <span>RV-{{ $row2->unique_id }}</span>
                                </td>
                                <td style="text-align: left
            ;">
                                    <span>{{ $row2->narration }}</span>
                                </td>
                                <td style="text-align:right;">
                                    <span>{{ $row2->amount }}</span>
                                </td>

                                <td style="text-align:right;">
                                    <span>0.00</span>
                                </td>
                            </tr>
                            @php
                                $debit += $row2->amount_total;
                                $rv_total += $row2->amount;
                            @endphp
                        @endforeach
                <tfoot style="color: green; font-weight: bolder ;">
                    <tr>
                        <td colspan="3" style="text-align:right; border: none !important; "><span
                                style="color:blue;">CH-{{ $row->unique_id }}'s</span> &nbsp; Remaining Total:
                        </td>
                        <td style="text-align:right; background-color: lightgray;">
                            {{ $row->amount_total - $rv_total }}</td>
                        <td style="text-align:right; background-color: lightgray;">
                            {{ $row->sale_amount_total - $pv_total }}</td>
                    </tr>
                </tfoot>
                @endforeach
                @foreach ($chickInvoice as $row)
                    @php
                        $rv_total = 0;
                        $pv_total = 0;
                    @endphp
                    <td colspan="8" style="border: none !important;">&nbsp;</td>
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
                            <span>{{ $row->description }}</span>
                        </td>
                        <td style="text-align:right;">
                            <span>
                                @if (!isset($company) || empty($company))
                                    {{ $row->seller ? $row->amount_total : 0.0 }}
                                @else
                                    {{ $row->seller == $company ? $row->amount_total : 0.0 }}
                                @endif
                            </span>
                        </td>

                        <td style="text-align:right;">
                            <span>
                                @if (!isset($company) || empty($company))
                                    {{ $row->buyer ? $row->sale_amount_total : 0.0 }}
                                @else
                                    {{ $row->buyer == $company ? $row->sale_amount_total : 0.0 }}
                                @endif
                            </span>
                        </td>

                    </tr>
                    @if (!isset($company) || empty($company))
                        @php $debit += $row->amount_total; @endphp
                    @elseif($row->seller == $company)
                        @php $debit += $row->amount_total @endphp
                    @endif

                    @if (!isset($company) || empty($company))
                        @php $credit += $row->sale_amount_total; @endphp
                    @elseif($row->buyer == $company)
                        @php $credit += $row->sale_amount_total @endphp
                    @endif

                    @foreach ($payment_voucher->where('invoice_no', 'C-' . $row->unique_id) as $row2)
                        <tr style="text-align: center;">
                            <td class="text-right" style="width: 100px;">
                                <span>{{ (new DateTime($row2->date))->format('d-m-Y') }}</span>
                            </td>
                            <td class="text-right">
                                <span>PV-{{ $row2->unique_id }}</span>
                            </td>
                            <td style="text-align: left
;">
                                <span>{{ $row2->narration }}</span>
                            </td>
                            <td style="text-align:right;">
                                <span>0.00</span>
                            </td>
                            <td style="text-align:right;">
                                <span>{{ $row2->amount }}</span>
                            </td>

                        </tr>
                        @php
                            $credit += $row2->amount_total;
                            $pv_total += $row2->amount;
                        @endphp
                    @endforeach
                    @foreach ($receipt_voucher->where('invoice_no', 'C-' . $row->unique_id) as $row2)
                        <tr style="text-align: center;">
                            <td class="text-right" style="width: 100px;">
                                <span>{{ (new DateTime($row2->date))->format('d-m-Y') }}</span>
                            </td>
                            <td class="text-right">
                                <span>RV-{{ $row2->unique_id }}</span>
                            </td>
                            <td style="text-align: left
;">
                                <span>{{ $row2->narration }}</span>
                            </td>
                            <td style="text-align:right;">
                                <span>{{ $row2->amount }}</span>
                            </td>

                            <td style="text-align:right;">
                                <span>0.00</span>
                            </td>
                        </tr>
                        @php
                            $debit += $row2->amount_total;
                            $rv_total += $row2->amount;
                        @endphp
                    @endforeach
                    @foreach ($journal_voucher->where('invoice_no', 'C-' . $row2->unique_id) as $row2)
                        <tr style="text-align: center;">
                            <td class="text-right" style="width: 100px;">
                                <span>{{ (new DateTime($row2->date))->format('d-m-Y') }}</span>
                            </td>
                            <td class="text-right">
                                <span>JV-{{ $row2->unique_id }}</span>
                            </td>
                            <td style="text-align: left
;">
                                <span>{{ $row2->narration }}</span>
                            </td>
                            <td style="text-align:right;">
                                <span>
                                    @if ($single_data)
                                        @if ($single_data->id == $row2->from_account && $row2->status == 'credit')
                                            {{ $row2->amount ?? 0.0 }}
                                        @elseif($single_data->id == $row2->to_account && $row2->status == 'debit')
                                            {{ $row2->amount ?? 0.0 }}
                                        @endif
                                    @else
                                        {{ $row2->amount ?? 0.0 }}
                                    @endif
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <span>
                                    @if ($single_data)
                                        @if ($single_data->id == $row2->to_account && $row2->status == 'credit')
                                            {{ $row2->amount ?? 0.0 }}
                                        @elseif($single_data->id == $row2->from_account && $row2->status == 'debit')
                                            {{ $row2->amount ?? 0.0 }}
                                        @elseif($single_data->id == $row2->from_account && $row2->status == 'debit')
                                            {{ $row2->amount ?? 0.0 }}
                                        @endif
                                    @else
                                        {{ $row2->amount ?? 0.0 }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @if ($single_data)
                            @if ($single_data->id == $row2->from_account && $row2->status == 'credit')
                                @php
                                    $debit += $row2->amount;
                                    $deb_jv_total += $row2->amount;
                                @endphp
                            @elseif($single_data->id == $row2->to_account && $row2->status == 'debit')
                                @php
                                    $debit += $row2->amount;
                                    $deb_jv_total += $row2->amount;
                                @endphp
                            @endif
                        @else
                            @php
                                $debit += $row2->amount;
                                $deb_jv_total += $row2->amount;
                            @endphp
                        @endif
                        @if ($single_data)
                            @if ($single_data->id == $row2->to_account && $row2->status == 'credit')
                                @php
                                    $credit += $row2->amount;
                                    $cred_jv_total += $row2->amount;
                                @endphp
                            @elseif($single_data->id == $row2->from_account && $row2->status == 'debit')
                                @php
                                    $credit += $row2->amount;
                                    $cred_jv_total += $row2->amount;
                                @endphp
                            @elseif($single_data->id == $row2->from_account && $row2->status == 'debit')
                                @php
                                    $credit += $row2->amount;
                                    $cred_jv_total += $row2->amount;
                                @endphp
                            @endif
                        @else
                            @php
                                $credit += $row2->amount;
                                $cred_jv_total += $row2->amount;
                            @endphp
                        @endif
                    @endforeach
                    <tfoot style="color: green; font-weight: bolder ;">
                        <tr>
                            <td colspan="3" style="text-align:right; border: none !important; "><span
                                    style="color:blue;">C-{{ $row->unique_id }}'s</span> &nbsp; Remaining Total:</td>
                            <td style="text-align:right; background-color: lightgray;">
                                {{ $row->amount_total - $rv_total - $deb_jv_total }}</td>
                            <td style="text-align:right; background-color: lightgray;">
                                {{ $row->sale_amount_total - $pv_total - $cred_jv_total }}</td>
                        </tr>
                    </tfoot>
                @endforeach
                @foreach ($feedInvoice as $row)
                    @php
                        $rv_total = 0;
                        $pv_total = 0;
                    @endphp
                    <td colspan="8" style="border: none !important;">&nbsp;</td>
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
                            <span>{{ $row->description }},
                                {{ $row->seller == $company ? str_replace('.00', '', $row->qty_total) : str_replace('.00', '', $row->sale_qty_total) }}
                                Bags</span>
                        </td>
                        <td style="text-align:right;">
                            <span>
                                @if (!isset($company) || empty($company))
                                    {{ $row->seller ? $row->amount_total : 0.0 }}
                                @else
                                    {{ $row->seller == $company ? $row->amount_total : 0.0 }}
                                @endif
                            </span>
                        </td>

                        <td style="text-align:right;">
                            <span>
                                @if (!isset($company) || empty($company))
                                    {{ $row->buyer ? $row->sale_amount_total : 0.0 }}
                                @else
                                    {{ $row->buyer == $company ? $row->sale_amount_total : 0.0 }}
                                @endif
                            </span>
                        </td>

                    </tr>
                    @if (!isset($company) || empty($company))
                        @php $debit += $row->amount_total; @endphp
                    @elseif($row->seller == $company)
                        @php $debit += $row->amount_total @endphp
                    @endif

                    @if (!isset($company) || empty($company))
                        @php $credit += $row->sale_amount_total; @endphp
                    @elseif($row->buyer == $company)
                        @php $credit += $row->sale_amount_total @endphp
                    @endif


                    @foreach ($payment_voucher->where('invoice_no', 'F-' . $row->unique_id) as $row2)
                        <tr style="text-align: center;">
                            <td class="text-right" style="width: 100px;">
                                <span>{{ (new DateTime($row2->date))->format('d-m-Y') }}</span>
                            </td>
                            <td class="text-right">
                                <span>PV-{{ $row2->unique_id }}</span>
                            </td>
                            <td style="text-align: left
;">
                                <span>{{ $row2->narration }}</span>
                            </td>
                            <td style="text-align:right;">
                                <span>0.00</span>
                            </td>
                            <td style="text-align:right;">
                                <span>{{ $row2->amount }}</span>
                            </td>

                        </tr>
                        @php
                            $credit += $row2->amount_total;
                            $pv_total += $row2->amount;
                        @endphp
                    @endforeach
                    @foreach ($receipt_voucher->where('invoice_no', 'F-' . $row->unique_id) as $row2)
                        <tr style="text-align: center;">
                            <td class="text-right" style="width: 100px;">
                                <span>{{ (new DateTime($row2->date))->format('d-m-Y') }}</span>
                            </td>
                            <td class="text-right">
                                <span>RV-{{ $row2->unique_id }}</span>
                            </td>
                            <td style="text-align: left
;">
                                <span>{{ $row2->narration }}</span>
                            </td>
                            <td style="text-align:right;">
                                <span>{{ $row2->amount }}</span>
                            </td>

                            <td style="text-align:right;">
                                <span>0.00</span>
                            </td>
                        </tr>
                        @php
                            $debit += $row2->amount_total;
                            $rv_total += $row2->amount;
                        @endphp
                    @endforeach
                    <tfoot style="color: green; font-weight: bolder ;">
                        <tr>
                            <td colspan="3" style="text-align:right; border: none !important; "><span
                                    style="color:blue;">F-{{ $row->unique_id }}'s</span> &nbsp; Remaining Total:</td>
                            <td style="text-align:right; background-color: lightgray;">
                                {{ $row->amount_total - $rv_total }}</td>
                            <td style="text-align:right; background-color: lightgray;">
                                {{ $row->sale_amount_total - $pv_total }}</td>
                        </tr>
                    </tfoot>
                @endforeach


                @foreach ($expense_voucher as $row)
                    <tr style="text-align: center;">
                        <td class="text-right" style="width: 100px;">
                            <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                        </td>
                        <td class="text-right">
                            <a href="{{ Route('expense_voucher.edit', $row->unique_id) }}"
                                target="__blank"><span>EV-{{ $row->unique_id }}
                                </span>
                            </a>
                        </td>
                        <td style="text-align: left
            ;">
                            <span>{{ $row->narration }}</span>
                        </td>

                        <td style="text-align:right;">
                            <span>{{ number_format($row->amount, 2) }}</span>
                        </td>
                        <td style="text-align:right;">
                            <span>0.00</span>
                        </td>
                    </tr>
                    @php $credit += $row->amount; @endphp
                @endforeach
                </tbody>
                <tfoot class="full-width">
                    <tr>
                        <th colspan="1"></th>
                        <th colspan="1"></th>
                        <th> Total: </th>
                        <th colspan="1" style="text-align:right;"> {{ $debit }} </th>
                        <th colspan="1" style="text-align:right;"> {{ $credit }} </th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
    @endif
    </div>
    </div>

    @if ($type == 1)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                sortTableByDate(); // Sort on document ready
                calculateClosingBalance();
            });

            function sortTableByDate() {
                const table = document.getElementById('invoice-table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));

                rows.sort((rowA, rowB) => {
                    const dateA = parseDate(rowA.cells[0].textContent.trim());
                    const dateB = parseDate(rowB.cells[0].textContent.trim());
                    return dateA - dateB; // For ascending order
                });

                rows.forEach(row => tbody.appendChild(row)); // Reorder rows
            }

            function parseDate(dateStr) {
                const [day, month, year] = dateStr.split('-').map(Number);
                return new Date(year, month - 1, day); // JavaScript Date object uses 0-based month
            }

            function calculateClosingBalance() {
                const table = document.getElementById('invoice-table');
                const tbody = table.querySelector('tbody');
                const rows = tbody.querySelectorAll('tr');

                let runningBalance = 0; // Initialize running balance

                rows.forEach(row => {
                    // Fetch the values from Credit and Debit columns
                    const creditText = row.cells[3].textContent.trim();
                    const debitText = row.cells[4].textContent.trim();

                    // Parse the values to float, accounting for potential empty values
                    const credit = parseFloat(creditText.replace(/,/g, '') || '0');
                    const debit = parseFloat(debitText.replace(/,/g, '') || '0');

                    // Update the running balance
                    runningBalance += credit;
                    runningBalance -= debit;

                    // Update the Closing Balance column with the new value
                    row.cells[5].textContent = runningBalance.toFixed(2); // Format to 2 decimal places

                    // Log for debugging
                    console.log(
                        `Row: ${row.rowIndex}, Credit: ${credit}, Debit: ${debit}, Running Balance: ${runningBalance.toFixed(2)}`
                    );
                });

                // Update the <th> element with id "balance" with the last sum of the running balance
                const balanceHeader = document.getElementById('balance');
                if (balanceHeader) {
                    balanceHeader.textContent = runningBalance.toFixed(2); // Display the final running balance
                }
            }
        </script>
    @endif

@endsection
