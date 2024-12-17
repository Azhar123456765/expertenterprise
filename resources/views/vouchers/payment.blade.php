@extends('layout.app') @section('title', 'Payment Voucher') @section('content')
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
        width: 131px;
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
        width: 131px;
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
        width: 200px !important;
    }

    .total input {
        width: 260px !important;
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
    }
</style>
<div class="container">
    <h3 class="text-center my-2">Payment Voucher</h3>
    <div class="finance-layout" id="invoiceForm" style="overflow-x: visible;
">
        <form id="form">
            <div class="row justify-content-around mt-0">
                <div class="col-3">
                    <div class="row mb-3">
                        <div class="col-8">
                            <input style="border: none !important;" style="border: none !important;" readonly
                                type="date" id="date" value="<?php
                                $currentDate = date('Y-m-d');
                                echo $currentDate;
                                ?>" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label" for="Invoice">GR#</label>
                        <div class="col-8">
                            <input class="form-control" style="border: none !important;width: 219px !important;"
                                type="text" id="invoice#" value="<?php $year = date('Y');
                                $lastTwoWords = substr($year, -2);
                                echo $rand = 'PV' . '-' . $year . '-' . $count + 1; ?>" />
                            <input type="hidden" id="unique_id" name="unique_id" value="{{ $rand = $count + 1 }}" />
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
                        <label class="col-3 col-form-label">Company</label>
                        <div class="col-8">
                            <select name="company" id="company" class="company select-buyer" required>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label">Sales Officer</label>
                        <div class="col-8">
                            <select name="sales_officer" id="sales_officer" class="select-sales_officer">
                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-3">
                    <div class="row mb-3">
                        <label class="col-3 col-form-label" for="remark">Ref No</label>
                        <div class="col-8">
                            <input class="form-control" type="text" id="ref_no" name="ref_no"
                                style="width: 219px !important;" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label" for="remark">Remarks</label>
                        <div class="col-8">
                            <input class="form-control" style="width: 219px !important;" type="text" id="remark"
                                name="remark" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-form-label">Farm</label>
                        <div class="col-8">
                            <select name="farm" class="select-farm">
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <br />

            <div class="invoice">
                @csrf
                <div class="dup_invoice" onchange="addInvoice()">


                    <div class="div">
                        <label for="unit">Narration</label>
                        <input style="width: 289px !important;" type="text" id="narration" name="narration[]" />
                    </div>
                    <div class="div">
                        <label for="dis">Invoice</label>
                        <select class="invoice_no select-seller-invoice-no" name="invoice_no[]" style="height: 28px">
                            <option></option>
                        </select>
                    </div>

                    <div class="div">
                        <label for="dis">Cheque No (s)</label>
                        <input type="text" min="0.00" step="any" id="cheque_no" name="cheque_no[]" />
                    </div>
                    <div class="div">
                        <label for="dis">Cheque Date</label>
                        <input type="date" min="0.00" style="width: 131px !important;" step="any"
                            value="0.00" id="cheque_date" name="cheque_date[]" onchange='  total_amount()' />
                    </div>
                    <div class="div">
                        <label>Cash/Bank Account</label>
                        <select class="cash_bank select-assets-account" name="cash_bank[]" style="height: 28px">
                        </select>
                    </div>

                    <div class="div">
                        <label for="amount">Amount</label>
                        <input type="number" step="any" min="0.00"
                            style="text-align: right; width: 240px !important;" step="any" value="0.00"
                            onchange='total_amount()' id="amount" name="amount[]" />
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
                    margin-top: -210px;
                }
            </style>

            <div class="total" style="margin-top: 2.25%;">
                <div class="first">
                    <div class="one" style="
            margin-left: 0%;
        ">

                        <input type="number" step="any" step="any" name="amount_total" id="amount_total"
                            style="
            margin-left: 183%;
            text-align:end;
        " readonly>

                    </div>

                    <br>
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
    style="width: 95%; position: absolute; top:90%; gap: 30px !important;">
    <button type="submit" class="btn px-3 p-1 btn-secondary btn-md submit" id="submit" data-bs-toggle="tooltip"
        data-bs-placement="top" title="Shortcut: Enter">
        submit
    </button>


    <a href="{{ Route('payment_voucher.create_first') }}" class="btn px-3 p-1 btn-secondary btn-md " id="first_btn"
        data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + A">
        First
    </a>
    <a href="{{ Route('payment_voucher.edit', $rand - 1) }}"
        class="btn px-3 p-1 btn-secondary btn-md "id="previous_btn" data-bs-toggle="tooltip" data-bs-placement="top"
        title="Shortcut: Shift + B">
        Previous
    </a>
    <a href="{{ Route('payment_voucher.edit', $rand + 1) }}" class="btn px-3 p-1 btn-secondary btn-md "
        id="next_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + N">
        Next
    </a>
    <a href="{{ Route('payment_voucher.create_last') }}"
        class="btn px-3 p-1 btn-secondary btn-md  submit"id="last_btn" data-bs-toggle="tooltip"
        data-bs-placement="top" title="Shortcut: Shift + L">
        Last
    </a>
    <a href="{{ Route('payment_voucher.edit', $rand) }}"
        class="edit edit-btn  btn px-3 p-1 btn-secondary btn-md disabled" id="edit" data-bs-toggle="tooltip"
        data-bs-placement="top" title="Shortcut: Shift + E">
        Edit
    </a>
    <a href="{{ Route('payment_voucher.create') }}" class="edit add-more  btn px-3 p-1 btn-secondary btn-md"
        id="add_more_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Shortcut: Shift + M">
        Add More
    </a>

    <a href="{{ Route('payment_voucher.report', $rand) }}" class="edit pdf btn btn-secondary btn-md disabled"
        target="__blank" id="pdf">
        PDF
    </a>



    <button class="btn px-3 p-1 btn-secondary btn-md  submit" style=""
        onclick="
        
        window.location.reload()
        ">
        Revert
    </button>
