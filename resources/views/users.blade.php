@extends('layout.app') @section('title', 'User Table') @section('content')

<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Users table</h3>
                <a href="/add-user" class="btn btn-success float-right ">
                    <i class="fa fa-plus"></i>Add User</a>
            </div>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>name</th>
                        <th>role</th>
                        <th>Access</th>
                        <th>no.records</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $serial = ($users->currentPage() - 1) * $users->perPage() + 1;
                    @endphp
                    @foreach ($users as $row)
                        <tr>
                            <td>
                                {{ $serial }}
                            </td>
                            <td>{{ $row->username }}</td>
                            <td>
                                <span class="status--process">{{ $row->role }}</span>
                            </td>
                            @if ($row->access != 'access')
                                <td>
                                    <span class="badge badge-danger">{{ $row->access }}</span>
                                </td>
                            @else
                                <td>
                                    <span class="badge badge-success">{{ $row->access }}</span>
                                </td>
                            @endif

                            <td><a href="/user-records-{{ $row->user_id }}"><span
                                        class="block-email">{{ $row->no_records }}</span></a></td>
                            <td>{{ $row->created_at }}</td>

                            <td>
                                <div class="table-data-feature">

                                    <a href="/edit-user-{{ $row->user_id }}" class="item" data-bs-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="/user-rights-{{ $row->user_id }}" class="item" data-bs-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Manage rights">
                                        <i class="fa fa-universal-access"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
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

@endsection
