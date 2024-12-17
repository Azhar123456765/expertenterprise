@extends('layout.app') @section('title', 'Products') @section('content')
<style>
    @media (max-width: 755px) {
        .modal-dialog {

            margin-right: 1% !important;
        }

        .modal-content {
            width: 100% !important;
        }
    }
</style>
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Products Table</h3>
                <a href="{{ route('product.create') }}" class="btn btn-success float-right">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp; Add Product</a>
            </div>
        </div>

        <div class="card-body">
            <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>

                        <th>S.NO</th>
                        <th>product Name</th>
                        <th>Sale Price</th>
                        <th>purchase Price</th>
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





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            processing: true,
            ajax: '/data-product',
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'product_sale_price',
                    name: 'product_sale_price'
                },
                {
                    data: 'purchase_price',
                    name: 'purchase_price'
                },

                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                        <div class="table-data-feature">
                                <a href="/edit_product/${row.product_id}" class="item" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="/product_delete${row.product_id}" class="item" data-bs-toggle="tooltip" data-placement="top" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <a href="/product_pdf_id=${row.product_id}" class="item" data-bs-toggle="tooltip" data-placement="top" title="View">
                                    <i class="fa fa-print"></i>
                                </a>

</div>
    `;
                    }

                },
            ]
        });
    });
</script>
@endsection

{{-- 
<div class="modal fade" id="add-modal">
    <div class="modal-dialog" style="margin-right: 42%;">
        <div class="modal-content" style="width: 150%; ">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Add product</h4>
                <div class="container">
                    <div class="card-body card-block">
                        <form action="add_product_form" method="post" enctype="multipart/form-data">
                            @csrf

                            <!-- SQL Fields -->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" id="product_name" name="product_name"
                                            placeholder="Product Name" class="form-control " required>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="desc" name="desc" placeholder="Description"
                                            class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="company">Product Company</label>
                                        <select name="company" id="company" class="form-control select-product_company">
                                          
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="type">Type</label>
                                        <select name="type" id="type" class="form-control select-product_type">
                                         
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="category">Product category</label>
                                        <select name="category" id="category" class="form-control select-product_category">
                                    
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <br>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="purchase_price">Purchase Price</label>
                                        <input type="number" step="any" id="purchase_price" name="purchase_price"
                                            class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="sale_price">Sale Price</label>
                                        <input type="number" step="any" id="sale_price" name="sale_price"
                                            class="form-control ">
                                    </div>
                                    <div class="col">
                                        <label for="opening_pur_price">Opening Purchase Price</label>
                                        <input type="number" step="any" id="opening_pur_price"
                                            name="opening_pur_price" class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="opening_quantity">Opening Quantity</label>
                                        <input type="number" step="any" id="opening_quantity"
                                            name="opening_quantity" class="form-control" value="0.00">
                                    </div>
                                    <div class="col">
                                        <label for="avg_pur_price">Average Purchase Price</label>
                                        <input type="number" step="any" id="avg_pur_price" name="avg_pur_price"
                                            class="form-control ">
                                    </div>
                                    <div class="col">
                                        <label for="overhead_exp">Overhead Expense</label>
                                        <input type="number" step="any" id="overhead_exp" name="overhead_exp"
                                            class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="overhead_price_pur">Overhead Price Purchase</label>
                                        <input type="number" step="any" id="overhead_price_pur"
                                            name="overhead_price_pur" class="form-control ">
                                    </div>
                                    <div class="col">
                                        <label for="overhead_price_avg">Overhead Price Average</label>
                                        <input type="number" step="any" id="overhead_price_avg"
                                            name="overhead_price_avg" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="pur_price_plus_oh">Purchase Price + Overhead</label>
                                        <input type="number" step="any" id="pur_price_plus_oh"
                                            name="pur_price_plus_oh" class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="avg_price_plus_oh">Average Price + Overhead</label>
                                        <input type="number" step="any" id="avg_price_plus_oh"
                                            name="avg_price_plus_oh" class="form-control ">
                                    </div>
                                    <div class="col">
                                        <label for="inactive_item">Inactive Item</label>
                                        <input type="text" id="inactive_item" name="inactive_item"
                                            class="form-control ">
                                    </div>
                                    <div class="col">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" id="barcode" name="barcode" class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="unit">Unit</label>
                                        <input type="text" style="text-align:center !important;" id="unit"
                                            name="unit" class="form-control ">
                                    </div>
                                    <div class="col">
                                        <label for="re_order_level">Re-order Level</label>
                                        <input style="width: 49%;" type="text" id="re_order_level"
                                            name="re_order_level" class="form-control ">
                                    </div>
                                    <div class="col">
                                        <label for="image">Product Image</label>
                                        <input style="width: 49%;" type="file" id="image" name="image"
                                            class="form-control ">
                                        <input type="hidden" name="old_image">
                                    </div>
                                </div>
                            </div>

                            <!-- End of SQL Fields -->

                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>













<div class="modal fade" id="edit_modal${row.product_id}">
    <div class="modal-dialog" style="margin-right: 42%;">
        <div class="modal-content" style="width: 150%; ">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Edit product</h4>
                <div class="modal-body">
                    <div class="container">
                        <style>
                            .card-body label {
                                width: 222px;
                            }
                        </style>
                        <div class="card-body card-block">
                            <form action="edit_product${row.product_id}" method="post" enctype="multipart/form-data">
                                @csrf

                                <!-- SQL Fields -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="product_name">Product Name</label>
                                            <input type="text" id="product_name" name="product_name" class="form-control " value="${row.product_name ?? ''}" required>
                                        </div>
                                        <div class="col">
                                            <label for="desc">Description</label>
                                            <input type="text" id="desc" name="desc" class="form-control " value="${row.desc ?? ''}">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="company">Product Company</label>
                                            <select name="company" id="company" class="form-control ">
                                                @foreach ($company as $companyRow)
                                                <option value="{{ $companyRow->product_company_id }}" {{ ($companyRow->product->company ?? null) == $companyRow->product_company_id ? 'selected' : '' }}>{{ $companyRow->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="type">Type</label>
                                            <select name="type" id="type" class="form-control ">
                                                @foreach ($type as $typeRow)
                                                <option value="{{ $typeRow->product_type_id }}" {{ $typeRow->product_type_id == ($typeRow->product->product_type ?? null) ? 'selected' : '' }}>{{ $typeRow->type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="category">Product Category</label>
                                            <select name="category" id="category" class="form-control ">
                                                @foreach ($category as $categoryRow)
                                                <option value="{{ $categoryRow->product_category_id }}" {{ $categoryRow->product_category_id == ($categoryRow->product->category ?? null) ? 'selected' : '' }}>{{ $categoryRow->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>                               <br>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="purchase_price">Purchase Price</label>
                                            <input type="number" step="any" id="purchase_price" name="purchase_price" class="form-control " value="${row.purchase_price ?? ''}">
                                        </div>
                                        <div class="col">
                                            <label for="sale_price">Sale Price</label>
                                            <input type="number" step="any" id="sale_price" name="sale_price" class="form-control " value="${row.product_sale_price ?? ''}">
                                        </div>
                                        <div class="col">
                                            <label for="opening_pur_price">Opening Purchase Price</label>
                                            <input type="number" step="any" id="opening_pur_price" name="opening_pur_price" class="form-control " value="${row.opening_pur_price ?? ''}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="opening_quantity">Opening Quantity</label>
                                            <input type="number" step="any" id="opening_quantity" name="opening_quantity" class="form-control " value="${row.opening_quantity ?? 0}">
                                        </div>
                                        <div class="col">
                                            <label for="avg_pur_price">Average Purchase Price</label>
                                            <input type="number" step="any" id="avg_pur_price" name="avg_pur_price" class="form-control " value="${row.avg_pur_price ?? ''}">
                                        </div>
                                        <div class="col">
                                            <label for="overhead_exp">Overhead Expense</label>
                                            <input type="number" step="any" id="overhead_exp" name="overhead_exp" class="form-control " value="${row.overhead_exp ?? ''}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="overhead_price_pur">Overhead Price Purchase</label>
                                            <input type="number" step="any" id="overhead_price_pur" name="overhead_price_pur" class="form-control " value="${row.overhead_price_pur ?? ''}">
                                        </div>
                                        <div class="col">
                                            <label for="overhead_price_avg">Overhead Price Average</label>
                                            <input type="number" step="any" id="overhead_price_avg" name="overhead_price_avg" class="form-control " value="${row.overhead_price_avg ?? ''}">
                                        </div>
                                        <div class="col">
                                            <label for="pur_price_plus_oh">Purchase Price + Overhead</label>
                                            <input type="number" step="any" id="pur_price_plus_oh" name="pur_price_plus_oh" class="form-control " value="${row.pur_price_plus_oh ?? ''}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="avg_price_plus_oh">Average Price + Overhead</label>
                                            <input type="number" step="any" id="avg_price_plus_oh" name="avg_price_plus_oh" class="form-control " value="${row.avg_price_plus_oh ?? ''}">
                                        </div>
                                        <div class="col">
                                            <label for="inactive_item">Inactive Item</label>
                                            <input type="text" id="inactive_item" name="inactive_item" class="form-control " value="${row.inactive_item ?? ''}">
                                        </div>
                                        <div class="col">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" id="barcode" name="barcode" class="form-control " value="${row.barcode ?? ''}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="unit">Unit</label>
                                            <input type="text" style="text-align:center !important;" id="unit" name="unit" class="form-control " value="${row.unit ?? ''}">
                                        </div>
                                        <div class="col">
                                            <label for="re_order_level">Re-order Level</label>
                                            <input style="width: 49%;" type="text" id="re_order_level" name="re_order_level" class="form-control " value="${row.re_order_level ?? ''}">
                                        </div>
                                        <div class="col">
                                            <label for="image">Product Image</label>
                                            <input style="width: 49%;" type="file" id="image" name="image" class="form-control ">
                                            <input type="hidden" name="old_image" value="${row.image}">
                                        </div>
                                    </div>
                                </div>
                                <img src="${row.image}" alt="No image" width="75%" height="75%">

                                <!-- End of SQL Fields -->

                                <div class="form-actions form-group">
                                    <button type="submit" class="btn btn-secondary btn-sm">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div> --}}
