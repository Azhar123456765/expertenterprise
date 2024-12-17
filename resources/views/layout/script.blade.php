<!-- Core JS Files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('../assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('../assets/js/core/bootstrap.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('../assets/js/plugin/datatables/datatables.min.js') }}"></script>

<!-- Kaiadmin JS -->
<script src="{{ asset('../assets/js/kaiadmin.min.js') }}"></script>
<script src="{{ asset('../assets/js/setting-demo2.js') }}"></script>

<!-- Include Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<script>
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
    $(document).ready(function() {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
            pageLength: 5,
            initComplete: function() {
                this.api()
                    .columns()
                    .every(function() {
                        var column = this;
                        var select = $(
                                '<select class="form-select"><option value=""></option></select>'
                            )
                            .appendTo($(column.footer()).empty())
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                column
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function(d, j) {
                                select.append(
                                    '<option value="' + d + '">' + d + "</option>"
                                );
                            });
                    });
            },
        });

        // Add Row
        $("#add-row").DataTable({
            pageLength: 5,
        });

        var action =
            '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function() {
            $("#add-row")
                .dataTable()
                .fnAddData([
                    $("#addName").val(),
                    $("#addPosition").val(),
                    $("#addOffice").val(),
                    action,
                ]);
            $("#addRowModal").modal("hide");
        });

    });
</script>

<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js') }}"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.min.css">
<script src="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.min.js') }}"></script>

@if (session('message') != '')
    <script>
        Swal.fire({
            icon: 'success',
            title: "{{ session('message') }}",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000 // Automatically close after 3 seconds
        });
    </script>
