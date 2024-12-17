@extends('layout.app') @section('title', 'Narrtions') @section('content')
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Narrations table</h3>
            <a href="" data-bs-toggle="modal" data-bs-target="#add-modal" class="btn btn-success float-right">
                <i class="fa fa-plus"></i>&nbsp;&nbsp; Add Narrations</a>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>

                        <th>S.NO</th>
                        <th>Narrations</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $serial = 1;
                    @endphp
                    @forelse ($narrations as $row)
                        <tr class="tr-shadow">
                            <td>{{ $serial }}</td>
                            <td>{{ $row->narration }}</td>
                            <td>
                                <div class="table-data-feature">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit_modal{{ $row->id }}"
                                        class="item" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- <tr class="spacer"></tr> -->
                        @php
                            $serial++;
                        @endphp
                    @empty
                        <td>No Narration available.</td>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="add-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Add narration</h4>
                <div class="modal-body">
                    <form method="POST" action="{{ Route('store_narration') }}">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="username">Narration</label>
                            <input type="text" class="form-control" id="narration" name="narration"
                                placeholder="narration" required>
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

@foreach ($narrations as $row)
    <div class="modal fade" id="edit_modal{{ $row->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4>Edit narration</h4>
                    <div class="modal-body">
                        <form method="POST" action="{{ Route('update_narration', $row->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="username">narration Name</label>
                                <input type="text" class="form-control " id="narration" name="narration"
                                    placeholder="narration" required value="{{ $row->narration }}">
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
