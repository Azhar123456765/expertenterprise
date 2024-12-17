<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="pdf_assets/style.css" media="all" />
</head>
@php

$org = App\Models\Organization::all();
foreach ($org as $key => $value) {

$logo = $value->logo;
$address = $value->address;
$name = $value->organization_name;
$phone_number = $value->phone_number;
$email = $value->email;


}

$data = session()->get('sale_invoice_pdf_data');
$sdata = session()->get('s_sale_invoice_pdf_data');

// $product_pdf_data = session()->get('product_pdf_data');
// $sales_officer_pdf_data = session()->get('sales_officer_pdf_data');
// $seller_pdf_data = session()->get('seller_pdf_data');


@endphp

<body>
  <header class="clearfix">
    <div id="logo">
      <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($logo))) }}">
    </div>
    <div id="company">
      <h2 class="name">{{$name}}</h2>
      <div>{{$address}}</div>
      <div>{{$phone_number}}</div>
      <div><a href="mailto:{{$email}}">{{$email}}</a></div>
    </div>
    </div>
  </header>
  <main>
    @foreach ($sdata as $row)

    <div id="details" class="clearfix">
      <div id="client">
        <div class="to">INVOICE TO:</div>
        <h2 class="name">{{$row->company_name}}</h2>
        <div class="address">{{$row->company_address}}</div>
        <div class="email"><a href="mailto:{{$row->company_email}}">{{$row->company_email}}</a></div>
      </div>
      <div id="invoice">
        <h1>INVOICE: {{$row->unique_id}}</h1>
        <div class="date">Date of Invoice: {{$row->date}}</div>
        <div class="date">Due Date: {{$row->due_date}}</div>
      </div>
    </div>

    @endforeach
    <table border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th class="no">#</th>
          <th class="desc">DESCRIPTION</th>
          <th class="unit">UNIT PRICE</th>
          <th class="qty">QUANTITY</th>
          <th class="qty">DISCOUNT AMOUNT</th>
          <th class="total">TOTAL</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $key => $row)

        <tr>
          <td class="no" style="text-align: center;">{{$key+1}}</td>
          <td class="desc">
            <h3>{{$row->product->product_name}}</h3>
          </td>
          <td class="unit">{{$row->sale_price}} </td>
          <td class="qty">{{$row->sale_qty}}</td>
          <td class="qty">{{$row->dis_amount}}</td>
          <td class="total">{{$row->amount}}</td>
        </tr>
        @endforeach
      </tbody>
      @foreach ($sdata as $row)

      <tfoot>
        <tr>
          <td colspan="3"></td>
          <td colspan="2">SUBTOTAL</td>
          <td>{{$row->amount_total}}</td>
        </tr>
        <tr>
          <td colspan="3"></td>
          <td colspan="2">Previous Balance</td>
          <td>{{$row->previous_balance}}</td>
        </tr>
        <tr>
          <td colspan="3"></td>
          <td colspan="2">Cartage</td>
          <td>{{$row->cartage}}</td>
        </tr>
        <tr style="font-weight: 900;">
          <td colspan="3"></td>
          <td colspan="2">GRAND TOTAL</td>
          <td>{{$row->grand_total}}</td>
        </tr>
        <tr>
          <td colspan="3"></td>
          <td colspan="2">AMOUNT PAID</td>
          <td>{{$row->amount_paid}}</td>
        </tr>
        <tr>
          <td colspan="3"></td>
          <td colspan="2">BALANCE AMOUNT</td>
          <td>{{$row->balance_amount}}</td>
        </tr>
      </tfoot>
      @endforeach
    </table>
    <div id="thanks">Thank you!</div>
    <div id="notices">
      <div>NOTICE:</div>
    @foreach ($sdata as $row)
      <div class="notice">{{$row->remark}}</div>
@endforeach
    </div>
  </main>
  <footer>
    Invoice was created on a computer and is valid without the signature and seal.
  </footer>
</body>

</html>