<!DOCTYPE html>
<html lang="en">
@php

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

    $chickenInvoice = session()->get('Data')['chickenInvoice'];
    $chickInvoice = session()->get('Data')['chickInvoice'];
    $feedInvoice = session()->get('Data')['feedInvoice'];
    $payment_voucher = session()->get('Data')['payment_voucher'];
    $receipt_voucher = session()->get('Data')['receipt_voucher'];
    $expense_voucher = session()->get('Data')['expense_voucher'];
    $journal_voucher = session()->get('Data')['journal_voucher'];

    $heads = session()->get('Data')['heads'] ?? null;
    $sub_heads = session()->get('Data')['sub_heads'] ?? null;
    $accounts = session()->get('Data')['accounts'] ?? null;

@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Sheet</title>
    <style>
        /*CSS Selectors*/
        html {
            /*reset box model*/
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            color: #0a0a23;
        }

        /*Select any span with "sr-only class"*/
        span[class~="sr-only"]

        /*elem are hidden visually*/
            {
            border: 0 !important;
            clip: rect(1px,
                    1px,
                    1px,
                    1px) !important;
            /*define the visible portions of an element*/
            clip-path: inset(50%) !important;
            /*determines the shape the clip*/
            width: 1px !important;
            height: 1px !important;
            overflow: hidden !important;
            white-space: nowrap !important;
            position: absolute !important;
            padding: 0 !important;
            margin: -1px !important;
        }

        /*Table Heading*/
        h1 {
            max-width: 37.25rem;
            margin: 0 auto;
            padding: 1.5rem 1.25rem;
        }

        /*Target flex container*/
        h1 .flex {
            display: flex;
            /*enable flexbox layout*/
            /*display the elem from bottom to top*/
            justify-content: space-between;
            gap: 1rem;
            /*create space between elem*/
        }

        /*Pseudo Selector*/
        /*target first span in the .flex container*/
        h1 .flex span:first-of-type {
            font-size: 0.7em;
            /*make to look like a sub-heading*/
        }

        h1 .flex span:last-of-type {
            font-size: 1.2em;
        }

        section {
            /*center the table and create a border*/
            max-width: 50rem;
            margin: 0 auto;
            border: 2px solid #d0d0d5;
        }

        /*ID Selector*/
        /*Years*/
        #years {
            display: flex;
            /*enable flexbox*/
            justify-content: flex-end;
            /*move to the right*/
            position: sticky;
            top: 0;
            /*fix to the top*/
            color: #fff;
            background-color: #0a0a23;
            margin: 0 -2px;
            padding: 0.5rem calc(1.25rem + 2px) 0.5rem 0;
            /*allows to calculate a value based on other values*/
            z-index: 999;
        }

        /*target any "span" elem*/
        #years span[class] {
            /* move years to the right*/
            font-weight: bold;
            width: 4.5rem;
            text-align: right;
        }

        /*Class Selectors*/
        /*Table container*/
        .table-wrap {
            padding: 0 0.75rem 1.5rem 0.75rem;
        }

        table {
            border-collapse: collapse;
            /*allow cell borders to collapse into a single border*/
            border: 0;
            /*hide the borders themselves*/
            width: 100%;
            margin-top: 3rem;
            position: relative;
        }

        /*Captions*/
        table caption {
            /*header tables*/
            color: #356eaf;
            font-size: 1.3em;
            font-weight: normal;
            position: absolute;
            top: -2.25rem;
            left: 0.5rem;
        }

        /*Table Cells*/
        /*target td elem within table body*/
        tbody td {
            width: 100vw;
            /*fill the viewport*/
            max-width: 4rem;
            min-width: 4rem;
        }

        /*Data Cell*/
        tbody th {
            width: calc(100% - 12rem);
            /*width of the entire container, less 12rem*/
        }

        /* target tr elements with the total class*/
        tr[class="total"] {
            border-bottom: 4px double #0a0a23;
            font-weight: bold;
        }

        /* target the th elements within your table rows */
        tr[class="total"] th {
            text-align: left;
            padding: 0.5rem 0 0.25rem 0.5rem;
        }

        /*target all td elements within .total rows.*/
        tr.total td {
            text-align: right;
            padding: 0 0.25rem;
        }

        /*pseudo-selector to target the third td element within your total table rows*/
        tr.total td:nth-of-type(3) {
            padding: 0.5rem;
        }

        tr.total:hover {
            background-color: #99c9ff;
        }

        /*Select the td elements with the class value of current*/
        td.current {
            font-style: italic;
        }

        tr.data {
            background-image: linear-gradient(to bottom,
                    #dfdfe2 1.845rem,
                    white 1.845rem);
        }

        tr.data th {
            text-align: left;
            padding-top: 0.3rem;
            padding-left: 0.5rem;
        }

        /*target the elements with the class set to description that are within  th elements in .data table rows*/
        tr.data th .description {
            display: block;
            font-style: italic;
            font-weight: normal;
            padding: 1rem 0 0.75rem;
            margin-right: -13.5rem;
        }

        tr.data td {
            text-align: right;
            vertical-align: top;
            horizontally-align: right;
            padding: 0.3rem 0.25rem 0;
        }

        tr.data td:last-of-type {
            padding: 0.5rem;
        }

        .year {
            width: 100% !important;
        }
    </style>
