@extends('layout.app') @section('title', 'Product Company') @section('content')

<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Product Company</h3>
                <a href="" data-bs-toggle="modal" data-bs-target="#add-modal" class="btn btn-success float-right">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp; Add Product company</a>
            </div>
        </div>
        <!-- <div class="row justify-content-center align-items-center my-3">
            <div class="col-md-5">
                <input type="text" class="form-control w-100" id="searchData" placeholder="Search">
            </div>
            <div class="col-md-5">
                <button class="btn btn-primary w-75" id="searchBtn">Search</button>
            </div>
        </div> -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.NO</th>
                        <th>company Name</th>
                        <th>Created At</th>
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


</div>



<div class="modal fade" id="add-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4>Add Company</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/add_product_company" class="needs-validation"
                    novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="username">company Name</label>
                            <input type="text" class="form-control " id="company" name="company"
                                placeholder="company" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            processing: true,
            ajax: '/data-product-company',
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit_modal${row.product_company_id}" class="item" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="/product_company_delete${row.product_company_id}" class="item" data-bs-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <!-- <a href="/del_user/${row.user_id}" class="item" data-bs-toggle="tooltip" data-placement="top" title="Delete User">
                                            <i class="fa fa-trash"></i>
                                        </a> -->
                                </div>

                                <div class="modal fade" id="edit_modal${row.product_company_id}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4>Edit Company</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/edit_product_company${row.product_company_id}">
                        @csrf
                        <div class="form-group">
                            <label for="username">company Name</label>
                            <input type="text" class="form-control " id="company" name="company" placeholder="company" required value="${row.company_name}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn">Submit</button>
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
</script>
@endsection
