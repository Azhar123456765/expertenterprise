@extends('layout.app') @section('title', 'Panel') @section('content')
<div class="container m-1">

    <h2>Edit buyer</h2>
    <div class="card-body card-block">
        <form action="{{ route('buyer.update', $buyer->buyer_id) }}" method="post"  class="needs-validation"
            novalidate>
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col">
                    <label>Customer Name</label>
                    <div class="input-group">
                        <input type="text" name="company_name" placeholde="Customer" class="form-control"
                            value="{{ $buyer->company_name }}" required>
                    </div>
                </div>
                <div class="form-group col">
                    <label>Customer Email</label>

                    <div class="input-group">
                        <input type="text" id="email2" name="company_email" placeholde="Customer Email"
                            class="form-control" value="{{ $buyer->company_email }}">
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
                            class="form-control" value="{{ $buyer->company_phone_number }}">
                        <div class="input-group-addon">

                        </div>
                    </div>
                </div>

                <div class="form-group col">
                    <label>contact person</label>

                    <div class="input-group">
                        <input type="text" name="contact_person" placeholde="contact person" class="form-control"
                            value="{{ $buyer->contact_person }}">
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
                            placeholde="contact person number" class="form-control"
                            value="{{ $buyer->contact_person_number }}">
                        <div class="input-group-addon">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label>City</label>
                    <select name="city" class="form-control select-zone">
                        <option value="{{ $buyer->zone->zone_id ?? null }}" selected>
                            {{ $buyer->zone->zone_name ?? null }}</option>
                    </select>
                </div>
                <div class="form-group col">
                    <label>buyer Type</label>
                    <select name="buyer_type" id="" style="text-transform: capitalize;" class="form-control">
                        <option value="Customer" {{ $buyer->buyer_type == 'Customer' ? 'selected' : '' }}>Customer
                        </option>
                        <option value="medical" {{ $buyer->buyer_type == 'medical' ? 'selected' : '' }}>medical</option>
                        <option value="layer farm" {{ $buyer->buyer_type == 'layer farm' ? 'selected' : '' }}>layer
                            farm
                        </option>
                        <option value="control" {{ $buyer->buyer_type == 'control' ? 'selected' : '' }}>control
                        </option>
                        <option value="farmer" {{ $buyer->buyer_type == 'farmer' ? 'selected' : '' }}>farmer</option>
                        <option value="doctor" {{ $buyer->buyer_type == 'doctor' ? 'selected' : '' }}>doctor</option>
                        <option value="vaccinator" {{ $buyer->buyer_type == 'vaccinator' ? 'selected' : '' }}>
                            vaccinator</option>
                        <option value="customer" {{ $buyer->buyer_type == 'customer' ? 'selected' : '' }}>customer
                        </option>
                        <option value="corporate" {{ $buyer->buyer_type == 'corporate' ? 'selected' : '' }}>corporate
                        </option>
                        <option value="institution" {{ $buyer->buyer_type == 'institution' ? 'selected' : '' }}>
                            institution</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label>Debit</label>
                    <div class="input-group">
                        <input type="number" step="any" name="debit" placeholde="debit" class="form-control"
                            value="{{ $buyer->debit }}">
                        <div class="input-group-addon">

                        </div>
                    </div>
                </div>

                <div class="form-group col">
                    <label>Credit</label>
                    <div class="input-group">
                        <input type="number" step="any" name="credit" placeholde="Credit" class="form-control"
                            value="{{ $buyer->credit }}">
                        <div class="input-group-addon">

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col">
                <label>Address</label>
                <div class="input-group">
                    <textarea name="address" cols="30" rows="20"
                        style="border: 0.5px solid lightgray; width: 100%; padding:3px 3px 3px 3px" placeholde="Customer Address">{{ $buyer->address }}</textarea>
                </div>
            </div>


            <div class="form-actions form-group col">
                <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
            </div>
        </form>
    </div>

</div>
@endsection
