@extends('layout.app') @section('title', 'Sale Invoice DO') @section('content')

<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sale Invoice DO</h3>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>

                        <th>S.NO</th>
                        <th>Invoice No</th>
                        <th>Customer</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $serial = 1;
                    @endphp
                    @foreach ($invoices as $row)
                        <tr class="tr-shadow">
                            <td>{{ $serial }}</td>
                            <td>{{ $row->unique_id }}</td>
                            <td>{{ $row->customer->company_name }}</td>
                            <td>{{ $row->created_at }}</td>
                            <td>{{ $row->updated_at }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" onclick="changeInvoiceStatus({{$row->unique_id}})">Pending</button>
                            </td>
                        </tr>
                        @php
                            $serial++;
                        @endphp
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
<script>
    function changeInvoiceStatus(id) {
        const url = "{{ route('changeSaleInvoiceStatus', ':id') }}".replace(':id', id);
        window.location.href = url;
    }
</script>
@endsection
