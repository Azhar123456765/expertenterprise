@extends('layout.app')  @section('title','Product Sub Category')  @section('content')

<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">sub Category Table</h3>
            <a href="" data-bs-toggle="modal" data-bs-target="#add-modal" class="btn btn-success float-right">
                <i class="fa fa-plus"></i>&nbsp;&nbsp; Add sub Category</a>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>

                    <th>S.NO</th>
                            <th>Category Name</th>
                            <th>Main Category</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $serial = 1
                    @endphp
                    @foreach ($users as $row)
                        <tr class="tr-shadow">
                            <td>{{ $serial }}</td>
                            <td>{{ $row->sub_category_name }}</td>
                            <td>{{ $row->category_name }}</td>
                            <td>{{ $row->created_at }}</td>
                            <td>{{ $row->updated_at }}</td>
                            <td>
                                <div class="table-data-feature">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit_modal{{$row->product_sub_category_id}}" class="item" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="/product_sub_category_delete{{ $row->product_sub_category_id }}" class="item" data-bs-toggle="tooltip" data-placement="top" title="Delete">
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
                <h4>Add Sub Category</h4>
                <div class="modal-body">
                    <form method="POST" action="/add_product_sub_category">
                        @csrf
                        <div class="form-group">
                            <label for="username">Category Name</label>
                            <input type="text" class="form-control " id="category_name" name="category_name" placeholder="Category" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Main Category</label>
                            <select name="main_category" id="">
                                @foreach ($category as $row)


                                <option value="{{$row->product_category_id}}">{{$row->category_name}}</option>

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
@foreach ($users as $row)


<div class="modal fade" id="edit_modal{{$row->product_sub_category_id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Edit Sub Category</h4>
                <div class="modal-body">
                    <form method="POST" action="/edit_product_sub_category{{$row->product_sub_category_id}}">
                        @csrf
                        <div class="form-group">
                            <label for="username">Category Name</label>
                            <input type="text" class="form-control " id="category_name" name="category_name" placeholder="Category" required value="{{$row->sub_category_name}}">
                        </div>
                        <div class="form-group">
                            <label for="username">Main Category</label>
                            <select name="main_category" id="">
                                @foreach ($category as $row2)
                                <option value="{{$row2->product_category_id}}" {{$row->product_category_id === $row2->product_category_id ? 'selected' : ''}}>{{$row2->category_name}}</option>
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