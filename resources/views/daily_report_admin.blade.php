@extends('layout.app') @section('title', 'Daily Report') @section('content')
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daily report table</h3>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Farm</th>
                        <th>Date</th>
                        <th>User Name</th>
                        <th>chicken deaths / چکن کی موت
                            / مرغي جو موت</th>
                        <th>Feed consumed</th>
                        <th>Water consumed</th>
                        <th>Extra expense</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $serial = 1;
                    @endphp
                    @forelse ($farm_daily_reports as $row)
                        <tr class="tr-shadow">
                            <td>{{ $serial }}</td>
                            <td class="text-center">{{ $row->farms->name ?? null }}</td>
                            <td class="text-center">{{ $row->date }}</td>
                            <td>{{ $row->user->username }}</td>
                            <td class="text-right">{{ $row->hen_deaths }}</td>
                            <td class="text-right">{{ $row->feed_consumed }}</td>
                            <td class="text-right">{{ $row->water_consumed }}</td>
                            <td class="text-right">
                                {{ $row->extra_expense_narration }}, {{ $row->extra_expense_amount }}Rs</td>
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
                        <td>No Report available.</td>
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
                <h4>Add Report</h4>
                <div class="modal-body">
                    <form method="POST" action="{{ Route('store_daily_report') }}">
                        @csrf

                        @method('post')
                </div>
                <div class="form-group">
                    <label for="farm">Select Farm</label>
                    <select class="form-select form-control form-select-lg" name="farm" id="farm">
                        <option selected disabled>Select Farm</option>
                        @foreach ($farms as $farmRow)
                            <option value="{{ $farmRow->id }}">{{ $farmRow->name }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <label for="username">chicken deaths / چکن کی موت
                        / مرغي جو موت</label>
                    <input type="number" step="any" class="form-control" id="hen_deaths" name="hen_deaths"
                        placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="username">Feed consumed (Bags) / استعمال شدہ فیڈ (بیگ) / کاڌ خوراڪ (بيگ)</label>
                    <input type="number" step="any" class="form-control" id="feed_consumed" name="feed_consumed"
                        placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="username">Water consumed (liters) / استعمال شدہ پانی (لیٹر) / استعمال ٿيل پاڻي
                        (ليٽر)</label>
                    <input type="number" step="any" class="form-control" id="water_consumed" name="water_consumed"
                        placeholder="" required>
                </div>
                <div class="form-group">
                    <h4 class="text-center">Extra expense (optional) / اضافی اخراجات (اختیاری) / اضافي خرچ (اختياري)
                    </h4>
                    <div class="row justify-content-between my-4">
                        <div class="col-6">
                            <label for="username fs-5">Narration / بیانیہ / داستان</label>
                            <input type="text" step="any" class="form-control" id="extra_expense_narration"
                                name="extra_expense_narration" placeholder="">
                        </div>
                        <div class="col-6">
                            <label for="username">Amount / رقم</label>
                            <input type="number" step="any" class="form-control" id="extra_expense_amount"
                                name="extra_expense_amount" placeholder="">
                        </div>
                    </div>
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

@foreach ($farm_daily_reports as $row)
    <div class="modal fade" id="edit_modal{{ $row->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4>Edit Report</h4>
                    <div class="modal-body">
                        <form method="POST" action="{{ Route('update_daily_report', $row->id) }}">
                            @csrf

                            @method('put')
                            <div class="form-group">
                                <label for="farm">Select Farm</label>
                                <select class="form-select form-control form-select-lg" name="farm"
                                    id="farm">
                                    @foreach ($farms as $farmRow)
                                        <option value="{{ $farmRow->id }}"
                                            {{ $row->farm == $farmRow->id ? 'selected' : '' }}>{{ $farmRow->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="username">chicken deaths / چکن کی موت
                                    / مرغي جو موت</label>
                                <input type="number" step="any" class="form-control" id="hen_deaths"
                                    name="hen_deaths" placeholder="" required value="{{ $row->hen_deaths }}">
                            </div>
                            <div class="form-group">
                                <label for="username">Feed consumed (Bags) / استعمال شدہ فیڈ (بیگ) / کاڌ خوراڪ
                                    (بيگ)</label>
                                <input type="number" step="any" class="form-control" id="feed_consumed"
                                    name="feed_consumed" placeholder="" required value="{{ $row->feed_consumed }}">
                            </div>
                            <div class="form-group">
                                <label for="username">Water consumed (liters) / استعمال شدہ پانی (لیٹر) / استعمال ٿيل
                                    پاڻي (ليٽر)</label>
                                <input type="number" step="any" class="form-control" id="water_consumed"
                                    name="water_consumed" placeholder="" required
                                    value="{{ $row->water_consumed }}">
                            </div>
                            <div class="form-group">
                                <h4 class="text-center">Extra expense (optional) / اضافی اخراجات (اختیاری) / اضافي خرچ
                                    (اختياري)</h4>
                                <div class="row justify-content-between my-4">
                                    <div class="col-6">
                                        <label for="username fs-5">Narration / بیانیہ / داستان</label>
                                        <input type="text" step="any" class="form-control"
                                            id="extra_expense_narration" name="extra_expense_narration"
                                            value="{{ $row->extra_expense_narration }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="username">Amount / رقم</label>
                                        <input type="number" step="any" class="form-control"
                                            id="extra_expense_amount" name="extra_expense_amount"
                                            value="{{ $row->extra_expense_amount }}">
                                    </div>
                                    <input type="hidden" name="user_id" value="{{ $row->user_id }}">
                                </div>
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
<script>
    // $(document).ready(function() {
    //     $('form').validin();
    //     $("#example1")
    //         .DataTable({
    //             responsive: true,
    //             lengthChange: false,
    //             autoWidth: false,
    //             buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
    //         })

    //     $("#example2").DataTable({
    //         paging: true,
    //         lengthChange: false,
    //         searching: false,
    //         ordering: true,
    //         info: true,
    //         autoWidth: false,
    //         responsive: true,
    //     });
    // });
</script>

@endsection
