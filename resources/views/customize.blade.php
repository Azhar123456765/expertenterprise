@extends('layout.app') @section('title', 'Organization') @section('content')

<style>
    @media (max-width: 755px) {

        .container {
            width: 100% !important;

        }

        body {
            font-family: sans-serif;
            background-color: #eeeeee;
        }

    }
</style>
<div class="container">

    <form action="/organization" method="POST" enctype="multipart/form-data" class="needs-validation"
        novalidate>
        <div class="row flex-column">
            @csrf
            @foreach ($organization as $row)
                <div class="form-group col-md-12">
                    <label>Organization Name</label>
                    <input type="text" name="name" id="company" class="form-control"
                        value="{{ $row->organization_name }}" placeholder="" aria-describedby="helpId" required>
                </div>

                <div class="form-group  col-md-12">
                    <label>Organization address</label>
                    <br>
                    <textarea name="address" class="form-control" id="" cols="78" rows="3"
                        style="border: 1px solid lightgray; width: 100%;" required>{{ $row->address }}</textarea>
                </div>
                <div class="form-group col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Phone Number</label>
                            <input type="number" step="any" name="phone_number" class="form-control"
                                value="{{ $row->phone_number }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Email address</label>
                            <input required type="email" name="email" class="form-control" placeholder=""
                                aria-describedby="helpId" value="{{ $row->email }}" required>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="file-upload">
                        <button class="file-upload-btn" type="button"
                            onclick="$('.file-upload-input').trigger( 'click' )">Add Organization Logo</button>

                        <div class="image-upload-wrap" style="display: none;">
                            <input class="file-upload-input" name="logo" type='file' onchange="readURL(this);"
                                accept="image/*" />
                            <input name="old_logo" type='hidden' value="{{ $row->logo }}" />
                            <div class="drag-text">
                                <h3>Drag and drop a file or select add Image</h3>
                            </div>
                        </div>
                        <div class="file-upload-content" style="display: block;">
                            <img class="file-upload-image" src="{{ $row->logo ?? '#' }}" alt="your image" />
                            <div class="image-title-wrap">
                                <button type="button" onclick="removeUpload()" class="remove-image">Remove <span
                                        class="image-title">Uploaded </span></button>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>
        <div class="col-md-12 d-flex justify-content-center">
            <button type="submit" class="btn btn-success btn-md w-50">
                Submit
            </button>
        </div>
    </form>

</div>

@endsection
