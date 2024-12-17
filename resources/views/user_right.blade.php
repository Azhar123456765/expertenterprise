@extends('layout.app')  @section('title','User Rights')  @section('content')
<style>
    @media (max-width:755px) {
        .container {
            width: 100% !important;
        }
    }
</style>
<br><br><br>
<div class="container" style="width: 50%;">
    <h3>Manage Right</h3>
    <div class="card-body card-block">
        @foreach ($user as $row)
        <form action="/user_right_form-{{$row->user_id}}" method="post">
            @csrf



            <h4>Permissions</h4>
            <br>
            <div class="row">


                <div class="form-group col-md-6">
                    <label>Setup</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="setup_permission" id="readPermission" {{$row->setup_permission == 'on' ? 'checked' : ''}}>

                                <label class="form-check-label my-3" for="readPermission">
                                    Access
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>Finance</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="finance_permission" id="readPermission" {{$row->finance_permission == 'on' ? 'checked' : ''}}>
                                <label class="form-check-label my-3" for="readPermission">
                                    Access
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>Products</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="product_permission" id="readPermission" {{$row->product_permission == 'on' ? 'checked' : ''}}>
                                <label class="form-check-label my-3" for="readPermission">
                                    Access
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>Reports</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="report_permission" id="readPermission" {{$row->report_permission == 'on' ? 'checked' : ''}}>
                                <label class="form-check-label my-3" for="readPermission">
                                    Access
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Select Data</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="select_permission" id="select_permission" {{$row->select_permission == 'on' ? 'checked' : ''}}>
                                <label class="form-check-label my-3" for="readPermission">
                                    Access
                                </label>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <input type="hidden" name="user_id" value="{{$row->user_id}}">



            <div class="form-group" required>
                <label>Manage Access</label>
                <select class="form-control" name="access" id="">
                    <option <?php if ($row->access == 'access') {
                                echo 'selected';
                            }    ?> value="access">Access</option>
                    <option <?php if ($row->access == 'denied') {
                                echo 'selected';
                            }    ?> value="denied">Denied</option>

                </select>
            </div>

            <div class="form-group" required>
                <label>Select Role</label>
                <select class="form-control" name="role" id="">
                    <option <?php if ($row->role == 'admin') {
                                echo 'selected';
                            }    ?> value="admin">admin</option>
                    <option <?php if ($row->role == 'user') {
                                echo 'selected';
                            }    ?> value="user">user</option>

                </select>
            </div>

            @error('username')

            <div class="alert alert-danger" role="alert">
                {{$message}}



            </div>
            @enderror

            @error('email')

            <div class="alert alert-danger" role="alert">
                {{$message}}



            </div>
            @enderror


            @error('phone_number')

            <div class="alert alert-danger" role="alert">
                {{$message}}



            </div>
            @enderror

            @endforeach

            <div class="form-actions form-group">
                <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
            </div>
        </form>
    </div>

</div>
@endsection