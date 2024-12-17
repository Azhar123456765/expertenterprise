<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css" media="all" />
</head>

<body>
  <header class="clearfix">
    <div id="logo">
      <img src="logo.png">
    </div>
    <div id="company">
      @foreach ($sdata as $row)
      <h2 class="name">{{$row->company_name}}</h2>
      <div>{{$row->company_address}}</div>
      <div>{{$row->company_phone_number}}</div>
      <div><a href="mailto:{{$row->company_email}}">{{$row->company_email}}</a></div>
      @endforeach
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
          <th class="total">TOTAL</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $row)

        <tr>
          <td class="no">01</td>
          <td class="desc">
            <h3>Website Design</h3>Creating a recognizable design solution based on the company's existing visual identity
          </td>
          <td class="unit">$40.00</td>
          <td class="qty">30</td>
          <td class="total">$1,200.00</td>
        </tr>
        <tr>
          <td class="no">02</td>
          <td class="desc">
            <h3>Website Development</h3>Developing a Content Management System-based Website
          </td>
          <td class="unit">$40.00</td>
          <td class="qty">80</td>
          <td class="total">$3,200.00</td>
        </tr>
        <tr>
          <td class="no">03</td>
          <td class="desc">
            <h3>Search Engines Optimization</h3>Optimize the site for search engines (SEO)
          </td>
          <td class="unit">$40.00</td>
          <td class="qty">20</td>
          <td class="total">$800.00</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"></td>
          <td colspan="2">SUBTOTAL</td>
          <td>$5,200.00</td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td colspan="2">TAX 25%</td>
          <td>$1,300.00</td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td colspan="2">GRAND TOTAL</td>
          <td>$6,500.00</td>
        </tr>
      </tfoot>
    </table>
    <div id="thanks">Thank you!</div>
    <div id="notices">
      <div>NOTICE:</div>
      <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
    </div>
  </main>
  <footer>
    Invoice was created on a computer and is valid without the signature and seal.
  </footer>
</body>

</html>