</head>

<body>
    <main>
        <section>
            <h1><span class="flex">
                    <div class="">
                        <span>Balance Sheet</span>
                        <br>
                        <span>Balance Sheet</span>
                    </div>
                    <img class="logo"
                        src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($logo))) }}"
                        width="50px" />
                </span></h1>
            <!--Years -->
            <div id="years" aria-hidden="true">
                <span class="year">2020 TO 2021</span>
            </div>
            <!--Tables -->
            <div class="table-wrap">
                <!--Liabilities -->
                @foreach ($heads as $headRow)
                    <table>
                        <caption>{{ $headRow->name }}</caption>

                        <tbody>
                            @php $totalHeadAmount = 0; @endphp

                            @foreach ($sub_heads->where('head', $headRow->id) as $subRow)
                                <tr class="data">
                                    <th>{{ $subRow->name }}</th>
                                    <th style="text-align: end;">
                                        @if ($headRow->id == 1)
                                            @php
                                                $totalDebit = 0;
                                                $totalCredit = 0;
                                                $accountDetails = $accounts->where('account_category', $subRow->id);

                                                foreach ($accountDetails as $accountDetailsRow) {
                                                    $chickenInvoiceAmount = $chickInvoiceAmount = $feedInvoiceAmount = 0;
                                                    $PVAmount = $RVAmount = $EVAmount = $JVAmount = 0;

                                                    $chickenInvoiceAmount = $chickenInvoice
                                                        ->where('buyer', $accountDetailsRow->reference_id)
                                                        ->sum('amount');
                                                    $totalCredit += max($chickenInvoiceAmount, 0);
                                                    $totalDebit +=
                                                        $chickenInvoiceAmount < 0
                                                            ? ($chickenInvoiceAmount = $chickenInvoice
                                                                ->where('seller', $accountDetailsRow->reference_id)
                                                                ->sum('amount'))
                                                            : 0;

                                                    $chickInvoiceAmount = $chickInvoice
                                                        ->where('buyer', $accountDetailsRow->reference_id)
                                                        ->sum('amount');
                                                    $totalCredit += max($chickInvoiceAmount, 0);
                                                    $totalDebit +=
                                                        $chickInvoiceAmount < 0
                                                            ? ($chickInvoiceAmount = $chickInvoice
                                                                ->where('seller', $accountDetailsRow->reference_id)
                                                                ->sum('amount'))
                                                            : 0;

                                                    $feedInvoiceAmount = $feedInvoice
                                                        ->where('buyer', $accountDetailsRow->reference_id)
                                                        ->sum('amount');
                                                    $totalCredit += max($feedInvoiceAmount, 0);
                                                    $totalDebit +=
                                                        $feedInvoiceAmount < 0
                                                            ? ($feedInvoiceAmount = $feedInvoice
                                                                ->where('seller', $accountDetailsRow->reference_id)
                                                                ->sum('amount'))
                                                            : 0;

                                                    $PVAmount = $payment_voucher
                                                        ->where('cash_bank', $accountDetailsRow->id)
                                                        ->sum('amount');
                                                    $totalCredit += max($PVAmount, 0);
                                                    $totalDebit +=
                                                        $PVAmount < 0
                                                            ? ($PVAmount = $payment_voucher
                                                                ->where('company', $accountDetailsRow->reference_id)
                                                                ->sum('amount'))
                                                            : 0;

                                                    $RVAmount = $receipt_voucher
                                                        ->where('cash_bank', $accountDetailsRow->id)
                                                        ->sum('amount');
                                                    $totalDebit += max($RVAmount, 0);
                                                    $totalCredit +=
                                                        $RVAmount < 0
                                                            ? ($RVAmount = $receipt_voucher
                                                                ->where('company', $accountDetailsRow->reference_id)
                                                                ->sum('amount'))
                                                            : 0;

                                                    $EVAmount = $expense_voucher
                                                        ->where('cash_bank', $accountDetailsRow->id)
                                                        ->sum('amount');
                                                    $totalCredit += max($EVAmount, 0);
                                                    $totalDebit +=
                                                        $EVAmount < 0
                                                            ? ($EVAmount = $expense_voucher
                                                                ->where('buyer', $accountDetailsRow->reference_id)
                                                                ->sum('amount'))
                                                            : 0;

                                                    $JVAmount = $journal_voucher
                                                        ->where('from_account', $accountDetailsRow->id)
                                                        ->where('status', 'credit')
                                                        ->sum('amount');

                                                    $JVAmount += $journal_voucher
                                                        ->where('to_account', $accountDetailsRow->id)
                                                        ->where('status', 'debit')
                                                        ->sum('amount');
                                                    $totalDebit += max($JVAmount, 0);

                                                    $totalCredit +=
                                                        $JVAmount < 0
                                                            ? ($JVAmount = $journal_voucher
                                                                ->where('to_account', $accountDetailsRow->id)
                                                                ->where('status', 'credit')
                                                                ->sum('amount'))
                                                            : ($JVAmount = $journal_voucher
                                                                ->where('from_account', $accountDetailsRow->id)
                                                                ->where('status', 'debit')
                                                                ->sum('amount'));

                                                    $totalAmount = $totalCredit - $totalDebit;
                                                }
                                                $totalHeadAmount += $totalAmount;
                                            @endphp
                                        @elseif($headRow->id == 5)
                                            @php
                                                $totalDebit = 0;
                                                $totalCredit = 0;
                                                $accountDetails = $accounts->where('account_category', $subRow->id);

                                                foreach ($accountDetails as $accountDetailsRow) {
                                                    $chickenInvoiceAmount = $chickInvoiceAmount = $feedInvoiceAmount = 0;
                                                    $PVAmount = $RVAmount = $EVAmount = $JVAmount = 0;

                                                    $chickenInvoiceAmount = $chickenInvoice
                                                        ->where('buyer', $accountDetailsRow->reference_id)
                                                        ->sum('amount');
                                                    $totalCredit += max($chickenInvoiceAmount, 0);
                                                    $totalDebit +=
                                                        $chickenInvoiceAmount < 0
                                                            ? ($chickenInvoiceAmount = $chickenInvoice
                                                                ->where('seller', $accountDetailsRow->reference_id)
                                                                ->sum('amount'))
                                                            : 0;

                                                    $chickInvoiceAmount = $chickInvoice
                                                        ->where('buyer', $accountDetailsRow->reference_id)
                                                        ->sum('amount');
                                                    $totalCredit += max($chickInvoiceAmount, 0);
                                                    $totalDebit +=
                                                        $chickInvoiceAmount < 0
                                                            ? ($chickInvoiceAmount = $chickInvoice
                                                                ->where('seller', $accountDetailsRow->reference_id)
                                                                ->sum('amount'))
                                                            : 0;

                                                    $feedInvoiceAmount = $feedInvoice
                                                        ->where('buyer', $accountDetailsRow->reference_id)
                                                        ->sum('amount');
                                                    $totalCredit += max($feedInvoiceAmount, 0);
                                                    $totalDebit +=
                                                        $feedInvoiceAmount < 0
                                                            ? ($feedInvoiceAmount = $feedInvoice
                                                                ->where('seller', $accountDetailsRow->reference_id)
                                                                ->sum('amount'))
                                                            : 0;

                                                    $PVAmount = $payment_voucher
                                                        ->where('cash_bank', $accountDetailsRow->id)
                                                        ->sum('amount');
                                                    $totalCredit += max($PVAmount, 0);
                                                    $totalDebit +=
                                                        $PVAmount < 0
                                                            ? ($PVAmount = $payment_voucher
                                                                ->where('company', $accountDetailsRow->reference_id)
                                                                ->sum('amount'))
                                                            : 0;

                                                    $RVAmount = $receipt_voucher
                                                        ->where('cash_bank', $accountDetailsRow->id)
                                                        ->sum('amount');
                                                    $totalDebit += max($RVAmount, 0);
                                                    $totalCredit +=
                                                        $RVAmount < 0
                                                            ? ($RVAmount = $receipt_voucher
                                                                ->where('company', $accountDetailsRow->reference_id)
                                                                ->sum('amount'))
                                                            : 0;

                                                    $EVAmount = $expense_voucher
                                                        ->where('cash_bank', $accountDetailsRow->id)
                                                        ->sum('amount');
                                                    $totalDebit += max($EVAmount, 0);
                                                    $totalDebit +=
                                                        $EVAmount < 0
                                                            ? ($EVAmount = $expense_voucher
                                                                ->where('buyer', $accountDetailsRow->reference_id)
                                                                ->sum('amount'))
                                                            : 0;

                                                   $JVAmount = $journal_voucher
                                                        ->where('from_account', $accountDetailsRow->id)
                                                        ->where('status', 'credit')
                                                        ->sum('amount');

                                                    $JVAmount += $journal_voucher
                                                        ->where('to_account', $accountDetailsRow->id)
                                                        ->where('status', 'debit')
                                                        ->sum('amount');
                                                    $totalDebit += max($JVAmount, 0);
                                                    
                                                    $totalCredit +=
                                                        $JVAmount < 0
                                                            ? ($JVAmount = $journal_voucher
                                                                ->where('to_account', $accountDetailsRow->id)
                                                                ->where('status', 'credit')
                                                                ->sum('amount'))
                                                            : ($JVAmount = $journal_voucher
                                                                ->where('from_account', $accountDetailsRow->id)
                                                                ->where('status', 'debit')
                                                                ->sum('amount'));

                                                    $totalAmount =  $totalDebit -$totalCredit;
                                                }
                                                $totalHeadAmount += $totalAmount;
                                            @endphp
                                        @endif
                                        {{ number_format($totalAmount, 2) }}
                                    </th>
                                </tr>
                            @endforeach

                            <tr class="total">
                                <th>Total <span class="sr-only">{{ $headRow->name }}</span></th>
                                <td> {{ number_format($totalHeadAmount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach

                <!--Net Worth -->
                <table>
                    <caption>Net Worth</caption>
                    <thead>
                        <tr>
                            <td></td>
                            <th><span class="sr-only">2019</span></th>
                            <th><span class="sr-only">2020</span></th>
                            <th><span class="sr-only">2021</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="total">
                            <th>Total <span class="sr-only">Net Worth</span></th>
                            <td>$-171</td>
                            <td>$136</td>
                            <td class="current">$334</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>

</html>
