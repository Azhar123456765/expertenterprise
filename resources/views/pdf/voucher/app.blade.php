<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.9/semantic.min.css'>
    <link rel="stylesheet" href="./style.css">

    <style>
        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 200mm;
                height: 297mm;
                margin: 10px
            }

            /* ... the rest of the rules ... */
        }

        body {
            background: #ffff;
            font-size: 0.9em !important;
        }

        .bigfont {
            font-size: 3rem !important;
        }

        .invoice {
            width: 970px !important;
            margin: 50px auto;
        }

        .logo {
            float: left;
            padding-right: 10px;
            margin: 10px auto;
        }

        dt {
            float: left;
        }

        dd {
            float: left;
            clear: right;
        }

        .customercard {
            min-width: 98.5%;
        }

        .itemscard {
            min-width: 98.5%;
            margin-left: 0.5%;
        }

        .logo {
            max-width: 5rem;
            margin-top: -0.25rem;
        }

        .invDetails {
            margin-top: 0rem;
        }

        .pageTitle {
            margin-bottom: -1rem;
        }

        /* CUSTOME */
        th {
            background-color: #f2f2f2;
        }

        .full-width tr th {
            font-weight: 1000 !important;
        }

        .ui.table {
            font-size: 0.8em;
        }

        table th {
            padding: 0.5px
        }

        table td {
            padding: 0.5px;
            font-size: 0.8em;

        }

        th {
            background: #ececec !important;
            border: 1px solid #7f7b7b !important;
        }

        td {
            border: 1px solid #7f7b7b !important;
        }

        .itemscard {
            border: 1px solid #7f7b7b !important;
        }

        .customercard {
            border: 1px solid #7f7b7b !important;
        }

        .cards {
            border: 1px solid #7f7b7b !important;
        }

        table {
            font-weight: bold;
        }

        table {
            font-weight: 1000 !important;
        }

        th {
            font-weight: bolder !important;
            font-size: 13px !important;
        }


        tfoot th {
            font-size: 12px !important;
        }

        td {
            font-size: 12px !important;
        }

        td span {
            font-weight: 700 !important;
            font-size: 11px !important;
        }


        .invDetails {
            font-size: 15px !important;
        }

        .text-center {
            text-align: center !important;
        }
        a{
            color: black !important;
        }
    </style>
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="container invoice">

        @yield('pdf_content')

        <!-- partial -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.9/semantic.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                sortAllTablesByDate(); // Sort all tables on document ready
            });

            function sortAllTablesByDate() {
                const tables = document.querySelectorAll('table'); // Select all <table> elements

                tables.forEach(table => {
                    const tbody = table.querySelector('tbody');
                    const rows = Array.from(tbody.querySelectorAll('tr'));

                    rows.sort((rowA, rowB) => {
                        const dateA = parseDate(rowA.cells[0].textContent.trim());
                        const dateB = parseDate(rowB.cells[0].textContent.trim());
                        return dateA - dateB; // For ascending order
                    });

                    rows.forEach(row => tbody.appendChild(row)); // Reorder rows in each table
                });
            }

            function parseDate(dateStr) {
                const [day, month, year] = dateStr.split('-').map(Number);
                return new Date(year, month - 1, day); // JavaScript Date object uses 0-based month
            }
        </script>
</body>

</html>
