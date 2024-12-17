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

$startDate = session()->get('Data')['startDate'] ?? null;
$endDate = session()->get('Data')['endDate'] ?? null;
$qty = session()->get('Data')['qty'] ?? null;
$warehouse = session()->get('Data')['warehouse'] ?? null;
?>
@include('pdf.head_pdf')

<h2 style="text-align: center;">Warehouse Report</h2>
<div class="col-md-3"></div>

<div class="row">
    <h4 style="text-align: center;">FROM: {{$startDate}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TO: {{$endDate}}</h4>
    <h3 style="text-align: left;">Warehouse:<span style="color:green;">&nbsp;{{$warehouse ?? ''}}</span></h3>
    <br>
    <h3 style="text-align: right;"><?php echo date("l"); ?>,<?php echo '  ' . date('d-m-Y'); ?></h3>
</div>
<table>
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Purchase Price</th>
            <th>Company</th>
            <th>Description</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = session()->get('Data')['query'];
        foreach ($query as $row) {
        ?>
            <tr style="text-align: center;">
                <td>
                    <span><?php echo $row->product->product_name; ?></span>
                </td>
                <td>
                    <span><?php echo $row->pur_price; ?></span>
                </td>
                
            </tr>
        <?php
        }
        ?>
    </tbody>
  

    </h3>

</table>

<div class="pdf-time">
    Generated on: <?php echo date('Y-m-d H:i:s'); ?>
</div>

</div>