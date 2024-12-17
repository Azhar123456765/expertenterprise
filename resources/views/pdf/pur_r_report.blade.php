<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
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
// $data = session()->get('Data');



$startDate = session()->get('Data')['startDate'];
$endDate = session()->get('Data')['endDate'];
$total_amount = session()->get('Data')['total_amount'];
$balance_amount = session()->get('Data')['balance_amount'];
$credit = session()->get('Data')['credit'];
$type = session()->get('Data')['type'];


// $name = App\Models\accounts::where('id',$account)->get();

// foreach ($name as $key => $value) {
//     $name2 = $value->account_name;
// }
// // $startDate = $value->startDate


?>
@include('pdf.head_pdf')


<h2 style="text-align: center;">Supplier Report</h2>
<div class="col-md-3"></div>

<div class="row">
    <h4 style="text-align: center;">FROM: {{$startDate}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TO: {{$endDate}}</h4>
    <h3 style="text-align: right; "><?php echo date("l"); ?>,<?php echo '  ' . date('d-m-Y'); ?></h3>
</div>
@if($type == 1)

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Invoice No</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Total Discount Amount</th>
            <th>Sales Tax</th>
            <th>total Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $SaleInvoice = session()->get('Data')['invoice'];
        print_r($SaleInvoice);
        if ($SaleInvoice != null) {
            # code...
            foreach ($SaleInvoice as $row) {
        ?>
                <tr style="text-align: center;">
                    <td>
                        <span><?php echo $row->date; ?></span>
                    </td>
                    <td>
                        <span><?php echo $row->unique_id; ?></span>
                    </td>
                    <td style="text-align: left
                ;">
                        <span><?php echo $row->remark; ?></span>
                    </td>
                    <td>
                        <span><?php echo $row->qty_total; ?></span>
                    </td>
                    <td>
                        <span><?php echo $row->dis_amount; ?></span>
                    </td>
                    <td style="text-align:right;">
                        <span><?php echo $row->sales_tax; ?></span>
                    </td>
                    <td style="text-align:right;">
                        <span><?php echo $row->amount_total; ?></span>
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
<h3 style="text-align:right; border:none;"><b>Total Amount Of Purchase With Tax:&nbsp;&nbsp;</b><span style="color: green;"><b>{{$balance_amount}}</b></span>
</h3>

@elseif($type == 2)

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Invoice No</th>
            <th>Product Name</th>
            <th>Qty</th>
            <th>total Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $SaleInvoice = session()->get('Data')['invoice'];
        print_r($SaleInvoice);
        if ($SaleInvoice != null) {
            # code...
            foreach ($SaleInvoice as $row) {
        ?>
                <tr style="text-align: center;">
                    <td>
                        <span><?php echo $row->date; ?></span>
                    </td>
                    <td>
                        <span><?php echo $row->unique_id; ?></span>
                    </td>
                    <td style="text-align: left
                ;">
                        <span><?php echo $row->product->product_name; ?></span>
                    </td>
                    <td>
                        <span><?php echo $row->pur_qty; ?></span>
                    </td>
                    <td style="text-align:right;">
                        <span><?php echo $row->amount; ?></span>
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
<h3 style="text-align:right; border:none;"><b>Total Amount Of Purchase With Tax:&nbsp;&nbsp;</b><span style="color: green;"><b>{{$balance_amount}}</b></span>
</h3>

@endif

<div class="pdf-time">
    Generated on: <?php echo date('Y-m-d  H:i:s'); ?>
</div>

</div>