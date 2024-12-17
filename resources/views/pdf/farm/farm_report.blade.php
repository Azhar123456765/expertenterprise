@extends('pdf.ledger.app') @section('pdf_content')
    @php
        use Illuminate\Support\Facades\DB;
        use App\Models\p_voucher;
        use App\Models\JournalVoucher;
        use App\Models\accounts;

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
        $expense_voucher = session()->get('Data')['expense_voucher'] ?? null;
        $journal_voucher = session()->get('Data')['journal_voucher'] ?? null;
        $chickenInvoice = session()->get('Data')['chickenInvoice'] ?? null;
        $payment_voucher = session()->get('Data')['payment_voucher'] ?? null;
        $chickInvoice = session()->get('Data')['chickInvoice'] ?? null;
        $feedInvoice = session()->get('Data')['feedInvoice'] ?? null;
        $daily_reports = session()->get('Data')['daily_reports'] ?? null;
        $payment_voucher = session()->get('Data')['payment_voucher'] ?? null;

        $salary = session()->get('Data')['salary'] ?? null;
        $rent = session()->get('Data')['rent'] ?? null;
        $utility = session()->get('Data')['utility'] ?? null;

        $salaryAccounts = session()->get('Data')['salaryAccounts'] ?? null;
        $rentAccounts = session()->get('Data')['rentAccounts'] ?? null;
        $utilityAccounts = session()->get('Data')['utilityAccounts'] ?? null;

        $farm = session()->get('Data')['farm'];

        $salary = $expense_voucher->whereIn('cash_bank', $salary);
        $rent = $expense_voucher->whereIn('cash_bank', $rent);
        $utility = $expense_voucher->whereIn('cash_bank', $utility);
        // $utility = ;

        // dd(
        //     $payment_voucher
        //         ->whereIn(
        //             'invoice_no',
        //             $chickInvoice
        //                 ->select(DB::raw("CONCAT('C-', unique_id) as unique_id_name"))
        //                 ->get('unique_id_name')
        //                 ->pluck(), // Pluck after executing the query
        //         )
        //         ->orWhereIn(
        //             'invoice_no',
        //             $feedInvoice
        //                 ->select(DB::raw("CONCAT('F-', unique_id) as unique_id_name"))
        //                 ->get('unique_id_name')
        //                 ->pluck(), // Pluck after executing the query
        //         )
        //         ->get(), // Fetch the results from the payment_voucher query
        // );
        $chickInvoiceLiab = $chickInvoice->groupBy('unique_id')->map(function ($group) {
            $description = $group
                ->map(function ($item) {
                    return $item->product->product_name;
                })
                ->join(', ');
            // $sale_amount_rv = ReceiptVoucher::where('invoice_no', 'C-' . $group->first()->unique_id)->sum('amount');
            $account = accounts::where('reference_id', $group->first()->seller)->first();
            $sale_amount_pv = P_voucher::where('invoice_no', 'C-' . $group->first()->unique_id)->sum('amount');
            $sale_amount_jv = JournalVoucher::where('invoice_no', 'C-' . $group->first()->unique_id)
                ->where('to_account', $account->id)
                ->where('status', 'debit')
                ->sum('amount');

            if ($sale_amount_jv <= 0) {
                $sale_amount_jv = JournalVoucher::where('invoice_no', 'C-' . $group->first()->unique_id)
                    ->where('to_account', $account->id)
                    ->where('status', 'debit')
                    ->sum('amount');
            }
            $groupedData = new \stdClass();
            $groupedData->date = $group->first()->date;
            $groupedData->unique_id = $group->first()->unique_id;
            $groupedData->description = $description;
            $groupedData->seller = $group->first()->seller;
            $groupedData->buyer = $group->first()->buyer;
            $groupedData->sale_amount_total = $group->first()->sale_amount_total;
            $groupedData->amount_total = $group->first()->amount_total - ($sale_amount_pv + $sale_amount_jv);

            return $groupedData;
        });
        $feedInvoiceLiab = $feedInvoice->groupBy('unique_id')->map(function ($group) {
            $description = $group
                ->map(function ($item) {
                    return $item->product->product_name;
                })
                ->join(', ');
            // $sale_amount_rv = ReceiptVoucher::where('invoice_no', 'C-' . $group->first()->unique_id)->sum('amount');
            $sale_amount_pv = P_voucher::where('invoice_no', 'F-' . $group->first()->unique_id)->sum('amount');
            $groupedData = new \stdClass();
            $groupedData->date = $group->first()->date;
            $groupedData->unique_id = $group->first()->unique_id;
            $groupedData->description = $description;
            $groupedData->seller = $group->first()->seller;
            $groupedData->buyer = $group->first()->buyer;
            $groupedData->sale_amount_total = $group->first()->sale_amount_total;
            $groupedData->amount_total = $group->first()->amount_total - $sale_amount_pv;

            return $groupedData;
        });
        // dd($salaryAccounts);
        $total_amount = 0;
        $total_sale_amount = 0;
    @endphp
    <style>
        .ui .content p {
            display: flex;
            justify-content: space-between;
        }
    </style>
    <div class="invoice-header">
        <div class="ui left aligned grid">
            <div class="row">
                <div class="left floated left aligned six wide column">
                    <div class="ui">
                        <h1 class="ui header pageTitle">Farm Report
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
        @if ($farm)
            <div class="ui card customercard">
                <div class="content">
                    <div class="header">Farm Details</div>
                </div>
                <div class="content">
                    {{ $farm->name }}
                </div>
            </div>
        @endif

        <div class="ui segment itemscard">
            <div class="content">


                @if (count($chickInvoice) > 0 || count($feedInvoice) > 0)
                    <h3><b>Purchase</b></h3>
                    @if (count($chickInvoice) > 0)
                        <table class="ui celled table">
                            <thead>
                                <tr>
                                    <th class="text-center colfix date-th" style="text-align: center;">Date</th>
                                    <th class="text-center colfix" style="text-align: center;">Invoice No</th>
                                    <th class="text-center colfix">Description</th>
                                    <th class="text-center colfix">Parties</th>
                                    <th class="text-center colfix">Amount</th>
                                </tr>
                            </thead>
                            <h4><b>Chicks Purchase</b></h4>

                            <tbody>
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
                                            <span>{{ $row->product->product_name }}</span>
                                        </td>
                                        <td style="text-align: left
