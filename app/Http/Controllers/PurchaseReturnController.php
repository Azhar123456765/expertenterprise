<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\accounts;
use App\Models\users;
use App\Models\customization;
use App\Models\Expense;
use App\Models\Income;
use App\Models\seller;
use App\Models\purchase_invoice;
use App\Models\sales_officer;
use App\Models\product_sub_category;
use App\Models\product_category;
use App\Models\product_company;
use App\Models\product_type;
use App\Models\products;
use App\Models\purchase_return;
use App\Models\warehouse;

class PurchaseReturnController extends Controller
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
        // $product = products::all();
        $seller = seller::all();
        $warehouse = warehouse::all();

        $sales_officer  = sales_officer::all();

        $purchase_invoice  = purchase_invoice::all();
        $product  = products::all();

        $account = accounts::all();
        $count = purchase_return::whereIn('purchase_returns.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('purchase_returns')
                ->groupBy('unique_id');
        })->count();

        $data = compact('seller', 'sales_officer', 'product', 'warehouse', 'purchase_invoice', 'account', 'count');
        return view('invoice.arp_med_invoice')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoiceData = $request->all();
        $user_id = session()->get('user_id')['user_id'];

        $expense =  new Income;
        $expense->category_id = $invoiceData['unique_id'];
        $expense->category = 'Purchase Invoice Return';
        $expense->company_id = $invoiceData['company'];
        $expense->company_ref = 'S';
        $expense->amount = $request['amount_total'];
        $expense->save();
        // Assuming all array fields have the same lengthbdnbbh

        users::where("user_id", $user_id)->update([
            'no_records' => DB::raw("no_records + " . 1)
        ]);
        $pr_amount = $request['previous_balance'];


        $amount = $request['amount_total'];



        $arrayLength = count(array_filter($invoiceData['item']));

        for ($i = 0; $i < $arrayLength; $i++) {

            $invoice = new purchase_return;
            $user_id = session()->get('user_id')['user_id'];

            $invoice->user_id = $user_id;
            $invoice->sales_officer = $invoiceData['sales_officer'] ?? null;
            $invoice->company = $invoiceData['company'] ?? null;
            $invoice->remark = $invoiceData['remark'] ?? null;
            $invoice->pkr_amount = $invoiceData['pkr_amount'] ?? null;
            $invoice->date = $invoiceData['date'] ?? null;
            $invoice->bilty_no = $invoiceData['bilty_no'] ?? null;
            $invoice->warehouse = $invoiceData['warehouse'] ?? null;


            $invoice->book = $invoiceData['book'] ?? null;
            $invoice->due_date = $invoiceData['due_date'] ?? null;
            $invoice->transporter = $invoiceData['transporter'] ?? null;
            $invoice->unique_id = $invoiceData['unique_id'] ?? null;

            $invoice->previous_balance = $invoiceData['amount_total'] ?? null;
            $invoice->cartage = $invoiceData['cartage'] ?? null;
            $invoice->grand_total = $invoiceData['grand_total'] ?? null;
            $invoice->amount_paid = $invoiceData['amount_paid'] ?? null;
            $invoice->balance_amount = $invoiceData['balance_amount'] ?? null;

            $invoice->qty_total = $invoiceData['qty_total'] ?? null;
            $invoice->dis_total = $invoiceData['dis_total'] ?? null;
            $invoice->amount_total = $invoiceData['amount_total'] ?? null;

            $invoice->invoice_no = $invoiceData['invoice_no'] ?? null;

            $invoice->freight = $invoiceData['freight'] ?? null;
            $invoice->freighta = $invoiceData['freighta'] ?? null;
            $invoice->sales_tax = $invoiceData['sales_tax'] ?? null;
            $invoice->sales_taxa = $invoiceData['sales_taxa'] ?? null;
            $invoice->ad_sales_tax = $invoiceData['ad_sales_tax'] ?? null;
            $invoice->ad_sales_taxa = $invoiceData['ad_sales_taxa'] ?? null;
            $invoice->bank = $invoiceData['bank'] ?? null;
            $invoice->banka = $invoiceData['banka'] ?? null;
            $invoice->other_expense = $invoiceData['other_expense'] ?? null;
            $invoice->other_expensea = $invoiceData['other_expensea'] ?? null;



            $invoice->pr_item = $invoiceData['item']["$i"] ?? null;



            $invoice->previous_stock = $invoiceData['pur_qty']["$i"] ?? null;

            $product = $invoiceData['item']["$i"];

            products::where("product_id", $product)->update([
                'opening_quantity' => DB::raw("opening_quantity - " . $invoiceData['pur_qty']["$i"])
            ]);



            $invoice->dis_amount = $invoiceData['dis_amount']["$i"] ?? null;
            $invoice->type = $invoiceData['type']["$i"] ?? null;
            $invoice->item = $invoiceData['item']["$i"] ?? 'error';
            $invoice->unit = $invoiceData['unit']["$i"] ?? null;
            $invoice->batch_no = $invoiceData['batch_no']["$i"] ?? null;
            $invoice->expiry = $invoiceData['expiry']["$i"] ?? null;
            $invoice->pur_qty = $invoiceData['pur_qty']["$i"] ?? null;
            $invoice->price = $invoiceData['price']["$i"] ?? null;
            $invoice->amount = $invoiceData['amount']["$i"] ?? null;
            $invoice->discount = $invoiceData['dis_per']["$i"] ?? null;
            $invoice->exp_unit = $invoiceData['exp_unit']["$i"] ?? null;
            $invoice->mor_cut = $invoiceData['mor_cut']["$i"] ?? null;
            $invoice->crate_cut = $invoiceData['crate_cut']["$i"] ?? null;
            $invoice->avg = $invoiceData['avg']["$i"] ?? null;
            $invoice->n_weight = $invoiceData['n_weight']["$i"] ?? null;
            $invoice->rate_diff = $invoiceData['rate_diff']["$i"] ?? null;
            $invoice->rate = $invoiceData['rate']["$i"] ?? null;
            $invoice->pur_price = $invoiceData['pur_price']["$i"] ?? null;
            $invoice->sale_price = $invoiceData['sale_price']["$i"] ?? null;
            $invoice->sale_qty = $invoiceData['sale_qty']["$i"] ?? null;
            $invoice->bonus_qty = $invoiceData['bonus_qty']["$i"] ?? null;


            $invoice->save();
        }

        $data = 'Invoices added successfully!';
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\purchase_return  $purchase_return
     * @return \Illuminate\Http\Response
     */
    public function show(purchase_return $purchase_return)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\purchase_return  $purchase_return
     * @return \Illuminate\Http\Response
     */
    public function edit(purchase_return $purchase_return)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\purchase_return  $purchase_return
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, purchase_return $purchase_return)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\purchase_return  $purchase_return
     * @return \Illuminate\Http\Response
     */
    public function destroy(purchase_return $purchase_return)
    {
        //
    }
}
