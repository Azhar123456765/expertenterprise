<?php

namespace App\Http\Controllers;

use App\Models\buyer;
use App\Models\ChickInvoice;
use App\Models\products;
use App\Models\sales_officer;
use Illuminate\Support\Facades\DB;
use App\Models\users;
use Illuminate\Http\Request;

class ChickInvoiceController extends Controller
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
        $count = ChickInvoice::whereIn('chick_invoices.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('chick_invoices')
                ->groupBy('unique_id');
        })->count();

        $data = compact('count');
        return view('invoice.farm.chick_invoice')->with($data);
    }
    public function create_first(Request $request)
    {
        $invoice = ChickInvoice::where('unique_id', 1)->get();
        $single_invoice = ChickInvoice::where('unique_id', 1)->first();
        if (count($invoice) > 0) {
            return view('invoice.farm.edit_chick_invoice', compact('invoice', 'single_invoice'));
        } else {
            session()->flash('something_error', 'Invoice Not Found');
            return redirect()->back();
        }
    }

    public function create_last(Request $request)
    {
        $count = ChickInvoice::whereIn('chick_invoices.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('chick_invoices')
                ->groupBy('unique_id');
        })->count();

        $invoice = ChickInvoice::where('unique_id', $count)->get();
        $single_invoice = ChickInvoice::where('unique_id', $count)->first();
        if (count($invoice) > 0) {
            return view('invoice.farm.edit_chick_invoice', compact('invoice', 'single_invoice'));
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

            $invoice = new ChickInvoice;

            $invoice->unique_id = $request['unique_id'] ?? 000;
            $invoice->user_id = $user_id;
            $invoice->item = $request['item']["$i"];
            $invoice->date = $request['date'] ?? 000;
            $invoice->seller = $request['seller'];
            $invoice->buyer = $request['buyer'];
            $invoice->sales_officer = $request['sales_officer'] ?? null;
            $invoice->farm = $request['farm'] ?? null;
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
     * @param  \App\Models\ChickInvoice  $chickInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(ChickInvoice $chickInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChickInvoice  $chickInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $invoice = ChickInvoice::where('unique_id', $id)->get();
        $single_invoice = ChickInvoice::where('unique_id', $id)->first();
        if (count($invoice) > 0) {
            return view('invoice.farm.edit_chick_invoice', compact('invoice', 'single_invoice'));
        } else {
            session()->flash('something_error', 'Invoice Not Found');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChickInvoice  $chickInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $user_id = session()->get('user_id')['user_id'];
        ChickInvoice::where('unique_id', $id)->delete();
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

            $invoice = new ChickInvoice;

            $invoice->unique_id = $request['unique_id'] ?? 000;
            $invoice->user_id = $user_id;
            $invoice->item = $request['item']["$i"];
            $invoice->date = $request['date'] ?? 000;
            $invoice->seller = $request['seller'];
            $invoice->buyer = $request['buyer'];
            $invoice->sales_officer = $request['sales_officer'] ?? null;
            $invoice->farm = $request['farm'] ?? null;
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
     * @param  \App\Models\ChickInvoice  $chickInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChickInvoice $chickInvoice)
    {
        //
    }
}