;">
                                            <span>{{ $row->supplier->company_name }}&nbsp;&nbsp; TO
                                                &nbsp;&nbsp;{{ $row->customer->company_name }}</span>
                                        </td>
                                        <td style="text-align:right;">
                                            {{ number_format($row->amount,2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="full-width">
                                <tr>
                                    <th colspan="4" style="text-align:right;"> Total: </th>
                                    <th colspan="1" style="text-align:right;"> {{ $chickInvoice->sum('amount_total') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                        </table>
                    @endif
                    @if (count($feedInvoice) > 0)
                        <table class="ui celled table">
                            <thead>
                                <tr>
                                    <th class="text-center colfix date-th" style="text-align: center;">Date</th>
                                    <th class="text-center colfix" style="text-align: center;">Invoice No</th>
                                    <th class="text-center colfix">Description</th>
                                    <th class="text-center colfix">Parties</th>
                                    <th class="text-center colfix">Amount</th>
                                </tr>
                            </thead>
                            <h4><b>Feed Purchase</b></h4>

                            <tbody>
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
                                            <span>{{ $row->product->product_name }}</span>
                                        </td>
                                        <td style="text-align: left
;">
                                            <span>{{ $row->supplier->company_name }}&nbsp;&nbsp; TO
                                                &nbsp;&nbsp;{{ $row->customer->company_name }}</span>
                                        </td>
                                        <td style="text-align:right;">
                                            @if ($farm)
                                                {{ $row->farm == $farm->id ? $row->amount : '-' . $row->sale_amount }}
                                            @else
                                                {{ number_format($row->amount,2) }}
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="full-width">
                                <tr>
                                    <th colspan="4" style="text-align:right;"> Total: </th>
                                    <th colspan="1" style="text-align:right;">
                                        @if ($farm)
                                            {{ $feedInvoice->where('farm', $farm->id)->sum('amount') - $feedInvoice->where('supply_farm', $farm->id)->sum('sale_amount') }}
                                        @else
                                            {{ $feedInvoice->sum('amount') }}
                                        @endif

                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    @endif

                @endif
                @if (count($salary) > 0 || count($rent) > 0 || count($utility) > 0)
                    <h3><b>Expenses</b></h3>
                    @if (
                        (count($salary) > 0 && count($salaryAccounts) > 0) ||
                            ($journal_voucher->whereIn('to_account', $salaryAccounts->pluck('id'))->where('status', 'debit')->count() > 0 ||
                                $journal_voucher->whereIn('from_account', $salaryAccounts->pluck('id'))->where('status', 'credit')->count()))
                        <h3><b>salary</b></h3>

                        @foreach ($salaryAccounts as $salaryRow)
                            @if (
                                $expense_voucher->where('cash_bank', $salaryRow->id)->count() > 0 ||
                                    ($journal_voucher->where('to_account', $salaryRow->id)->where('status', 'debit')->count() > 0 ||
                                        $journal_voucher->where('from_account', $salaryRow->id)->where('status', 'credit')->count()))
                                <h6><b>{{ $salaryRow->account_name }}</b></h6>
                                <table class="ui celled table">
                                    <thead>
                                        <tr>
                                            <th class="text-center colfix date-th" style="text-align: center;">Date</th>
                                            <th class="text-center colfix" style="text-align: center;">Voucher No</th>
                                            <th class="text-center colfix">Narration</th>
                                            <th class="text-center colfix">Expense Account</th>
                                            <th class="text-center colfix" style="text-align: center;">Cheque Date</th>
                                            <th class="text-center colfix">Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($expense_voucher->where('cash_bank', $salaryRow->id) as $row)
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
                                                <td style="text-align: left;">
                                                    <span>{{ $row->narration }}</span>
                                                </td>
                                                <td style="text-align: left;">
                                                    <span>{{ $row->accounts->account_name }}</span>
                                                </td>
                                                <td class="text-center" style="text-align: center;">
                                                    <span>{{ $row->cheque_date }}</span>
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($row->amount,2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($journal_voucher->where('to_account', $salaryRow->id)->where('status', 'debit')->count() > 0
            ? $journal_voucher->where('to_account', $salaryRow->id)->where('status', 'debit')
            : $journal_voucher->where('from_account', $salaryRow->id)->where('status', 'credit') as $row)
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
                                                <td style="text-align: left;">
                                                    <span>{{ $row->narration }}</span>
                                                </td>
                                                @if ($row->status == 'credit')
                                                    <td style="text-align: left
        ;">
                                                        <span>{{ $row->fromAccount->account_name }}</span>
                                                    </td>
                                                @else
                                                    <td style="text-align: left
                            ;">
                                                        <span>{{ $row->toAccount->account_name }}</span>
                                                    </td>
                                                @endif
                                                <td class="text-center" style="text-align: center;">
                                                    <span>{{ $row->cheque_date }}</span>
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($row->amount,2) }}
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot class="full-width">
                                        <tr>
                                            <th colspan="5" style="text-align:right;"> Total: </th>
                                            <th colspan="1" style="text-align:right;">
                                                {{ $expense_voucher->where('cash_bank', $salaryRow->id)->sum('amount') +
                                                    ($journal_voucher->where('to_account', $salaryRow->id)->where('status', 'debit')->sum('amount') +
                                                        $journal_voucher->where('from_account', $salaryRow->id)->where('status', 'credit')->sum('amount')) }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
                        @endforeach
                    @endif
                    @if (
                        (count($rent) > 0 && count($rentAccounts) > 0) ||
                            ($journal_voucher->whereIn('to_account', $rentAccounts->pluck('id'))->where('status', 'debit')->count() > 0 ||
                                $journal_voucher->whereIn('from_account', $rentAccounts->pluck('id'))->where('status', 'credit')->count()))
                        <h3><b>rent</b></h3>

                        @foreach ($rentAccounts as $rentRow)
                            @if (
                                $expense_voucher->where('cash_bank', $rentRow->id)->count() > 0 ||
                                    ($journal_voucher->where('to_account', $rentRow->id)->where('status', 'debit')->count() > 0 ||
                                        $journal_voucher->where('from_account', $rentRow->id)->where('status', 'credit')->count()))
                                <h6><b>{{ $rentRow->account_name }}</b></h6>
                                <table class="ui celled table">
                                    <thead>
                                        <tr>
                                            <th class="text-center colfix date-th" style="text-align: center;">Date</th>
                                            <th class="text-center colfix" style="text-align: center;">Voucher No</th>
                                            <th class="text-center colfix">Narration</th>
                                            <th class="text-center colfix">Expense Account</th>
                                            <th class="text-center colfix" style="text-align: center;">Cheque Date</th>
                                            <th class="text-center colfix">Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($expense_voucher->where('cash_bank', $rentRow->id) as $row)
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
                                                <td style="text-align: left;">
                                                    <span>{{ $row->narration }}</span>
                                                </td>
                                                <td style="text-align: left;">
                                                    <span>{{ $row->accounts->account_name }}</span>
                                                </td>
                                                <td class="text-center" style="text-align: center;">
                                                    <span>{{ $row->cheque_date }}</span>
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($row->amount,2) }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        @foreach ($journal_voucher->where('to_account', $rentRow->id)->where('status', 'debit')->count() > 0
            ? $journal_voucher->where('to_account', $rentRow->id)->where('status', 'debit')
            : $journal_voucher->where('from_account', $rentRow->id)->where('status', 'credit') as $row)
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
                                                <td style="text-align: left;">
                                                    <span>{{ $row->narration }}</span>
                                                </td>
                                                @if ($row->status == 'credit')
                                                    <td style="text-align: left
    ;">
                                                        <span>{{ $row->fromAccount->account_name }}</span>
                                                    </td>
                                                @else
                                                    <td style="text-align: left
                        ;">
                                                        <span>{{ $row->toAccount->account_name }}</span>
                                                    </td>
                                                @endif
                                                <td class="text-center" style="text-align: center;">
                                                    <span>{{ $row->cheque_date }}</span>
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($row->amount,2) }}
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot class="full-width">
                                        <tr>
                                            <th colspan="5" style="text-align:right;"> Total: </th>
                                            <th colspan="1" style="text-align:right;">
                                                {{ $expense_voucher->where('cash_bank', $rentRow->id)->sum('amount') +
                                                    ($journal_voucher->where('to_account', $rentRow->id)->where('status', 'debit')->sum('amount') +
                                                        $journal_voucher->where('from_account', $rentRow->id)->where('status', 'credit')->sum('amount')) }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
                        @endforeach
                    @endif
                    @if (
                        (count($utility) > 0 && count($utilityAccounts) > 0) ||
                            ($journal_voucher->whereIn('to_account', $utilityAccounts->pluck('id'))->where('status', 'debit')->count() >
                                0 ||
                                $journal_voucher->whereIn('from_account', $utilityAccounts->pluck('id'))->where('status', 'credit')->count()))
                        <h3><b>Utility</b></h3>

                        @foreach ($utilityAccounts as $utilityRow)
                            @if (
                                $expense_voucher->where('cash_bank', $utilityRow->id)->count() > 0 ||
                                    ($journal_voucher->where('to_account', $utilityRow->id)->where('status', 'debit')->count() > 0 ||
                                        $journal_voucher->where('from_account', $utilityRow->id)->where('status', 'credit')->count()))
                                <h6><b>{{ $utilityRow->account_name }}</b></h6>
                                <table class="ui celled table">
                                    <thead>
                                        <tr>
                                            <th class="text-center colfix date-th" style="text-align: center;">Date</th>
                                            <th class="text-center colfix" style="text-align: center;">Voucher No</th>
                                            <th class="text-center colfix">Narration</th>
                                            <th class="text-center colfix">Expense Account</th>
                                            <th class="text-center colfix" style="text-align: center;">Cheque Date</th>
                                            <th class="text-center colfix">Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($expense_voucher->where('cash_bank', $utilityRow->id) as $row)
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
                                                <td style="text-align: left;">
                                                    <span>{{ $row->narration }}</span>
                                                </td>
                                                <td style="text-align: left;">
                                                    <span>{{ $row->accounts->account_name }}</span>
                                                </td>
                                                <td class="text-center" style="text-align: center;">
                                                    <span>{{ $row->cheque_date }}</span>
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($row->amount,2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($journal_voucher->where('to_account', $utilityRow->id)->where('status', 'debit')->count() > 0
            ? $journal_voucher->where('to_account', $utilityRow->id)->where('status', 'debit')
            : $journal_voucher->where('from_account', $utilityRow->id)->where('status', 'credit') as $row)
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
                                                <td style="text-align: left;">
                                                    <span>{{ $row->narration }}</span>
                                                </td>
                                                @if ($row->status == 'credit')
                                                    <td style="text-align: left
    ;">
                                                        <span>{{ $row->fromAccount->account_name }}</span>
                                                    </td>
                                                @else
                                                    <td style="text-align: left
                        ;">
                                                        <span>{{ $row->toAccount->account_name }}</span>
                                                    </td>
                                                @endif
                                                <td class="text-center" style="text-align: center;">
                                                    <span>{{ $row->cheque_date }}</span>
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($row->amount,2) }}
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                    <tfoot class="full-width">
                                        <tr>
                                            <th colspan="5" style="text-align:right;"> Total: </th>
                                            <th colspan="1" style="text-align:right;">
                                                {{ $expense_voucher->where('cash_bank', $utilityRow->id)->sum('amount') +
                                                    ($journal_voucher->where('to_account', $utilityRow->id)->where('status', 'debit')->sum('amount') +
                                                        $journal_voucher->where('from_account', $utilityRow->id)->where('status', 'credit')->sum('amount')) }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
                        @endforeach
                    @endif

                    @if (count($daily_reports) > 0)
                        <table class="ui celled table">
                            <thead>
                                <tr>
                                    <th class="text-center colfix" style="text-align: center;">Hean Deaths</th>
                                    <th class="text-center colfix" style="text-align: center;">Feed Consumed</th>
                                    <th class="text-center colfix" style="text-align: center;">Water Consumed</th>
                                    <th class="text-center colfix" style="text-align: center;">Extra Expense</th>
                                </tr>
                            </thead>
                            <h4><b>Farm Daily Reports</b></h4>
                            <h3 class="ui sub header invDetails">FROM:
                                {{ (new DateTime($startDate))->format('d-m-Y') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TO:
                                {{ (new DateTime($endDate))->format('d-m-Y') }}</h3>
                            <tbody>
                                <tr style="text-align: center;">

                                    <td class="text-right" style="text-align: center;">
                                        <span>{{ $daily_reports->sum('hen_deaths') }}</span>
                                    </td>
                                    <td style="text-align: center
;">
                                        <span>{{ $daily_reports->sum('feed_consumed') }}</span>
                                    </td>
                                    <td style="text-align: center
;">
                                        <span>{{ $daily_reports->sum('water_consumed') }}</span>
                                    </td>
                                    <td class="text-center" style="text-align: center;">
                                        <span>{{ $daily_reports->sum('extra_expense_amount') }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                @endif
                {{-- @if (count($chickInvoiceLiab->where('amount_total', '>=', 0)) > 0)
                    <h3><b>Liablities</b></h3>
                    @if (count($chickInvoiceLiab->where('amount_total', '>=', 0)) > 0)
                        {{-- <table class="ui celled table">
                            <thead>
                                <tr>
                                    <th class="text-center colfix date-th" style="text-align: center;">Date</th>
                                    <th class="text-center colfix" style="text-align: center;">Voucher No</th>
                                    <th class="text-center colfix">Narration</th>
                                    <th class="text-center colfix">Payable Account</th>
                                    <th class="text-center colfix">Amount</th>
                                </tr>
                            </thead>
                            <h4><b>Accounts Payable</b></h4>

                            <tbody>
                                @foreach ($payment_voucher as $row)
                                    <tr style="text-align: center;">
                                        <td class="text-right" style="width: 100px;">
                                            <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                                        </td>
                                        <td class="text-right">
                                            <span>PV-{{ $row->unique_id }} || {{ $row->unique_id }}2</span>
                                        </td>
                                        <td style="text-align: left
;">
                                            <span>{{ $row->narration }}</span>
                                        </td>
                                        <td style="text-align: left
;">
                                            <span>{{ $row->accounts->account_name ?? null }}</span>
                                        </td>
                                        <td style="text-align:right;">
                                            {{ number_format($row->amount,2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="full-width">
                                <tr>
                                    <th colspan="4" style="text-align:right;"> Total: </th>
                                    <th colspan="1" style="text-align:right;"> {{ $payment_voucher->sum('amount') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table> --}}

                {{-- <table class="ui celled table">
                            <thead>
                                <tr>
                                    <th class="text-center colfix date-th" style="text-align: center;">Date</th>
                                    <th class="text-center colfix" style="text-align: center;">Invoice No</th>
                                    <th class="text-center colfix">Description</th>
                                    <th class="text-center colfix">Amount Remaining</th>
                                </tr>
                            </thead>
                            <h4><b>Chicks Purchase</b></h4>

                            <tbody>
                                @foreach ($chickInvoiceLiab->where('amount_total', '>=', 0) as $row)
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
                                            {{ number_format($row->amount,2) }}
                                        </td>
                                    </tr>
@endforeach
                            </tbody>
                            <tfoot class="full-width">
                                <tr>
                                    <th colspan="3" style="text-align:right;"> Total: </th>
                                    <th colspan="1" style="text-align:right;">
                                        {{ $chickInvoiceLiab->where('amount_total', '>=', 0)->sum('amount_total') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
@endif
                    @if (count($feedInvoiceLiab->where('amount_total', '>=', 0)) > 0) --}}
                {{-- <table class="ui celled table">
                        <thead>
                            <tr>
                                <th class="text-center colfix date-th" style="text-align: center;">Date</th>
                                <th class="text-center colfix" style="text-align: center;">Voucher No</th>
                                <th class="text-center colfix">Narration</th>
                                <th class="text-center colfix">Payable Account</th>
                                <th class="text-center colfix">Amount</th>
                            </tr>
                        </thead>
                        <h4><b>Accounts Payable</b></h4>

                        <tbody>
                            @foreach ($payment_voucher as $row)
                                <tr style="text-align: center;">
                                    <td class="text-right" style="width: 100px;">
                                        <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                                    </td>
                                    <td class="text-right">
                                        <span>PV-{{ $row->unique_id }} || {{ $row->unique_id }}2</span>
                                    </td>
                                    <td style="text-align: left
;">
                                        <span>{{ $row->narration }}</span>
                                    </td>
                                    <td style="text-align: left
;">
                                        <span>{{ $row->accounts->account_name ?? null }}</span>
                                    </td>
                                    <td style="text-align:right;">
                                        {{ number_format($row->amount,2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="full-width">
                            <tr>
                                <th colspan="4" style="text-align:right;"> Total: </th>
                                <th colspan="1" style="text-align:right;"> {{ $payment_voucher->sum('amount') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table> --}}

                {{-- <table class="ui celled table">
                        <thead>
                            <tr>
                                <th class="text-center colfix date-th" style="text-align: center;">Date</th>
                                <th class="text-center colfix" style="text-align: center;">Invoice No</th>
                                <th class="text-center colfix">Description</th>
                                <th class="text-center colfix">Amount Remaining</th>
                            </tr>
                        </thead>
                        <h4><b>Feed Purchase</b></h4>

                        <tbody>
                            @foreach ($feedInvoiceLiab->where('amount_total', '>=', 0) as $row)
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
                                            <span>{{ $row->description }}</span>
                                        </td>
                                        <td style="text-align:right;">
                                            {{ number_format($row->amount,2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="full-width">
                                <tr>
                                    <th colspan="3" style="text-align:right;"> Total: </th>
                                    <th colspan="1" style="text-align:right;">
                                        {{ $feedInvoiceLiab->where('amount_total', '>=', 0)->sum('amount_total') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    @endif 
                @endif --}}
                @if (count($chickenInvoice) > 0)
                    <h3><b>Income</b></h3>
                    @if (count($chickenInvoice) > 0)
                        <table class="ui celled table">
                            <thead>
                                <tr>
                                    <th class="text-center colfix date-th" style="text-align: center;">Date</th>
                                    <th class="text-center colfix" style="text-align: center;">Invoice No</th>
                                    <th class="text-center colfix">Description</th>
                                    <th class="text-center colfix">Parties</th>
                                    <th class="text-center colfix">Amount</th>
                                </tr>
                            </thead>
                            <h4><b>Chickens Sale</b></h4>

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
                                            <span>{{ $row->product->product_name }}</span>
                                        </td>
                                        <td style="text-align: left
;">
                                            <span>{{ $row->supplier->company_name }}&nbsp;&nbsp; TO
                                                &nbsp;&nbsp;{{ $row->customer->company_name }}</span>
                                        </td>
                                        <td style="text-align:right;">
                                            {{ number_format($row->amount,2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="full-width">
                                <tr>
                                    <th colspan="4" style="text-align:right;"> Total: </th>
                                    <th colspan="1" style="text-align:right;">
                                        {{ $chickenInvoice->sum('amount') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    @endif
                @endif

                @php
                    $total_amount = 0;
                    $total_sale_amount = 0;
                @endphp
            </div>
        </div>
        <div class="ui card">
            <div class="content" style="border-top:1px solid #363636 !important;">
                <div class="header">Amount Details</div>
            </div>
            <div class="content" style="border-top:1px solid #363636 !important;">
                <p> <strong> Purchases: </strong>PKR
                    @if ($farm)
                        {{ $total_purchase = $chickInvoice->sum('amount') + $feedInvoice->where('farm', $farm->id)->sum('amount') - $feedInvoice->where('supply_farm', $farm->id)->sum('sale_amount') }}
                    @else
                        {{ $total_purchase = $chickInvoice->sum('amount') + $feedInvoice->sum('amount') }}
                    @endif
                </p>
                <p> <strong> Expenses: </strong>
                    PKR
                    {{ $total_expense =
                        $expense_voucher->whereIn('cash_bank', $salaryAccounts->pluck('id'))->sum('amount') +
                        ($journal_voucher->whereIn('to_account', $salaryAccounts->pluck('id'))->where('status', 'debit')->sum('amount') +
                            $journal_voucher->whereIn('from_account', $salaryAccounts->pluck('id'))->where('status', 'credit')->sum('amount')) +
                        $expense_voucher->whereIn('cash_bank', $rentAccounts->pluck('id'))->sum('amount') +
                        ($journal_voucher->whereIn('to_account', $rentAccounts->pluck('id'))->where('status', 'debit')->sum('amount') +
                            $journal_voucher->whereIn('from_account', $rentAccounts->pluck('id'))->where('status', 'credit')->sum('amount')) +
                        $expense_voucher->whereIn('cash_bank', $utilityAccounts->pluck('id'))->sum('amount') +
                        ($journal_voucher->whereIn('to_account', $utilityAccounts->pluck('id'))->where('status', 'debit')->sum('amount') +
                            $journal_voucher->whereIn('from_account', $utilityAccounts->pluck('id'))->where('status', 'credit')->sum('amount')) }}
                </p>
                <p> <strong> Income: </strong>PKR {{ $total_income = $chickenInvoice->sum('amount') }} </p>
                <p> <strong> Net Income: </strong>PKR
                    {{ $total_income - ($total_purchase + $total_expense) }}
                </p>
            </div>
        </div>
        <div class="ui card">
            <div class="content" style="border-top:1px solid #363636 !important;">
                <div class="header">Hens Summary</div>
            </div>
            <div class="content" style="border-top:1px solid #363636 !important;">
                <p> <strong> Total Chicks Purchase: </strong>{{ $chickInvoice->sum('sale_qty') }} </p>
                @if ($farm)
                    <p> <strong> Total Feed In: </strong>{{ $feedInvoice->where('farm', $farm->id)->sum('qty') }} </p>
                    <p> <strong> Total Feed Out:
                        </strong>{{ $feedInvoice->where('supply_farm', $farm->id)->sum('sale_qty') }} </p>
                @else
                    <p> <strong> Total Feed: </strong>{{ $feedInvoice->sum('qty') }} </p>
                @endif
                <p> <strong> Chickens Sale (QTY):
                    </strong>{{ $chickenInvoice->sum('hen_qty') }} </p>
                <p> <strong> Chickens Sale (Net Weight):
                    </strong>{{ $chickenInvoice->sum('net_weight') }} </p>
            </div>
        </div>
        <div class="ui card">
            <div class="content" style="border-top:1px solid #363636 !important;">
                <div class="header">Expense Summary</div>
            </div>
            <div class="content" style="border-top:1px solid #363636 !important;height: 160px;">
                <p> <strong> Salary:
                    </strong>{{ $expense_voucher->whereIn('cash_bank', $salaryAccounts->pluck('id'))->sum('amount') +
                        ($journal_voucher->whereIn('to_account', $salaryAccounts->pluck('id'))->where('status', 'debit')->sum('amount') +
                            $journal_voucher->whereIn('from_account', $salaryAccounts->pluck('id'))->where('status', 'credit')->sum('amount')) }}
                </p>
                <p> <strong> Rent:
                    </strong>{{ $expense_voucher->whereIn('cash_bank', $rentAccounts->pluck('id'))->sum('amount') +
                        ($journal_voucher->whereIn('to_account', $rentAccounts->pluck('id'))->where('status', 'debit')->sum('amount') +
                            $journal_voucher->whereIn('from_account', $rentAccounts->pluck('id'))->where('status', 'credit')->sum('amount')) }}
                </p>
                <p> <strong> Utility:
                    </strong>{{ $expense_voucher->whereIn('cash_bank', $utilityAccounts->pluck('id'))->sum('amount') +
                        ($journal_voucher->whereIn('to_account', $utilityAccounts->pluck('id'))->where('status', 'debit')->sum('amount') +
                            $journal_voucher->whereIn('from_account', $utilityAccounts->pluck('id'))->where('status', 'credit')->sum('amount')) }}
                </p>

            </div>
        </div>
    </div>
    </div>

@endsection
