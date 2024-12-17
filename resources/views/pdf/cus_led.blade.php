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



$startDate = session()->get('Data')['startDate'] ?? null;
$endDate = session()->get('Data')['endDate'] ?? null;
$total_amount = session()->get('Data')['total_amount'] ?? null;
$balance_amount = session()->get('Data')['balance_amount'] ?? null;
$credit = session()->get('Data')['credit'] ?? null;
$grand_total = session()->get('Data')['grand_total' ] ?? null;
$debit = session()->get('Data')['debit'] ?? null;
$customerName = session()->get('Data')['customerName'] ?? null;
$type = session()->get('Data')['type'] ?? null;

$querysi = session()->get('Data')['ledgerDatasi'] ?? null;
$queryrv = session()->get('Data')['ledgerDatarv'] ?? null;
$querypv = session()->get('Data')['ledgerDatapv'] ?? null;

?>

@include('pdf.head_pdf')


<h2 style="text-align: center;">Customer Ledger</h2>
<div class="col-md-3"></div>

<div class="row">
    <h4 style="text-align: center;">FROM: {{$startDate}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TO: {{$endDate}}</h4>
    <h3 style="text-align: left; color: darkblue;">Customer:&nbsp;{{$customerName}}</h3>
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
            <th>Previous Balance</th>
            <th>total Amount</th>
            <th>amount Paid</th>
            <th>Balance Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $SaleInvoice = session()->get('Data')['invoice'] ?? null;

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
                    <td style="text-align:right;">
                        <span><?php echo $row->previous_balance; ?></span>
                    </td>
                    <td style="text-align:right;">
                        <span><?php echo $row->amount_total; ?></span>
                    </td>
                    <td style="text-align:right;">
                        <span><?php echo $row->amount_paid; ?></span>
                    </td>
                    <td style="text-align:right;">
                        <span><?php echo $row->balance_amount; ?></span>
                    </td>
                </tr>

        <?php
            }
        } else {
            echo 'No record Found';
        }
        ?>
    </tbody>
    <tfoot style="color: darkblue; text-align:right;">
        <td colspan="4" style="text-align:right; border:none;"><b>Total:</b></td>
        <td><b>{{$debit}}</b></td>
        <td><b>{{$total_amount}}</b></td>
        <td><b>{{$credit}}</b></td>
        <td><b>{{$balance_amount}}</b></td>

    </tfoot>
</table>
<h3 style="text-align:right; border:none;"><b>Total Customer Debit:&nbsp;&nbsp;</b><span style="color: green;"><b>{{$grand_total}}</b></span>
</h3>
@elseif($type == 2)

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Invoice No</th>
            <th>Narration</th>
            <th>Amount Paid</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $SaleInvoice = session()->get('Data')['invoice'] ?? null;

        if ($SaleInvoice != null) {
            # code...
            foreach ($SaleInvoice as $row) {
        ?>
                <tr style="text-align: center;">
                    <td>
                        <span><?php echo $row->date; ?></span>
                    </td>
                    <td>
                        <span>{{$row->Invoice->unique_id?? ''}}</span>
                    </td>
                    <td style="text-align: left
                ;">
                        <span><?php echo $row->narration; ?></span>
                    </td>
                    <td style="text-align:right;">
                        <span><?php echo $row->amount; ?></span>
                    </td>
                </tr>

        <?php
                $buyerDebit = $row->debit;
            }
        } else {
            echo 'No record Found';
        }
        ?>
    </tbody>
    <tfoot style="color: darkblue; text-align:right;">
        <td colspan="3" style="text-align:right; border:none;"><b>Total:</b></td>
        <td><b>{{$total_amount}}</b></td>
    </tfoot>
    <tfoot style="color: purple; text-align:right;">
        <td colspan="3" style="text-align:right; border:none;"><b>Remaining Total:</b></td>
        <td><b>{{$debit-$total_amount}}</b></td>
    </tfoot>
</table>

@elseif($type == 3)

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Reference No</th>
            <th>Description</th>
            <th>Credit</th>
            <th>Debit</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($querysi as $row) {
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
                <td style="text-align:right;">
 +  +++                 <span>0.00</span>
                </td>
                <td style="text-align:right;">
                    <span><?php echo $row->grand_total; ?></span>
                </td>
            </tr>

        <?php
        }
        ?>

        <?php
        foreach ($queryrv as $row) {
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
                <td style="text-align:right;">
                    <span>0.00</span>
                </td>
                +
                <td style="text-align:right;">
                    <span><?php echo $row->amount_total; ?></span>
                </td>
            </tr>

        <?php
        }
        ?>

        <?php
        foreach ($querypv as $row) {
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
        <td colspan="3" style="text-align:right; border:none;"><b>Total:</b></td>
        <td><b>{{$credit}}</b></td>
        <td><b>{{$debit}}</b></td>
    </tfoot>
</table>

@endif




<div class="pdf-time">
    Generated on: <?php echo date('Y-m-d  H:i:s'); ?>
</div>

</div>






























