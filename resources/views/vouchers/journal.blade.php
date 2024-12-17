@extends('layout.app') @section('title', 'Journal Voucher') @section('content')
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

    .container {
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
    }

    .top label {
        margin: 5px;
    }

    .dup_invoice label {
        width: 71px;
        text-align: center;
        height: 55px;
        padding: 15px auto 15px 15px;
        border: 1px solid none;
        display: flex;
    }


    .dup_invoice input {
        border: 1px solid;
        width: 71px;
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
        width: 141px !important;
        height: 27px !important;
    }

    #invoiceForm select {
        width: 181px !important;
        height: 27px !important;
    }

    #form {
        width: 140%;
        margin-left: -22%;
    }

    #invoiceForm .select2-container--classic {
        width: 171px !important;
        height: 27px !important;

        line-height: 25px !important;
        height: 25px !important;
    }

    .select2-dropdown {
        width: 200px !important;
    }

    .select2-container--classic .select2-search--dropdown .select2-search__field {
        width: 100% !important;
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
        /* Remove the default focus outline */
    }



    .remark .select2-container--default .select2-selection--single .select2-selection__rendered {
        width: 219px !important;
        height: 27px !important;

        line-height: 25px !important;
        height: 25px !important;
        padding-top: 2px;
    }





    /* .fields input{
    padding-left: 25%;
  }
  .one select{
    padding-left: 25%;
      } */
</style>
<div class="container" id="invoiceForm" style="margin-top: -37px; padding-top: 5px;        overflow-x: visible;
">
    <form id="form">
        <h3 style="text-align: center;">Journal Voucher</h3>

        <div class="top">
            <div class="fields">
                <div class="one">
                    <input style="border: none !important;" style="border: none !important;" readonly type="date"
                        id="date" value="<?php
                        $currentDate = date('Y-m-d');
                        echo $currentDate;
                        ?>" />
                </div>
                <div class="one">
                    <label for="Invoice">GR#</label>
                    <input style="border: none !important;" type="text" readonly value="<?php $year = date('Y');
                    $lastTwoWords = substr($year, -2);
                    echo $rand = 'JV' . '-' . $year . '-' . $count + 1; ?>" />
                    <input style="border: none !important;" type="hidden" id="invoice#" name="unique_id" readonly
                        value="{{ $rand = $count + 1 }}" />
                </div>
                <div class="one">
                    <label for="date">Date</label>
                    <input style="border: none !important;" type="date" id="date" name="date"
                        value="<?php
                        $currentDate = date('Y-m-d');
                        echo $currentDate;
                        ?>" />
                </div>



            </div>

            <div class="fields">

                <div class="one  remark">
                    <label for="seller">Accounts</label>
                    <select name="company" id="seller" class="company select-account">
                    </select>
                </div>

                <div class="one  remark">
                    <label for="seller">Sales Ofiicer</label>
                    <select name="sales_officer" id="sales_officer" class="sales_officer select-sales_officer">
                    </select>
                </div>
            </div>

            <div class="fields">


                <div class="one">
                    <label for="Invoice">Ref No</label>
                    <input type="text" id="ref_no" name="ref_no" />
                </div>
                <div class="one  remark">
                    <label for="remark">Remarks</label>
                    <input style="width: 219px !important;" type="text" id="remark" name="remark" />
                </div>
                {{-- <div class="one  remark">
                    <label for="farm">Farm</label>
                    <select name="farm" class="select-farm" style="justify-content: space-around">
                    </select>
                </div> --}}
            </div>
        </div>

        <br />

        <div class="invoice">
            @csrf
            <div class="dup_invoice" onchange="addInvoice()">


                <div class="div">
                    <label for="unit">Narration</label>
                    <input style="width: 249px !important;" type="text" list="narrations" id="narration"
                        name="narration[]" />
                    <datalist id="narrations">
                        @foreach ($narrations as $row)
                            <option>{{ $row->narration }}</option>
                        @endforeach
                    </datalist>
                </div>

                <div class="div">
                    <label for="dis">Farm</label>
                    <select name="farm[]" class="select-farm" style="justify-content: space-around">
                    </select>
                </div>
                <div class="div">
                    <label for="dis">Invoice</label>
                    <select class="invoice_no select-all-invoice-no" name="invoice_no[]" style="height: 28px">
                        <option></option>
                    </select>
                </div>
                <div class="div">
                    <label for="dis">Cheque No (s)</label>
                    <input type="text" min="0.00" step="any" id="cheque_no" name="cheque_no[]" />
                </div>
                <div class="div">
                    <label for="dis">Cheque Date</label>
                    <input type="date" min="0.00" style="width: 131px !important;" step="any" value="0.00"
                        id="cheque_date" name="cheque_date[]" onchange='  total_amount()' />
                </div>
                <div class="div">
                    <label>From Account</label>
                    <select class="cash_bank  select-account" name="from_account[]" style="height: 28px">

                    </select>
                </div>
                <div class="div">
                    <label>To Account</label>
                    <select class="cash_bank  select-account" name="to_account[]" style="height: 28px">

                    </select>
                </div>
                <div class="div">
                    <label for="dis">Dr/Cr</label>
                    <select name="status[]">
                        <option value="debit">Debit</option>
                        <option value="credit">Credit</option>
                    </select>
                </div>
                <div class="div">
                    <label for="amount">Amount</label>
                    <input type="number" step="any" min="0.00" style="text-align: right;" step="any"
                        value="0.00" onchange='total_amount()' id="amount" name="amount[]" />
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
<button type="button" class="mx-5 px-3 p-1 btn btn-secondary btn-md" data-bs-toggle="modal"
    data-bs-target="#imageModal" style="
    margin-top: -17%;
