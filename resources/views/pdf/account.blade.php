@include('pdf.head_pdf')


<table>
    <thead>
        <tr>
            <th>S.no</th>
            <th>Account Name</th>
            <th>Created At</th>
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
                    <span><?php echo $row->account_name; ?></span>
                    </a>
                </td>
                <td>
                    <span><?php echo $row->created_at; ?></span>
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