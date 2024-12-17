@extends('layout.app') @section('title', 'farming period Table') @section('content')

<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">farming period Table</h3>
            <a href="" data-bs-toggle="modal" data-bs-target="#add-modal" class="btn btn-success float-right">
                <i class="fa fa-plus"></i>&nbsp;&nbsp; Add farming period</a>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>

                        <th>S.NO</th>
                        <th>Farm</th>
                        <th>Assigned User</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $serial = 1;
                    @endphp
                    @foreach ($farming_pr as $row)
                        <tr class="tr-shadow">
                            <td>{{ $serial }}</td>
                            <td>{{ $row->farm->name }}</td>
                            <td>{{ $row->user->username }}</td>
                            <td>{{ $row->start_date }}</td>
                            <td>{{ $row->end_date }}</td>
                            <td>
                                <div class="table-data-feature">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit_modal{{ $row->id }}"
                                        class="item" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);"
                                        data-url="{{ route('farming_period.destroy', $row->id) }}"
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
                <h4>Add farming period</h4>
                <div class="modal-body">
                    <form method="POST" action="{{ route('farming_period.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="farm">Farm</label>
                            <select name="farm_id" class="form-control select-farm" required>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="username">Assigned User</label>
                            <select name="assign_user_id" class="form-control" required>
                                <option disabled selected value="">Assign A User</option>
                                @foreach ($users as $row)
                                    <option value="{{ $row->user_id }}">{{ $row->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" placeholder=""
                                aria-describedby="helpId" />
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" placeholder=""
                                aria-describedby="helpId" />
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
@foreach ($farming_pr as $row)
    <div class="modal fade" id="edit_modal{{ $row->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4>Edit farming period</h4>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('farming_period.update', $row->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="username">Farm</label>
                                <select name="farm_id" class="form-control select-farm" required>
                                    <option value="{{ $row->farm->id }}" selected>
                                        {{ $row->farm->name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="username">Assigned User</label>
                                <select name="assign_user_id" class="form-control" required>
                                    <option disabled selected value="">Assign A User</option>
                                    @foreach ($users as $userRow)
                                        <option value="{{ $userRow->user_id }}"
                                            {{ $row->assign_user_id === $userRow->user_id ? 'selected' : '' }}>
                                            {{ $userRow->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    required placeholder="" aria-describedby="helpId" 
                                    value="{{ $row->start_date }}" />
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"required
                                    placeholder="" aria-describedby="helpId" value="{{ $row->end_date }}" />
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
