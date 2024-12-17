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
                    <div class="col">
                        <label>Description</label>
                        <input type="text" value="{{ $product->desc }}" id="desc" name="desc"
                            placeholde="Description" class="form-control">
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
                        <div class="col">
                            <label for="type">Type</label>
                            <select name="type" class="form-control select-type">
                                @foreach ($type as $typeRow)
                                    <option value="{{ $typeRow->product_type_id }}}"
                                        {{ $typeRow->product_type_id == ($typeRow->product->product_type ?? null) ? 'selected' : '' }}>
                                        {{ $typeRow->type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <label>Purchase Price</label>
                        <input type="number" value="{{ $product->product_name }}" step="any" id="purchase_price"
                            name="purchase_price" placeholde="Purchase Price" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Sale Price</label>
                        <input type="number" value="{{ $product->product_sale_price }}" step="any" id="sale_price"
                            name="sale_price" placeholde="Sale Price" class="form-control">
                    </div>
                    <div class="col">
                        <label>Opening Purchase Price</label>
                        <input type="number" value="{{ $product->opening_pur_price }}" step="any"
                            id="opening_pur_price" name="opening_pur_price" placeholde="Opening Purchase Price"
                            class="form-control">
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
                        <label>Average Purchase Price</label>
                        <input type="number" value="{{ $product->avg_pur_price }}" step="any" id="avg_pur_price"
                            name="avg_pur_price" placeholde="Average Purchase Price" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Overhead Expense</label>
                        <input type="number" value="{{ $product->overhead_exp }}" step="any" id="overhead_exp"
                            name="overhead_exp" placeholde="Overhead Expense" class="form-control">
                    </div>
                    <div class="col">
                        <label>Overhead Price Purchase</label>
                        <input type="number" value="{{ $product->overhead_price_pur }}" step="any"
                            id="overhead_price_pur" name="overhead_price_pur" placeholde="Overhead Price Purchase"
                            class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Overhead Price Average</label>
                        <input type="number" value="{{ $product->overhead_price_avg }}" step="any"
                            id="overhead_price_avg" name="overhead_price_avg" placeholde="Overhead Price Average"
                            class="form-control">
                    </div>
                    <div class="col">
                        <label>Purchase Price + Overhead</label>
                        <input type="number" value="{{ $product->pur_price_plus_oh }}" step="any"
                            id="pur_price_plus_oh" name="pur_price_plus_oh" placeholde="Purchase Price + Overhead"
                            class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Average Price + Overhead</label>
                        <input type="number" value="{{ $product->avg_price_plus_oh }}" step="any"
                            id="avg_price_plus_oh" name="avg_price_plus_oh" placeholde="Average Price + Overhead"
                            class="form-control">
                    </div>
                    <div class="col">
                        <label>Inactive Item</label>
                        <input type="text" value="{{ $product->inactive_item }}" id="inactive_item"
                            name="inactive_item" placeholde="" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Barcode</label>
                        <input type="text" value="{{ $product->barcode }}" id="barcode" name="barcode"
                            placeholde="" class="form-control">
                    </div>
                    <div class="col">
                        <label>unit</label>
                        <select id="unit" name="unit" class="form-control">
                            <option value="foot" {{$product->unit == 'foot' ? 'selected' : ''}}>foot</option>
                            <option value="inch" {{$product->unit == 'inch' ? 'selected' : ''}}>inch</option>
                            <option value="gaz" {{$product->unit == 'gaz' ? 'selected' : ''}}>gaz</option>
                            <option value="meter" {{$product->unit == 'meter' ? 'selected' : ''}}>meter</option>
                            <option value="pcs" {{$product->unit == 'pcs' ? 'selected' : ''}}>pcs</option>
                          </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Re-order Level</label>

                        <input style="width: 49%;" type="text" value="{{ $product->re_order_level }}"
                            id="re_order_level" name="re_order_level" class="form-control">
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
