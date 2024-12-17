@extends('layout.app') @section('title', 'Customers') @section('content')

<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Customer table</h3>
                <a href="{{ url('add-buyer') }}" class="btn btn-success float-right">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp; Add Customer</a>
            </div>
        </div>

        <div class="card-body">
            <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>

                        <th>S.NO</th>
                        <th>Customer name</th>
                        <th>Contact Person</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>no.records</th>
                        <th>Customer Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
        </div>
    </div>
</div>


</div>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        var elements = document.getElementsByTagName("INPUT");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("This field cannot be left blank");
                }
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
    })
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<!-- <script>
    $(function() {
        $("input,textarea,select").not("[type=submit]").jqbootstrapValidation();
    });
    $("#searchBtn").on('click', function() {

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        var searchQuery = $('#searchData').val();
        $.ajax({
            url: window.location.href,
            type: 'get',
            data: {
                "search": searchQuery
            },
            beforeSend: function() {},
            success: function(data) {
                $('tbody tr').hide();
                $('tbody').append(data.view);
            }
        });
    })

    $(document).ready(function() {

        let nextPageUrl = '{{ $buyer->nextPageUrl() }}';

        var prevScrollPos = $(window).scrollTop();

        $(window).scroll(function() {
            var currentScrollPos = $(window).scrollTop();
            var searchQuery = $('#searchData').val();

            if (currentScrollPos > prevScrollPos && // Check for scrolling down
                $(window).scrollTop() + $(window).height() >= $(document).height()) {
                if (nextPageUrl) {
                    loadMorePosts();
                }
            }

            prevScrollPos = currentScrollPos;
        });


        function loadMorePosts() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                url: nextPageUrl,
                type: 'get',
                data: {
                    "serial": serial
                },
                beforeSend: function() {
                    nextPageUrl = ''
                },
                success: function(data) {
                    if ($('#searchData').val() == '') {
                        nextPageUrl = data.nextPageUrl;
                        $('tbody').append(data.view);
                    }
                }
            })
        }
    });
</script> -->

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            ajax: '/data-buyers',
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<a href="" data-bs-toggle="modal" data-bs-target="#view_modal${row.buyer_id}"> <span id="company_name" class="block-email">${row.company_name}</span></a>`;
                    }
                },
                {
                    data: 'contact_person',
                    name: 'amount_total'
                },

                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span id="debit" class="status--process">${row.debit}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<span id="credit" class="status--process" style="color: red;">${row.credit}</span>`;
                    }
                },

                {
                    data: 'total_records',
                    name: 'amount_total'
                },
                {
                    data: 'buyer_type',
                    name: 'due_date'
                },

                {
                    data: null,
                    render: function(data, type, row) {
                        return `
    <div class="table-data-feature">

<a href="/edit-buyer/${row.buyer_id}" class="item" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
    <i class="fa fa-edit"></i>
</a>
<a href="/view-buyer/${row.buyer_id}" class="item" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="View">
    <i class="fa fa-light fa-eye"></i>
</a>

</div>

    `;
                    }

                },
            ]
        });
    });
</script>
{{-- <div class="modal fade" id="add-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Add Customer</h4>
                <div class="modal-body">
                    <form action="add_buyer_form" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col col">
                                <div class="input-group">
                                    <input type="text" id="username2" name="company_name" placeholder="Customer"
                                        class="form-control" oninvalid="this.setCustomValidity('Enter User Name Here')"
                                        required data-validation-required-message="Please enter your organization name">
                                    <p class="help-block"></p>

                                    <div class="input-group-addon">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group col col">
                                <div class="input-group">
                                    <input type="text" id="email2" name="company_email"
                                        placeholder="Customer Email" class="form-control">
                                    <div class="input-group-addon">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col col">
                                <div class="input-group">
                                    <input type="text" name="company_phone_number"
                                        placeholder="Customer Phone Number" class="form-control">
                                    <div class="input-group-addon">

                                    </div>
                                </div>
                            </div>

                            <div class="form-group col col">
                                <div class="input-group">
                                    <input type="text" id="username2" name="contact_person"
                                        placeholder="contact person" class="form-control">
                                    <div class="input-group-addon">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col col">
                                <div class="input-group">
                                    <input type="text" id="email2" name="contact_person_number"
                                        placeholder="contact person number" class="form-control">
                                    <div class="input-group-addon">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>City</label>
                                <select name="city" id="" style="text-transform: capitalize;"
                                    class="form-control">
                                    <option value=""></option>
                                    @foreach ($zone as $row)
                                        <option value="{{ $row->zone_id }}">{{ $row->zone_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col">
                                <label>buyer Type</label>
                                <select name="buyer_type" id="" style="text-transform: capitalize;"
                                    class="form-control ">
                                    <option value="Customer">Customer</option>
                                    <option value="medical">medical</option>
                                    <option value="layer farm">layer farm</option>
                                    <option value="control">control</option>
                                    <option value="farmer">farmer</option>
                                    <option value="doctor">doctor</option>
                                    <option value="vaccinator">vaccinator</option>
                                    <option value="customer">customer</option>
                                    <option value="corporate">corporate</option>
                                    <option value="institution">institution</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Debit</label>
                                <div class="input-group">
                                    <input type="number" step="any" id="username2" name="debit"
                                        placeholder="debit" class="form-control " value="0.00">
                                    <div class="input-group-addon">

                                    </div>
                                </div>
                            </div>

                            <div class="form-group col">
                                <label>Credit</label>
                                <div class="input-group">
                                    <input type="number" step="any" id="username2" name="credit"
                                        placeholder="Credit" class="form-control " value="0.00">
                                    <div class="input-group-addon">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col">
                            <label>Address</label>
                            <div class="input-group">
                                <textarea name="address" cols="30" rows="20"
                                    style="border: 0.5px solid lightgray; width: 100%; padding:3px 3px 3px 3px" placeholder="Customer Address"></textarea>
                            </div>
                        </div>






                        @error('company_name')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}



                            </div>
                        @enderror

                        @error('company_email')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}



                            </div>
                        @enderror




                        <div class="form-actions form-group col">
                            <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div> --}}












