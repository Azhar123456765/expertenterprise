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
</style>

<div id="pdf_table">
  <div class="header">
    <div>
      <img src="path/to/your/logo.png" alt="Organization Logo" class="logo">
    </div>
    <div class="address">
      Head Office Address:
      <br>
      <p> Your Head Office Address Here</p>
    </div>
  </div>

  <h3 style="text-align: center;">seller</h3>

  <table>
    <thead>
      <tr>
        <th>S.no</th>
        <th>username</th>
        <th>EMAIL</th>
        <th>PHONE NUMBER</th>
        <th>ROLE</th>
        <th>Access</th>
        <th>no.records</th>
        <th>seller Type</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $serialNumber = 1; // Initialize serial number counter
      $seller = session()->get('pdf_data');
      foreach ($seller as $row) {
      ?>
        <tr>
          <td><?php echo $serialNumber; ?></td>
          <td>
            <span><?php echo $row->company_name; ?></span>
            </a>
          </td>
          <td>
            <span><?php echo $row->contact_person; ?></span>
          </td>
          <td>
            <span><?php echo $row->debit; ?></span>
          </td>
          <td>
            <span><?php echo $row->credit; ?></span>
          </td>
          <td>
            <span><?php echo $row->total_records; ?></span>
          </td>
          <td>
            <span><?php echo $row->seller_type; ?></span>
          </td>
        </tr>
      <?php
        $serialNumber++; // Increment serial number after each row
      }
      ?>
    </tbody>
  </table>

  <div class="pdf-time">
    Generated on: <?php echo date('Y-m-d H:i:s'); ?>
  </div>

</div>