@extends('layout.app') @section('title', 'Chick Invoice (EDIT)') @section('content')


<style>
    @media (max-width: 755px) {
        body {
            overflow: scroll !important;
            width: max-content;

        }

        .img {
            position: absolute;
            top: 70% !important;
            left: 80.5% !important;
            width: 217px;
            height: 191px;
        }

        .options {
            width: 23% !important;
        }

    }


    .finance-layout {
        transform: scale(0.75);
    }

    

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    * input {
        border: 1px solid gray !important;
        width: 71px;
    }

    label {
        margin: 3px;
        font-weight: bolder;
        font-size: larger !important;
    }

    h6 {
        margin: 3px;
        font-weight: bolder;
        font-size: large;
    }

    /* .top label {
        margin: 5px;
    } */

    .dup_invoice label {
        width: 55px;
        text-align: center;
        height: 55px;
        padding: 15px auto 15px 15px;
        border: 1px solid none;
        display: flex;
    }




    .dup input {
        border: 1px solid;
        width: 71px;
    }

    .total input {
        border: 1px solid;
        width: 71px;
    }

    .dup_invoice {
        /* margin-top: 39px; */
        margin: 6px;
        display: flex;
        width: 100%;
        justify-content: center;
    }

    .dup {
        /* margin-top: 39px; */
        display: flex;
        justify-content: center;
    }

    .invoice input {
        border: 1px solid;
        width: 71px;
    }

    .invoice label {
        text-align: center;
    }

    .invoice {
        background-color: #f8f9fa;
        border: none;

        height: 167.5px;
        overflow-y: scroll;
        overflow-x: hidden;

    }

    .total input {
        border: 1px solid;
        width: 71px;
    }

    .top {
        /* margin-top: 5%; */
        display: flex;
        flex-direction: row;
        width: 103%;
        justify-content: space-around !important;
    }

    input {
        width: 131px !important;
        height: 27px !important;
    }

    /* #invoiceForm select {
        width: 131px !important;
        height: 27px !important;
    } */

    #invoiceForm .select2-container--bootstrap4 {
        width: 210px !important;
        line-height: 25px !important;
    }

    .select2-dropdown {
        width: 200px !important;
    }

    .select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
        width: 100% !important;
    }

    .select2-dropdown {
        width: 200px !important;
    }

    .select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
        width: 100% !important;
    }

    #form {
        width: 140%;
        margin-left: -22%;
    }

    .fields {

        width: 19%;
        justify-content: space-around;
        flex-direction: column;
    }

    .one {
        display: flex;
        justify-content: space-between;
        margin-top: 5px;
    }

    .flex {
        display: flex;
        justify-content: end;
    }

    input:focus {
        border: 3px solid;
        background-color: lightgray;
        /* Change this to your desired dark background color */
        color: black;
        /* Change this to your desired text color */
        outline: none;
        /* Remove the classic focus outline */
    }

    .select2:focus {
        border: 100px solid;
        background-color: lightgray;
        /* Change this to your desired dark background color */
        color: black;
        /* Change this to your desired text color */
        outline: 50px;
        /* Remove the classic focus outline */
    }


    /* .remark .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        width: 219px !important;
        height: 27px !important;

        line-height: 25px !important;
        height: 25px !important;
        padding-top: 2px;
    } */

    .cash .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        width: 139px !important;
    }

    .items #invoiceForm .select2-container--bootstrap4 {
        width: 115px !important;
    }

    /* .fields input{
    padding-left: 25%;
  }
  .one select{
    padding-left: 25%;
      } */


    .dup_invoice #invoiceForm select {
        border: 1px solid;
        width: 83px !important;
    }

    .dup_invoice input {
        border: 1px solid;
        width: 108px !important;
    }

    .dup_invoice input[id="amount"] {
        width: 90px !important;
    }

    .total input {
        width: 108px !important;
    }

    .xl-width-inp {
        width: 90px !important;
    }

    .dup_invoice .div {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .dup_invoice .div label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    #invoiceForm .dup_invoice .select2-container--bootstrap4 {
        width: 120px !important;

        line-height: 25px !important;
        height: 30px !important;
    }
