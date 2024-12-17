<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="pdf_assets/style.css" media="all" />
    <style>
        input{
            border: none;
        }
    </style>
</head>

<body>
    @foreach(session()->get('product') as $key => $row )
    <div class="card-body card-block">
        <div>
            @csrf
            <!-- SQL Fields -->
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="product_name">Product Name:</label>
                        <input readonly type="text" id="product_name" name="product_name" class="form-control " value="{{ $row->product_name ?? '' }}" required>
                    </div>
                    <div class="col">
                        <label for="desc">Description:</label>
                        <input readonly type="text" id="desc" name="desc" class="form-control " value="{{ $row->desc ?? '' }}">
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="company">Product Company:</label>
                        <input readonly type="text" id="" name="" class="form-control " value="{{ $row->company_name ?? '' }}">
                    </div>
                    <div class="col">
                        <label for="type">Type:</label>
                        <input readonly type="text" id="" name="" class="form-control " value="{{ $row->type ?? '' }}">

                    </div>
                    <div class="col">
                        <label for="category">Product Category:</label>
                        <input readonly type="text" id="" name="" class="form-control " value="{{ $row->category_name ?? '' }}">

                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="purchase_price">Purchase Price:</label>
                        <input readonly type="number" step="any" id="purchase_price" name="purchase_price" class="form-control " value="{{ $row->purchase_price ?? '' }}">
                    </div>
                    <div class="col">
                        <label for="sale_price">Sale Price:</label>
                        <input readonly type="number" step="any" id="sale_price" name="sale_price" class="form-control " value="{{ $row->product_sale_price ?? '' }}">
                    </div>
                    <div class="col">
                        <label for="opening_pur_price">Opening Purchase Price:</label>
                        <input readonly type="number" step="any" id="opening_pur_price" name="opening_pur_price" class="form-control " value="{{ $row->opening_pur_price ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="opening_quantity">Opening Quantity:</label>
                        <input readonly type="number" step="any" id="opening_quantity" name="opening_quantity" class="form-control " value="{{ $row->opening_quantity ?? 0 }}">
                    </div>
                    <div class="col">
                        <label for="avg_pur_price">Average Purchase Price:</label>
                        <input readonly type="number" step="any" id="avg_pur_price" name="avg_pur_price" class="form-control " value="{{ $row->avg_pur_price ?? '' }}">
                    </div>
                    <div class="col">
                        <label for="overhead_exp">Overhead Expense:</label>
                        <input readonly type="number" step="any" id="overhead_exp" name="overhead_exp" class="form-control " value="{{ $row->overhead_exp ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="overhead_price_pur">Overhead Price Purchase:</label>
                        <input readonly type="number" step="any" id="overhead_price_pur" name="overhead_price_pur" class="form-control " value="{{ $row->overhead_price_pur ?? '' }}">
                    </div>
                    <div class="col">
                        <label for="overhead_price_avg">Overhead Price Average:</label>
                        <input readonly type="number" step="any" id="overhead_price_avg" name="overhead_price_avg" class="form-control " value="{{ $row->overhead_price_avg ?? '' }}">
                    </div>
                    <div class="col">
                        <label for="pur_price_plus_oh">Purchase Price + Overhead:</label>
                        <input readonly type="number" step="any" id="pur_price_plus_oh" name="pur_price_plus_oh" class="form-control " value="{{ $row->pur_price_plus_oh ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="avg_price_plus_oh">Average Price + Overhead:</label>
                        <input readonly type="number" step="any" id="avg_price_plus_oh" name="avg_price_plus_oh" class="form-control " value="{{ $row->avg_price_plus_oh ?? '' }}">
                    </div>
                    <div class="col">
                        <label for="inactive_item">Inactive Item:</label>
                        <input readonly type="text" id="inactive_item" name="inactive_item" class="form-control " value="{{ $row->inactive_item ?? '' }}">
                    </div>
                    <div class="col">
                        <label for="barcode">Barcode:</label>
                        <input readonly type="text" id="barcode" name="barcode" class="form-control " value="{{ $row->barcode ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="unit">Unit:</label>
                        <input readonly type="text" style="text-align:center !important;" readonly id="unit" name="unit" class="form-control " value="{{ $row->unit ?? '' }}">
                    </div>
                    <div class="col">
                        <label for="re_order_level">Re-order Level:</label>
                        <input readonly style="width: 49%;" type="text" id="re_order_level" name="re_order_level" class="form-control " value="{{ $row->re_order_level ?? '' }}">
                    </div>

                </div>
            </div>
            <img src="{{$row->image}}" alt="image" width="75%" height="75%">
            <!-- End of SQL Fields -->


        </div>
    </div>
    @endforeach
</body>

</html>