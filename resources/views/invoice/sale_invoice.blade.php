@extends('layout.app') @section('title', 'Sale Invoice') @section('content')
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
        transform: scale(0.73);
        margin-top: -27px;
        overflow-x: visible;
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

    .dup_invoice {
        /* margin-top: 39px; */

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


    .dup_invoice select {
        width: 235px !important;
    }

    .dup_invoice input {
        border: 1px solid;
        width: 235px !important;
    }

    .dup_invoice input[id="amount"] {
        width: 90px !important;
    }

    .total input {
        width: 235px !important;
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
        width: 235px !important;

        line-height: 25px !important;
        height: 30px !important;
    }

    .total .select2-container--bootstrap4 {
        width: 245px !important;

        line-height: 25px !important;
        height: 30px !important;
    }

    .last_dup_invoice {
        margin-left: 27px;
    }

    .cut-btn {
        margin-left: 30px;
    }
</style>
<div class="container">
    <h4 class="text-center my-2">{{ $type == 0 ? 'Cash Invoice' : 'Credit Invoice' }}</h4>
    <div class="finance-layout" id="invoiceForm">
        <form id="form" enctype="multipart/form-data">
            @if ($type == 0)
                <div class="row justify-content-around mt-0">
                    <div class="col-3">
                        <div class="row mb-3">
                            <label class="col-3 col-form-label" for="Invoice">Invoice#</label>
                            <div class="col-8">
                                <input class="form-control" style="border: none !important; width: 219px !important;"
                                    type="text" id="" name="" value="<?php $year = date('Y');
                                    $lastTwoWords = substr($year, -2);
                                    echo $rand = 'SI' . '-' . $year . '-' . $count + 1; ?>" />
                                <input class="form-control" type="hidden" id="unique_id" name="unique_id"
                                    value="{{ $rand = $count + 1 }}" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-3 col-form-label" for="date">Date</label>
                            <div class="col-8">
                                <input class="form-control"
                                    style="border: none !important; width: 219px !important; text-align:center;        "
                                    type="date" id="date" name="date" value="<?php
                                    $currentDate = date('Y-m-d');
                                    echo $currentDate;
                                    ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="row mb-3">
                            <label class="col-4 col-form-label" for="w_cus_name">Customer Name</label>
                            <div class="col-7 d-flex align-items-center">
                                <input class="form-control" style="width: 219px !important;" type="text"
                                    id="w_cus_name" name="w_cus_name" />
                            </div>
                        </div>
                    </div>
                    <div class="col-3">

                        <div class="row mb-3">
                            <label class="col-4 col-form-label" for="w_cus_num">Customer Number</label>
                            <div class="col-7 d-flex align-items-center">
                                <input class="form-control" style="width: 219px !important;" type="text"
                                    id="w_cus_num" name="w_cus_num" />
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($type == 1)
                <div class="row justify-content-around mt-0">
                    <div class="col-3">
                        <div class="row mb-3">
                            <label class="col-3 col-form-label" for="Invoice">Invoice#</label>
                            <div class="col-8">
                                <input class="form-control" style="border: none !important; width: 219px !important;"
                                    type="text" id="" name="" value="<?php $year = date('Y');
                                    $lastTwoWords = substr($year, -2);
                                    echo $rand = 'SI' . '-' . $year . '-' . $count + 1; ?>" />
                                <input class="form-control" type="hidden" id="unique_id" name="unique_id"
                                    value="{{ $rand = $count + 1 }}" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-3 col-form-label" for="date">Date</label>
                            <div class="col-8">
                                <input class="form-control"
                                    style="border: none !important; width: 219px !important; text-align:center;        "
                                    type="date" id="date" name="date" value="<?php
                                    $currentDate = date('Y-m-d');
                                    echo $currentDate;
                                    ?>" />
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-3">
                        <div class="row mb-3">
                            <label class="col-3 col-form-label" for="buyer">Customer</label>
                            <div class="col-8">
                                <select name="buyer" id="buyer" class="select-buyer">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="row mb-3">
                            <label class="col-3 col-form-label" for="remark">Remarks</label>
                            <div class="col-8">
                                <input class="form-control" style="width: 219px !important;" type="text"
                                    id="remark" name="remark" />
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <br />

            <div class="invoice">
                @csrf
                <div class="dup_invoice" onchange="addInvoice()">
                    <input type="hidden" class="pr_unit">
                    <input type="hidden" class="pr_price">
                    <div class="div   items">
                        <label for="item">Item</label>
                        <select name="item[]" id="item" style="height: 28px" onchange="addInvoice()" required
                            class="item0 select-fin-products">
                        </select>
                    </div>
                    <div class="div">
                        <label for="unit">Unit</label>
                        <select name="unit[]" id="unit" class="form-control" onchange="unitPrice(this)">
                            <option value="foot">foot</option>
                            <option value="inch">inch</option>
                            <option value="gaz">gaz</option>
                            <option value="meter">meter</option>
                            <option value="box">box</option>
                            <option value="coil">coil</option>
                            <option value="pcs">pcs</option>
                        </select>
                    </div>
                    <div class="div">
                        <label for="qty">Quantity</label>
                        <input type="number" step="any" id="qty" name="qty[]" />
                    </div>
                    <div class="div">
                        <label for="price">Price</label>
                        <input type="number" step="any" id="price" name="price[]" />
                    </div>
                    <div class="div">
                        <label for="amount">Amount</label>
                        <input type="number" step="any" min="0.00"
                            style="text-align: right;width: 235px !important;" step="any" value="0.00"
                            onchange='count()' id="amount" name="amount[]" />
                    </div>
                </div>
            </div>

            <div class="total" style="margin-top: 2.25%;">
                <div class="first">
                    <div class="one" style="
                    margin-left: -136%;
                ">
                        <label
                            style="
            position: fixed;
            top: 95%;
            left: -1%;
        ">Total</label>
                        <label
                            style="
            position: fixed;
            top: 124%;
            left: 69%;
        ">Discount:</label>


                        <label
                            style="
            position: fixed;
            top: 133%;
            left: 69%;
        ">Remaining
                            Balance:</label>
                        <label
                            style="
            position: fixed;
            top: 114%;
            left: 69%;
        ">Cash
                            Receive:</label>

                        <input type="number" step="any" name="qty_total" id="qty_total"
                            style="
                    
                    position: fixed;
                    top: 95%;
                    left: 27%;
                "=""="">
                        <input type="number" step="any" name="amount_total" id="amount_total"
                            style="
                    
                    position: fixed;
                    top: 95%;
                    left: 89.8%;
                    /* width: 190px !important; */
                "=""="">



                        @if ($type != 0)
                            <label style="
position: fixed;
top: 104%;
left: 69%;
">Receive
                                Account:</label>
                            <div
                                style="
                        position: fixed;
                        top: 104%;
                        left: 89.8%;
                        width: 235px !important;
                    "=""="">
                                <select name="cash_receive_account" id="cash_receive_account"
                                    class="select-assets-account"> </select>
                            </div>
                        @endif
                        <input type="number" step="any" name="cash_receive" id="cash_receive"
                            oninput="
                        let amount_total = +$('#amount_total').val();
                        $('#discount').val(amount_total - this.value)"
                            style="
                position: fixed;
                top: 115%;
                left: 89.8%;
                /* width: 190px !important; */
            "=""="">
                        <input type="number" step="any" name="discount" id="discount"
                            style="
                    position: fixed;
                    top: 124%;
                    left: 89.8%;
                    /* width: 190px !important; */
                "=""="">
                        <input type="number" step="any" name="remaining_balance" id="remaining_balance"
                            style="
            position: fixed;
            top: 133%;
            left: 89.8%;
            /* width: 190px !important; */
        "=""="">
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
                            <a href="#" id="imageAnchor" target="_blank"><img src="" alt="img"
                                    class="img-fluid" id="imagePreview" style="object-fit: fill; display:none;">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="mb-3">
                        <input type="file" class="form-control w-100" name="attachment" id="attachment"
                            style="
height: max-content !important;
" />
                    </div>
                    <button type="button" class="btn px-3 p-1 btn-secondary btn-md"
                        onclick="
            const fileInput = document.getElementById('attachment');
            fileInput.value = '';
            const imagePreview = document.getElementById('imagePreview');
            const imageAnchor = document.getElementById('imageAnchor');
            imagePreview.style.display = 'none'; 
            imagePreview.src = ''; 
            imageAnchor.href = '';
        ">
                        REMOVE
                    </button>

                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center"
        style="width: 90%; position: absolute; top:90%; gap: 30px !important;">

        <button type="submit" class="btn px-3 p-1 btn-secondary btn-md submit" id="submit"
            data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Enter">
            submit
        </button>
        {{-- <a href="{{ Route('invoice_sale') }}" class="btn px-3 p-1 btn-secondary btn-md submit" id="first_btn"
            data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + A">
            First
        </a>
        <a href="{{ Route('edit_invoice_sale', $rand - 1) }}" class="btn px-3 p-1 btn-secondary btn-md submit"
            id="previous_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + B">
            Previous
        </a>
        <a href="{{ Route('edit_invoice_sale', $rand + 1) }}" class="btn px-3 p-1 btn-secondary btn-md  submit"
            id="next_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + N">
            Next
        </a>
        <a href="{{ Route('last_invoice_sale') }}" class="btn px-3 p-1 btn-secondary btn-md  submit" id="last_btn"
            data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + L">
            Last
        </a>--}}
        <a href="{{ Route('edit_invoice_sale', $rand) }}"
            class="edit edit-btn  btn px-3 p-1 btn-secondary btn-md disabled" id="edit" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Shortcut: Shift + E">
            Edit
        </a> 
        <a href="{{ Route('new_invoice_sale') }}" class="edit add-more  btn px-3 p-1 btn-secondary btn-md disabled"
            id="add_more_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + M">
            Add More
        </a>

        <button type="button" class="btn px-3 p-1 btn-secondary btn-md disabled" id="sale_pdf">
            SALE PDF
        </button>
        {{-- 
        <button class="btn px-3 p-1 btn-secondary btn-md submit" onclick="
        window.location.reload()
        ">
            Revert
        </button> --}}
    </div>


    </form>
</div>
</div>

@push('s_script')
    <script>
        function cutShow() {
            $('.dup_invoice').removeClass('last_dup_invoice');

            $('.dup_invoice .cut-btn').remove();

            $('.dup_invoice:last').append(`
    <div class="div">
        <button class="cut-btn bg-transparent border-0" onclick="cutRow(this)">
            <i class="fas fa-times"></i>
        </button>
    </div>
`);

            $('.dup_invoice:last').addClass('last_dup_invoice');
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });



        $('.select-fin-products').on('select2:select', function(e) {
            var selectedData = e.params.data;
            let selectedOption = $(this).find('option:selected');

            let unit = selectedData.unit;
            let sale_price = selectedData.sale_price;

            let unitDropdown = $(this).closest('.dup_invoice').find('select[name="unit[]"]');
            let price = $(this).closest('.dup_invoice').find('input[name="price[]"]');
            unitDropdown.val(unit).change();
            price.val(sale_price).change();

            $(this).closest('.dup_invoice').find('.pr_unit').val(unit).change()
            $(this).closest('.dup_invoice').find('.pr_price').val(sale_price).change()

            // let cus_id = $('buyer')
            // $.ajax({
            //     url: '{{ Route('pr_sale_rate') }}',
            //     method: 'POST',
            //     data: {'cus_id':},
            //     success: function(response) {

            //     },
            //     error: function(error) {}
            // });

            // if (sale_price != 0 && sale_price != null){
            //     switch (unit) {
            //         case 'foot':
            //         price.val(sale_price).change(); // Supose price is 100 
            //             break;

            //         default:
            //             break;
            //     }

            // }
        });

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
        var counter = 1
        var countera = 0

        function addInvoice(one) {
            for (let i = 1; i <= counter; i++) {
                var clonedFields = `
    <div class="dup_invoice" onchange="addInvoice2()">
        <input type="hidden" class="pr_unit">
                    <input type="hidden" class="pr_price">
    <div class="div   items">
                    <select name="item[]" id="item` + counter + `" style="height: 28px" onchange="addInvoice2()"
                        class="item0 select-fin-products">
                    </select>
                </div>
                <div class="div">
                        <select name="unit[]" id="unit` + counter + `" class="form-control">
                               <option value="foot">foot</option>
                            <option value="inch">inch</option>
                            <option value="gaz">gaz</option>
                            <option value="meter">meter</option>
                            <option value="box">box</option>
                            <option value="coil">coil</option>
                            <option value="pcs">pcs</option>
                        </select>
                    </div>
                                <div class="div">
                    <input  type="number" step="any" id="qty` + counter + `"
                        name="qty[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" id="price` +
                    counter + `" name="price[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" min="0.00"
                        style="text-align: right;width: 235px !important;" step="any" value="0.00" onchange='count()'
                        id="amount` + counter + `" name="amount[]" class="xl-width-inp" />
                </div>
                
            </div>

`;
            }

            let amount = $("#amount").val()
            let narration = $("#sale_price").val()
            if (!$("#amount").hasClass('check')) {
                $("#amount").addClass("check")
                counter++
                countera++
                $(".invoice").append(clonedFields);

                cutShow()
            }

            $(document).ready(function() {

                $("input").on('input', function() {
                    total_calc();
                });
                $(document).on('click', function() {
                    total_calc();
                });
                $('.select-fin-products').select2({
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
                                        unit: item.unit,
                                        pur_price: item.purchase_price,
                                        sale_price: item.product_sale_price,
                                    };
                                })
                            };
                        },
                        cache: true
                    },

                    theme: 'bootstrap4',
                    width: '100%',
                    allowClear: true,
                    placeholder: '',
                });

                $('.select-fin-products').on('select2:select', function(e) {
                    var selectedData = e.params.data;
                    let selectedOption = $(this).find('option:selected');

                    let unitDropdown = $(this).closest('.dup_invoice').find('select[name="unit[]"]');
                    let price = $(this).closest('.dup_invoice').find('input[name="price[]"]');
                    unitDropdown.val(selectedData.unit).change();
                    price.val(selectedData.sale_price).change();
                });
            });
            $('.invoice').removeAttr('data-select2-id');


        }






        function addInvoice2(one) {
            for (let i = 1; i <= counter; i++) {
                var clonedFields = `
    <div class="dup_invoice" onchange="addInvoice2()">
        <input type="hidden" class="pr_unit">
                    <input type="hidden" class="pr_price">
    <div class="div   items">
                    <select name="item[]" id="item` + counter + `" style="height: 28px" onchange="addInvoice2()"
                        class="item0 select-fin-products">
                    </select>
                </div>
                <div class="div">
                        <select name="unit[]" id="unit` + counter + `" class="form-control">
                               <option value="foot">foot</option>
                            <option value="inch">inch</option>
                            <option value="gaz">gaz</option>
                            <option value="meter">meter</option>
                            <option value="box">box</option>
                            <option value="coil">coil</option>
                            <option value="pcs">pcs</option>
                        </select>
                    </div>
                                <div class="div">
                    <input  type="number" step="any" id="qty` + counter + `"
                        name="qty[]" />
                </div>
                <div class="div">
                    <input  type="number" step="any" id="price` +
                    counter + `" name="price[]" />
                </div>

                

                <div class="div">
                    <input  type="number" step="any" min="0.00"
                        style="text-align: right;width: 235px !important;" step="any" value="0.00" onchange='count()'
                        id="amount` + counter + `" name="amount[]" class="xl-width-inp" />
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
                    cutShow()
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


            $('.select-fin-products').select2({
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
                                    unit: item.unit,
                                    pur_price: item.purchase_price,
                                    sale_price: item.product_sale_price,
                                };
                            })
                        };
                    },
                    cache: true
                },

                theme: 'bootstrap4',
                width: '100%',
                allowClear: true,
                placeholder: '',
            });
            $('.select-fin-products').on('select2:select', function(e) {
                var selectedData = e.params.data;
                let selectedOption = $(this).find('option:selected');

                let unitDropdown = $(this).closest('.dup_invoice').find('select[name="unit[]"]');
                let price = $(this).closest('.dup_invoice').find('input[name="price[]"]');
                unitDropdown.val(selectedData.unit).change();
                price.val(selectedData.sale_price).change();
            });
            $('.invoice').removeAttr('data-select2-id');
        }

        function unitPrice(element) {
            let currentUnit = $(element).closest('.dup_invoice').find('.pr_unit').val();
            let price = parseFloat($(element).closest('.dup_invoice').find('.pr_price').val());
            let selectedUnit = $(element).val();

            if (selectedUnit != 'pcs' || selectedUnit != 'box' || selectedUnit != 'coil') {

                if (isNaN(price)) {
                    return;
                }

                const unitRatios = {
                    foot: 1,
                    inch: 12,
                    yard: 0.3333,
                    meter: 0.3048,
                    gaz: 0.9144
                };

                if (!unitRatios[currentUnit] || !unitRatios[selectedUnit]) {
                    return;
                }

                let basePrice = price / unitRatios[currentUnit];
                let newPrice = basePrice * unitRatios[selectedUnit];

                $(element).closest('.dup_invoice').find('input[name="price[]"]').val(newPrice.toFixed(2));
            } else {
                $(element).closest('.dup_invoice').find('input[name="price[]"]').val(price);
            }
        }

        function total_calc() {
            // GENERAL
            // let unit = $('#unit').find('option:selected');
            let qty = +$('#qty').val();
            let price = +$('#price').val();
            // let discount = +$('#discount').val();
            let amount = (qty * price);

            $('#amount').val(amount);

            // CLONE
            for (let i = 1; i <= countera; i++) {
                let qty = +$('#qty' + i).val();
                let price = +$('#price' + i).val();
                // let discount = +$('#discount' + i).val();
                let amount = (qty * price);

                $('#amount' + i).val(amount);
            }

            // TOTAL
            let qty_total = +$('#qty').val();
            let discount = +$('#discount').val();
            let cash_receive = +$('#cash_receive').val();
            let amount_total = +$('#amount').val();
            for (let i = 1; i <= countera; i++) {
                qty_total += +$('#qty' + i).val();
                amount_total += +$('#amount' + i).val();
            }


            $('#qty_total').val(qty_total);
            $('#amount_total').val(amount_total);
            let balance = amount_total - (discount + cash_receive)
            $('#remaining_balance').val(balance);
        }

        function cutRow(element) {
            $(element).closest('.dup_invoice').remove()
            counter--;
            countera--;
            cutShow()
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        var invoiceSubmitted = 0;

        $('#form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            if (invoiceSubmitted == 0) {

                $.ajax({
                    url: '{{ Route('store_invoice_sale') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false, // Prevent jQuery from setting the content type
                    processData: false, // Prevent jQuery from processing the data
                    success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: response,
                            timer: 1900
                        });

                        // $("#submit").addClass("disabled");
                        $("#submit").text("Correct");
                        invoiceSubmitted = 1;

                        $(".edit").css("display", "block");
                        $("#btn").css("display", "none");
                        $("#edit").removeClass("disabled");
                        $("#add_more").removeClass("disabled");
                        $("#sale_pdf").removeClass("disabled");
                        $("#purchase_pdf").removeClass("disabled");


                    },
                    error: function(error) {}
                });
            } else if (invoiceSubmitted == 1) {

                var unique_id = $("#unique_id").val();
                $.ajax({
                    url: '{{ Route('update_invoice_sale', [':unique_id']) }}'.replace(':unique_id',
                        unique_id),
                    method: 'POST',
                    data: formData,
                    contentType: false, // Prevent jQuery from setting the content type
                    processData: false, // Prevent jQuery from processing the data
                    success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: response,
                            timer: 1900
                        });
                    },
                    error: function(error) {}
                });
            }
        });



        $('#sale_pdf').click(function(event) {
            if (!$(this).hasClass('disabled')) {

                event.preventDefault();
                // var formData = new FormData(this);
                var unique_id = $("#unique_id").val();
                var url = '{{ route('pdf_invoice_sale', [':unique_id', 0]) }}'.replace(':unique_id', unique_id);

                window.open(url, '__blank')
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

                            <button type="submit" data-url="{{ Route('edit_invoice_sale') }}" class="btn btn-primary"
                                id="search-btn">Search</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endpush
@endsection
