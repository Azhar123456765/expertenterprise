<style>


    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 120px;
        /* Adjust the logo width as needed */
    }

    .address {
        font-weight: normal;
        text-align: right;
        margin-bottom: 78px;

    }

    .pdf-time {
        position: fixed;
        bottom: 20px;
        left: 20px;
        font-size: 12px;
        color: #999;
    }

    * {
        font-family: "Poppins", sans-serif !important;
    }
    table{
        font-size: 16px;
    }
</style>

<head>
    <title>PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
</head>
@php

$org = App\Models\Organization::all();
foreach ($org as $key => $value) {

$logo = $value->logo;
$address = $value->address;


}
@endphp
<div class="container">
    <div id="pdf_table">
        <div class="header">
            <div>
                <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($logo))) }}" alt="Organization Logo" class="logo">

            </div>
            <u>
                <div class="address">
            </u>

            <p>Head Office Address:</p>
            <br>
            <p>{{$address}}</p>
        </div>
    </div>

    @yield('content')

</div>