</style>
<div class="container">
    <h5 class="text-center my-2">Chick Invoice (Edit)</h5>
    <div class="finance-layout" id="invoiceForm" style="overflow-x: visible;
">
        <h6 style="
position: absolute;
top: 35%;
left: 15%;
">Supplier</h6>
        <h6 style="
position: absolute;
top: 35%;
right: 15%;
">Customer</h6>
        <form id="form" enctype="multipart/form-data">
            <div class="row justify-content-around mt-0">
                <div class="col-3">
                    <div class="row mb-3">
                        <label class="col-3 col-form-label" for="Invoice">Invoice#</label>
                        <div class="col-8">
                            <input clang="form-control" style="border: none !important; width: 219px !important;"
                                type="text" id="" name="" value="<?php $year = date('Y');
                                $lastTwoWords = substr($year, -2);
                                echo $rand = 'SI' . '-' . $year . '-' . $single_invoice->unique_id; ?>" />
                            <input clang="form-control" type="hidden" id="unique_id" name="unique_id"
                                value="{{ $rand = $single_invoice->unique_id }}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label" for="date">Date</label>
                        <div class="col-8">
                            <input clang="form-control"
                                style="border: none !important; width: 219px !important; text-align:center;        "
                                type="date" id="date" name="date" value="{{ $single_invoice->date }}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label" for="seller">Supplier</label>
                        <div class="col-8">

                            <select name="seller" class="company select-buyer" required>
                                <option value="{{ $single_invoice->supplier->buyer_id ?? null }}" selected>
                                    {{ $single_invoice->supplier->company_name ?? null }}</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-3">
                    <div class="row mb-3">
                        <label class="col-3 col-form-label" for="sales_officer">Farm</label>
                        <div class="col-8">
                            <select name="farm" class="select-farm">
                                <option value="{{ $single_invoice->farms->id ?? (null ?? null) }}" selected>
                                    {{ $single_invoice->farms->name ?? (null ?? null) }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label" for="sales_officer">Sales Officer</label>
                        <div class="col-8">

                            <select name="sales_officer" id="sales_officer" class="select-sales_officer">
                                <option value="{{ $single_invoice->officer->sales_officer_id ?? null }}" selected>
                                    {{ $single_invoice->officer->sales_officer_name ?? null }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-3">


                    <div class="row mb-3">
                        <label class="col-3 col-form-label" for="remark">Remarks</label>
                        <div class="col-8">

                            <input clang="form-control" style="width: 219px !important;" type="text" id="remark"
                                name="remark" value="{{ $single_invoice->remark }}" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label" for="seller">Customer</label>
                        <div class="col-8">

                            <select name="buyer" class="select-buyer" required>
                                <option value="{{ $single_invoice->customer->buyer_id }}" selected>
                                    {{ $single_invoice->customer->company_name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <br />

            <div class="invoice">
                @csrf
                @php
                    $counter = 1;
                @endphp
                @foreach ($invoice as $row)
                    <div class="dup_invoice" onchange="addInvoice2()">
                        <div class="div   items">
                            <label class="{{ $counter > 1 ? 'd-none' : '' }}" for="item">Item</label>
                            <select name="item[]" id="item{{ $counter }}" style="height: 28px"
                                onchange="addInvoice2()" required class="item0 select-products">
                                <option value="{{ $row->product->product_id }}" selected>
                                    {{ $row->product->product_name }}</option>
                            </select>
                        </div>
                        <div class="div">
                            <label class="{{ $counter > 1 ? 'd-none' : '' }}" for="actual_qty">Actual Quantity</label>
                            <input type="number" step="any" id="actual_qty{{ $counter }}"
                                name="actual_qty[]" value="{{ $row->qty / (1 + $row->bonus / 100) }}" />
                        </div>

                        <div class="div">
                            <label class="{{ $counter > 1 ? 'd-none' : '' }}" for="rate">Rate</label>
                            <input type="number" step="any"
                                oninput="$('#sale_rate{{ $counter }}').val(this.value)"
                                id="rate{{ $counter }}" name="rate[]" value="{{ $row->rate }}" />
                        </div>

                        <div class="div">
                            <label class="{{ $counter > 1 ? 'd-none' : '' }}" for="crate_type">Discount</label>
                            <input type="number" step="any"
                                oninput="$('#sale_discount{{ $counter }}').val(this.value)"
                                id="discount{{ $counter }}" name="discount[]" value="{{ $row->discount }}" />
                        </div>
                        <div class="div">
                            <label class="{{ $counter > 1 ? 'd-none' : '' }}" for="bonus">Bonus</label>
                            <input type="number" step="any" min="0.00" step="any" placeholder="0.00"
                                oninput="$('#sale_bonus{{ $counter }}').val(this.value)"
                                id="bonus{{ $counter }}" name="bonus[]" value="{{ $row->bonus }}" />
                        </div>
                        <div class="div">
                            <label class="{{ $counter > 1 ? 'd-none' : '' }}" for="qty">Quantity</label>
                            <input type="number" step="any" id="qty{{ $counter }}" name="qty[]"
                                value="{{ $row->qty }}" />
                        </div>
                        <div class="div">
                            <label class="{{ $counter > 1 ? 'd-none' : '' }}" for="amount">Amount</label>
                            <input type="number" step="any" min="0.00"
                                style="text-align: right;width: 190px !important;" step="any" onchange='count()'
                                id="amount{{ $counter }}" name="amount[]" class="xl-width-inp"
                                value="{{ $row->amount }}" />
                        </div>

                        {{-- PURCHASE --}}
                        <div class="div">
                            <label class="{{ $counter > 1 ? 'd-none' : '' }}" for="sale_rate">Rate</label>
                            <input type="number" step="any" id="sale_rate{{ $counter }}"
                                name="sale_rate[]" value="{{ $row->sale_rate }}" />
                        </div>
                        <div class="div">
                            <label class="{{ $counter > 1 ? 'd-none' : '' }}" for="sale_crate_type">Discount</label>
                            <input type="number" step="any" id="sale_discount{{ $counter }}"
                                name="sale_discount[]" value="{{ $row->sale_discount }}" />
                        </div>
                        <div class="div">
                            <label class="{{ $counter > 1 ? 'd-none' : '' }}" for="sale_bonus">Bonus</label>
                            <input type="number" step="any" min="0.00" step="any" placeholder="0.00"
                                id="sale_bonus{{ $counter }}" name="sale_bonus[]"
                                value="{{ $row->sale_bonus }}" />
                        </div>
                        <div class="div">
                            <label class="{{ $counter > 1 ? 'd-none' : '' }}" for="sale_qty">Quantity</label>
                            <input type="number" step="any" id="sale_qty{{ $counter }}" name="sale_qty[]"
                                value="{{ $row->sale_qty }}" />
                        </div>
                        <div class="div">
                            <label class="{{ $counter > 1 ? 'd-none' : '' }}" for="sale_amount">Amount</label>
                            <input type="number" step="any" min="0.00"
                                style="text-align: right;width: 190px !important;" step="any" onchange='count()'
                                id="sale_amount{{ $counter }}" name="sale_amount[]" class="xl-width-inp"
                                value="{{ $row->sale_amount }}" />
                        </div>
                    </div>
                    @php
                        $counter++;
                    @endphp
                @endforeach
                <div class="dup_invoice" onchange="addInvoice2()">
                    <div class="div   items">
                        <select name="item[]" id="item" style="height: 28px" onchange="addInvoice2()"
                            class="item0 select-products">
                        </select>
                    </div>
                    <div class="div">

                        <input type="number" step="any" id="actual_qty{{ $counter }}"
                            name="actual_qty[]" />
                    </div>

                    <div class="div">
                        <input type="number" step="any"
                            oninput="$('#sale_rate{{ $counter }}').val(this.value)"
                            id="rate{{ $counter }}" name="rate[]" />
                    </div>

                    <div class="div">
                        <input type="number" step="any"
                            oninput="$('#sale_discount{{ $counter }}').val(this.value)"
                            id="discount{{ $counter }}" name="discount[]" />
                    </div>
                    <div class="div">
                        <input type="number" step="any" min="0.00" step="any" placeholder="0.00"
                            oninput="$('#sale_bonus{{ $counter }}').val(this.value)"
                            id="bonus{{ $counter }}" name="bonus[]" />
                    </div>
                    <div class="div">
                        <input type="number" step="any" id="qty{{ $counter }}" name="qty[]" />
                    </div>
                    <div class="div">
                        <input type="number" step="any" min="0.00"
                            style="text-align: right;width: 190px !important;" step="any" value="0.00"
                            onchange='count()' id="amount{{ $counter }}" name="amount[]"
                            class="xl-width-inp" />
                    </div>

                    {{-- PURCHASE --}}
                    <div class="div">
                        <input type="number" step="any" id="sale_rate{{ $counter }}"
                            name="sale_rate[]" />
                    </div>
                    <div class="div">
                        <input type="number" step="any" id="sale_discount{{ $counter }}"
                            name="sale_discount[]" />
                    </div>
                    <div class="div">
                        <input type="number" step="any" min="0.00" step="any" placeholder="0.00"
                            id="sale_bonus{{ $counter }}" name="sale_bonus[]" />
                    </div>
                    <div class="div">
                        <input type="number" step="any" id="sale_qty{{ $counter }}" name="sale_qty[]" />
                    </div>
                    <div class="div">
                        <input type="number" step="any" min="0.00"
                            style="text-align: right;width: 190px !important;" step="any" value="0.00"
                            onchange='count()' id="sale_amount{{ $counter }}" name="sale_amount[]"
                            class="xl-width-inp" />
                    </div>
                </div>
            </div>


            <style>
                .total {
                    justify-content: center;
                    /* width: 50%; */
                    /* align-items: flex-end; */
                    display: flex;
                }

                .total .last input {
                    margin-top: 9px !important;

                }

                .one {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 5px;
                    flex-direction: row;
                }

                .last {
                    display: flex;

                    flex-direction: column;
                }

                .last .one input {
                    margin-top: 5px;
                }

                .options {
                    display: flex;
                    justify-content: center;
                    margin-top: -7%;
                }
            </style>

            <div class="total" style="margin-top: 2.25%;">
                <div class="first">
                    <div class="one" style="
                margin-left: -136%;
            ">
                        <label for="mor_cut"
                            style="
        position: fixed;
        top: 95%;
        left: -1%;
    ">Total</label>


                        <input type="number" step="any" step="any" name="qty_total" id="qty_total"
                            value="{{ $single_invoice->qty_total }}"
                            style="
                /* margin-left: 30%; */
                position: fixed;
                top: 95%;
                left: 26%;
            "=""="">
                        <input type="number" step="any" step="any" name="amount_total" id="amount_total"
                            value="{{ $single_invoice->amount_total }}"
                            style="
                /* margin-left: 30%; */
                position: fixed;
                top: 95%;
                left: 36.8%;
                width: 190px !important;
            "=""="">

                        <input type="number" step="any" step="any" name="sale_qty_total"
                            id="sale_qty_total"
                            style="/* margin-left: 30%; */position: fixed;top: 95%;left: 85.7%;"=""=""
                            value="{{ $single_invoice->sale_qty_total }}">
                        <input type="number" step="any" step="any" name="sale_amount_total"
                            id="sale_amount_total"
                            style="/* margin-left: 30%; */position: fixed;top: 95%;left: 96.55%;width: 190px !important;"=""=""
                            value="{{ $single_invoice->sale_amount_total }}">

                    </div>

                </div>
            </div>

    </div>
    <button type="button" class="me-5 px-3 p-1 btn btn-secondary btn-md" style="position: fixed; top: 75%; left:7%;"
        data-bs-toggle="modal" data-bs-target="#imageModal">
        Attachment
    </button>
    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row p-2">
                        <div class="col-lg-12 col-md-12 p-5">
                            <a href="#" id="imageAnchor" target="_blank"><img
                                    src="{{ asset($single_invoice->attachment) }}" alt="img" class="img-fluid"
                                    id="imagePreview" style="object-fit: fill;">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="mb-3">
                        <input type="file" class="form-control w-100" name="attachment" id="attachment"
                            value="{{ $single_invoice->attachment }}" style="
height: max-content !important;
" />
                        <input type="hidden" class="form-control" name="old_attachment" id="old_attachment"
                            value="{{ $single_invoice->attachment }}" />
                    </div>
                    <button type="button" class="btn px-3 p-1 btn-secondary btn-md"
                        onclick=" 
document.getElementById('attachment').value = '';
document.getElementById('imagePreview').style.display = 'none';
document.getElementById('imagePreview').src = '';
document.getElementById('imageAnchor').href = '';">
                        REMOVE
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center"
        style="width: 90%; position: absolute; top:90%; gap: 30px !important;">

        <button type="submit" class="btn px-3 p-1 btn-secondary btn-md submit" id="submit" disabled
            data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Enter">
            Update
        </button>
        <button type="button" class="btn px-3 p-1 btn-secondary btn-md submit" id="edit"
            data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + E"
            onclick="$('#submit').removeAttr('disabled'); $(this).attr('disabled', 'disabled');">
            Edit
        </button>



        <a href="{{ Route('invoice_chick') }}" class="btn px-3 p-1 btn-secondary btn-md  submit" id="first_btn"
            data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + A">
            First
        </a>
        <a href="{{ Route('edit_invoice_chick', $rand - 1) }}" class="btn px-3 p-1 btn-secondary btn-md  submit"
            id="previous_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + B">
            Previous
        </a>
        <a href="{{ Route('edit_invoice_chick', $rand + 1) }}" class="btn px-3 p-1 btn-secondary btn-md  submit"
            id="next_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + N">
            Next
        </a>
        <a href="{{ Route('last_invoice_chick') }}" class="btn px-3 p-1 btn-secondary btn-md  submit" id="last_btn"
            data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + L">
            Last
        </a>
        <a href="{{ Route('new_invoice_chick') }}" class="edit add-more  btn px-3 p-1 btn-secondary btn-md"
            id="add_more_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + M">
            Add More
        </a>

        <button type="button" class="btn px-3 p-1 btn-secondary btn-md" id="sale_pdf">
            SALE PDF
        </button>

        <button type="button" class="btn px-3 p-1 btn-secondary btn-md" id="purchase_pdf">
            PURCHASE PDF
        </button>

        <button class="btn px-3 p-1 btn-secondary btn-md  submit" onclick="

window.location.reload()
">
            Revert
        </button>
    </div>


    </form>
</div>
</div>

@push('s_script')
    <script>
        document.getElementById('attachment').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Get the uploaded file
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.getElementById('imagePreview');
                const a = document.getElementById('imageAnchor');

                // Set the href of the anchor to the image's data URL
                a.href = e.target.result;

                // Set the src of the img to the image's data URL
                img.src = e.target.result;

                // Show the image
                img.style.display = 'block';
            };

            // Check if a file is selected, then read it
            if (file) {
                reader.readAsDataURL(file);
            }
        });
        var counter = {{ $counter }}
        var countera = {{ $counter - 1 }}


        function addInvoice(one) {

            for (let i = 1; i <= counter; i++) {


                var clonedFields = `
    <div class="dup_invoice" onchange="addInvoice2()">
    <div class="div   items">
                    <select name="item[]" id="item` + counter + `" style="height: 28px" onchange="addInvoice2()"
                        class="item0 select-products">
                    </select>
                </div>
                <div class="div">
                    <input  type="number" step="any" id="actual_qty` + counter + `"
                        name="actual_qty[]" />
                </div>

                <div class="div">
                    <input  type="number" step="any" oninput="$('#sale_rate` + counter +
                    `').val(this.value)" id="rate` +
                    counter + `" name="rate[]" />
                </div>

                <div class="div">
                    <input  type="number" step="any" oninput="$('#sale_discount` + counter +
                    `').val(this.value)" id="discount` +
                    counter + `" name="discount[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" min="0.00"
                        step="any" placeholder="0.00" oninput="$('#sale_bonus` + counter +
                    `').val(this.value)" id="bonus` + counter + `" name="bonus[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" id="qty` + counter + `"
                        name="qty[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" min="0.00"
                        style="text-align: right;width: 190px !important;" step="any" value="0.00" onchange='count()'
                        id="amount` + counter + `" name="amount[]" class="xl-width-inp" />
                </div>


                <div class="div">
                    <input  type="number" step="any" id="sale_rate` + counter + `" name="sale_rate[]" />
                </div>

                <div class="div">
                    <input  type="number" step="any" id="sale_discount` + counter + `" name="sale_discount[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" min="0.00"
                        step="any" placeholder="0.00" id="sale_bonus` + counter + `" name="sale_bonus[]"  />
                </div>
                <div class="div">
                    <input  type="number" step="any" id="sale_qty` + counter + `"
                        name="sale_qty[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" min="0.00"
                        style="text-align: right;width: 190px !important;" step="any" value="0.00" onchange='count()'
                        id="sale_amount` + counter + `" name="sale_amount[]" class="xl-width-inp" />
                </div>
            </div>

`;


            }


            let amount = $("#amount").val()
            let narration = $("#sale_price").val()
            if (!$("#amount").hasClass('check')) {



                $("#amount").addClass("check")
                // console.log(counter + "first");

                counter++
                countera++


                $(".invoice").append(clonedFields);
                $('.select-products').select2({
                    ajax: {
                        url: '{{ route('select2.products') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.product_name,
                                        id: item.product_id,
                                    };
                                })
                            };
                        },
                        cache: true
                    },

                    theme: 'bootstrap4',
                    width: '100%'
                });
            }

            $(document).ready(function() {

                $("input").on('input', function() {
                    total_calc();
                });
                $(document).on('click', function() {
                    total_calc();
                });
                $('.select-products').select2({
                    ajax: {
                        url: '{{ route('select2.products') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.product_name,
                                        id: item.product_id,
                                    };
                                })
                            };
                        },
                        cache: true
                    },

                    theme: 'bootstrap4',
                    width: '100%'
                });
                $(".select2-container--open .select2-search__field").focus();

                var selectedOption = $("#item").find('option:selected');
                var unitInput = $('#unit');
                unitInput.val(selectedOption.data(
                    'unit')); // Set the value of the unit input field to the data-unit value of the selected option


                var pInput = $('#sale_price');
                pInput.val(selectedOption.data('sale_price'));


                $('.avail_stock').css("display", "block")
                var stInput = $('#avail_stock');
                let s = selectedOption.data('stock');
                let t = selectedOption.data('name');
                let = st_val2 = '  ' + t + ',  ' + s;
                if (st_val2 != null) {

                    // console.log(st_val2);
                    stInput.val(st_val2);
                }

                // var st = $('#avail_stock2');
                // st.val(selectedOption.data('stock'));
                // var pst = $('#previous_stock');
                // pst.val(selectedOption.data('stock'));

                $('#p-img').css("display", "block")
                var imgInput = $('#p-img');
                var imgSrc = selectedOption.data('img');
                imgInput.attr('src', imgSrc);

                $(".p-img").attr('href', imgSrc)
                // Initialize other select elements if necessary
            });
        }






        function addInvoice2(one) {

            for (let i = 1; i <= counter; i++) {
                var clonedFields = `
    <div class="dup_invoice" onchange="addInvoice2()">
         <div class="div   items">
                    <select name="item[]" id="item` + counter + `" style="height: 28px" onchange="addInvoice2()"
                        class="item0 select-products">
                    </select>
                </div>
                <div class="div">
                    <input  type="number" step="any" id="actual_qty` + counter + `"
                        name="actual_qty[]" />
                </div>

                <div class="div">
                    <input  type="number" step="any" oninput="$('#sale_rate` + counter +
                    `').val(this.value)" id="rate` +
                    counter + `" name="rate[]" />
                </div>

                <div class="div">
                    <input  type="number" step="any" oninput="$('#sale_discount` + counter +
                    `').val(this.value)" id="discount` +
                    counter + `" name="discount[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" min="0.00"
                        step="any" placeholder="0.00" oninput="$('#sale_bonus` + counter +
                    `').val(this.value)" id="bonus` + counter + `" name="bonus[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" id="qty` + counter + `"
                        name="qty[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" min="0.00"
                        style="text-align: right;width: 190px !important;" step="any" value="0.00" onchange='count()'
                        id="amount` + counter + `" name="amount[]" class="xl-width-inp" />
                </div>

                <div class="div">
                    <input  type="number" step="any" id="sale_rate` + counter + `" name="sale_rate[]" />
                </div>

                <div class="div">
                    <input  type="number" step="any" id="sale_discount` + counter + `" name="sale_discount[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" min="0.00"
                        step="any" placeholder="0.00" id="sale_bonus` + counter + `" name="sale_bonus[]"  />
                </div>
                <div class="div">
                    <input  type="number" step="any" id="sale_qty` + counter + `"
                        name="sale_qty[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" min="0.00"
                        style="text-align: right;width: 190px !important;" step="any" value="0.00" onchange='count()'
                        id="sale_amount` + counter + `" name="sale_amount[]" class="xl-width-inp" />
                </div>
            </div>

`;
            }
            counter = counter - 1
            let amount2 = $("#amount" + counter).val()
            let narration2 = $("#amount" + counter).val()
            if (!$("#amount" + counter).hasClass('check')) {
                if (narration2 > 0) {
                    $("#amount" + countera).addClass("check")
                    counter++
                    countera++
                    $(".invoice").append(clonedFields);
                }
            }
            var one = one
            counter = counter + 1
            $(document).ready(function() {
                $("input").on('input', function() {
                    total_calc();
                });
                $(document).on('click', function() {
                    total_calc();
                });
            });


            $('.select-products').select2({
                ajax: {
                    url: '{{ route('select2.products') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.product_name,
                                    id: item.product_id,
                                };
                            })
                        };
                    },
                    cache: true
                },

                theme: 'bootstrap4',
                width: '100%'
            });
        }

        function total_calc() {
            // // GENERAL
            // let actual_qty = +$('#actual_qty').val();
            // let qty = +$('#actual_qty').val();
            // let rate = +$('#rate').val();
            // let discount = +$('#discount').val();
            // let bonus = +$('#bonus').val();
            // let bonusQty = qty + bonus;
            // // qty += bonusQty;
            // let amount = qty * rate;
            // // let discountAmount = (qty * rate) * (discount / 100);
            // // amount -= discountAmount;
            // amount -= discount;

            // let sale_qty = +$('#actual_qty').val();
            // let sale_rate = +$('#sale_rate').val();
            // let sale_discount = +$('#sale_discount').val();
            // let sale_bonus = +$('#sale_bonus').val();
            // let sale_bonusQty = sale_qty + sale_bonus;
            // // sale_qty += sale_bonusQty;
            // let sale_amount = sale_qty * sale_rate;
            // // let sale_discountAmount = (sale_qty * sale_rate) * (sale_discount / 100);
            // // sale_amount -= sale_discountAmount;
            // sale_amount -= sale_discount;

            // $('#qty').val(bonusQty);
            // $('#sale_qty').val(sale_bonusQty);
            // $('#amount').val(amount);
            // $('#sale_amount').val(sale_amount);

            // CLONE
            for (let i = 1; i <= countera; i++) {
                let actual_qty = +$('#actual_qty' + i).val();
                let qty = +$('#actual_qty' + i).val();
                let rate = +$('#rate' + i).val();
                let discount = +$('#discount' + i).val();
                let bonus = +$('#bonus' + i).val();
                let bonusQty = qty + (qty * bonus / 100);
                // qty += bonusQty;
                rate -= discount;

                let amount = qty * rate;
                // let discountAmount = (qty * rate) * (discount / 100);
                // amount -= discountAmount;
                // amount -= discount;

                let sale_qty = +$('#actual_qty' + i).val();
                let sale_rate = +$('#sale_rate' + i).val();
                let sale_discount = +$('#sale_discount' + i).val();
                let sale_bonus = +$('#sale_bonus' + i).val();
                let sale_bonusQty = sale_qty + (sale_qty * sale_bonus / 100);
                sale_rate -= sale_discount;
                // sale_qty += sale_bonusQty;
                let sale_amount = sale_qty * sale_rate;
                // let sale_discountAmount = (sale_qty * sale_rate) * (sale_discount / 100);
                // sale_amount -= sale_discountAmount;
                // sale_amount -= sale_discount;

                $('#qty' + i).val(bonusQty);
                $('#sale_qty' + i).val(sale_bonusQty);
                $('#amount' + i).val(amount);
                $('#sale_amount' + i).val(sale_amount);
            }

            // TOTAL
            let qty_total = 0;
            let amount_total = 0;
            let sale_qty_total = 0;
            let sale_amount_total = 0;
            for (let i = 1; i <= countera; i++) {
                qty_total += +$('#qty' + i).val();
                amount_total += +$('#amount' + i).val();
                sale_qty_total += +$('#sale_qty' + i).val();
                sale_amount_total += +$('#sale_amount' + i).val();
            }
            $('#qty_total').val(qty_total);
            $('#amount_total').val(amount_total);
            $('#sale_qty_total').val(sale_qty_total);
            $('#sale_amount_total').val(sale_amount_total);

        }

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });



        $('#form').submit(function(event) {

            event.preventDefault();

            // Create a FormData object
            var formData = new FormData(this);

            var unique_id = $("#unique_id").val();
            $.ajax({
                url: '{{ Route('update_invoice_chick', [':unique_id']) }}'.replace(':unique_id',
                    unique_id),
                method: 'POST',
                data: formData,
                contentType: false, // Prevent jQuery from setting the content type
                processData: false, // Prevent jQuery from processing the data
                success: function(response) {
                    // Handle the response


                    Swal.fire({
                        icon: 'success',
                        title: response,
                        timer: 1900
                    });

                    $("#submit").attr('disabled', 'disabled');
                    $('#edit').removeAttr('disabled');
                },
                error: function(error) {
                    // Handle the error
                }
            });
        });



        $('#sale_pdf').click(function(event) {
            if (!$(this).hasClass('disabled')) {

                event.preventDefault();
                // var formData = new FormData(this);
                var unique_id = $("#unique_id").val();
                var url = '{{ route('pdf_invoice_chick', [':unique_id', 0]) }}'.replace(':unique_id', unique_id);

                window.open(url, '__blank')
            }
        });
        $('#purchase_pdf').click(function(event) {
            if (!$(this).hasClass('disabled')) {

                event.preventDefault();
                // var formData = new FormData(this);
                var unique_id = $("#unique_id").val();
                var url = '{{ route('pdf_invoice_chick', [':unique_id', 1]) }}'.replace(':unique_id', unique_id);

                window.open(url, '__blank')
            }
        });


        $(document).on('keydown', function(e) {
            if ((e.altKey) && (String.fromCharCode(e.which).toLowerCase() === 'a')) {
                var link = document.querySelector('.add-more');
                window.location.href = link.href;
            }
        });
        $(document).on('keydown', function(e) {
            if ((e.altKey) && (String.fromCharCode(e.which).toLowerCase() === 'p')) {
                var link = document.querySelector('.pdf');
                window.location.href = link.href;
            }
        });
        $(document).on('keydown', function(e) {
            if ((e.altKey) && (String.fromCharCode(e.which).toLowerCase() === 'e')) {
                var link = document.querySelector('.edit-btn');
                window.location.href = link.href;
            }
        });


        $(document).on('keydown', function(e) {
            if ((e.altKey) && (String.fromCharCode(e.which).toLowerCase() === 'n')) {
                var str = $('[name=\'unique_id\']').val();
                var parts = str.split('-');
                var firstPart = parts.slice(0, -1).join('-');
                var lastPart = parts[parts.length - 1];
                var newUrl = '/es_med_invoice_id=' + firstPart + '-' + (parseInt(lastPart) + 1);
                window.location.href = newUrl;
            }
        });

        $(document).on('keydown', function(e) {
            if ((e.altKey) && (String.fromCharCode(e.which).toLowerCase() === 'b')) {
                var str = $('[name=\'unique_id\']').val();
                var parts = str.split('-');
                var firstPart = parts.slice(0, -1).join('-');
                var lastPart = parts[parts.length - 1];
                var newUrl = '/es_med_invoice_id=' + firstPart + '-' + (parseInt(lastPart) - 1);
                window.location.href = newUrl;
            }
        });
    </script>
    <div class="modal fade" id="iv-search">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Search Invoice</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="/saleInvoice-search">
                        @csrf
                        <div class="form-group">
                            <label>Invoice No</label>
                            <input type="text" class="form-control" id="search-input"
                                style="width: 100% !important;">
                        </div>

                        <div class="form-group">

                        <button type="submit" data-url="{{ Route('edit_invoice_chick') }}" class="btn btn-primary"
                            id="search-btn">Search</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endpush
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>
@endsection
