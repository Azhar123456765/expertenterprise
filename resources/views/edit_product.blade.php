@extends('layout.app') @section('title', 'Edit Product') @section('content')
<br>
<div class="container">
    <h2>Edit Product</h2>
    <div class="card-body card-block">
        <form action="{{ Route('product.update', $product->product_id) }}" method="post" enctype="multipart/form-data" class="needs-validation"
            novalidate>
            @csrf

            <!-- SQL Fields -->
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Product Name</label>
                        <input type="text" value="{{ $product->product_name }}" id="product_name" name="product_name"
                            placeholde="Product Name" class="form-control" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="company">Product Company</label>
                        <select name="company" id="company" class="form-control select-product_company">
                            <option value="{{ $product->companies->product_company_id ?? null }}" selected>
                                {{ $product->companies->company_name ?? null }}</option>
                        </select>
                    </div>

                    <div class="col">
                        <label for="category">Product category</label>
                        <select name="category" id="category" class="form-control select-product_category">
                            <option value="{{ $product->categories->product_category_id ?? null }}" selected>
                            {{ $product->categories->category_name ?? null }}</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Purchase Price</label>
                        <input type="text" value="{{ $product->purchase_price }}" step="any" id="purchase_price"
                            name="purchase_price" placeholde="Purchase Price" class="form-control">
                    </div>
                    <div class="col">
                        <label>Sale Price</label>
                        <input type="text" value="{{ $product->product_sale_price }}" step="any" id="sale_price"
                            name="sale_price" placeholde="Sale Price" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Opening Quantity</label>
                        <input type="number" value="{{ $product->opening_quantity }}" step="any"
                            id="opening_quantity" name="opening_quantity" placeholde="Opening Quantity"
                            class="form-control">
                    </div>
                    <div class="col">
                        <label>unit</label>
                        <select id="unit" name="unit" class="form-control">
                            <option value="foot" {{$product->unit == 'foot' ? 'selected' : ''}}>foot</option>
                            <option value="inch" {{$product->unit == 'inch' ? 'selected' : ''}}>inch</option>
                            <option value="gaz" {{$product->unit == 'gaz' ? 'selected' : ''}}>gaz</option>
                            <option value="meter" {{$product->unit == 'meter' ? 'selected' : ''}}>meter</option>
                            <option value="box" {{$product->unit == 'box' ? 'selected' : ''}}>box</option>
                            <option value="coil" {{$product->unit == 'coil' ? 'selected' : ''}}>coil</option>
                            <option value="pcs" {{$product->unit == 'pcs' ? 'selected' : ''}}>pcs</option>
                          </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="image">Product Image</label>
                        <input style="width: 49%;" type="file" id="image" name="image"
                            class="form-control ">
                        <input type="hidden" name="old_image" value="{{ $product->image }}">
                    </div>
                </div>
            </div>
            <img src="{{ asset($product->image) }}" alt="No image" width="75%" height="75%" class="m-5 border">

            <!-- End of SQL Fields -->

            <div class="form-actions form-group">
                <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection
