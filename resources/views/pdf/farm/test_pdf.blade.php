@extends('pdf.head_pdf') @section('content')
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 150px;
        /* Adjust the logo width as needed */
    }

    .address {
        font-weight: normal;
        text-align: right;
    }

    .pdf-time {
        position: fixed;
        bottom: 20px;
        left: 20px;
        font-size: 12px;
        color: #999;
    }

    .col-md-3 {
        display: flex;
        flex-direction: row;
    }
</style>
<?php
$startDate = session()->get('Data')['startDate'] ?? null;
$endDate = session()->get('Data')['endDate'] ?? null;
$total_amount = session()->get('Data')['total_amount'] ?? null;
$balance_amount = session()->get('Data')['balance_amount'] ?? null;
$credit = session()->get('Data')['credit'] ?? null;
$type = session()->get('Data')['type'] ?? null;
$qty_total = session()->get('Data')['qty_total'] ?? null;
$dis_total = session()->get('Data')['dis_total'] ?? null;
$amount_total = session()->get('Data')['amount_total'] ?? null;
?>


@if($type == 1)
<h2 style="text-align: center;">Customer Report</h2>

<div class="row">
    <h4 style="text-align: center;">FROM: {{$startDate}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TO: {{$endDate}}</h4>
    <h3 style="text-align: right; ">{{date("l")}},{{ '  ' . date('d-m-Y')}}</h3>
</div>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Invoice No</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Cartage</th>
            <th>Previous Balance</th>
            <th>total Amount</th>
            <th>amount Paid</th>
            <th>Balance Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $SaleInvoice = session()->get('Data')["invoice"];

        if ($SaleInvoice != null) {
            # code...
            foreach ($SaleInvoice as $row) {
        ?>
                <tr style="text-align: center;">
                    <td>
                        <span>{{$row->date}}</span>
                    </td>
                    <td>
                        <span>{{$row->unique_id}}</span>
                    </td>
                    <td style="text-align: left
                ;">
                        <span>{{$row->remark}}</span>
                    </td>
                    <td>
                        <span>{{$row->qty_total}}</span>
                    </td>
                    <td>
                        <span>{{$row->cartage}}</span>
                    </td>
                    <td style="text-align:right;">
                        <span>{{$row->previous_balance}}</span>
                    </td>
                    <td style="text-align:right;">
                        <span>{{$row->amount_total}}</span>
                    </td>
                    <td style="text-align:right;">
                        <span>{{$row->amount_paid}}</span>
                    </td>
                    <td style="text-align:right;">
                        <span>{{$row->balance_amount}}</span>
                    </td>
                </tr>

        <?php
            }
        } else {
            echo 'No record Found';
        }
        ?>
    </tbody>
</table>
<h3 style="text-align:right; border:none;"><b>Total Amount Of Sales:&nbsp;&nbsp;</b><span style="color: green;"><b>{{$balance_amount}}</b></span>
</h3>
@elseif($type == 2)

<h2 style="text-align: center;">Customer Report (Detail Wise)</h2>

<div class="row">
    <h4 style="text-align: center;">FROM: {{$startDate}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TO: {{$endDate}}</h4>
    <h3 style="text-align: right; ">{{date("l")}},{{ '  ' . date('d-m-Y')}}</h3>
</div>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Invoice No</th>
            <th>Book No</th>
            <th>Product Name</th>
            <th>Per Price</th>
            <th>Qty</th>
            <th>Discount</th>
            <th>total Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $SaleInvoice = session()->get('Data')["invoice"];
        $unique_ids = [];
        $last_unique_id = null;
        $last_row_key = null;

        foreach ($SaleInvoice as $key => $row) {

            if ($last_unique_id !== $row->unique_id) {
                // Add tfoot for the last row of the previous group
                if ($last_row_key !== null) {
                    echo '                    <tr>
                    <td colspan="8" style="border: none !important;">&nbsp;</td>
                </tr>';
                }

                // Update the last_unique_id and last_row_key for the next iteration
                $last_unique_id = $row->unique_id;
                $last_row_key = $key;
            }

            $last_unique_id = $row->unique_id;
            $next_key = $key + 1;
            $next_unique_id = isset($SaleInvoice[$next_key]) ? $SaleInvoice[$next_key]->unique_id : null;

        ?>


            <tr style="text-align: center;">
                <td>
                    <span style="width:8px;">{{$row->date}}</span>
                </td>
                <td>
                    <span>{{$row->unique_id}}</span>
                </td>
                <td>
                    <span>{{$row->book}}</span>
                </td>
                <td style="text-align: left;">
                    <span>{{$row->product->product_name ?? 'null'}}</span>
                </td>
                <td>
                    <span>{{$row->sale_price}}</span>
                </td>
                <td>
                    <span>{{$row->sale_qty}}</span>
                </td>
                <td>
                    <span>{{$row->dis_amount}}</span>
                </td>
                <td style="text-align:right;">
                    <span>{{$row->amount}}</span>
                </td>
            </tr>
            <?php
            if ($next_unique_id !== $row->unique_id || $next_key === count($SaleInvoice) - 1) {
            ?>
    <tfoot style="color: green; font-weight: bolder ;">
        <tr>
            <td colspan="5" style="text-align:right; border: none !important; "><span style="color:blue;">{{$row->customer->company_name}}'s</span> &nbsp; Invoice# {{$row->unique_id}} Total:</td>
            <td style="text-align:center;  background-color: lightgray;">{{$row->qty_total}}</td>
            <td style="text-align:center; background-color: lightgray;">{{$row->dis_total}}</td>
            <td style="text-align:right; background-color: lightgray;">{{$row->amount_total}}</td>
        </tr>
    </tfoot>
<?php
            }
        }
?>


</tbody>

<tfoot style="color: blue; font-weight: bolder ;">
    <tr>
        <td colspan="5" style="text-align:right; border: none !important; ">Grand Total:</td>
        <td style="text-align:center;  background-color: lightgray;">{{$qty_total}}</td>
        <td style="text-align:center; background-color: lightgray;">{{$dis_total}}</td>
        <td style="text-align:right; background-color: lightgray;">{{$amount_total}}</td>
    </tr>
</tfoot>

</table>
@elseif($type == 3)

<h2 style="text-align: center;">Customer Report (Detail Wise)</h2>

<div class="row">
    <h4 style="text-align: center;">FROM: {{$startDate}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TO: {{$endDate}}</h4>
    <h3 style="text-align: right; ">{{date("l")}},{{ '  ' . date('d-m-Y')}}</h3>
</div>

<table>
    <thead>
        <tr>
            <th>Invoice No</th>
            <th>Date</th>
            <th>Customer Name</th>
            <th>Unit</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Discount</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $SaleInvoice = session()->get('Data')["invoice"];
        $unique_ids = [];
        $last_unique_id = null;
        $last_row_key = null;

        foreach ($SaleInvoice as $key => $row) {

            if ($last_unique_id !== $row->product_id) {
                // Add tfoot for the last row of the previous group
                if ($last_row_key !== null) {
                    echo '                    <tr>
                    <td colspan="8" style="border: none !important;">&nbsp;</td>
                </tr>';
                }

                // Update the last_unique_id and last_row_key for the next iteration
                $last_unique_id = $row->product_id;
                $last_row_key = $key;
            }

            $next_key = $key + 1;
            $next_unique_id = isset($SaleInvoice[$next_key]) ? $SaleInvoice[$next_key]->product_id : null;


        ?>


            <tr style="text-align: center;">
                <td>
                    <span>{{$row->unique_id}}</span>

                </td>
                <td>
                    <span style="width:8px;">{{$row->date}}</span>
                </td>
                <td>
                    <span>{{optional($row->customer)->company_name}}</span>
                </td>
                <td style="text-align: left;">
                    <span>{{$row->product->product_name}}</span>
                </td>
                <td>
                    <span>{{$row->sale_price}}</span>
                </td>
                <td>
                    <span>{{$row->sale_qty}}</span>
                </td>
                <td>
                    <span>{{$row->dis_amount}}</span>
                </td>
                <td style="text-align:right;">
                    <span>{{$row->amount}}</span>
                </td>
            </tr>
            <?php
            if ($next_unique_id !== $row->product_id || $next_key === count($SaleInvoice) - 1) {
            ?>
    <tfoot style="color: green; font-weight: bolder ;">
        <tr>
            <td colspan="5" style="text-align:right; border: none !important; "><span style="color:blue;">{{$row->product_name}}'s</span> &nbsp; Total:</td>
            <td style="text-align:center;  background-color: lightgray;">{{$SaleInvoice[$key]->where('item', $row->product_id)->sum('sale_qty')}}</td>
            <td style="text-align:center; background-color: lightgray;">{{$SaleInvoice[$key]->where('item', $row->product_id)->sum('dis_amount')}}</td>
            <td style="text-align:right; background-color: lightgray;">{{$SaleInvoice[$key]->where('item', $row->product_id)->sum('amount')}}</td>
        </tr>
    </tfoot>
<?php
            }
        }
?>


</tbody>

<tfoot style="color: blue; font-weight: bolder ;">
    <tr>
        <td colspan="5" style="text-align:right; border: none !important; ">Grand Total:</td>
        <td style="text-align:center;  background-color: lightgray;">{{$qty_total}}</td>
        <td style="text-align:center; background-color: lightgray;">{{$dis_total}}</td>
        <td style="text-align:right; background-color: lightgray;">{{$amount_total}}</td>
    </tr>
</tfoot>

</table>


@endif


@endsection