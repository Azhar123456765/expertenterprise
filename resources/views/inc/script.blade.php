<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>

<script src="{{ asset('../../plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('../../plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('../../plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('../../plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('../../plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script src="{{ asset('../../dist/js/adminlte.min2167.js?v=3.2.0') }}"></script>

<script src="{{ asset('../../dist/js/demo.js') }}"></script>
<!-- Include Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="validate/validin.js"></script>


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
</script>





<script src="../../plugins/summernote/summernote-bs4.min.js"></script>


<script>
    $(function() {
        //Add text editor
        $(".textarea").summernote();
    });
</script>



<script>
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
</script>

<script>
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
</script>




<style>
    /* styles.css */
    .loader-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }

    .loader {
        border: 4px solid #f3f3f3;
        border-top: 4px solid green;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

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
            timer: 3000
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
            timer: 3000 // Automatically close after 3 seconds
        });
    </script>
@endif
<!--
@if (session()->get('not_found'))
<script>
    Swal.fire({
        icon: 'succes',
        title: "{{ session()->get('not_found') }}",
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000 // Automatically close after 3 seconds
    });
</script>
@endif -->

@if ($errors->all() != null)
    <script>
        Swal.fire({
            icon: 'warning',
            @foreach ($errors->all() as $error)
                title: "{{ $error }}",
            @endforeach
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000 // Automatically close after 3 seconds
        });
    </script>
@endif

<script>
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
</script>



@stack('s_script')

<script>
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

    $(document).on('keydown', function(e) {
        if ((e.shiftKey) && (String.fromCharCode(e.which).toLowerCase() === 'f')) {
            $("#iv-search").modal('show');
            $("#iv-search #search-input").focus();
        }
    });
    $('#search-btn').click(function() {
        let searchTerm = $('#search-input').val();
        let url = $(this).data('url');
        window.location.href = url + '/' + searchTerm;
    })

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
</script>
