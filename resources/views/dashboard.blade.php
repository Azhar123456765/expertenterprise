@extends('layout.app') @section('title', 'Dashboard') @section('content')
@php
    $endDate = date('Y-m-d');
    $startDate = date('Y-m-d', strtotime('-1 year', strtotime($endDate)));
@endphp
<div class="container">
    <br>
    @if (session()->get('user_id')['role'] == 'user')
        <h3>User's Dashboard</h3>
    @elseif(session()->get('user_id')['role'] == 'admin')
        <style>
            .date {
                border: none;
                outline: none;
                background: transparent;
            }
        </style>
        <label>Start Date:</label>
        <input type="date" class="date" name="start_date" id="start_date" onchange="date()" value="{{ $startDate }}">
        &nbsp;&nbsp;&nbsp;
        <label>End Date:</label>
        <input type="date" class="date" name="end_date" id="end_date" onchange="date()"
            value="{{ $endDate }}">
    @endif
    <br><br>

    <div class="row m-t-25" style="text-transform: capitalize;">

        @if (session()->get('user_id')['role'] == 'user')
            <div class="col-md-12">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-book"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total No of records you input</span>
                        <span class="info-box-number">{{ session()->get('user_id')['no_records'] }}</span>
                    </div>
                </div>
            </div>
        @elseif(session()->get('user_id')['role'] == 'admin')
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fa fa-shopping-cart text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Items Purchase</p>
                                        <h4 class="card-title">{{ str_replace('.00', '', $pur_invoice_qty) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-luggage-cart text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Items Sale</p>
                                        <h4 class="card-title">{{ str_replace('.00', '', $SaleInvoice_qty) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-exclamation-circle text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Expense</p>
                                        <h4 class="card-title">{{ str_replace('.00', '', number_format($expense, 2)) }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fa fa-money-bill text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Income</p>
                                        <h4 class="card-title">{{ str_replace('.00', '', number_format($earning, 2)) }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endif

    <div class="row p-3">


        <div class="col-lg-6 rounded-2 shadow bg-white p-4">
            <div class="au-card m-b-30">
                <div class="au-card-inner">
                    <div class="chartjs-size-monitor"
                        style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                        <div class="chartjs-size-monitor-expand"
                            style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink"
                            style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                        </div>
                    </div>
                    <h3 class="title-2 m-b-40">Yearly Income</h3>
                    <canvas id="team-chart2" height="195" style="display: block; width: 390px; height: 195px;"
                        width="390" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>



        <!-- <div class="col-lg-6">
            <div class="au-card m-b-30">
                <div class="au-card-inner">
                    <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                        </div>
                    </div>
                    <h3 class="title-2 m-b-40">Yearly Sales</h3>
                    <canvas id="sales-chart" height="195" style="display: block; width: 390px; height: 195px;" width="390" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div> -->

    </div>


    <!-- <div class="col-lg-6">
        <div class="au-card m-b-30">
        <h3 class="title-2 m-b-40">Yearly Sales</h3>

            <div class="au-card-inner">
                <canvas id="sales-chart1" height="195" width="390"></canvas>
            </div>
        </div>
    </div> -->
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    var ctx = document.getElementById("team-chart2").getContext('2d');
    if (ctx) {
        const Utils = {
            rand: function({
                min = 0,
                max = 1
            }) {
                return Math.random() * (max - min) + min;
            },
            months: function({
                count = 1
            }) {
                const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                    'September', 'October', 'November', 'December'
                ];
                return months.slice(0, count);
            },
            transparentize: function(color, opacity) {
                // Implement transparentize function as per your requirement
            }
        };

        const DATA_COUNT = 12;
        const NUMBER_CFG = {
            count: DATA_COUNT,
            min: -100,
            max: 100
        };

        const labels = {!! json_encode($months) !!};
        const data = {
            labels: labels,
            datasets: [{
                    label: 'Expense',
                    data: {!! json_encode($expense_chart) !!},
                    borderColor: 'red', // Utils.CHART_COLORS.red is not defined, replace with a color string
                    backgroundColor: Utils.transparentize('red',
                        0.5), // Utils.transparentize is not defined, replace with a color string
                    yAxisID: 'y',
                },
                {
                    label: 'Earning',
                    data: {!! json_encode($earning_chart) !!},
                    borderColor: 'green', // Utils.CHART_COLORS.blue is not defined, replace with a color string
                    backgroundColor: Utils.transparentize('blue',
                        0.5), // Utils.transparentize is not defined, replace with a color string
                    yAxisID: 'y1',
                }
            ]
        };

        const myChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'May Contain Inaccurate Information'
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',

                        // grid line settings
                        grid: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                        },
                    },
                }
            },
        });
    }























    //Sales chart
    var ctx = document.getElementById("sales-chart1");
    if (ctx) {
        ctx.height = 150;
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016"],
                type: 'line',
                defaultFontFamily: 'Poppins',
                datasets: [{
                    label: "Foods",
                    data: [0, 30, 10, 120, 50, 63, 10],
                    backgroundColor: 'transparent',
                    borderColor: 'rgba(220,53,69,0.75)',
                    borderWidth: 3,
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: 'transparent',
                    pointBackgroundColor: 'rgba(220,53,69,0.75)',
                }, {
                    label: "Electronics",
                    data: [0, 50, 40, 80, 40, 79, 120],
                    backgroundColor: 'transparent',
                    borderColor: 'rgba(40,167,69,0.75)',
                    borderWidth: 3,
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: 'transparent',
                    pointBackgroundColor: 'rgba(40,167,69,0.75)',
                }]
            },
            options: {
                responsive: true,
                tooltips: {
                    mode: 'index',
                    titleFontSize: 12,
                    titleFontColor: '#000',
                    bodyFontColor: '#000',
                    backgroundColor: '#fff',
                    titleFontFamily: 'Poppins',
                    bodyFontFamily: 'Poppins',
                    cornerRadius: 3,
                    intersect: false,
                },
                legend: {
                    display: false,
                    labels: {
                        usePointStyle: true,
                        fontFamily: 'Poppins',
                    },
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        ticks: {
                            fontFamily: "Poppins"
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Value',
                            fontFamily: "Poppins"

                        },
                        ticks: {
                            fontFamily: "Poppins"
                        }
                    }]
                },
                title: {
                    display: false,
                    text: 'Normal Legend'
                }
            }
        });
    }


    function getMonthName(month) {
        var months = [
            "January", "February", "March", "April", "May", "June", "July",
            "August", "September", "October", "November", "December"
        ];
        return months[month - 1];
    }

    function date() {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        $('#sell_qty').text('loading...');
        $('#pur_qty').text('loading...');
        $('#expense').text('loading...');
        $('#earning').text('loading...');

        $.ajax({
            url: '/dashboard',
            method: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date
            },
            success: function(response) {
                $('#sell_qty').text(response.sell_qty);
                $('#pur_qty').text(response.pur_qty);
                $('#expense').text(response.expense + ' Rs');
                $('#earning').text(response.earning + ' Rs');
            },
            error: function(error) {
                // Handle the error
            },
        });
    }

    function expense() {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        window.location.href = `expense?start_date=` + start_date + `&end_date=` + end_date + ``
    }

    function income() {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        window.location.href = `income?start_date=` + start_date + `&end_date=` + end_date + ``
    }
</script>
@endsection
