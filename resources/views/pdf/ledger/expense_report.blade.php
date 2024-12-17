@extends('pdf.ledger.app') @section('pdf_content')
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

        $expense_voucher = session()->get('Data')['expense_voucher'];

        $accountDetails = session()->get('Data')['accountDetails'] ?? null;
        $farmDetails = session()->get('Data')['farmDetails'] ?? null;

        $journal_voucher = session()->get('Data')['journal_voucher'] ?? null;

        $salaryAccounts = session()->get('Data')['salaryAccounts'] ?? null;
        $rentAccounts = session()->get('Data')['rentAccounts'] ?? null;
        $utilityAccounts = session()->get('Data')['utilityAccounts'] ?? null;

        $salary = session()->get('Data')['salary'] ?? null;
        $rent = session()->get('Data')['rent'] ?? null;
        $utility = session()->get('Data')['utility'] ?? null;

        $salaryjv = session()->get('Data')['salaryjv'] ?? null;
        $rentjv = session()->get('Data')['rentjv'] ?? null;
        $utilityjv = session()->get('Data')['utilityjv'] ?? null;

        // $grand_total = 0;
        $total_amount = 0;
        $total_sale_amount = 0;
    @endphp
    <div class="invoice-header">
        <div class="ui left aligned grid">
            <div class="row">
                <div class="left floated left aligned six wide column">
                    <div class="ui">
                        <h1 class="ui header pageTitle">Expense Report
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
        @if ($accountDetails)
            <div class="ui card customercard">
                <div class="content">
                    <div class="header">Account Details</div>
                </div>
                <div class="content">
                    {{ $accountDetails->account_name }}
                </div>
            </div>
        @endif
        @if ($farmDetails)
            <div class="ui card customercard">
                <div class="content">
                    <div class="header">Farm Details</div>
                </div>
                <div class="content">
                    {{ $farmDetails->name }}
                </div>
            </div>
        @endif

        <div class="ui segment itemscard">
            <div class="content">
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
                                                    <span>{{ number_format($row->amount,2) }}</span>
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
                                                    <span>{{ number_format($row->amount,2) }}</span>
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
                                                    <span>{{ number_format($row->amount,2) }}</span>
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
                                                    <span>{{ number_format($row->amount,2) }}</span>
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
                                                    <span>{{ number_format($row->amount,2) }}</span>
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
                                                    <span>{{ number_format($row->amount,2) }}</span>
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
                @endif
            </div>
        </div>

    </div>
    </div>

    <script></script>
@endsection