{{-- 
<div class="modal fade" id="edit_modal${row.buyer_id}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Edit Customer</h4>
                <div class="modal-body">
                    <form action="edit_buyer_form" method="post">

                        @csrf
                        <div class="row">
                            <div class="form-group col">
                                <label>Customer</label>
                                <div class="input-group">
                                    <input type="text" id="username2" name="company_name" placeholder="Customer" class="form-control " value="${row.company_name}" required>
                                    <div class="input-group-addon">

                                    </div>
                                </div>
                            </div>



                            <div class="form-group col">
                                <label>Customer Email</label>
                                <div class="input-group">
                                    <input type="text"  id="email2" name="company_email" placeholder="Customer Email" class="form-control " value="${row.company_email}">
                                    <div class="input-group-addon">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Customer Phone Number</label>
                                <div class="input-group">
                                    <input type="text" id="email2" name="company_phone_number" class="form-control " value="${row.company_phone_number}">
                                    <div class="input-group-addon">

                                    </div>
                                </div>
                            </div>

                            <div class="form-group col">
                                <label>contact person</label>
                                <div class="input-group">
                                    <input type="text" id="username2" name="contact_person" placeholder="contact person" class="form-control " value="${row.contact_person}">
                                    <div class="input-group-addon">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>contact person number</label>
                                <div class="input-group">
                                    <input type="text" id="email2" name="contact_person_number" placeholder="contact person number" class="form-control " value="${row.contact_person_number}">
                                    <div class="input-group-addon">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>City</label>
                                <select name="city" id="" style="text-transform: capitalize;" class="form-control ">
                                    <option value=""></option>
                                    @foreach ($zone as $row2)
                                    <option value="{{ $row2->zone_id }}" {{ $row2->zone_id == ($row2->customer->city ?? '') ? 'selected' : '' }}>{{ $row2->zone_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col">
    <label for="buyer_type">Buyer Type</label>
    <select name="buyer_type" id="buyer_type" class="form-control" style="text-transform: capitalize;">
        <option value="Customer" ${ row.buyer_type == 'Customer' ? 'selected' : '' }>Customer</option>
        <option value="medical" ${ row.buyer_type == 'medical' ? 'selected' : '' }>Medical</option>
        <option value="layer farm" ${ row.buyer_type == 'layer farm' ? 'selected' : '' }>Layer Farm</option>
        <option value="control" ${ row.buyer_type == 'control' ? 'selected' : '' }>Control</option>
        <option value="farmer" ${ row.buyer_type == 'farmer' ? 'selected' : '' }>Farmer</option>
        <option value="doctor" ${ row.buyer_type == 'doctor' ? 'selected' : '' }>Doctor</option>
        <option value="vaccinator" ${ row.buyer_type == 'vaccinator' ? 'selected' : '' }>Vaccinator</option>
        <option value="customer" ${ row.buyer_type == 'customer' ? 'selected' : '' }>Customer</option>
        <option value="corporate" ${ row.buyer_type == 'corporate' ? 'selected' : '' }>Corporate</option>
        <option value="institution" ${ row.buyer_type == 'institution' ? 'selected' : '' }>Institution</option>
    </select>
</div>

                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Debit</label>
                                <div class="input-group">
                                    <input type="number" step="any" id="username2" name="debit" placeholder="debit" class="form-control " value="${row.debit}">
                                    <div class="input-group-addon">

                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="${row.buyer_id}">
                            <div class="form-group col">
                                <label>Credit</label>
                                <div class="input-group">
                                    <input type="number" step="any" id="username2" name="credit" placeholder="Credit" class="form-control " value="${row.credit}">
                                    <div class="input-group-addon">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col">
                            <label>Address</label>
                            <div class="input-group">
                                <textarea name="address" class="form-control" cols="30" rows="10" style="border: 0.5px solid lightgray; width: 100%; padding:3px 3px 3px 3px" placeholder="Customer Address">${row.address}</textarea>

                            </div>
                        </div>






                        @error('company_name')

                        <div class="alert alert-danger" role="alert">
                            {{ $message }}



                        </div>
                        @enderror

                        @error('company_email')

                        <div class="alert alert-danger" role="alert">
                            {{ $message }}



                        </div>
                        @enderror



                        <div class="form-actions form-group col">
                            <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="view_modal${row.buyer_id}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>View Customer</h4>
                <div class="modal-body">
                    <form action="edit_buyer_form" method="post">


                        @csrf
                        <div class="form-group col">
                            <label>Customer</label>
                            <div class="input-group">
                                <p type="text" id="username2" name="company_name" placeholder="Customer" class="form-control " value="" required>
                                    ${row.company_name}
                                </p>
                                <div class="input-group-addon">

                                </div>
                            </div>
                        </div>



                        <div class="form-group col">
                            <label>Customer Email</label>

                            <div class="input-group">
                                <p type="text"  id="email2" name="company_email" placeholder="Customer Email" class="form-control " value="${row.company_email}">
                                    ${row.company_email}
                                </p>
                                <div class="input-group-addon">

                                </div>
                            </div>
                        </div>

                        <div class="form-group col">
                            <label>Customer Phone Number</label>
                            <div class="input-group">
                                <p type="text"  id="email2" name="company_phone_number" placeholder="Customer Email" class="form-control " value="${row.company_email}">
                                    ${row.company_phone_number}
                                </p>
                                <div class="input-group-addon">

                                </div>
                            </div>
                        </div>

                        <div class="form-group col">
                            <label>contact person</label>

                            <div class="input-group">
                                <p type="text" id="username2" name="contact_person" placeholder="contact person" class="form-control " value="${row.contact_person}">
                                    ${row.contact_person}
                                </p>
                                <div class="input-group-addon">

                                </div>
                            </div>
                        </div>

                        <div class="form-group col">
                            <label>contact person number</label>

                            <div class="input-group">
                                <p type="text"  id="email2" name="contact_person_number" placeholder="contact person number" class="form-control " value="${row.contact_person_number}">
                                    ${row.contact_person_number}
                                </p>
                                <div class="input-group-addon">

                                </div>
                            </div>
                        </div>


                        <div class="form-group col">
                            <label>City</label>
                            <select name="city" id="" style="text-transform: capitalize;" class="form-control ">
                                <option value=""></option>
                                @foreach ($zone as $row2)
                                <option value="{{ $row2->zone_id }}" {{ $row2->zone_id == ($row2->customer->city ?? '') ? 'selected' : '' }}>{{ $row2->zone_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col">
    <label for="buyer_type">Buyer Type</label>
    <select name="buyer_type" id="buyer_type" class="form-control" style="text-transform: capitalize;">
        <option value="Customer" ${ row.buyer_type == 'Customer' ? 'selected' : '' }>Customer</option>
        <option value="medical" ${ row.buyer_type == 'medical' ? 'selected' : '' }>Medical</option>
        <option value="layer farm" ${ row.buyer_type == 'layer farm' ? 'selected' : '' }>Layer Farm</option>
        <option value="control" ${ row.buyer_type == 'control' ? 'selected' : '' }>Control</option>
        <option value="farmer" ${ row.buyer_type == 'farmer' ? 'selected' : '' }>Farmer</option>
        <option value="doctor" ${ row.buyer_type == 'doctor' ? 'selected' : '' }>Doctor</option>
        <option value="vaccinator" ${ row.buyer_type == 'vaccinator' ? 'selected' : '' }>Vaccinator</option>
        <option value="customer" ${ row.buyer_type == 'customer' ? 'selected' : '' }>Customer</option>
        <option value="corporate" ${ row.buyer_type == 'corporate' ? 'selected' : '' }>Corporate</option>
        <option value="institution" ${ row.buyer_type == 'institution' ? 'selected' : '' }>Institution</option>
    </select>
</div>


                        <div class="form-group col">
                            <label>Debit</label>
                            <div class="input-group">
                                <p type="number" step="any" id="username2" name="debit" placeholder="debit" class="form-control " value="${row.debit}" value="0.00">
                                    ${row.debit}
                                </p>
                                <div class="input-group-addon">

                                </div>
                            </div>
                        </div>







                        <div class="form-group col">
                            <label>Credit</label>
                            <div class="input-group">
                                <p type="number" step="any" id="username2" name="credit" placeholder="Credit" class="form-control " value="0.00">
                                    ${row.credit}
                                </p>
                                <div class="input-group-addon">

                                </div>
                            </div>
                        </div>

                        <div class="form-group col">
                            <label>Address</label>
                            <div class="input-group">
                                <textarea readonly name="address" id="" cols="30" rows="10" style="border: 0.5px solid lightgray; width: 100%; padding:3px 3px 3px 3px" placeholder="Customer Address">${row.address}</textarea>

                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div> --}}
@endsection
