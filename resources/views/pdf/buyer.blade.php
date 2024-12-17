<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-number {
            font-weight: bold;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 8px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #f2f2f2;
        }

        .invoice-total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>Invoice</h1>
        <p class="invoice-number">Invoice Number: [Invoice Number]</p>
        <p>Date: [Invoice Date]</p>
        <p>Due Date: [Due Date]</p>
    </div>

    <div class="client-details">
        <h3>Client Details</h3>
        <p>Client Name: [Client Name]</p>
        <p>Client Address: [Client Address]</p>
        <p>City, State, ZIP: [Client City, State, ZIP]</p>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>[Item 1]</td>
                <td>[Quantity]</td>
                <td>[Unit Price]</td>
                <td>[Total]</td>
            </tr>
            <!-- Add more rows for additional items -->
        </tbody>
    </table>

    <div class="invoice-total">
        <p>Total: [Total Amount]</p>
    </div>

</body>
</html>
