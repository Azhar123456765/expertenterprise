@php

    $endDate = date('Y-m-d');
    $startDate = date('Y-m-d', strtotime('-1 year', strtotime($endDate)));
@endphp
<style>
    .date {
        border: none;
        outline: none;
    }
</style>

<head>
    <!-- Include other necessary scripts and stylesheets -->
    <!-- Include Select2 CSS -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" /> --}}

    <!-- Include jQuery library -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

    <!-- Include Select2 JS -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}


</head>
<div class="modal fade" id="p-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Export</h4>
                <div class="modal-body">
                    <form method="GET" action="/pdf_limitusers">
                        @csrf
                        <div class="form-group">
                            <label for="username">No. Records</label>
                            <input type="number" step="any" min="1" class="form-control" id="type"
                                name="limit" required value="">
                        </div>

                        <button type="submit" target class="btn btn-primary" id="btn">Submit</button>
                        <a type="button" class="btn btn-primary" style="background-color:black;" id="btn"
                            href="/pdf_field=users">PDF All</a>

                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>





<div class="modal fade" id="p-supplier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Export</h4>
                <div class="modal-body">
                    <form method="GET" action="/pdf_limitsupplier">
                        @csrf
                        <div class="form-group">
                            <label for="username">No. Records</label>
                            <input type="number" step="any" min="1" class="form-control" id="type"
                                name="limit" required value="">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                        </div>
                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                        <a type="button" class="btn btn-primary" style="background-color:black;" id="btn"
                            href="/pdf_field=supplier">PDF All</a>

                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>





<div class="modal fade" id="p-buyer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Export</h4>
                <div class="modal-body">
                    <form method="GET" action="/pdf_limitbuyer">
                        @csrf
                        <div class="form-group">
                            <label for="username">No. Records</label>
                            <input type="number" step="any" min="1" class="form-control" id="type"
                                name="limit" required value="">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                        </div>
                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                        <a type="button" class="btn btn-primary" style="background-color:black;" id="btn"
                            href="/pdf_field=buyer">PDF All</a>

                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>




<div class="modal fade" id="p-zone">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Export</h4>
                <div class="modal-body">
                    <form method="GET" action="/pdf_limitzone">
                        @csrf
                        <div class="form-group">
                            <label for="username">No. Records</label>
                            <input type="number" step="any" min="1" class="form-control" id="type"
                                name="limit" required value="">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                        </div>
                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                        <a type="button" class="btn btn-primary" style="background-color:black;" id="btn"
                            href="/pdf_field=zone">PDF All</a>

                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>




<div class="modal fade" id="pwarehouse">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Export</h4>
                <div class="modal-body">
                    <form method="GET" action="/pdf_limitwarehouse">
                        @csrf
                        <div class="form-group">
                            <label for="username">No. Records</label>
                            <input type="number" step="any" min="1" class="form-control" id="type"
                                name="limit" required value="">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                        </div>
                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                        <a type="button" class="btn btn-primary" style="background-color:black;" id="btn"
                            href="/pdf_field=warehouse">PDF All</a>

                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>







<div class="modal fade" id="p-sales_officer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Export</h4>
                <div class="modal-body">
                    <form method="GET" action="/pdf_limitsales_officer">
                        @csrf
                        <div class="form-group">
                            <label for="username">No. Records</label>
                            <input type="number" step="any" min="1" class="form-control" id="type"
                                name="limit" required value="">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                        </div>
                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                        <a type="button" class="btn btn-primary" style="background-color:black;" id="btn"
                            href="/pdf_field=sales_officer">PDF All</a>

                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


@php

    $id = session()->get('user_id')['user_id'];
    $theme_colors = App\Models\users::where('user_id', $id)->get();

    foreach ($theme_colors as $key => $value2) {
        $theme_color = $value2->theme;
    }

