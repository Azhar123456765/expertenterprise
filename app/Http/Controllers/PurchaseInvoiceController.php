<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\accounts;
use App\Models\users;
use App\Models\customization;
use App\Models\Expense;
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

class PurchaseInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $post)
    {


        $product = products::all();
        $seller = seller::all();
        $warehouse = warehouse::all();

        $sales_officer  = sales_officer::all();



        $invoice_no = $post['invoice_no'] ?? null;
        $company = $post['company'] ?? null;
        $sales_officer2 = $post['sales_officer'] ?? null;
        $date = $post['date'] ?? null;

        if ($post['check'] != null) {
            $query = purchase_invoice::query();

            if ($post['invoice_no']) {
                $query->Where("purchase_invoice.unique_id", $post['invoice_no']);
            }
            if ($post['company']) {
                $query->Where("purchase_invoice.company", $post['company']);
            }
            if ($post['sales_officer']) {
                $query->Where("sales_officer", $post['sales_officer']);
            }
            if ($post['date']) {
                $query->Where("date", $post['date']);
            }
            $query->leftJoin('buyer', 'purchase_invoice.company', '=', 'buyer.buyer_id')
                ->leftJoin('products', 'purchase_invoice.item', '=', 'products.product_id')
                ->leftJoin('warehouse', 'purchase_invoice.warehouse', '=', 'warehouse.warehouse_id')
                ->leftJoin('sales_officer', 'purchase_invoice.sales_officer', '=', 'sales_officer.sales_officer_id')
                ->whereIn('purchase_invoice.id', function ($query2) {
                    $query2->select(DB::raw('MIN(id)'))
                        ->from('purchase_invoice')
                        ->groupBy('unique_id');
                })
                ->orderBy("purchase_invoice.id");

            $purchase_invoice = $query->get();


            $account = accounts::all();

            $data = compact('seller', 'sales_officer', 'product', 'warehouse', 'purchase_invoice', 'account', 'date', 'invoice_no', 'sales_officer2', 'company');

            return view('invoice.view_purchase_invoice')->with($data);
        }

        $purchase_invoice = purchase_invoice::leftJoin('seller', 'purchase_invoice.company', '=', 'seller.seller_id')
            ->leftJoin('products', 'purchase_invoice.item', '=', 'products.product_id')
            ->leftJoin('warehouse', 'purchase_invoice.warehouse', '=', 'warehouse.warehouse_id')
            ->leftJoin('sales_officer', 'purchase_invoice.sales_officer', '=', 'sales_officer.sales_officer_id')
            ->whereRaw('purchase_invoice.id IN (SELECT MIN(id) FROM purchase_invoice GROUP BY unique_id)')
            ->orderby("purchase_invoice.id")
            ->get();



        $account = accounts::all();

        $data = compact('seller', 'sales_officer', 'product', 'warehouse', 'purchase_invoice', 'account', 'date', 'invoice_no', 'sales_officer2', 'company');

        return view('invoice.view_purchase_invoice')->with($data);
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
        $count = purchase_invoice::whereIn('purchase_invoice.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('purchase_invoice')
                ->groupBy('unique_id');
        })->count();

        $data = compact('seller', 'sales_officer', 'product', 'warehouse', 'purchase_invoice', 'account', 'count');
        return view('invoice.p_med_invoice')->with($data);
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

        $expense =  new Expense;
        $expense->category_id = $invoiceData['unique_id'];
        $expense->category = 'Purchase Invoice';
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

            $invoice = new purchase_invoice;
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
                'opening_quantity' => DB::raw("opening_quantity + " . $invoiceData['pur_qty']["$i"])
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $product = products::all();
        $seller = seller::all();
        $warehouse = warehouse::all();

        $sales_officer  = sales_officer::all();

        $purchase_invoice = purchase_invoice::where("unique_id", $id)
            ->leftJoin('seller', 'purchase_invoice.company', '=', 'seller.seller_id')

            ->leftJoin('warehouse', 'purchase_invoice.warehouse', '=', 'warehouse.warehouse_id')
            ->leftJoin('sales_officer', 'purchase_invoice.sales_officer', '=', 'sales_officer.sales_officer_id')
            ->get();


        $single_invoice  = purchase_invoice::where([

            "unique_id" => $id

        ])->limit(1)->get();



        $account = accounts::all();

        $data = compact('seller', 'sales_officer', 'product', 'warehouse', 'purchase_invoice', 'single_invoice', 'account');
        return view('invoice.ep_med_invoice')->with($data);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        purchase_invoice::where('unique_id', $id)->delete();


        $pr_amount = $request['previous_balance'];


        $amount = $request['amount_total'];






        $invoiceData = $request->all();

        $expense =  Expense::where('category_id', $invoiceData['unique_id'])->update([
            'amount' => $request['amount_total'],
            'company' => $request['company']
        ]);
        // Assuming all array fields have the same length
        $arrayLength = count(array_filter($invoiceData['item']));

        for ($i = 0; $i < $arrayLength; $i++) {


            $invoice = new purchase_invoice;

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


            $invoice->created_at = $invoiceData['created_at'] ?? null;
            $invoice->updated_at = date("Y-m-d H:i:s") ?? null;

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

            // if ($invoiceData['item']["$i"] != $invoiceData['pr_item']["$i"]) {


            //     products::where("product_id", $invoiceData['pr_item']["$i"])->update([
            //         'opening_quantity' => DB::raw("opening_quantity - " . $invoiceData['previous_stock']["$i"])
            //     ]);

            //     products::where("product_id", $invoiceData['item']["$i"])->update([
            //         'opening_quantity' => DB::raw("opening_quantity + " . $invoiceData['pur_qty']["$i"])
            //     ]);
            // }


            products::where("product_id", $invoiceData['pr_item']["$i"])->update([
                'opening_quantity' => DB::raw("opening_quantity - " . $invoiceData['previous_stock']["$i"])
            ]);

            products::where("product_id", $invoiceData['item']["$i"])->update([
                'opening_quantity' => DB::raw("opening_quantity + " . $invoiceData['pur_qty']["$i"])
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function r_edit(Request $post, $id)
    {
        $product = products::all();
        $seller = seller::all();
        $warehouse = warehouse::all();

        $sales_officer  = sales_officer::all();

        $purchase_invoice = purchase_invoice::where("unique_id", $id)
            ->leftJoin('seller', 'purchase_invoice.company', '=', 'seller.seller_id')
            ->leftJoin('products', 'purchase_invoice.item', '=', 'products.product_id')
            ->leftJoin('warehouse', 'purchase_invoice.warehouse', '=', 'warehouse.warehouse_id')
            ->leftJoin('sales_officer', 'purchase_invoice.sales_officer', '=', 'sales_officer.sales_officer_id')
            ->get();


        $single_invoice  = purchase_invoice::where([

            "unique_id" => $id

        ])->limit(1)->get();

        $count = purchase_return::whereIn('purchase_returns.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('purchase_returns')
                ->groupBy('unique_id');
        })->count();

        $account = accounts::all();

        $data = compact('seller', 'sales_officer', 'product', 'warehouse', 'purchase_invoice', 'single_invoice', 'account', 'count');
        return view('invoice.rp_med_invoice')->with($data);
    }

    // UPDATE THIS FIRST
    function r_update(Request $request, $id)
    {
        

        purchase_invoice::where('unique_id', $id)->delete();

        $pr_amount = $request['previous_balance'];
        $amount = $request['amount_total'];
        $invoiceData = $request->all();

        $expense =  Expense::where('category_id', $invoiceData['unique_id'])->update([
            'amount' => $request['amount_total'],
            'company' => $request['company']
        ]);

        $arrayLength = count(array_filter($invoiceData['item']));

        for ($i = 0; $i < $arrayLength; $i++) {


            $invoice = new purchase_invoice;

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

            // if ($invoiceData['item']["$i"] != $invoiceData['pr_item']["$i"]) {


            //     products::where("product_id", $invoiceData['pr_item']["$i"])->update([
            //         'opening_quantity' => DB::raw("opening_quantity - " . $invoiceData['previous_stock']["$i"])
            //     ]);

            //     products::where("product_id", $invoiceData['item']["$i"])->update([
            //         'opening_quantity' => DB::raw("opening_quantity + " . $invoiceData['pur_qty']["$i"])
            //     ]);
            // }

            products::where("product_id", $invoiceData['pr_item']["$i"])->update([
                'opening_quantity' => DB::raw("opening_quantity - " . $invoiceData['previous_stock']["$i"])
            ]);

            products::where("product_id", $invoiceData['item']["$i"])->update([
                'opening_quantity' => DB::raw("opening_quantity + " . $invoiceData['pur_qty']["$i"])
            ]);

            products::where("product_id", $invoiceData['item']["$i"])->update([
                'opening_quantity' => DB::raw("opening_quantity - " . $invoiceData['return_qty']["$i"])
            ]);

            $invoice->return_qty =  $invoice->return_qty + $invoiceData['return_qty']["$i"] ?? null;

            $invoice->dis_amount = $invoiceData['dis_amount']["$i"] ?? null;
            $invoice->type = $invoiceData['type']["$i"] ?? null;
            $invoice->item = $invoiceData['item']["$i"] ?? 'error';
            $invoice->unit = $invoiceData['unit']["$i"] ?? null;
            $invoice->batch_no = $invoiceData['batch_no']["$i"] ?? null;
            $invoice->expiry = $invoiceData['expiry']["$i"] ?? null;
            $invoice->pur_qty = $invoiceData['pur_qty']["$i"] - $invoiceData['return_qty']["$i"] ?? null;
            $invoice->amount = $invoiceData['amount']["$i"] ?? null;
            $invoice->discount = $invoiceData['dis_per']["$i"] ?? null;
            $invoice->exp_unit = $invoiceData['exp_unit']["$i"] ?? null;
            $invoice->pur_price = $invoiceData['pur_price']["$i"] ?? null;
            $invoice->bonus_qty = $invoiceData['bonus_qty']["$i"] ?? null;

            $invoice->save();
        }




        $arrayLength = count(array_filter($invoiceData['return_qty'], function ($value) {
            return $value > 0;
        }));

        for ($i = 0; $i < $arrayLength; $i++) {


            $invoice_r = new purchase_return;

            $invoice_r->sales_officer = $invoiceData['sales_officer'] ?? null;
            $invoice_r->company = $invoiceData['company'] ?? null;
            $invoice_r->remark = $invoiceData['remark'] ?? null;
            $invoice_r->pkr_amount = $invoiceData['pkr_amount'] ?? null;
            $invoice_r->date = $invoiceData['date'] ?? null;
            $invoice_r->bilty_no = $invoiceData['bilty_no'] ?? null;
            $invoice_r->warehouse = $invoiceData['warehouse'] ?? null;


            $invoice_r->book = $invoiceData['book'] ?? null;
            $invoice_r->due_date = $invoiceData['due_date'] ?? null;
            $invoice_r->transporter = $invoiceData['transporter'] ?? null;
            $invoice_r->return_id = $invoiceData['return_id'] ?? null;
            $invoice_r->unique_id = $invoiceData['unique_id'] ?? null;

            $invoice_r->previous_balance = $invoiceData['amount_total'] ?? null;
            $invoice_r->cartage = $invoiceData['cartage'] ?? null;
            $invoice_r->grand_total = $invoiceData['grand_total'] ?? null;
            $invoice_r->amount_paid = $invoiceData['amount_paid'] ?? null;
            $invoice_r->balance_amount = $invoiceData['balance_amount'] ?? null;

            $invoice_r->qty_total = $invoiceData['qty_total'] ?? null;
            $invoice_r->dis_total = $invoiceData['dis_total'] ?? null;
            $invoice_r->amount_total = $invoiceData['amount_total'] ?? null;

            $invoice_r->invoice_no = $invoiceData['invoice_no'] ?? null;



            $invoice_r->freight = $invoiceData['freight'] ?? null;
            $invoice_r->freighta = $invoiceData['freighta'] ?? null;
            $invoice_r->sales_tax = $invoiceData['sales_tax'] ?? null;
            $invoice_r->sales_taxa = $invoiceData['sales_taxa'] ?? null;
            $invoice_r->ad_sales_tax = $invoiceData['ad_sales_tax'] ?? null;
            $invoice_r->ad_sales_taxa = $invoiceData['ad_sales_taxa'] ?? null;
            $invoice_r->bank = $invoiceData['bank'] ?? null;
            $invoice_r->banka = $invoiceData['banka'] ?? null;
            $invoice_r->other_expense = $invoiceData['other_expense'] ?? null;
            $invoice_r->other_expensea = $invoiceData['other_expensea'] ?? null;



            $invoice_r->pr_item = $invoiceData['item']["$i"] ?? null;
            $invoice_r->previous_stock = $invoiceData['pur_qty']["$i"] ?? null;
            $product = $invoiceData['item']["$i"];

            // if ($invoiceData['item']["$i"] != $invoiceData['pr_item']["$i"]) {


            //     products::where("product_id", $invoiceData['pr_item']["$i"])->update([
            //         'opening_quantity' => DB::raw("opening_quantity - " . $invoiceData['previous_stock']["$i"])
            //     ]);

            //     products::where("product_id", $invoiceData['item']["$i"])->update([
            //         'opening_quantity' => DB::raw("opening_quantity + " . $invoiceData['pur_qty']["$i"])
            //     ]);
            // }

            products::where("product_id", $invoiceData['pr_item']["$i"])->update([
                'opening_quantity' => DB::raw("opening_quantity - " . $invoiceData['previous_stock']["$i"])
            ]);

            products::where("product_id", $invoiceData['item']["$i"])->update([
                'opening_quantity' => DB::raw("opening_quantity + " . $invoiceData['pur_qty']["$i"])
            ]);

            products::where("product_id", $invoiceData['item']["$i"])->update([
                'opening_quantity' => DB::raw("opening_quantity - " . $invoiceData['return_qty']["$i"])
            ]);

            $invoice_r->return_qty =  $invoice_r->return_qty + $invoiceData['return_qty']["$i"] ?? null;

            $invoice_r->dis_amount = $invoiceData['dis_amount']["$i"] ?? null;
            $invoice_r->type = $invoiceData['type']["$i"] ?? null;
            $invoice_r->item = $invoiceData['item']["$i"] ?? 'error';
            $invoice_r->unit = $invoiceData['unit']["$i"] ?? null;
            $invoice_r->batch_no = $invoiceData['batch_no']["$i"] ?? null;
            $invoice_r->expiry = $invoiceData['expiry']["$i"] ?? null;
            $invoice_r->pur_qty = $invoiceData['pur_qty']["$i"] - $invoiceData['return_qty']["$i"] ?? null;
            $invoice_r->amount = $invoiceData['amount']["$i"] ?? null;
            $invoice_r->discount = $invoiceData['dis_per']["$i"] ?? null;
            $invoice_r->exp_unit = $invoiceData['exp_unit']["$i"] ?? null;
            $invoice_r->pur_price = $invoiceData['pur_price']["$i"] ?? null;
            $invoice_r->bonus_qty = $invoiceData['bonus_qty']["$i"] ?? null;

            $invoice_r->save();
        }

        $data = 'Invoices added successfully!';
        return response()->json($data);
    }
}