">
    Attachment
</button>
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Image Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row p-2">
                    <div class="col-lg-9 col-md-12 p-2">
                        <a href="#" id="imageAnchor" target="_blank"><img src="" alt="img"
                                class="img-fluid" id="imagePreview" style="object-fit: fill; display:none;">
                        </a>
                    </div>
                    <div class="col-3 col-md-12">
                        <div class="row justify-content-start">
                            <div class="mb-3">
                                <input type="file" class="form-control" name="attachment" id="attachment"
                                    style="
    height: max-content !important;
" />
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
        </div>
    </div>
</div>
<div class="row m-5 justify-content-center align-items-center"
    style="position: relative;gap: 30px;margin-top: -110px !important;top: 60%;right: 0%;">

    <button type="submit" class="btn px-3 p-1 btn-secondary btn-md submit" id="submit" data-bs-toggle="tooltip" 
      data-bs-placement="top" 
      title="Shortcut: Enter">
        submit
    </button>
    <a href="{{ Route('journal-voucher.edit', $rand - 1) }}" class="btn px-3 p-1 btn-secondary btn-md  submit"id="previous_btn" data-bs-toggle="tooltip" 
        data-bs-placement="top" 
        title="Shortcut: Shift + B">
            Previous
    </a>
    <a href="{{ Route('journal-voucher.edit', $rand + 1) }}" class="btn px-3 p-1 btn-secondary btn-md  submit" id="next_btn" data-bs-toggle="tooltip" 
        data-bs-placement="top" 
        title="Shortcut: Shift + N">
            Next
    </a>

    <a href="{{ Route('journal-voucher.edit', $rand) }}"
        class="edit edit-btn  btn px-3 p-1 btn-secondary btn-md disabled" id="edit" data-bs-toggle="tooltip" 
            data-bs-placement="top" 
            title="Shortcut: Shift + E">
            Edit
    </a>
    <a href="{{ Route('journal-voucher.create') }}" class="edit add-more  btn px-3 p-1 btn-secondary btn-md"
        id="add_more_btn" data-bs-toggle="tooltip" 
            data-bs-placement="top" 
            title="Shortcut: Shift + M">
            Add More
    </a>


    <a href="{{ Route('journal_voucher.report', $rand) }}" class="edit pdf btn btn-secondary btn-md" id="pdf"
        target="__blank">
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
        $('#form').submit(function(event) {

            event.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '{{ Route('journal-voucher.store') }}',
                method: 'POST',
                data: formData,
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
    </script>
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

        });

        var counter = 1
        var countera = 0
        var stop = 0

        function addInvoice(one) {

            for (let i = 1; i <= counter; i++) {


                var clonedFields = `
            <div class="dup_invoice" >


<div class="div">
    <input style="width: 249px !important;"  type="text" id="narration` + counter +
                    `" name="narration[]" onchange="addInvoice2(` + counter + `)"/>
</div>

 <div class="div">
                    <select class="farm select-farm" name="farm[]" style="height: 28px">
                        <option></option>
                    </select>
                </div>
 <div class="div">
                    <select class="invoice_no select-all-invoice-no" name="invoice_no[]" style="height: 28px">
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
                    <select class="cash_bank  select-account" name="from_account[]" style="height: 28px">

                    </select>
                </div>
                <div class="div">
                    <select class="cash_bank  select-account" name="to_account[]" style="height: 28px">

                    </select>
                </div>
                <div class="div">
                    <select name="status[]">
                        <option value="debit">Debit</option>
                        <option value="credit">Credit</option>
                    </select>
                </div>

<div class="div">
    <input  type="number" step="any" min="0.00" style="text-align: right;" step="any" value="0.00" onchange='total_amount()' id="amount` +
                    counter + `"  style="text-align:end;" name="amount[]" />
</div>
</div>


  `;



            }

            let amount = $("#narration").val()
            let narration = $("#narration").val()
            if (!$("#narration").hasClass('check')) {


                if (amount > 0 && narration != '') {

                    $("#narration").addClass("check")
                    console.log(counter + "first");


                    counter++
                    countera++


                    $(".invoice").append(clonedFields);



                    $('.select-account').select2({
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
                    $('.select-farm').select2({
                        ajax: {
                            url: '{{ route('select2.farm') }}',
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
                                            text: item.name,
                                            id: item.id
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
                        allowClear: true,
                        placeholder: '',
                    });
                    $('.select-all-invoice-no').select2({
                        ajax: {
                            url: '{{ route('select2.all_invoice_no') }}',
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
<input style="width: 249px !important;"  type="text" id="narration` + counter +
                    `" name="narration[]" onchange="addInvoice2(` + counter + `)"/>
</div>
 <div class="div">
                    <select class="farm select-farm" name="farm[]" style="height: 28px">
                        <option></option>
                    </select>
                </div>
 <div class="div">
                    <select class="invoice_no select-all-invoice-no" name="invoice_no[]" style="height: 28px">
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
                    <select class="cash_bank  select-account" name="from_account[]" style="height: 28px">

                    </select>
                </div>
                <div class="div">
                    <select class="cash_bank  select-account" name="to_account[]" style="height: 28px">

                    </select>
                </div>
                <div class="div">
                    <select name="status[]">
                        <option value="dr">Debit</option>
                        <option value="credit">Credit</option>
                    </select>
                </div>

<div class="div">
<input  type="number" step="any" min="0.00" style="text-align: right;" step="any" value="0.00" onchange='total_amount()' id="amount` +
                    counter + `"  style="text-align:end;" name="amount[]" />
</div>
</div>


`;



            }




            counter = counter - 1
            let amount2 = $("#narration" + counter).val()
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

                    $('.select-account').select2({
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
                    $('.select-farm').select2({
                        ajax: {
                            url: '{{ route('select2.farm') }}',
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
                                            text: item.name,
                                            id: item.id
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
                        allowClear: true,
                        placeholder: '',
                    });
                    $('.select-all-invoice-no').select2({
                        ajax: {
                            url: '{{ route('select2.all_invoice_no') }}',
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
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
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

                            <button type="submit" data-url="{{ Route('journal-voucher.edit') }}"
                                class="btn btn-primary" id="search-btn">Search</button>

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
