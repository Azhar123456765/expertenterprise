@extends('layout.app') @section('title', 'Panel') @section('content')
<div class="container m-1">

    <h2>Add buyer</h2>
    <div class="card-body card-block">
        <form action="add_buyer_form" method="post"  class="needs-validation"
        novalidate>
            @csrf
            <div class="row">
                <div class="form-group col">
                    <label>Customer Name</label>
                    <div class="input-group">
                        <input type="text" id="username2" name="company_name" placeholde="Customer"
                            class="form-control" required>
                    </div>
                </div>
                <div class="form-group col">
                    <label>Customer Email</label>

                    <div class="input-group">
                        <input type="text" id="email2" name="company_email" placeholde="Customer Email"
                            class="form-control">
                        <div class="input-group-addon">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label>Customer Phone Number</label>

                    <div class="input-group">
                        <input type="text" name="company_phone_number" placeholde="Customer Phone Number"
                            class="form-control">
                        <div class="input-group-addon">

                        </div>
                    </div>
                </div>

                <div class="form-group col">
                    <label>contact person</label>

                    <div class="input-group">
                        <input type="text" id="username2" name="contact_person" placeholde="contact person"
                            class="form-control">
                        <div class="input-group-addon">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label>contact person number</label>

                    <div class="input-group">
                        <input type="text" id="email2" name="contact_person_number"
                            placeholde="contact person number" class="form-control">
                        <div class="input-group-addon">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label>City</label>
                    <select name="city" class="form-control select-zone">
                        <option value=""></option>
                    </select>
                </div>
                <div class="form-group col">
                    <label>buyer Type</label>
                    <select name="buyer_type" id="" style="text-transform: capitalize;" class="form-control ">
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
                        <input type="number" step="any" id="username2" name="debit" placeholde="debit"
                            class="form-control " value="0.00">
                        <div class="input-group-addon">

                        </div>
                    </div>
                </div>

                <div class="form-group col">
                    <label>Credit</label>
                    <div class="input-group">
                        <input type="number" step="any" id="username2" name="credit" placeholde="Credit"
                            class="form-control " value="0.00">
                        <div class="input-group-addon">

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col">
                <label>Address</label>
                <div class="input-group">
                    <textarea name="address" cols="30" rows="20"
                        style="border: 0.5px solid lightgray; width: 100%; padding:3px 3px 3px 3px" placeholde="Customer Address"></textarea>
                </div>
            </div>


            <div class="form-actions form-group col">
                <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
            </div>
        </form>
    </div>

</div>
@endsection
