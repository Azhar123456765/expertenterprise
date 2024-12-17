<?php

namespace App\Http\Controllers;

use App\Models\chickenInvoice;
use App\Models\users;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ChickenInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $count = chickenInvoice::grouped()->count();

        $data = compact('count');
        return view('invoice.farm.chicken_invoice')->with($data);
    }

    public function create_first(Request $request)
    {
        $invoice = chickenInvoice::where('unique_id', 1)->get();
        $single_invoice = chickenInvoice::where('unique_id', 1)->first();
        if (count($invoice) > 0) {
            return view('invoice.farm.edit_chicken_invoice', compact('invoice', 'single_invoice'));
        } else {
            session()->flash('something_error', 'Invoice Not Found');
            return redirect()->back();
        }
    }
    public function create_last(Request $request)
    {
        $count = chickenInvoice::grouped()->count();

        $invoice = chickenInvoice::where('unique_id', $count)->get();
        $single_invoice = chickenInvoice::where('unique_id', $count)->first();
        if (count($invoice) > 0) {
            return view('invoice.farm.edit_chicken_invoice', compact('invoice', 'single_invoice'));
        } else {
            session()->flash('something_error', 'Invoice Not Found');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $user_id = session()->get('user_id')['user_id'];
        users::where("user_id", $user_id)->update([
            'no_records' => DB::raw("no_records + " . 1)
        ]);
        // $income = new Income;
        // $income->category_id = $request['unique_id'];
        // $income->category = 'Chick Invoice';
        // $income->amount = $request['amount_paid'];
        // $income->save(); 
        // $array = $request['amount'];
        // $filteredArray = array_filter($array, function ($value) {
        //     return $value > 0;
        // });

        $arrayLength = count(array_filter($request['item']));

        for ($i = 0; $i < $arrayLength; $i++) {

            $invoice = new chickenInvoice;

            $invoice->unique_id = $request['unique_id'] ?? 0;
            $invoice->user_id = $user_id;
            $invoice->item = $request['item']["$i"];
            $invoice->date = $request['date'] ?? 0;
            $invoice->seller = $request['seller'];
            $invoice->buyer = $request['buyer'];
            $invoice->sales_officer = $request['sales_officer'] ?? null;
            $invoice->farm = $request['farm'] ?? null;
            $invoice->remark = $request['remark'] ?? null;

            $invoice->rate_type = $request['rate_type']["$i"] ?? 0;
            $invoice->vehicle_no = $request['vehicle_no']["$i"] ?? 0;
            $invoice->crate_type = $request['crate_type']["$i"] ?? 0;
            $invoice->crate_qty = $request['crate_qty']["$i"] ?? 0;
            $invoice->hen_qty = $request['hen_qty']["$i"] ?? 0;
            $invoice->gross_weight = $request['gross_weight']["$i"] ?? 0;
            $invoice->actual_rate = $request['actual_rate']["$i"] ?? 0;
            $invoice->feed_cut = $request['feed_cut']["$i"] ?? 0;
            $invoice->more_cut = $request['mor_cut']["$i"] ?? 0;
            $invoice->crate_cut = $request['crate_cut']["$i"] ?? 0;
            $invoice->net_weight = $request['n_weight']["$i"] ?? 0;
            $invoice->rate_diff = $request['rate_diff']["$i"] ?? 0;
            $invoice->rate = $request['rate']["$i"] ?? 0;
            $invoice->amount = $request['amount']["$i"] ?? 0;
            $invoice->sale_feed_cut = $request['sale_feed_cut']["$i"] ?? 0;
            $invoice->sale_more_cut = $request['sale_mor_cut']["$i"] ?? 0;
            $invoice->sale_crate_cut = $request['sale_crate_cut']["$i"] ?? 0;
            $invoice->sale_net_weight = $request['sale_n_weight']["$i"] ?? 0;
            $invoice->sale_rate_diff = $request['sale_rate_diff']["$i"] ?? 0;
            $invoice->sale_rate = $request['sale_rate']["$i"] ?? 0;
            $invoice->sale_amount = $request['sale_amount']["$i"] ?? 0;
            $invoice->avg = $request['avg']["$i"] ?? 0;

            $invoice->crate_qty_total = $request['crate_qty_total'] ?? 0;
            $invoice->hen_qty_total = $request['hen_qty_total'] ?? 0;
            $invoice->gross_weight_total = $request['gross_weight_total'] ?? 0;
            $invoice->feed_cut_total = $request['feed_cut_total'] ?? 0;
            $invoice->mor_cut_total = $request['mor_cut_total'] ?? 0;
            $invoice->crate_cut_total = $request['crate_cut_total'] ?? 0;
            $invoice->n_weight_total = $request['n_weight_total'] ?? 0;
            $invoice->amount_total = $request['amount_total'] ?? 0;
            $invoice->sale_feed_cut_total = $request['sale_feed_cut_total'] ?? 0;
            $invoice->sale_mor_cut_total = $request['sale_mor_cut_total'] ?? 0;
            $invoice->sale_crate_cut_total = $request['sale_crate_cut_total'] ?? 0;
            $invoice->sale_n_weight_total = $request['sale_n_weight_total'] ?? 0;
            $invoice->sale_amount_total = $request['sale_amount_total'] ?? 0;

            $image = $request->file('attachment');
            if ($image) {
                $attachmentPath = $image->store('attachments');
            } else {
                $attachmentPath = null;
            }

            $invoice->attachment = $attachmentPath;

            $invoice->save();
        }

        $data = 'Invoices added successfully!';
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\chickenInvoice  $chickenInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(chickenInvoice $chickenInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\chickenInvoice  $chickenInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $last_count = chickenInvoice::grouped()->count();
        $invoice = chickenInvoice::where('unique_id', $id)->get();
        $single_invoice = chickenInvoice::where('unique_id', $id)->first();
        if (count($invoice) > 0) {
            return view('invoice.farm.edit_chicken_invoice', compact('invoice', 'single_invoice', 'last_count'));
        } else {
            session()->flash('something_error', 'Invoice Not Found');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\chickenInvoice  $chickenInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $user_id = session()->get('user_id')['user_id'];
        chickenInvoice::where('unique_id', $id)->delete();
        users::where("user_id", $user_id)->update([
            'no_records' => DB::raw("no_records + " . 1)
        ]);
        // $income = new Income;
        // $income->category_id = $request['unique_id'];
        // $income->category = 'Chick Invoice';
        // $income->amount = $request['amount_paid'];
        // $income->save(); 
        // $array = $request['amount'];
        // $filteredArray = array_filter($array, function ($value) {
        //     return $value > 0;
        // });

        $arrayLength = count(array_filter($request['item']));

        for ($i = 0; $i < $arrayLength; $i++) {

            $invoice = new chickenInvoice;

            $invoice->unique_id = $request['unique_id'] ?? 0;
            $invoice->user_id = $user_id;
            $invoice->item = $request['item']["$i"];
            $invoice->date = $request['date'] ?? 0;
            $invoice->seller = $request['seller'];
            $invoice->buyer = $request['buyer'];
            $invoice->sales_officer = $request['sales_officer'] ?? null;
            $invoice->farm = $request['farm'] ?? null;
            $invoice->remark = $request['remark'] ?? null;

            $invoice->rate_type = $request['rate_type']["$i"] ?? 0;
            $invoice->vehicle_no = $request['vehicle_no']["$i"] ?? 0;
            $invoice->crate_type = $request['crate_type']["$i"] ?? 0;
            $invoice->crate_qty = $request['crate_qty']["$i"] ?? 0;
            $invoice->hen_qty = $request['hen_qty']["$i"] ?? 0;
            $invoice->gross_weight = $request['gross_weight']["$i"] ?? 0;
            $invoice->actual_rate = $request['actual_rate']["$i"] ?? 0;
            $invoice->feed_cut = $request['feed_cut']["$i"] ?? 0;
            $invoice->more_cut = $request['mor_cut']["$i"] ?? 0;
            $invoice->crate_cut = $request['crate_cut']["$i"] ?? 0;
            $invoice->net_weight = $request['n_weight']["$i"] ?? 0;
            $invoice->rate_diff = $request['rate_diff']["$i"] ?? 0;
            $invoice->rate = $request['rate']["$i"] ?? 0;
            $invoice->amount = $request['amount']["$i"] ?? 0;
            $invoice->sale_feed_cut = $request['sale_feed_cut']["$i"] ?? 0;
            $invoice->sale_more_cut = $request['sale_mor_cut']["$i"] ?? 0;
            $invoice->sale_crate_cut = $request['sale_crate_cut']["$i"] ?? 0;
            $invoice->sale_net_weight = $request['sale_n_weight']["$i"] ?? 0;
            $invoice->sale_rate_diff = $request['sale_rate_diff']["$i"] ?? 0;
            $invoice->sale_rate = $request['sale_rate']["$i"] ?? 0;
            $invoice->sale_amount = $request['sale_amount']["$i"] ?? 0;

            $invoice->avg = $request['avg']["$i"] ?? 0;

            $invoice->crate_qty_total = $request['crate_qty_total'] ?? 0;
            $invoice->hen_qty_total = $request['hen_qty_total'] ?? 0;
            $invoice->gross_weight_total = $request['gross_weight_total'] ?? 0;
            $invoice->feed_cut_total = $request['feed_cut_total'] ?? 0;
            $invoice->mor_cut_total = $request['mor_cut_total'] ?? 0;
            $invoice->crate_cut_total = $request['crate_cut_total'] ?? 0;
            $invoice->n_weight_total = $request['n_weight_total'] ?? 0;
            $invoice->amount_total = $request['amount_total'] ?? 0;
            $invoice->sale_feed_cut_total = $request['sale_feed_cut_total'] ?? 0;
            $invoice->sale_mor_cut_total = $request['sale_mor_cut_total'] ?? 0;
            $invoice->sale_crate_cut_total = $request['sale_crate_cut_total'] ?? 0;
            $invoice->sale_n_weight_total = $request['sale_n_weight_total'] ?? 0;
            $invoice->sale_amount_total = $request['sale_amount_total'] ?? 0;

            $image = $request->file('attachment');
            if ($image) {
                $attachmentPath = $image->store('attachments');
            } else {
                $attachmentPath = $request->input('old_attachment');
            }

            $invoice->attachment = $attachmentPath;

            $invoice->save();
        }

        $data = 'Invoices Updated successfully!';
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\chickenInvoice  $chickenInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(chickenInvoice $chickenInvoice)
    {
        //
    }
}
