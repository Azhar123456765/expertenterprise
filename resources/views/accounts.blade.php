@extends('layout.app') @section('title', 'Accounts')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Accounts</h3>
                    <a href="" data-bs-toggle="modal" data-bs-target="#login-modal" class="btn btn-success float-right">
                        <i class="fa fa-plus"></i> &nbsp; Add Account</a>
                </div>
            </div>
            <style>
                .card #invoiceForm .select2-container--classic {
                    width: 295px !important;
                    height: 27px !important;
                    margin-top: 1%;
                    margin-left: 2.5%;
                    line-height: 25px !important;
                    height: 25px !important;
                }
            </style>
            <div class="d-flex justify-content-center align-items-center my-3 px-5">
                <h5>Head Of Accounts:</h5>
                <select class="form-control account-select m-auto w-50" id="head_account" onchange="sub_head()">
                    @foreach ($head_accounts as $row)
                        <option value="{{ $row->id }}" {{ $head == $row->id ? 'selected' : '' }}>{{ $row->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-center align-items-center my-3 px-5">
                <h5>Sub-Head Of Accounts:</h5>
                <select class="form-control account-select m-auto w-50" id="sub_head_account" name="property"
                    onchange="sub_head()">
                    @foreach ($sub_head_accounts as $row)
                        <option value="{{ $row->id }}" {{ $sub_head == $row->id ? 'selected' : '' }}>
                            {{ $row->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="card-body">

                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S.NO</th>
                            <th>account Name</th>
                            <th>Qty</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <div class="modal fade" id="login-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add account</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="/add_account" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <label for="username">account Name</label>
                                <input type="text" class="form-control" name="account_name" required>
                                <input type="hidden" name="account_category" value="${id}">
                            </div>

                            <div class="form-group">
                                <label for="username">Qty</label>
                                <input type="number" step="any" class="form-control" name="account_qty">
                            </div>

                            <div class="form-group">
                                <label for="username">Debit</label>
                                <input type="number" step="any" class="form-control" name="account_debit">
                            </div>
                            <div class="form-group">
                                <label for="username">Credit</label>
                                <input type="number" step="any" class="form-control" name="account_credit">
                            </div>
                            <input type="hidden" step="any" class="form-control" id="account_category"
                                name="account_category">

                            <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>




    @push('s_script')
        <script>
            function headFunc() {

                var head_id = $("#head_account").find('option:selected').val();
                var sub_head_id = $("#sub_head_account").find('option:selected').val();

                window.location.href = '{{ route('account.index', [':head', ':sub_head']) }}'.replace(':sub_head', sub_head_id)
                    .replace(':head', head_id);
            }

            function sub_head() {

                var head_id = $("#head_account").find('option:selected').val();
                var sub_head_id = $("#sub_head_account").find('option:selected').val();

                window.location.href = '{{ route('account.index', [':head', ':sub_head']) }}'.replace(':sub_head', sub_head_id)
                    .replace(':head', head_id);
            }
        </script>
        <script>
            $(document).ready(function() {
                var head_id = $("#head_account").find('option:selected').val();
                var sub_head_id = $("#sub_head_account").find('option:selected').val();

                $('#account_category').val(sub_head_id)
                $('#table').DataTable({
                    ajax: '{{ route('account.data', [':head', ':sub_head']) }}'.replace(':sub_head',
                            sub_head_id)
                        .replace(':head', head_id),
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'account_name',
                            name: 'account_name'
                        },
                        {
                            data: 'account_qty',
                            name: 'account_qty'
                        },
                        {
                            data: 'account_debit',
                            name: 'account_debit'
                        },
                        {
                            data: 'account_credit',
                            name: 'account_credit'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },

                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
    <div class="table-data-feature">

<a href="#" data-bs-toggle="modal" data-bs-target="#edit_modal${row.id}" class="item" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
    <i class="fa fa-edit"></i>
</a>
<a href="/delete-account/${row.id}" class="item" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="delete">
    <i class="fa fa-trash"></i>
</a>

</div>

        <div class="modal fade" id="edit_modal${row.id}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
        <h1 class="modal-title fs-5">Edit account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <form method="POST" action="/edit_account${row.id}" class="needs-validation" novalidate>
                                @csrf
                                <div class="form-group">
                                    <label for="username">account Name</label>
                                    <input type="text" class="form-control"  name="account_name" required
                                        value="${row.account_name}">
                                </div>

                                <div class="form-group">
                                    <label for="username">Qty</label>
                                    <input type="number" step="any" class="form-control" 
                                        name="account_qty" value="${row.account_qty}">
                                </div>

                                <div class="form-group">
                                    <label for="username">Debit</label>
                                    <input type="number" step="any" class="form-control" 
                                        name="account_debit" value="${row.account_debit}">
                                </div>
                                <div class="form-group">
                                    <label for="username">Credit</label>
                                    <input type="number" step="any" class="form-control" 
                                        name="account_credit" value="${row.account_credit}">
                                </div>
                                <div class="form-group">
                                    <label for="username">Credit</label>
                                    <input type="number" step="any" class="form-control" 
                                        name="account_credit" value="${row.account_credit}">
                                </div>
                                <div class="form-group">
                                    <label for="username">Move Account</label>
                                    <select name="move_account" id="move_account" class="form-control">
                                        <option value="" selected disabled>Move TO Other Account</option>
                                        @foreach ($all_sub_head_accounts as $row)
    <option value="{{ $row->id }}">{{ $row->name }}</option>
    @endforeach
    </select>
    <button type="submit" class="btn btn-primary my-3" id="btn">Submit</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    `;
                            }

                        },
                    ]
                });
            });

            // $(document).ready(function() {
            //     $('#head_account').on('change', function() {
            //         // Get the selected value from the Head of Accounts select
            //         var selectedHead = $(this).val();

            //         // Hide all sub-head options initially
            //         $('#sub_head_account option').addClass('d-none');
            //         $('#sub_head_account').val(null).trigger('change');

            //         // Show the relevant sub-head options based on the selected head
            //         if (selectedHead == '1') {
            //             $('.Assets').removeClass('d-none');
            //         } else if (selectedHead == '2') {
            //             $('.Liabilities').removeClass('d-none');
            //         } else if (selectedHead == '3') {
            //             $('.OwnersEquity').removeClass('d-none');
            //         } else if (selectedHead == '4') {
            //             $('.Revenue').removeClass('d-none');
            //         } else if (selectedHead == '5') {
            //             $('.Expense').removeClass('d-none');
            //         }
            //     });

            //     // Trigger change event on page load if there is a pre-selected value
            //     $('#sub_head_account').trigger('change');
            // });
        </script>
    @endpush

@endsection
