@extends('layout.app')  @section('title','Panel')  @section('content')


<br><br><br>
<div class="container" style="width: 39%; margin-top:5%;">
    <h3>Edit seller</h3>
    <div class="card-body card-block">
        <form action="edit_seller_form" method="post">
            @foreach ($seller as $row)


            @csrf
            <div class="form-group">
            <label>Company</label>
                <div class="input-group">
                    <p type="text" id="username2" name="company_name" placeholder="Company" class="form-control " value="" required>
           {{$row->company_name}}                  </p>                                        <div class="input-group-addon">
                        <i class="fa fa-building"></i>
                    </div>
                </div>
            </div>



            <div class="form-group">
            <label>Company Email</label>

                <div class="input-group">
                    <p type="email" validate="email" id="email2" name="company_email" placeholder="Company Email" class="form-control " value="{{$row->company_email}}">
           {{$row->company_email}}                  </p>                                        <div class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
            <label>contact person</label>

                <div class="input-group">
                    <p type="text" id="username2" name="contact_person" placeholder="contact person" class="form-control " value="{{$row->contact_person}}">
           {{$row->contact_person}}                  </p>                                        <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
            <label>contact person number</label>

                <div class="input-group">
                    <p type="email" validate="email" id="email2" name="contact_person_number" placeholder="contact person number" class="form-control " value="{{$row->contact_person_number}}">
           {{$row->contact_person_number}}                  </p>                                        <div class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </div>
                </div>
            </div>


            <div class="form-group">
            <label>City</label>

                <div class="input-group">
                    <p type="text" id="username2" name="city" placeholder="city" class="form-control " value="{{$row->city}}">
           {{$row->city}}                  </p>                                        <div class="input-group-addon">
                        <i class="fa fa-building"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Seller Type</label>
                <select name="seller_type" id="" style="text-transform: capitalize;" class="form-control " value="{{$row->company_name}}">
                    <option <?php  if($row->seller_type == 'supplier'){ echo "selected"; }  ?> value="supplier">supplier</option>
                    <option <?php  if($row->seller_type == 'medical'){ echo "selected"; }  ?> value="medical">medical</option>
                    <option <?php  if($row->seller_type == 'layer farm'){ echo "selected"; }  ?> value="layer farm">layer farm</option>
                    <option <?php  if($row->seller_type == 'control'){ echo "selected"; }  ?> value="control">control</option>
                    <option <?php  if($row->seller_type == 'farmer'){ echo "selected"; }  ?> value="farmer">farmer</option>
                    <option <?php  if($row->seller_type == 'doctor'){ echo "selected"; }  ?> value="doctor">doctor</option>
                    <option <?php  if($row->seller_type == 'vaccinator'){ echo "selected"; }  ?> value="vaccinator">vaccinator</option>
                    <option <?php  if($row->seller_type == 'customer'){ echo "selected"; }  ?> value="customer">customer</option>
                    <option <?php  if($row->seller_type == 'corporate'){ echo "selected"; }  ?> value="corporate">corporate</option>
                    <option <?php  if($row->seller_type == 'institution'){ echo "selected"; }  ?> value="institution">institution</option>
                </select>


            </div>

            <div class="form-group">
                <label>Debit</label>
                <div class="input-group">
                    <p type="number" step="any" id="username2" name="debit" placeholder="debit" class="form-control " value="{{$row->debit}}" value="0.00">
           {{$row->debit}}                  </p>                                        <div class="input-group-addon">
                        <i class="fa fa-building"></i>
                    </div>
                </div>
            </div>







            <div class="form-group">
                <label>Credit</label>
                <div class="input-group">
                    <p type="number" step="any" id="username2" name="credit" placeholder="Credit" class="form-control " value="0.00">
           {{$row->credit}}                  </p>                                   
                <div class="input-group-addon">
                        <i class="fa fa-building"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Address</label>
                <div class="input-group">
                    <textarea readonly name="address" id="" cols="30" rows="10" style="border: 0.5px solid lightgray; width: 100%; padding:3px 3px 3px 3px" placeholder="Company Address">{{$row->address}}</textarea>

                </div>
            </div>


@endforeach
        </form>
    </div>

</div>
@endsection