@endif
@if (session('something_error') != '')
    <script>
        Swal.fire({
            icon: 'warning',
            title: "{{ session('something_error') }}",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            Swal.fire({
                icon: 'warning',
                title: "{{ $error }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endforeach
@endif

<script>
    $(document).ready(function() {
        $("#example1")
            .DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            })
            .buttons()
            .container()
            .appendTo("#example1_wrapper .col-md-6:eq(0)");
    });

    function pdf(field) {

        var href = field;
        window.location.href = "/pdf" + href
    }

    // Check if the screen width is less than or equal to 767 pixels (common mobile breakpoint)
    if (window.innerWidth() <= 500) {
        // Select anchor elements with the class 'external-link' within aside elements
        var links = $('aside a');

        // Iterate through each link and set the target attribute to '_blank'
        links.each(function() {
            $(this).attr('target', '_blank');
        });
    }

    function accountData() {
        var company = $("#head_account").find('option:selected');
        var id = company.data('id')

        $("#head_account").on('change', function() {

            let invoice = $("#gen-led-account").find('option:selected').val('');
            let invoiceText = $("#gen-led-account").find('option:selected').text('');

        })

        // console.log('it is id ' + id);
        $(document).ready(function() {
            $('#gen-led-account').select2({
                ajax: {
                    url: '/get-data/account',
                    dataType: 'json',
                    data: {
                        'id': id
                    },
                    delay: 250,
                    processResults: function(data) {

                        // console.log(data.data);          
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.account_name
                                };
                            })
                        }

                    },
                    cache: true,
                    theme: 'bootstrap4',
                    width: '100%',
                },
            });
        });

    }

    function user_check_access() {


        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });


        // Get the form data

        // Send an AJAX request
        $.ajax({
            url: '/user-access', // Replace with your Laravel route or endpoint
            method: 'POST',
            success: function(response) {
                // Handle the response
                // console.log(response);
                if (response == false) {
                    window.location.href = '/'
                } else {

                }

            },
            error: function(error) {
                // Handle the error
            },
        });
    }


    $(document).click(function() {

        user_check_access();
    })
    $(document).change(function() {

        user_check_access();
    })
    $(document).focus(function() {

        user_check_access();
    })

    function readURL(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image-upload-wrap').hide();

                $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();

                $('.image-title').html(input.files[0].name);
            };

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUpload();
        }
    }

    function removeUpload() {
        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }
    $('.image-upload-wrap').bind('dragover', function() {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function() {
        $('.image-upload-wrap').removeClass('image-dropping');
    });


    $(document).on('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && (String.fromCharCode(e.which).toLowerCase() === 'm')) {
            $("#add-modal").modal('show');
            $("#login-modal").modal('show');
        }
    });

    $(document).on('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && (String.fromCharCode(e.which).toLowerCase() === 'l')) {
            window.location.href = '/logout'
        }
    });

    $('#clear-btn').on('click', function() {
        alert(1)
    });
    // const elements = document.querySelectorAll('input, select');

    // let currentIndex = 2;

    // document.addEventListener('keydown', function(e) {
    //     if (e.key === 'Shift') {
    //         e.preventDefault();
    //         currentIndex = (currentIndex + 1) % elements.length;
    //         elements[currentIndex].focus();
    //     }
    // });

    $(document).ready(function() {

        $('input[name="date"]').focus();

    })


    // SELECT2
    // $(document).ready(function () {
    //     $('.select-account').select2({
    //         ajax: {
    //             url: '{{ route('select2.account') }}',
    //             dataType: 'json',
    //             delay: 250,
    //             data: function (params) {
    //                 return {
    //                     q: params.term
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: $.map(data, function (item) {
    //                         return {
    //                             text: item.account_name,
    //                             id: item.id
    //                         };
    //                     })
    //                 };
    //             },
    //             cache: true
    //         },
    //        
    //         theme: 'bootstrap4',
    //         width: '100%',
    //     });
    //     $('.select-warehouse').select2({
    //         ajax: {
    //             url: '{{ route('select2.warehouse') }}',
    //             dataType: 'json',
    //             delay: 250,
    //             data: function (params) {
    //                 return {
    //                     q: params.term
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: $.map(data, function (item) {
    //                         return {
    //                             text: item.warehouse_name,
    //                             id: item.warehouse_id
    //                         };
    //                     })
    //                 };
    //             },
    //             cache: true
    //         },
    //        
    //         theme: 'bootstrap4',
    //         width: '100%',
    //     });

    //     $('.select-sales_officer').select2({
    //         ajax: {
    //             url: '{{ route('select2.sales_officer') }}',
    //             dataType: 'json',
    //             delay: 250,
    //             data: function (params) {
    //                 return {
    //                     q: params.term
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: $.map(data, function (item) {
    //                         return {
    //                             text: item.sales_officer_name,
    //                             id: item.sales_officer_id
    //                         };
    //                     })
    //                 };
    //             },
    //             cache: true
    //         },
    //        
    //         theme: 'bootstrap4',
    //         width: '100%',
    //     });
    //     $('.select-product_category').select2({
    //         ajax: {
    //             url: '{{ route('select2.product_category') }}',
    //             dataType: 'json',
    //             delay: 250,
    //             data: function (params) {
    //                 return {
    //                     q: params.term
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: $.map(data, function (item) {
    //                         return {
    //                             text: item.product_category_name,
    //                             id: item.product_category_id
    //                         };
    //                     })
    //                 };
    //             },
    //             error: function (jqXHR, textStatus, errorThrown) {
    //                 console.error('AJAX Error:', textStatus, errorThrown);
    //             }
    //         },
    //        
    //         theme: 'bootstrap4',
    //         width: '100%'
    //     });


    //     $('.select-product_company').select2({
    //         ajax: {
    //             url: '{{ route('select2.product_company') }}',
    //             dataType: 'json',
    //             delay: 250,
    //             data: function (params) {
    //                 return {
    //                     q: params.term
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: $.map(data, function (item) {
    //                         return {
    //                             text: item.product_company_name,
    //                             id: item.product_company_id
    //                         };
    //                     })
    //                 };
    //             },
    //             cache: true
    //         },
    //        
    //         theme: 'bootstrap4',
    //         width: '100%',
    //     });


    //     $('.select-customer').select2({
    //         ajax: {
    //             url: '{{ route('select2.buyer') }}',
    //             dataType: 'json',
    //             delay: 250,
    //             data: function (params) {
    //                 return {
    //                     q: params.term
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: $.map(data, function (item) {
    //                         return {
    //                             text: item.buyer_name,
    //                             id: item.buyer_id
    //                         };
    //                     })
    //                 };
    //             },
    //             cache: true
    //         },
    //        
    //         theme: 'bootstrap4',
    //         width: '100%',
    //     });


    //     $('.select-seller').select2({
    //         ajax: {
    //             url: '{{ route('select2.seller') }}',
    //             dataType: 'json',
    //             delay: 250,
    //             data: function (params) {
    //                 return {
    //                     q: params.term
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: $.map(data, function (item) {
    //                         return {
    //                             text: item.seller_name,
    //                             id: item.seller_id
    //                         };
    //                     })
    //                 };
    //             },
    //             cache: true
    //         },
    //        
    //         theme: 'bootstrap4',
    //         width: '100%',
    //     });


    //     $('.select-product').select2({
    //         ajax: {
    //             url: '{{ route('select2.products') }}',
    //             dataType: 'json',
    //             delay: 250,
    //             data: function (params) {
    //                 return {
    //                     q: params.term
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: $.map(data, function (item) {
    //                         return {
    //                             text: item.product_id,
    //                             id: item.product_name
    //                         };
    //                     })
    //                 };
    //             },
    //             cache: true
    //         },
    //        
    //         theme: 'bootstrap4',
    //         width: '100%',
    //     });



    //     $('.select-seller-buyer').select2({
    //         ajax: {
    //             url: '{{ route('select2.seller-buyer') }}',
    //             dataType: 'json',
    //             delay: 250,
    //             data: function (params) {
    //                 return {
    //                     q: params.term
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: $.map(data.returnData, function (item) {
    //                         return {
    //                             if(data.ref == 'S') {
    //                     alert(data.ref)
    //                     text: item.buyer_name + data.ref,
    //                         id: item.buyer_id + data.ref
    //                 }
    //                            else if(data.ref == 'B') {
    //         alert(data.ref)

    //         text: item.seller_name + data.ref,
    //             id: item.seller_id + data.ref
    //     }
    // };
    //                     })
    //                 };
    //             },
    // cache: true
    //         },
    //
    //     theme: 'bootstrap4',
    //         width: '100%',
    //     });


    //     //     $('.select-account').select2({
    //     //         ajax: {
    //     //             url: 'https://api.example.com/data',  // Replace with your data URL
    //     //             dataType: 'json',
    //     //             delay: 250,  // Delay in milliseconds to reduce the number of requests
    //     //             data: function (params) {
    //     //                 return {
    //     //                     q: params.term,
    //     //                     page: params.page  // Pagination parameter
    //     //                 };
    //     //             },
    //     //             processResults: function (data, params) {
    //     //                 // Parse the results into the format expected by Select2
    //     //                 params.page = params.page || 1;

    //     //                 return {
    //     //                     results: data.items,  // Array of results
    //     //                     pagination: {
    //     //                         more: data.pagination.more  // Whether there are more results available
    //     //                     }
    //     //                 };
    //     //             },
    //     //             cache: true
    //     //         },
    //     //         placeholder: 'Search for an item',
    //     //         minimumInputLength: 1,  // Minimum number of characters required to trigger the search
    //     //     });
    //     // });

    // })
    $(document).on('click', '.clear-btn', function() {
        $(this).closest('.modal').find('.select2-hidden-accessible').val(null).trigger('change');
    });
    $(document).on('shown.bs.modal', function(e) {
        $(e.target).find('input, select').filter(':visible:first').focus();
    });


    $('.main-sidebar a').attr('target', '_blank');
    $(document).ready(function() {
        $('.modal form').on('submit', function(e) {
            if ($(this).attr('method').toLowerCase() === 'get') {
                $(this).attr('target', '_blank');
            }
        });
    });

    function deleteRecord(el) {
        event.preventDefault();

        var url = el.getAttribute('data-url');

        // Create a form dynamically
        var form = document.createElement('form');
        form.action = url;
        form.method = 'POST';

        // Add CSRF token input
        var csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}'; // Add CSRF token

        // Add DELETE method input
        var methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE'; // Spoof DELETE method

        form.appendChild(csrfInput);
        form.appendChild(methodInput);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }



    function subAccountFunc(head) {
        $('.select-sub-head-account').select2({
            ajax: {
                url: '{{ route('select2.sub_head_account') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        head: head
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
        });
    }

    function accountFunc(sub_head) {
        $('.normal-accounts').addClass('d-none');
        $('.dynamic-accounts').removeClass('d-none');
        $('.select-dynamic-account').select2({
            ajax: {
                url: '{{ route('select2.dynamic_account') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        sub_head: sub_head
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
            allowClear: true,
            placeholder: '',
        });
    }


    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
</script>



@stack('s_script')
<script>
    $(document).ready(function() {
        const dateInput = $('input[name="date"]');
        if (dateInput.length) {
            dateInput.focus();
        }
    });
    $(document).on('keydown', function(e) {
        if ((e.shiftKey) && (String.fromCharCode(e.which).toLowerCase() === 'f')) {
            $("#iv-search").modal('show');
            $("#iv-search #search-input").focus();
        }
    });

    $(document).on('keydown', function(e) {
        if ((e.shiftKey) && (String.fromCharCode(e.which).toLowerCase() === 'a')) {
            $("#first_btn")[0].click();
        }
    });
    $(document).on('keydown', function(e) {
        if ((e.shiftKey) && (String.fromCharCode(e.which).toLowerCase() === 'b')) {
            $("#previous_btn")[0].click();
        }
    });
    $(document).on('keydown', function(e) {
        if ((e.shiftKey) && (String.fromCharCode(e.which).toLowerCase() === 'n')) {
            $("#next_btn")[0].click();
        }
    });
    $(document).on('keydown', function(e) {
        if ((e.shiftKey) && (String.fromCharCode(e.which).toLowerCase() === 'l')) {
            $("#last_btn")[0].click();
        }
    });
    $(document).on('keydown', function(e) {
        if ((e.shiftKey) && (String.fromCharCode(e.which).toLowerCase() === 'e')) {
            $("#edit")[0].click();
        }
    });
    $(document).on('keydown', function(e) {
        if ((e.shiftKey) && (String.fromCharCode(e.which).toLowerCase() === 'm')) {
            $("#add_more_btn")[0].click();
        }
    });
    $(document).on('keydown', function(e) {
        if ((e.shiftKey) && (String.fromCharCode(e.which).toLowerCase() === 'b')) {
            $("#previous_btn")[0].click();
        }
    });

    $('#search-btn').click(function(e) {
        e.preventDefault()
        let searchTerm = $('#search-input').val();
        let url = $(this).data('url');
        window.location.href = url + '/' + searchTerm;
    });
</script>
