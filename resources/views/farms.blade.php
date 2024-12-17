@extends('layout.app') @section('title', 'farm Table') @section('content')

<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">farm Table</h3>
            <a href="" data-bs-toggle="modal" data-bs-target="#add-modal" class="btn btn-success float-right">
                <i class="fa fa-plus"></i>&nbsp;&nbsp; Add farm</a>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>

                        <th>S.NO</th>
                        <th>farm Name</th>
                        <th>Assigned User</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $serial = 1;
                    @endphp
                    @foreach ($farms as $row)
                        <tr class="tr-shadow">
                            <td>{{ $serial }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->user->username }}</td>
                            <td>{{ $row->created_at }}</td>
                            <td>{{ $row->updated_at }}</td>
                            <td>
                                <div class="table-data-feature">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit_modal{{ $row->id }}"
                                        class="item" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-url="{{ route('farm.destroy', $row->id) }}"
                                        onclick="deleteRecord(this);" class="item" data-bs-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
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


</div>



<div class="modal fade" id="add-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Add farm</h4>
                <div class="modal-body">
                    <form method="POST" action="{{ route('farm.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="username">farm Name</label>
                            <input type="text" class="form-control " id="name" name="name" placeholder="farm"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="username">Assigned User</label>
                            <select name="user" class="form-control" required>
                                <option disabled selected>Assign A User</option>
                                @foreach ($users as $row)
                                    <option value="{{ $row->user_id }}">{{ $row->username }}</option>
                                @endforeach
                            </select>
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
@foreach ($farms as $row)
    <div class="modal fade" id="edit_modal{{ $row->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4>Edit farm</h4>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('farm.update', $row->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="username">farm Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Category" required value="{{ $row->name }}">
                            </div>
                            <div class="form-group">
                                <label for="username">Assigned User</label>
                                <select name="user" class="form-control" required>
                                    <option disabled selected>Assign A User</option>
                                    @foreach ($users as $userRow)
                                        <option value="{{ $userRow->user_id }}"
                                            {{ $row->user_id === $userRow->user_id ? 'selected' : '' }}>
                                            {{ $userRow->username }}</option>
                                    @endforeach
                                </select>
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
