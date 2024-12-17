@extends('layout.app')  @section('title','Add User')  @section('content')
<style>
    @media (max-width:755px) {
        .container {
            width: 100% !important;
        }
    }
</style>
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add User</h3>
        </div>
        <div class="card-body card-block">
            <form action="add_user_form" method="post" class="needs-validation" novalidate>
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-group">
                        <input type="text" id="username2" name="username" placeholder="Username" class="form-control" required>
                        <div class="input-group-addon">
                            <i class=" -user"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <input type="email" validate="email" id="email2" name="email" placeholder="Email" class="form-control">
                        <div class="input-group-addon">
                            <i class=" -envelope"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>phone number</label>
                    <div class="input-group">
                        <input type="number" step="any" id="" name="phone_number" placeholder="phone number" class="form-control">
                        <div class="input-group-addon">
                            <i class=" -phone"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" id="password2" name="password" placeholder="Password" class="form-control" required>
                        <div class="input-group-addon">
                            <i class=" -asterisk"></i>
                        </div>
                    </div>
                </div>

                <div class="form-group" required>
                    <label>Select Role</label>
                    <select class="form-control" name="role" id="">
                        <option value="admin">admin</option>
                        <option value="user">user</option>
                        <option value="farm_user">farm user</option>

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

                <div class="form-actions form-group">
                    <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                </div>
            </form>
        </div>

    </div>
    </div>
    @endsection