</div>


</form>
</div>




<div class="flex justify-center items-center" style="display: none">
    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center custom-alert"
        style="
            position: fixed;
            top: 79%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 32%;
            opacity: 0.75;
        ">
        <span class="show1"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
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
        $(document).change(function() {
            total_amount();
            $('.select-seller-invoice-no').select2({
                ajax: {
                    url: '{{ route('select2.seller_invoice_no') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            id: $("#company").find('option:selected').val(),
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.unique_id_name,
                                    id: item.unique_id_name
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

        })





        function handleKeyPress(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Prevent the default behavior (e.g., form submission)
                const currentElement = event.target;
                const focusableElements = getFocusableElements();
                const currentIndex = focusableElements.indexOf(currentElement);
                const nextIndex = (currentIndex + 1) % focusableElements.length;
                focusableElements[nextIndex].focus();
            }
        }




        var counter = 1
        var countera = 0
        var stop = 0

        function addInvoice(one) {

            for (let i = 1; i <= counter; i++) {


                var clonedFields = `
            <div class="dup_invoice" >


<div class="div">
    <input style="width: 289px !important;"  type="text" id="narration` + counter +
                    `" name="narration[]" onchange="addInvoice2(` + counter + `)"/>
</div>

<div class="div">
                    <select class="invoice_no select-seller-invoice-no" name="invoice_no[]" style="height: 28px">
                        <option></option>
                        
                        

                    </select>
                </div>
<div class="div">
    <input  type="text" min="0.00" step="any" id="cheque_no` + counter +
                    `" name="cheque_no[]"  onchange="addInvoice2(` + counter +
                    `)"/>
</div>
<div class="div">
    <input  type="date" min="0.00" style="width: 131px !important;" step="any" value="0.00" id="cheque_date` +
                    counter +
                    `" name="cheque_date[]"  />
</div>
<div class="div">
    <select class="cash_bank select-assets-account" name="cash_bank[]" style="height: 28px">
     
    </select>
</div>

<div class="div">
    <input  type="number" step="any" min="0.00" style="text-align: right; width: 240px !important;" step="any" value="0.00" onchange='total_amount()' id="amount` +
                    counter + `"  style="text-align:end;" name="amount[]" />
</div>
</div>


  `;



            }

            let amount = $("#amount").val()
            let narration = $("#narration").val()
            if (!$("#narration").hasClass('check')) {


                if (amount > 0 && narration != '') {

                    $("#narration").addClass("check")
                    console.log(counter + "first");


                    counter++
                    countera++


                    $(".invoice").append(clonedFields);



                    $('.select-assets-account').select2({
                        ajax: {
                            url: '{{ route('select2.account') }}',
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
                                            text: item.account_name,
                                            id: item.id
                                        };
                                    })
                                };
                            },
                            cache: true
                        },

                        theme: 'bootstrap4',
                        width: '100%',
                    });

                }
            }

            // let amount2 = $("#amount" + counter).val()
            // let narration2 = $("#narration" + counter).val()

            // if (!$("#narration" + counter).hasClass('check')&& $("#narration").hasClass('check') && $("#narration").val() != '') {


            //     if (narration2 != '') {

            //         $("#narration" + counter).addClass("check")



            //         counter++
            //         countera++


            //         $(".invoice").append(clonedFields);

            //     }

            // }



        }









        function addInvoice2(one) {

            for (let i = 1; i <= counter; i++) {


                var clonedFields = `
    <div class="dup_invoice" >


<div class="div">
<input style="width: 289px !important;"  type="text" id="narration` + counter +
                    `" name="narration[]" onchange="addInvoice2(` + counter + `)"/>
</div>

<div class="div">
                    <select class="invoice_no select-seller-invoice-no" name="invoice_no[]" style="height: 28px">
                        <option></option>
                        
                        

                    </select>
                </div>
<div class="div">
<input  type="text" min="0.00" step="any" id="cheque_no` + counter +
                    `" name="cheque_no[]" onchange="addInvoice2(` + counter +
                    `)" />
</div>
<div class="div">
<input  type="date" min="0.00" style="width: 131px !important;" step="any" value="0.00" id="cheque_date` +
                    counter +
                    `" name="cheque_date[]"  />
</div>
<div class="div">
<select class="cash_bank select-assets-account" name="cash_bank[]" style="height: 28px">
     
    </select>
</div>

<div class="div">
<input  type="number" step="any" min="0.00" style="text-align: right; width: 240px !important;" step="any" value="0.00" onchange='total_amount()' id="amount` +
                    counter + `"  style="text-align:end;" name="amount[]" />
</div>
</div>


`;



            }




            counter = counter - 1
            let amount2 = $("#amount" + counter).val()
            console.log(counter);
            let narration2 = $("#narration" + counter).val()
            if (!$("#narration" + counter).hasClass('check')) {


                if (amount2 != '' && narration2 != '') {

                    $("#narration" + countera).addClass("check")

                    console.log(counter);
                    console.log(countera);

                    counter++
                    countera++


                    $(".invoice").append(clonedFields);

                    $('.select-assets-account').select2({
                        ajax: {
                            url: '{{ route('select2.account') }}',
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
                                            text: item.account_name,
                                            id: item.id
                                        };
                                    })
                                };
                            },
                            cache: true
                        },

                        theme: 'bootstrap4',
                        width: '100%',
                    });


                }
            }

            counter = counter + 1
            // let amount2 = $("#amount" + counter).val()
            // let narration2 = $("#narration" + counter).val()

            // if (!$("#narration" + counter).hasClass('check')&& $("#narration").hasClass('check') && $("#narration").val() != '') {


            //     if (narration2 != '') {

            //         $("#narration" + counter).addClass("check")



            //         counter++
            //         countera++


            //         $(".invoice").append(clonedFields);

            //     }

            // }


        }

















        function total_amount() {
            var atotal = parseFloat($("#amount").val());

            console.log(atotal);
            for (let i = 1; i <= countera; i++) {
                let amount1 = parseFloat($("#amount" + i).val());
                atotal += amount1;
            }

            $("#amount_total").val(atotal);
        }
    </script>
    <script>
        $(".cash_bank option").click(function() {
            // Initialize Select2 for the desired select elements
            // Initialize other select elements if necessary
        });

        $(document).ready(function() {
            // Initialize Select2 for the desired select elements



            // Initialize other select elements if necessary
        });

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });



        $('#form').submit(function(event) {

            event.preventDefault();

            // Get the form data
            var formData = new FormData(this);

            // Send an AJAX request
            $.ajax({
                url: '{{ Route('payment_voucher.store') }}', // Replace with your Laravel route or endpoint
                method: 'POST',
                data: formData,
                contentType: false, // Prevent jQuery from setting the content type
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting the content type
                processData: false, // Prevent jQuery from processing the data
                success: function(response) {
                    // Handle the response

                    Swal.fire({
                        icon: 'success',
                        title: response,
                        timer: 1900 // Automatically close after 3 seconds
                    });
                    $("#submit").addClass("disabled");
                    $("#edit").removeClass("disabled");
                    $("#pdf").removeClass("disabled");



                },
                error: function(error) {
                    // Handle the error
                },
            });
        })
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
            if ((e.altKey) && (String.fromCharCode(e.which).toLowerCase() === 'n')) {
                var str = $('[name=\'unique_id\']').val();
                var parts = str.split('-');
                var firstPart = parts.slice(0, -1).join('-');
                var lastPart = parts[parts.length - 1];
                var newUrl = '/ep_voucher_id=' + firstPart + '-' + (parseInt(lastPart) + 1);
                window.location.href = newUrl;
            }
        });

        $(document).on('keydown', function(e) {
            if ((e.altKey) && (String.fromCharCode(e.which).toLowerCase() === 'b')) {
                var str = $('[name=\'unique_id\']').val();
                var parts = str.split('-');
                var firstPart = parts.slice(0, -1).join('-');
                var lastPart = parts[parts.length - 1];
                var newUrl = '/ep_voucher_id=' + firstPart + '-' + (parseInt(lastPart) - 1);
                window.location.href = newUrl;
            }
        });
    </script>
    <div class="modal fade" id="iv-search">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Search Voucher</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="/saleInvoice-search">
                        @csrf
                        <div class="form-group">
                            <label>Voucher No</label>
                            <input type="text" class="form-control" id="search-input"
                                style="width: 100% !important;">
                        </div>

                        <button type="submit" data-url="{{ Route('payment_voucher.edit') }}" class="btn btn-primary"
                            id="search-btn">Search</button>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div>
@endpush
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>
@endsection
