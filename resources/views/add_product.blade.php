    @extends('layout.app') @section('title', 'Add Product') @section('content')
    <br>
    <div class="container">
        <h2>Add Product</h2>
        <div class="card-body card-block">
            <form action="add_product_form" method="post" enctype="multipart/form-data" class="needs-validation"
                novalidate>
                @csrf

                <!-- SQL Fields -->
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label>Product Name</label>
                            <input type="text" id="product_name" name="product_name" placeholde="Product Name"
                                class="form-control" required>
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
{{-- u --}}
                        <div class="col">
                            <label for="type">Type</label>
                            <select name="type" class="form-control select-type">
                                @foreach ($type as $row)
                                    <option value="{{ $row->type }}">{{ $row->type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label>Purchase Price</label>
                            <input type="text" step="any" id="purchase_price" name="purchase_price"
                                placeholde="Purchase Price" class="form-control">
                        </div>
                        <div class="col">
                            <label>Sale Price</label>
                            <input type="text" step="any" id="sale_price" name="sale_price"
                                placeholde="Sale Price" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label>Opening Quantity</label>
                            <input type="number" step="any" id="opening_quantity" name="opening_quantity"
                                placeholde="Opening Quantity" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col">
                        <label>unit</label>
                        <select id="unit" name="unit" class="form-control">
                            <option value="foot">foot</option>
                            <option value="inch">inch</option>
                            <option value="gaz">gaz</option>
                            <option value="meter">meter</option>
                            <option value="box">box</option>
                            <option value="coil">coil</option>
                            <option value="pcs">pcs</option>
                        </select>
                    </div>
                    <div class="col">
                        <label>Product Image</label>
                        <input style="width: 49%;" type="file" id="image" name="image" class="form-control">
                    </div>
                </div>
        </div>

        <div class="form-group">
            <div class="row">

            </div>
        </div>

        <!-- End of SQL Fields -->

        <div class="form-actions form-group">
            <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
        </div>
        </form>
    </div>
    </div>

@endsection
