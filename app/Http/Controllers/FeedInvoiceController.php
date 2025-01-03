<?php

namespace App\Http\Controllers;

use App\Models\feedInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\users;
use Illuminate\Http\Request;

class FeedInvoiceController extends Controller
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
        $count = feedInvoice::whereIn('feed_invoices.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('feed_invoices')
                ->groupBy('unique_id');
        })->count();

        $data = compact('count');
        return view('invoice.farm.feed_invoice')->with($data);
    }

    public function create_first(Request $request)
    {
        $invoice = feedInvoice::where('unique_id', 1)->get();
        $single_invoice = feedInvoice::where('unique_id', 1)->first();
        if (count($invoice) > 0) {
            return view('invoice.farm.edit_feed_invoice', compact('invoice', 'single_invoice'));
        } else {
            session()->flash('something_error', 'Invoice Not Found');
            return redirect()->back();
        }
    }
    public function create_last(Request $request)
    {
        $count = feedInvoice::whereIn('feed_invoices.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('feed_invoices')
                ->groupBy('unique_id');
        })->count();
        $invoice = feedInvoice::where('unique_id', $count)->get();
        $single_invoice = feedInvoice::where('unique_id', $count)->first();
        if (count($invoice) > 0) {
            return view('invoice.farm.edit_feed_invoice', compact('invoice', 'single_invoice'));
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
        // $income->category = 'feed Invoice';
        // $income->amount = $request['amount_paid'];
        // $income->save(); 
        // $array = $request['amount'];
        // $filteredArray = array_filter($array, function ($value) {
        //     return $value > 0;
        // });

        $arrayLength = count(array_filter($request['item']));

        for ($i = 0; $i < $arrayLength; $i++) {

            $invoice = new feedInvoice;

            $invoice->unique_id = $request['unique_id'] ?? 000;
            $invoice->user_id = $user_id;
            $invoice->item = $request['item']["$i"];
            $invoice->date = $request['date'] ?? 000;
            $invoice->seller = $request['seller'];
            $invoice->buyer = $request['buyer'];
            $invoice->sales_officer = $request['sales_officer'] ?? null;
            $invoice->supply_farm = $request['supply_farm'] ?? null;
            $invoice->farm = $request['farm'] ?? null;
            $invoice->farm_status = $request['farm_status'] ?? 0;
            $invoice->remark = $request['remark'] ?? null;

            $invoice->rate = $request['rate']["$i"] ?? 000;
            $invoice->qty = $request['qty']["$i"] ?? 000;
            $invoice->discount = $request['discount']["$i"] ?? 000;
            $invoice->bonus = $request['bonus']["$i"] ?? 000;
            $invoice->amount = $request['amount']["$i"] ?? 000;

            $invoice->sale_rate = $request['sale_rate']["$i"] ?? 000;
            $invoice->sale_qty = $request['sale_qty']["$i"] ?? 000;
            $invoice->sale_discount = $request['sale_discount']["$i"] ?? 000;
            $invoice->sale_bonus = $request['sale_bonus']["$i"] ?? 000;
            $invoice->sale_amount = $request['sale_amount']["$i"] ?? 000;

            $invoice->qty_total = $request['qty_total'] ?? 000;
            $invoice->amount_total = $request['amount_total'] ?? 000;
            $invoice->sale_qty_total = $request['sale_qty_total'] ?? 000;
            $invoice->sale_amount_total = $request['sale_amount_total'] ?? 000;

            $image = $request->file('attachment');
            if ($image) {
                $attachmentPath = $image->store('attachments');
            } else {
                $attachmentPath = $request->input('old_attachment');
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
     * @param  \App\Models\feedInvoice  $feedInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(feedInvoice $feedInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\feedInvoice  $feedInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $invoice = feedInvoice::where('unique_id', $id)->get();
        $single_invoice = feedInvoice::where('unique_id', $id)->first();
        if (count($invoice) > 0) {
            return view('invoice.farm.edit_feed_invoice', compact('invoice', 'single_invoice'));
        } else {
            session()->flash('something_error', 'Invoice Not Found');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\feedInvoice  $feedInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = session()->get('user_id')['user_id'];
        feedInvoice::where('unique_id', $id)->delete();
        // users::where("user_id", $user_id)->update([
        //     'no_records' => DB::raw("no_records + " . 1)
        // ]);
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

            $invoice = new feedInvoice;

            $invoice->unique_id = $request['unique_id'] ?? 000;
            $invoice->user_id = $user_id;
            $invoice->item = $request['item']["$i"];
            $invoice->date = $request['date'] ?? 000;
            $invoice->seller = $request['seller'];
            $invoice->buyer = $request['buyer'];
            $invoice->sales_officer = $request['sales_officer'] ?? null;
            $invoice->supply_farm = $request['supply_farm'] ?? null;
            $invoice->farm = $request['farm'] ?? null;
            $invoice->farm_status = $request['farm_status'] ?? 0;
            $invoice->remark = $request['remark'] ?? null;

            $invoice->rate = $request['rate']["$i"] ?? 000;
            $invoice->qty = $request['qty']["$i"] ?? 000;
            $invoice->discount = $request['discount']["$i"] ?? 000;
            $invoice->bonus = $request['bonus']["$i"] ?? 000;
            $invoice->amount = $request['amount']["$i"] ?? 000;

            $invoice->sale_rate = $request['sale_rate']["$i"] ?? 000;
            $invoice->sale_qty = $request['sale_qty']["$i"] ?? 000;
            $invoice->sale_discount = $request['sale_discount']["$i"] ?? 000;
            $invoice->sale_bonus = $request['sale_bonus']["$i"] ?? 000;
            $invoice->sale_amount = $request['sale_amount']["$i"] ?? 000;

            $invoice->qty_total = $request['qty_total'] ?? 000;
            $invoice->amount_total = $request['amount_total'] ?? 000;
            $invoice->sale_qty_total = $request['sale_qty_total'] ?? 000;
            $invoice->sale_amount_total = $request['sale_amount_total'] ?? 000;

            $image = $request->file('attachment');
            if ($image) {
                $attachmentPath = $image->store('attachments');
            } else {
                $attachmentPath = $request->input('old_attachment');
            }

            $invoice->attachment = $attachmentPath;

            $invoice->save();
        }

        $data = 'Invoices added successfully!';
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\feedInvoice  $feedInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(feedInvoice $feedInvoice)
    {
        //
    }
}