@endphp
<div class="modal fade" id="customize">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Customize Theme</h4>
                <div class="modal-body">
                    <form method="POST" action="/customize-form">
                        @csrf
                        <div class="form-group">
                            <label for="username">Theme</label>
                            <input type="color" class="form-control" name="theme_color" style="min-height:10vh;"
                                value="{{ $theme_color }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                            <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                        </div>

                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<style>
    @media (max-width: 755px) {

        .gen-led {
            width: auto !important;
            margin-left: auto !important;
            height: auto !important;

        }

    }
</style>

<div class="modal fade" id="farm-report">
    <div class="modal-dialog">
        <div class="modal-content gen-led">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Farm Report</h4>
                <div class="modal-body">
                    <form method="GET" action="{{ Route('farm.report') }}">
                        @csrf
                        <div class="row" style="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Farm</label>
                                    <select class="form-control select-farm" name="farm">
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-12">
                                <div class="form-group">
                                    <label>Sales Officer</label>
                                    
                                    <select class="form-control select-sales_officer" name="sales_officer">

                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Type</label>
                                    <select class="form-control" name="type">
                                        <option value="1">Summary</option>
                                        <option value="2">Detail</option>
                                    </select>
                                </div>
                            </div> --}}
                        </div>

                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date" value="{{ $endDate }}"
                                        id="" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="expense-report">
    <div class="modal-dialog">
        <div class="modal-content gen-led">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Expense Report</h4>
                <div class="modal-body">
                    <form method="GET" action="{{ Route('expense.report') }}">
                        @csrf
                        <div class="row" style="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Expense Account</label>
                                    <select class="form-control select-expense-account" name="account">
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Farm</label>
                                    <select class="form-control select-farm" name="farm">
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Sales Officer</label>

                                    <select class="form-control select-sales_officer" name="sales_officer">

                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date" value="{{ $endDate }}"
                                        id="" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="farm-daily-report">
    <div class="modal-dialog">
        <div class="modal-content gen-led">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Farm Daily Report</h4>
                <div class="modal-body">
                    <form method="GET" action="{{ Route('farm-daily.report') }}">
                        @csrf
                        <div class="row" style="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Farm</label>
                                    <select class="form-control select-farm" name="farm">
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-12">
                                <div class="form-group">
                                    <label>farming period</label>
                                    <select class="form-control select-farming-period" name="farming_period">
                                    </select>
                                </div>
                            </div> --}}

                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date" value="{{ $endDate }}"
                                        id="" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>



