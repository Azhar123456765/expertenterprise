@extends('layout.app') @section('title', 'Edit User') @section('content')


<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
        </div>
        <div class="card-body card-block">


            @foreach ($user as $row)
                <form action="/edit_user_form-{{ $row->user_id }}" method="post" class="needs-validation" novalidate>


                    @csrf

                    <div class="form-group">
                        <label>Username</label>
                        <div class="input-group">
                            <input type="text" id="username2" name="username" placeholder="Username"
                                class="form-control" required value="{{ $row->username }}">
                            <div class="input-group-addon">
                                <i class=" -user"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>email</label>
                        <div class="input-group">
                            <input type="email" validate="email" id="email2" name="email" placeholder="Email"
                                class="form-control" value="{{ $row->email }}">
                            <div class="input-group-addon">
                                <i class=" -envelope"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <div class="input-group">
                            <input type="number" step="any" id="" name="phone_number"
                                placeholder="phone number" class="form-control" 
                                value="{{ $row->phone_number }}">
                            <div class="input-group-addon">
                                <i class=" -asterisk"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>

                        <div class="input-group">
                            <input type="text" id="password2" name="password" placeholder="Add New Password"
                                class="form-control">
                            <div class="input-group-addon">
                                <i class=" -asterisk"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Select Role</label>
                        <select class="form-control" name="role" id="" required>
                            <option value="admin" {{ $row->role == 'admin' ? 'selected' : '' }}>admin</option>
                            <option value="user" {{ $row->role == 'user' ? 'selected' : '' }}>user</option>
                            <option value="farm_user" {{ $row->role == 'farm_user' ? 'selected' : '' }}>farm user
                            </option>
                        </select>
                    </div>

                    <input type="hidden" name="user_id" value="{{ $row->user_id }}">

                    <br>


                    <div class="form-actions form-group">
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </div>
            @endforeach
            </form>
        </div>

    </div>
</div>
@endsection
