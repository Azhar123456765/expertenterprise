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

$amount = session()->get('Data')['amount'] ?? null;
$credit = session()->get('Data')['credit'] ?? null;
$debit = session()->get('Data')['debit'] ?? null;
$account = session()->get('Data')['id'] ?? null;
$name = App\Models\accounts::where('id', $account)->get();

foreach ($name as $key => $value) {
    $name2 = $value->account_name;
}
// $startDate = $value->startDate


?>
@include('pdf.head_pdf')

<h2 style="text-align: center;">Gross Profit Report</h2>
<div class="col-md-3"></div>

<div class="row">
    <h4 style="text-align: center;">FROM: {{$startDate}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TO: {{$endDate}}</h4>
    <h3 style="text-align: right; "><?php echo date("l"); ?>,<?php echo '  ' . date('d-m-Y'); ?></h3>
</div>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Reference</th>
            <th>Company</th>
            <th>Description</th>
            <th>Credit</th>
            <th>Debit</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query1 = session()->get('Data')['query1'];
        foreach ($query1 as $row) {
        ?>
            <tr style="text-align: center;">
                <td>
                    <span><?php echo $row->date; ?></span>
                </td>
                <td>
                    <span><?php echo $row->unique_id; ?></span>
                </td>
                <td>
                    <span><?php echo $row->customer->company_name; ?></span>
                </td>
                <td style="text-align: left
        ;">
                    <span><?php echo $row->remark; ?></span>
                </td>

                <td style="text-align:right;">
                    <span><?php echo $row->amount_paid; ?></span>
                </td>
                <td style="text-align:right;">
                    <span>0.00</span>
                </td>

            </tr>
        <?php
        }
        ?>
        <?php
        $query2 = session()->get('Data')['query2'];
        foreach ($query2 as $row) {
        ?>
            <tr style="text-align: center;">
                <td>
                    <span><?php echo $row->date; ?></span>
                </td>
                <td>
                    <span><?php echo $row->unique_id; ?></span>
                </td>
                <td>
                    <span><?php echo $row->supplier->company_name; ?></span>
                </td>
                <td style="text-align: left
        ;">
                    <span><?php echo $row->remark; ?></span>
                </td>

                <td style="text-align:right;">
                    <span><?php echo $row->amount_total; ?></span>
                </td>
                <td style="text-align:right;">
                    <span>0.00</span>
                </td>

            </tr>
        <?php
        }
        ?>
        <?php
        $query3 = session()->get('Data')['query3'];
        foreach ($query3 as $row) {
        ?>
            <tr style="text-align: center;">
                <td>
                    <span><?php echo $row->date; ?></span>
                </td>
                <td>
                    <span><?php echo $row->unique_id; ?></span>
                </td>
                <td>
                    <span>{{$row->company_ref == "B" ? $row->cusotmer->company_name : $row->supplier->company_name}}</span>

                </td>
                <td style="text-align: left
        ;">
                    <span><?php echo $row->remark; ?></span>
                </td>
                <td style="text-align:right;">
                    <span>0.00</span>
                </td>
                <td style="text-align:right;">
                    <span><?php echo $row->amount_total; ?></span>
                </td>
            </tr>
        <?php
        }
        ?>

        <?php
        $query4 = session()->get('Data')['query4'];
        foreach ($query4 as $row) {
        ?>
            <tr style="text-align: center;">
                <td>
                    <span><?php echo $row->date; ?></span>
                </td>
                <td>
                    <span><?php echo $row->unique_id; ?></span>
                </td>
                <td>
                    <span>{{$row->company_ref == "B" ? $row->customer->company_name : $row->supplier->company_name}}</span>
                </td>
                <td style="text-align: left
        ;">
                    <span><?php echo $row->remark; ?></span>
                </td>
                <td style="text-align:right;">
                    <span><?php echo $row->amount_total; ?></span>
                </td>
                <td style="text-align:right;">
                    <span>0.00</span>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot style="color: darkblue; text-align:right;">
        <td colspan="4" style="text-align:right; border:none;"><b>Total:</b></td>
        <td style="border:none;"><b>{{$credit}}</b></td>
        <td style="border:none;"><b>{{$debit}}</b></td>

    </tfoot>

    <h3 style="text-align:right; border:none;"><b>Gross Profit:&nbsp;&nbsp;</b><span style="color: green;"><b>{{$debit-$credit}}</b></span>
    </h3>

</table>

<div class="pdf-time">
    Generated on: <?php echo date('Y-m-d H:i:s'); ?>
</div>

</div>