<div class="modal fade" id="gen-led">
    <div class="modal-dialog">
        <div class="modal-content gen-led">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>General Ledger</h4>
                <div class="modal-body">
                    <form method="GET" action="/gen-led">
                        @csrf
                        <div class="row" style="">

                            {{-- <div class="col-12">
                                <div class="form-group">
                                    <label>Head Of Account</label>
                                    <select class="form-control" name="head_account" id="head_account"
                                        onchange="accountData()">
                                        <option></option>
                                        <option value="1" data-id="1">Cash</option>
                                        <option value="2" data-id="2">Accounts Receivable</option>
                                        <option value="3" data-id="3">Accounts Payable</option>
                                        <option value="4" data-id="4">Bank</option>
                                        <option value="5" data-id="5">Expense</option>
                                        <option value="6" data-id="6">Income</option>
                                        <option value="7" data-id="7">Cost Of Sales</option>
                                        <option value="8" data-id="8">Long Term Liabilities</option>
                                        <option value="9" data-id="9">Inventory</option>
                                        <option value="10" data-id="10">Capital</option>
                                        <option value="11" data-id="11">Drawing</option>
                                    </select>
                                </div>
                            </div> --}}

                            {{-- <div class="col-12">

                                <div class="form-group">
                                    <label>Head Of Accounst</label>
                                    
                                    <select class="form-control select-head-account" name="head_account" onchange="subAccountFunc(this.value)">
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">

                                <div class="form-group">
                                    <label>Sub Head Of Accounts</label>
                                    
                                    <select class="form-control select-sub-head-account" name="sub_head_account" onchange="accountFunc(this.value)">
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 d-none dynamic-accounts">
                                <div class="form-group">
                                    <label>Account</label>
                                    
                                    <select class="form-control select-dynamic-account" name="account">
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-12 normal-accounts">

                                <div class="form-group">
                                    <label>Account</label>

                                    <select class="form-control select-account" name="account" id="gen-led-account">
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="col-12">
                                <div class="form-group">
                                    <label>Party</label>
                                    
                                    <select class="form-control select-buyer" name="company">

                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Sales Officer</label>

                                    <select class="form-control select-sales_officer" name="sales_officer">

                                    </select>
                                </div>
                            </div>


                            {{-- <div class="col-12">
                                <div class="form-group">
                                    <label>Company Type</label>
                                    
                                    <select class="form-control" name="company_type">
                                        <option></option>

                                    </select>
                                </div>
                            </div> --}}
                            {{-- <div class="col-12">
                                <div class="form-group">
                                    <label>Zone</label>
                                    
                                    <select class="select-warehouse js-example-basic-multiple js-states form-control"
                                        name="warehouse">
                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Type</label>
                                    <select class="form-control" name="type">
                                        <option value="1">Type 1</option>
                                        <option value="2">Type 2</option>
                                    </select>
                                </div>
                            </div>
                            <label>Customize Report</label>



                            <div class="col-12 d-flex justify-content-around">
                                <!-- Individual Checkboxes -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked name="jv" />
                                    <label class="form-check-label"> JV </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked name="pv" />
                                    <label class="form-check-label"> PV </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked name="rv" />
                                    <label class="form-check-label"> RV </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked name="ev" />
                                    <label class="form-check-label"> EV </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked name="chi" />
                                    <label class="form-check-label"> CHI </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked name="ci" />
                                    <label class="form-check-label"> CI </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked name="fi" />
                                    <label class="form-check-label"> FI </label>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 d-flex justify-content-around">
                            <!-- Master Checkbox -->
                            <div class="form-check">
                                <input id="selectAll" class="form-check-input" type="checkbox" />
                                <label class="form-check-label" for="selectAll">Select All</label>
                            </div>
                        </div>
                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn">Submit</button>

                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>




<div class="modal fade" id="bal-sheet">
    <div class="modal-dialog">
        <div class="modal-content gen-led">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Balance Sheet (Still In Testing)</h4>
                <div class="modal-body">
                    <form method="GET" action="{{ Route('balance_sheet.report') }}">
                        @csrf
                        <div class="row" style="">

                        </div>

                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn">Submit</button>

                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>






<div class="modal fade" id="pur-r-report">
    <div class="modal-dialog">
        <div class="modal-content gen-led" style="height: min-content;">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Purchase Return Report</h4>
                <div class="modal-body">
                    <form method="GET" action="/pur-r-report">
                        @csrf
                        <div class="row" style="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Supplier</label>
                                    <select class="form-control select-seller" name="customer">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Sales Officer</label>
                                    <select class="form-control select-sales_officer" name="sales_officer">


                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Warehouse</label>
                                    <select class="select-warehouse form-control" name="warehouse">
                                    </select>
                                </div>
                            </div>
                        </div>




                        <div class="row" style="">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product Category</label>
                                    <select class="form-control select-product_category" name="product_category">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product Company</label>
                                    <select class="form-control select-product_company" name="product_company">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product</label>
                                    <select class="form-control select-products" name="product">


                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Select Type</label>
                                <select class="form-control" name="type">
                                    <option value="1">Invoice Wise</option>
                                    <option value="2">Prodcut Wise</option>
                                </select>
                            </div>
                        </div>

                        <br>

                        <div class="row"
                            style="justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>
                            </div>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date" value=""
                                        id="" required>
                                </div>
                            </div>{{ $endDate }}
                        </div>
                </div>
            </div>
            <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                    <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="pur-report">
    <div class="modal-dialog">
        <div class="modal-content gen-led" style="height: min-content;">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Supplier Report</h4>
                <div class="modal-body">
                    <form method="GET" action="/pur-report">
                        @csrf
                        <div class="row" style="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Supplier</label>
                                    <select class="form-control select-buyer" name="supplier">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Sales Officer</label>
                                    <select class="form-control select-sales_officer" name="sales_officer">


                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Warehouse</label>
                                    <select class="select-warehouse form-control" name="warehouse">
                                    </select>
                                </div>
                            </div>
                        </div>




                        <div class="row" style="">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product Category</label>
                                    <select class="form-control select-product_category" name="product_category">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product Company</label>
                                    <select class="form-control select-product_company" name="product_company">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product</label>
                                    <select class="form-control select-products" name="product">


                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Select Type</label>
                                <select class="form-control" name="type">
                                    <option value="1">All</option>
                                    <option value="2">Chicken Only</option>
                                    <option value="3">Chick Only</option>
                                    <option value="4">Feed Only</option>
                                </select>
                            </div>
                        </div>

                        <div class="row"
                            style="justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>
                            </div>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                    <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="sale-r-report">
    <div class="modal-dialog">
        <div class="modal-content gen-led" style="height: min-content;">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Sale Return Report</h4>
                <div class="modal-body">
                    <form method="GET" action="/sale-r-report">
                        @csrf
                        <div class="row" style="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Customer</label>
                                    <select class="form-control select-buyer" name="customer">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Sales Officer</label>
                                    <select class="form-control select-sales_officer" name="sales_officer">


                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Warehouse</label>
                                    <select class="select-warehouse form-control" name="warehouse">
                                    </select>
                                </div>
                            </div>
                        </div>




                        <div class="row" style="">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product Category</label>
                                    <select class="form-control select-product_category" name="product_category">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product Company</label>
                                    <select class="form-control select-product_company" name="product_company">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product</label>
                                    <select class="form-control select-products" name="product">


                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Select Type</label>
                                <select class="form-control" name="type">
                                    <option value="1">Invoice Wise</option>
                                    <option value="2">Prodcut Wise</option>
                                </select>
                            </div>
                        </div>

                        <br>

                        <div class="row"
                            style="justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>
                            </div>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                    <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="sale-report">
    <div class="modal-dialog">
        <div class="modal-content gen-led" style="height: min-content;">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Customer Report</h4>
                <div class="modal-body">
                    <form method="GET" action="/sale-report">
                        @csrf
                        <div class="row" style="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Customer</label>
                                    <select class="form-control select-buyer" name="customer[]" multiple>


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Sales Officer</label>
                                    <select class="form-control select-sales_officer" name="sales_officer">


                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Warehouse</label>
                                    <select class="select-warehouse form-control" name="warehouse">
                                    </select>
                                </div>
                            </div>
                        </div>




                        <div class="row" style="">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product Category</label>
                                    <select class="form-control select-product_category" name="product_category">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product Company</label>
                                    <select class="form-control select-product_company" name="product_company">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product</label>
                                    <select class="form-control select-products" name="product">


                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Select Type</label>
                                <select class="form-control" name="type">
                                    <option value="1">All</option>
                                    <option value="2">Chicken Only</option>
                                    <option value="3">Chick Only</option>
                                    <option value="4">Feed Only</option>
                                </select>
                            </div>
                        </div>

                        <br>

                        <div class="row"
                            style="justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>
                            </div>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                    <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<div class="modal fade" id="sale-pur-report">
    <div class="modal-dialog">
        <div class="modal-content gen-led" style="height: min-content;">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Customer And Supplier Report</h4>
                <div class="modal-body">
                    <form method="GET" action="{{ Route('sale_pur.report') }}">
                        @csrf
                        <div class="row" style="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Customer</label>
                                    <select class="form-control select-buyer" name="customer">


                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Supplier</label>
                                    <select class="form-control select-buyer" name="supplier">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Sales Officer</label>
                                    <select class="form-control select-sales_officer" name="sales_officer">


                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Warehouse</label>
                                    <select class="select-warehouse form-control" name="warehouse">
                                    </select>
                                </div>
                            </div>
                        </div>




                        <div class="row" style="">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product Category</label>
                                    <select class="form-control select-product_category" name="product_category">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product Company</label>
                                    <select class="form-control select-product_company" name="product_company">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product</label>
                                    <select class="form-control select-products" name="product">


                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Select Type</label>
                                <select class="form-control" name="type">
                                    <option value="1">All</option>
                                    <option value="2">Chicken Only</option>
                                    <option value="3">Chick Only</option>
                                    <option value="4">Feed Only</option>
                                </select>
                            </div>
                        </div>

                        <br>

                        <div class="row"
                            style="justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>
                            </div>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                    <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="cus-led">
    <div class="modal-dialog">
        <div class="modal-content gen-led">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Customer Ledger</h4>
                <div class="modal-body">
                    <form method="GET" action="/cus-led">
                        @csrf
                        <div class="row" style="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Customer</label>
                                    <select class="form-control select-buyer" name="customer" required>


                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" id="type">
                                        <option value="1">Sale Invoice Wise</option>
                                        <option value="2">Receipt Voucher Wise</option>
                                        <option value="3">All Legder</option>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <br>

                        <div class="row"
                            style="justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>
                            </div>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                    <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>



<div class="modal fade" id="supplier-led">
    <div class="modal-dialog">
        <div class="modal-content gen-led">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Supplier Ledger</h4>
                <div class="modal-body">
                    <form method="GET" action="/supplier-led">
                        @csrf
                        <div class="row" style="">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Supplier</label>
                                    <select class="form-control select-seller" name="supplier" id="supplier">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">

                            <br>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn">Submit</button>

                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>




<div class="modal fade" id="profit-led">
    <div class="modal-dialog">
        <div class="modal-content gen-led">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Profit Report</h4>
                <div class="modal-body">
                    <form method="GET" action="/profit-led">
                        @csrf
                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <br>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn">Submit</button>

                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>



<div class="modal fade" id="stock-report">
    <div class="modal-dialog">
        <div class="modal-content stock-report">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Stock Report</h4>
                <div class="modal-body">
                    <form method="GET" action="/stock-report">
                        @csrf
                        <div class="row" style="">

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>Warehouse</label>
                                    <select class="select-warehouse form-control" name="warehouse" multiple="multiple">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>Select Product Category</label>
                                    <select class="form-control select-product_category" name="product_category" multiple="multiple">

                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Product Company</label>
                                    <select class="form-control select-product_company" name="product_company" multiple="multiple">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select class="form-control select-products" name="product" id="product" multiple="multiple">


                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <br>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn">Submit</button>

                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>



<div class="modal fade" id="warehouse-report">
    <div class="modal-dialog">
        <div class="modal-content warehouse-report">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Stock Report</h4>
                <div class="modal-body">
                    <form method="GET" action="/warehouse-report">
                        @csrf
                        <div class="row" style="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Warehouse</label>
                                    <select class="select-warehouse form-control" name="warehouse">
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">
                            <br>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="submit" style="
    text-align: center;
    margin-top: 3.5%;
">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn">Submit</button>

                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>

<script>
    // if ($('#gen-led').hasClass('show')) {

    // $('select').select2({})
    // }    

    //         $('#gen-led').hide()

    // $(document).ready(function () {

    //     $('.select-account').select2({
    //         placeholder: 'Enter a search term',
    //         ajax: {
    //             dataType: 'json',
    //             url: '/your-route/for-search', // Replace with your actual route
    //             delay: 400, // Optional: Delay before sending the request (milliseconds)
    //             data: function (params) {
    //                 return {
    //                     term: params.term // Search term entered by the user
    //                 };
    //             },
    //             processResults: function (data, page) {
    //                 return { results: data }; // Format the data for Select2
    //             }
    //         }
    //     });
    // });
</script>

<div class="modal fade" id="p-return">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Export</h4>
                <div class="modal-body">
                    <form method="GET" action="">
                        @csrf
                        <div class="form-group">
                            <label for="username">GR No</label>
                            <input type="number" step="any" min="1" class="form-control"
                                id="invoice" name="limit" required value="">
                        </div>

                        <button type="button" class="btn btn-primary" id="btn"
                            onclick="invoice()">Submit</button>

                    </form>
                    <script>
                        function invoice() {
                            let v = $("#invoice").val()

                            window.location.href = '/rp_med_invoice_form_id=' + v
                        }
                    </script>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>



<div class="modal fade" id="pi-search">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Search Purchase Invoice</h4>
                <div class="modal-body">
                    <form method="GET" action="/purchaseInvoice-search">
                        @csrf
                        <div class="form-group">
                            <label>Invoice No</label>
                            <input type="text" class="form-control" name="invoice_no" required>
                        </div>

                        <button type="submit" target class="btn btn-primary" id="btn">Search</button>

                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="p-voucher-report">
    <div class="modal-dialog">
        <div class="modal-content gen-led">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Payment Voucher Report</h4>
                <div class="modal-body">
                    <form method="GET" action="{{ Route('p_voucher.report') }}">
                        @csrf
                        <div class="row justify-content-between">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Company</label>
                                    <select class="form-control select-buyer" name="company">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Contra Account</label>
                                    <select class="form-control select-account" name="contra_account">

                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Sales Officer</label>
                                    <select class="form-control select-sales_officer" name="sales_officer">

                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Type</label>
                                    <select class="form-control" name="type">
                                        <option value="1">Payment Voucher Only</option>
                                        <option value="2">With Journal Voucher</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">

                            <br>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="submit" style="
    text-align: center;
">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn">Submit</button>

                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>







<div class="modal fade" id="r-voucher-report">
    <div class="modal-dialog">
        <div class="modal-content gen-led">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Receipt Voucher Report</h4>
                <div class="modal-body">
                    <form method="GET" action="{{ Route('r_voucher.report') }}">
                        @csrf
                        <div class="row justify-content-between">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Company</label>
                                    <select class="form-control select-buyer" name="company">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Contra Account</label>
                                    <select class="form-control select-account" name="contra_account">

                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Sales Officer</label>
                                    <select class="form-control select-sales_officer" name="sales_officer">

                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Type</label>
                                    <select class="form-control" name="type">
                                        <option value="1">Receipt Voucher Only</option>
                                        <option value="2">With Journal Voucher</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">

                            <br>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="submit" style="
    text-align: center;
">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn">Submit</button>

                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="e-voucher-report">
    <div class="modal-dialog">
        <div class="modal-content gen-led">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Expense Voucher Report</h4>
                <div class="modal-body">
                    <form method="GET" action="{{ Route('e_voucher.report') }}">
                        @csrf
                        <div class="row justify-content-between">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Assets</label>
                                    <select class="form-control select-assets-account" name="company">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Expense Account</label>
                                    <select class="form-control select-expense-account" name="expense_account">

                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Sales Officer</label>
                                    <select class="form-control select-sales_officer" name="sales_officer">

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">

                            <br>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="submit" style="
    text-align: center;
">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn">Submit</button>

                        <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="j-voucher-report">
    <div class="modal-dialog">
        <div class="modal-content gen-led">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Journal Voucher Report</h4>
                <div class="modal-body">
                    <form method="GET" action="{{ Route('journal-voucher.report') }}">
                        @csrf
                        <div class="row justify-content-between">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select From Account</label>
                                    <select class="form-control select-account" name="from_account">


                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select To Account</label>
                                    <select class="form-control select-account" name="to_account">

                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Sales Officer</label>
                                    <select class="form-control select-sales_officer" name="sales_officer">

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row"
                            style="    justify-content: space-between;
margin-top:12%;
text-align: center;
">

                            <br>
                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>From:</label>

                                    <input type="date" class="date" name="start_date"
                                        value="{{ $startDate }}" id="" required>
                                </div>

                            </div>

                            <div class="col-12-6">
                                <div class="form-group">
                                    <label>To:</label>
                                    <input type="date" class="date" name="end_date"
                                        value="{{ $endDate }}" id="" required>
                                </div>
                            </div>
                        </div>
                        <div class="submit" style="
    text-align: center;
">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                                <button type="button" class="btn btn-danger clear-btn">Clear Fields</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@push('s_script')
    <script>
        $(document).ready(function() {
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        });
        $('body').on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.form-check-input:not(#selectAll)');

        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            checkboxes.forEach((checkbox) => {
                checkbox.checked = isChecked;
            });
        });

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                selectAllCheckbox.checked = Array.from(checkboxes).every(
                    (checkbox) => checkbox.checked
                );
            });
        });
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.select-farm').select2({
            ajax: {
                url: '{{ route('select2.farm') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            },
            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });
        $('.select-farming-period').select2({
            ajax: {
                url: '{{ route('select2.farming_period') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.start_date + ' - ' + item.end_date,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            },
            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            // maximumSelectionLength:1,
        });
        $('.select-head-account').select2({
            ajax: {
                url: '{{ route('select2.head_account') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });
        $('.select-account').select2({
            ajax: {
                url: '{{ route('select2.account') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.account_name,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });
        $('.select-assets-account').select2({
            ajax: {
                url: '{{ route('select2.assets_account') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.account_name,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });
        $('.select-liability-account').select2({
            ajax: {
                url: '{{ route('select2.liability_account') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.account_name,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });
        $('.select-expense-account').select2({
            ajax: {
                url: '{{ route('select2.expense_account') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.account_name,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });
        $('.select-warehouse').select2({
            ajax: {
                url: '{{ route('select2.warehouse') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.warehouse_name,
                                id: item.warehouse_id
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });
        $('.select-zone').select2({
            ajax: {
                url: '{{ route('select2.zone') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.zone_name,
                                id: item.zone_id
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });

        $('.select-sales_officer').select2({
            ajax: {
                url: '{{ route('select2.sales_officer') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.sales_officer_name,
                                id: item.sales_officer_id
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });
        $('.select-product_category').select2({
            ajax: {
                url: '{{ route('select2.product_category') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.category_name,
                                id: item.product_category_id
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });

        $('.select-product_company').select2({
            ajax: {
                url: '{{ route('select2.product_company') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.company_name,
                                id: item.product_company_id
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });


        $('.select-buyer').select2({
            ajax: {
                url: '{{ route('select2.buyer') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.company_name,
                                id: item.buyer_id
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });


        $('.select-seller').select2({
            ajax: {
                url: '{{ route('select2.seller') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.company_name,
                                id: item.seller_id
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });


        $('.select-products').select2({
            ajax: {
                url: '{{ route('select2.products') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.product_name,
                                id: item.product_id,
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%'
        });

        $('.select-fin-products').select2({
            ajax: {
                url: '{{ route('select2.products') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.product_name,
                                id: item.product_id,
                                unit: item.unit,
                                pur_price: item.purchase_price,
                                sale_price: item.product_sale_price,
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });

        $('.select-fin-products').on('select2:select', function(e) {
            let selectedItem = e.params.data;
            let selectedOption = $(this).find('option:selected');
            selectedOption.attr('data-unit', selectedItem.data_unit);
            selectedOption.attr('data-stock', selectedItem.data_stock);
            selectedOption.attr('data-img', selectedItem.data_img);
        });


        $('.select-seller-buyer').select2({
            ajax: {
                url: '{{ route('select2.seller-buyer') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            let ref = '';
                            if (item.comp_ref === "S") {
                                ref = " (SELLER)";
                            } else if (item.comp_ref === "B") {
                                ref = " (BUYER)";
                            }
                            return {
                                text: item.company_name + ref,
                                id: item.id + item.comp_ref
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });
        $('.select-seller-buyer-sec').select2({
            ajax: {
                url: '{{ route('select2.seller-buyer') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            let ref = '';
                            if (item.comp_ref === "S") {
                                ref = " (SELLER)";
                            } else if (item.comp_ref === "B") {
                                ref = " (BUYER)";
                            }
                            return {
                                text: item.company_name + ref,
                                id: item.id + item.comp_ref
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });


        $('.select-buyer-invoice-no').select2({
            ajax: {
                url: '{{ route('select2.buyer_invoice_no') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        id: $("#company").find('option:selected').val(),
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.unique_id_name,
                                id: item.unique_id_name
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });


        $('.select-seller-invoice-no').select2({
            ajax: {
                url: '{{ route('select2.seller_invoice_no') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        id: $("#company").find('option:selected').val(),
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.unique_id_name,
                                id: item.unique_id_name
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });
        $('.select-all-invoice-no').select2({
            ajax: {
                url: '{{ route('select2.all_invoice_no') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        id: $("#company").find('option:selected').val(),
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.unique_id_name,
                                id: item.unique_id_name
                            };
                        })
                    };
                },
                cache: true
            },

            theme: 'bootstrap4',
            width: '100%',
            allowClear: true,
            placeholder: '',
            // maximumSelectionLength:1,
        });

        $("#company").on('change', function() {
            let invoice = $(".invoice_no").val('');
            let invoiceText = $(".invoice_no").text('');
        })
        // function companyInvoiceBuyer() {
        //     var company = $("#company").find('option:selected');
        //     var id = company.val()
        // $("#company").on('change', function() {

        //     let invoice = $("#invoice_no").val('');
        //     let invoiceText = $("#invoice_no").text('');

        //     let invoice2 = $("#invoice_no2").val('');
        //     let invoiceText2 = $("#invoice_no2").text('');
        // })
        //     $('.select-invoice-no').select2({
        //         ajax: {
        //             url: '{{ route('select2.buyer_invoice_no') }}',
        //             dataType: 'json',
        //             delay: 250,
        //             data: function(params) {
        //                 return {
        //                     q: params.term,
        //                     id: $("#company").find('option:selected').val(),
        //                 };
        //             },
        //             processResults: function(data) {
        //                 return {
        //                     results: $.map(data, function(item) {
        //                         return {
        //                             text: item.unique_id_name,
        //                             id: item.unique_id_name
        //                         };
        //                     })
        //                 };
        //             },
        //             cache: true
        //         },

        //         theme: 'bootstrap4',
        //         width: '100%',
        //         allowClear: true,
        //         placeholder: '',
        //     });
        // }

        // function companyInvoiceSeller() {
        //     var company = $("#company").find('option:selected');
        //     var id = company.val()
        //     $("#company").on('change', function() {

        //         let invoice = $("#invoice_no").val('');
        //         let invoiceText = $("#invoice_no").text('');

        //         let invoice2 = $("#invoice_no2").val('');
        //         let invoiceText2 = $("#invoice_no2").text('');
        //     })
        //     $('.select-invoice-no').select2({
        //         ajax: {
        //             url: '{{ route('select2.seller_invoice_no') }}',
        //             dataType: 'json',
        //             delay: 250,
        //             data: function(params) {
        //                 return {
        //                     q: params.term,
        //                     id: $("#company").find('option:selected').val(),
        //                 };
        //             },
        //             processResults: function(data) {
        //                 return {
        //                     results: $.map(data, function(item) {
        //                         return {
        //                             text: item.unique_id_name,
        //                             id: item.unique_id_name
        //                         };
        //                     })
        //                 };
        //             },
        //             cache: true
        //         },

        //         theme: 'bootstrap4',
        //         width: '100%',
        //         allowClear: true,
        //         placeholder: '',
        //     });



        $(document).ready(function() {
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        });
    </script>
@endpush
