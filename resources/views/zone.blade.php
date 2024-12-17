@extends('layout.app') @section('title', 'Zone Table') @section('content')

<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Zone table</h3>
                <a href="" data-bs-toggle="modal" data-bs-target="#add-modal" class="btn btn-success float-right">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp; Add Zone</a>
            </div>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>

                        <th>S.NO</th>
                        <th>Zone Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $serial = 1;
                    @endphp
                    @foreach ($users as $row)
                        <tr class="tr-shadow">
                            <td>{{ $serial }}</td>
                            <td>{{ $row->zone_name }}</td>
                            <td>{{ $row->created_at }}</td>
                            <td>{{ $row->updated_at }}</td>
                            <td>
                                <div class="table-data-feature">
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#edit_modal{{ $row->zone_id }}" class="item"
                                        data-bs-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    {{-- <a href="/zone_delete{{ $row->zone_id }}" class="item" data-bs-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a> --}}
                                    <!-- <a href="/del_user/{{ $row->user_id }}" class="item" data-bs-toggle="tooltip" data-placement="top" title="Delete User">
                                            <i class="fa fa-trash"></i>
                                        </a> -->
                                </div>
                            </td>
                        </tr>
                        <!-- <tr class="spacer"></tr> -->
                        @php
                            $serial++;
                        @endphp
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>



<div class="modal fade" id="add-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4>Add zone</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/add_zone" class="needs-validation"
                    novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="username">Zone Name</label>
                            <input type="text" class="form-control " id="zone" name="zone_name"
                                placeholder="zone" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>




@foreach ($users as $row)
    <div class="modal fade" id="edit_modal{{ $row->zone_id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                        <h4>Edit zone</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="/edit_zone{{ $row->zone_id }}" class="needs-validation"
                            novalidate>
                            @csrf
                            <div class="form-group">
                                <label for="username">Zone Name</label>
                                <input type="text" class="form-control " id="zone" name="zone_name"
                                    placeholder="zone" required value="{{ $row->zone_name }}">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="btn">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endforeach

@endsection
