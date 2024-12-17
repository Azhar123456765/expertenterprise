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
        $FarmingPeriod = session()->get('Data')['FarmingPeriod'] ?? null;
        $FarmingDailyReport = session()->get('Data')['FarmingDailyReport'] ?? null;

        $farm = session()->get('Data')['farm'];

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
                        <h1 class="ui header pageTitle">Farm Daily Reports
                        </h1>
                        <h4 class="ui sub header invDetails">FROM:
                            {{ (new DateTime($startDate))->format('d-m-Y') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TO:
                            {{ (new DateTime($endDate))->format('d-m-Y') }}</h4>
                    </div>
                </div>
                <div class="center floated left aligned six wide column">
                    <div class="ui">
                        <div class="column two wide center floated">
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
                @foreach ($FarmingPeriod as $FarmingPeriodRow)
                    {{-- <h3><b>{{ $FarmingDailyReport->where('farming_period', $FarmingPeriodRow->id)->pluck('id') }}</b></h3> --}}
                    @if ($FarmingDailyReport->where('farming_period', $FarmingPeriodRow->id)->count() > 0)
                        <table class="ui celled table" id="invoice-table">
                            <thead>
                                <tr>
                                    <th class="text-center colfix date-th" style="text-align: center;">Date</th>
                                    <th class="text-center colfix" style="text-align: center;">Hen Deaths</th>
                                    <th class="text-center colfix" style="text-align: center;">Feed Consumed</th>
                                    <th class="text-center colfix" style="text-align: center;">Water Consumed</th>
                                    <th class="text-center colfix" style="text-align: center;">Extra Expense</th>
                                </tr>
                            </thead>
                            <h4><b>{{ !isset($farm) ? 'Farm: ' . $FarmingPeriodRow->farm->name : '' }} &nbsp;&nbsp;
                                    {{ (new DateTime($FarmingPeriodRow->start_date))->format('d-m-Y') }} TO
                                    {{ (new DateTime($FarmingPeriodRow->end_date))->format('d-m-Y') }} &nbsp;&nbsp;
                                    Fillable
                                    Entries:
                                    {{ $FarmingDailyReport->where('farming_period', $FarmingPeriodRow->id)->where('status', 0)->count() }}</b>
                            </h4>

                            <tbody>
                                @foreach ($FarmingDailyReport->where('farming_period', $FarmingPeriodRow->id)->where('status', 1) as $row)
                                    <tr style="text-align: center;">
                                        <td class="text-center" style="width: 100px;">
                                            <span>{{ (new DateTime($row->date))->format('d-m-Y') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span>{{ $row->hen_deaths }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span>{{ $row->feed_consumed }}</span>

                                        </td>
                                        <td class="text-center">
                                            <span>{{ $row->water_consumed }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span>{{ $row->extra_expense_amount ?? 0 }}</span>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="full-width">
                                <tr>
                                    <th colspan="1" style="text-align:center;"> Total: </th>
                                    <th colspan="1" style="text-align:center;">
                                        {{ $FarmingDailyReport->where('farming_period', $FarmingPeriodRow->id)->where('status', 1)->sum('hen_deaths') }}
                                    </th>
                                    <th colspan="1" style="text-align:center;">
                                        {{ $FarmingDailyReport->where('farming_period', $FarmingPeriodRow->id)->where('status', 1)->sum('feed_consumed') }}
                                    </th>
                                    <th colspan="1" style="text-align:center;">
                                        {{ $FarmingDailyReport->where('farming_period', $FarmingPeriodRow->id)->where('status', 1)->sum('water_consumed') }}
                                    </th>
                                    <th colspan="1" style="text-align:center;">
                                        {{ $FarmingDailyReport->where('farming_period', $FarmingPeriodRow->id)->where('status', 1)->sum('extra_expense_amount') ?? 0 }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
