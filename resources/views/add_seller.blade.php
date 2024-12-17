@extends('layout.app')  @section('title','Panel')  @section('content')


<br><br><br>
<div class="container" style="width: 39%; margin-top:5%;">
    <h3>Add seller</h3>
    <div class="card-body card-block">
        <form action="add_seller_form" method="post">
            @csrf
            <div class="form-group">
                <div class="input-group">
                    <input type="text" id="username2" name="company_name" placeholder="Company" class="form-control" required>
                    <div class="input-group-addon">
                        <i class="fa fa-building"></i>
                    </div>
                </div>
            </div>



            <div class="form-group">
                <div class="input-group">
                    <input type="email" validate="email" id="email2" name="company_email" placeholder="Company Email" class="form-control">
                    <div class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input type="text" id="username2" name="contact_person" placeholder="contact person" class="form-control">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input type="text" id="email2" name="contact_person_number" placeholder="contact person number" class="form-control">
                    <div class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="input-group">
                    <input type="text" id="username2" name="city" placeholder="city" class="form-control">
                    <div class="input-group-addon">
                        <i class="fa fa-building"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
            <label>Seller Type</label>
            <select name="seller_type" id="" style="text-transform: capitalize;" class="form-control">
                <option value="supplier">supplier</option>
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
            
            <div class="form-group">
            <label>Debit</label>
                <div class="input-group">
                    <input type="number" step="any" id="username2" name="debit" placeholder="debit" class="form-control" value="0.00">
                    <div class="input-group-addon">
                        <i class="fa fa-building"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
            <label>Credit</label>
                <div class="input-group">
                    <input type="number" step="any" id="username2" name="credit" placeholder="Credit" class="form-control" value="0.00">
                    <div class="input-group-addon">
                        <i class="fa fa-building"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Address</label>
                <div class="input-group">
                    <textarea name="address" id="" cols="30" rows="10" style="border: 0.5px solid lightgray; width: 100%; padding:3px 3px 3px 3px" placeholder="Company Address"></textarea>

                </div>
            </div>






            @error('company_name')

            <div class="alert alert-danger" role="alert">
                {{$message}}



            </div>
            @enderror

            @error('company_email')

            <div class="alert alert-danger" role="alert">
                {{$message}}



            </div>
            @enderror




            <div class="form-actions form-group">
                <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
            </div>
        </form>
    </div>

</div>
@endsection