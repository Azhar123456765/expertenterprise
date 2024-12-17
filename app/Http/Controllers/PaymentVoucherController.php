<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\users;
use App\Models\customization;
use App\Models\buyer;
use App\Models\Expense;
use App\Models\p_voucher;
use App\Models\SaleInvoice;
use App\Models\seller;
use App\Models\sales_officer;
use App\Models\product_sub_category;
use App\Models\product_category;
use App\Models\product_company;
use App\Models\product_type;
use App\Models\products;
use App\Models\warehouse;
use App\Models\accounts;
use App\Models\chickenInvoice;
use App\Models\ChickInvoice;
use App\Models\feedInvoice;

class PaymentVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $count = p_voucher::whereIn('payment_voucher.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('payment_voucher')
                ->groupBy('unique_id');
        })->count();

        $data = compact('count');
        return view('vouchers.payment')->with($data);
    }
    public function create_first()
    {
        $p_voucher = p_voucher::where("unique_id", 1)
            ->get();
        $sp_voucher = p_voucher::where([

            "unique_id" => 1
        ])->first();
        $combinedInvoices = chickenInvoice::select(
            DB::raw("CONCAT('CH-', unique_id) as unique_id_name"),
            'unique_id' // Select the original unique_id as well
        )
            ->where('seller', $sp_voucher->company)
            ->whereIn('chicken_invoices.id', function ($subQuery) {
                $subQuery->select(DB::raw('MIN(id)'))
                    ->from('chicken_invoices')
                    ->groupBy('unique_id');
            })
            ->union(
                ChickInvoice::select(
                    DB::raw("CONCAT('C-', unique_id) as unique_id_name"),
                    'unique_id' // Select the original unique_id as well
                )
                    ->where('seller', $sp_voucher->company)
                    ->whereIn('chick_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('chick_invoices')
                            ->groupBy('unique_id');
                    })
            )->union(
                feedInvoice::select(
                    DB::raw("CONCAT('F-', unique_id) as unique_id_name"),
                    'unique_id' // Select the original unique_id as well
                )
                    ->where('seller', $sp_voucher->company)
                    ->whereIn('feed_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('feed_invoices')
                            ->groupBy('unique_id');
                    })
            )
            ->get();
        if (count($p_voucher) > 0) {
            $data = compact('p_voucher', 'sp_voucher', 'combinedInvoices');
            return view('vouchers.e_payment')->with($data);
        } else {
            session()->flash('something_error', 'Voucher Not Found');
            return redirect()->back();
        }
    }
    public function create_last()
    {
        $count = p_voucher::whereIn('payment_voucher.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('payment_voucher')
                ->groupBy('unique_id');
        })->count();

        $p_voucher = p_voucher::where("unique_id", $count)
            ->get();
        $sp_voucher = p_voucher::where([

            "unique_id" => $count
        ])->first();
        $combinedInvoices = chickenInvoice::select(
            DB::raw("CONCAT('CH-', unique_id) as unique_id_name"),
            'unique_id' // Select the original unique_id as well
        )
            ->where('seller', $sp_voucher->company)
            ->whereIn('chicken_invoices.id', function ($subQuery) {
                $subQuery->select(DB::raw('MIN(id)'))
                    ->from('chicken_invoices')
                    ->groupBy('unique_id');
            })
            ->union(
                ChickInvoice::select(
                    DB::raw("CONCAT('C-', unique_id) as unique_id_name"),
                    'unique_id' // Select the original unique_id as well
                )
                    ->where('seller', $sp_voucher->company)
                    ->whereIn('chick_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('chick_invoices')
                            ->groupBy('unique_id');
                    })
            )->union(
                feedInvoice::select(
                    DB::raw("CONCAT('F-', unique_id) as unique_id_name"),
                    'unique_id' // Select the original unique_id as well
                )
                    ->where('seller', $sp_voucher->company)
                    ->whereIn('feed_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('feed_invoices')
                            ->groupBy('unique_id');
                    })
            )
            ->get();
        if (count($p_voucher) > 0) {
            $data = compact('p_voucher', 'sp_voucher', 'combinedInvoices');
            return view('vouchers.e_payment')->with($data);
        } else {
            session()->flash('something_error', 'Voucher Not Found');
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
        // dd($request);
        $invoiceData = $request->all();
        $lastChar = $request['company'];

        $expense = new Expense;
        $expense->category_id = $invoiceData['unique_id'];
        $expense->category = 'Payment Voucher';
        $expense->company_id = $invoiceData['company'];
        $expense->company_ref = $lastChar;
        $expense->amount = $request['amount_total'];
        $expense->save();

        $company = $request['company'];


        $amount = $request['amount_total'];


        $arrayLength = count(array_filter($invoiceData['narration']));

        for ($i = 0; $i < $arrayLength; $i++) {

            $invoice = new p_voucher;

            $invoice->sales_officer = $invoiceData['sales_officer'] ?? null;
            $invoice->farm = $invoiceData['farm'] ?? null;
            $invoice->company = $company;
            $invoice->remark = $invoiceData['remark'] ?? null;
            $invoice->pkr_amount = $invoiceData['pkr_amount'] ?? null;
            $invoice->date = $invoiceData['date'] ?? null;
            $invoice->bilty_no = $invoiceData['bilty_no'] ?? null;
            $invoice->warehouse = $invoiceData['warehouse'] ?? null;
            $invoice->invoice_no = $invoiceData['invoice_no']["$i"] ?? null;


            $invoice->book = $invoiceData['book'] ?? null;
            $invoice->due_date = $invoiceData['due_date'] ?? null;
            $invoice->transporter = $invoiceData['transporter'] ?? null;
            $invoice->unique_id = $invoiceData['unique_id'] ?? null;

            $invoice->previous_balance = $invoiceData['previous_balance'] ?? null;
            $invoice->cartage = $invoiceData['cartage'] ?? null;
            $invoice->grand_total = $invoiceData['grand_total'] ?? null;
            $invoice->amount_paid = $invoiceData['amount_paid'] ?? null;
            $invoice->balance_amount = $invoiceData['balance_amount'] ?? null;

            $invoice->qty_total = $invoiceData['qty_total'] ?? null;
            $invoice->dis_total = $invoiceData['dis_total'] ?? null;
            $invoice->amount_total = $invoiceData['amount_total'] ?? null;
            $invoice->company_ref = "B";
            $invoice->narration = $invoiceData['narration']["$i"] ?? null;
            $invoice->cheque_no = $invoiceData['cheque_no']["$i"] ?? null;
            $invoice->cheque_date = $invoiceData['cheque_date']["$i"] ?? null;
            $invoice->cash_bank = $invoiceData['cash_bank']["$i"] ?? null;
            $invoice->amount = $invoiceData['amount']["$i"] ?? null;
            $invoice->ref_no = $invoiceData['ref_no'] ?? null;
            $image = $request->file('attachment');
            if ($image) {
                $attachmentPath = $image->store('attachments');
            } else {
                $attachmentPath = $request->input('old_attachment');
            }

            $invoice->attachment = $attachmentPath;
            $invoice->save();
        }

        $data = 'Voucher added successfully!';
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
    public function edit(Request $request, $id)
    {

        $p_voucher = p_voucher::where("unique_id", $id)
            ->get();
        $sp_voucher = p_voucher::where([

            "unique_id" => $id
        ])->first();
        if (count($p_voucher) > 0) {
        $account = accounts::all();
        $combinedInvoices = chickenInvoice::select(
            DB::raw("CONCAT('CH-', unique_id) as unique_id_name"),
            'unique_id' // Select the original unique_id as well
        )
            ->where('seller', $sp_voucher->company)
            ->whereIn('chicken_invoices.id', function ($subQuery) {
                $subQuery->select(DB::raw('MIN(id)'))
                    ->from('chicken_invoices')
                    ->groupBy('unique_id');
            })
            ->union(
                ChickInvoice::select(
                    DB::raw("CONCAT('C-', unique_id) as unique_id_name"),
                    'unique_id' // Select the original unique_id as well
                )
                    ->where('seller', $sp_voucher->company)
                    ->whereIn('chick_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('chick_invoices')
                            ->groupBy('unique_id');
                    })
            )->union(
                feedInvoice::select(
                    DB::raw("CONCAT('F-', unique_id) as unique_id_name"),
                    'unique_id' // Select the original unique_id as well
                )
                    ->where('seller', $sp_voucher->company)
                    ->whereIn('feed_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('feed_invoices')
                            ->groupBy('unique_id');
                    })
            )
            ->get();
       
            $data = compact('account', 'p_voucher', 'sp_voucher', 'combinedInvoices');
            return view('vouchers.e_payment')->with($data);
        } else {
            session()->flash('something_error', 'Voucher Not Found');
            return redirect()->back();
        }
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
        p_voucher::where('unique_id', $id)->delete();

        Expense::where('category_id', $id)->update([
            'amount' => $request['amount_total'],
            'company_id' => $request['company']
        ]);

        $invoiceData = $request->all();
        $company = $invoiceData['company'];
        $arrayLength = count(array_filter($invoiceData['narration']));

        for ($i = 0; $i < $arrayLength; $i++) {

            $invoice = new p_voucher;
            $invoice->invoice_no = $invoiceData['invoice_no']["$i"] ?? null;

            $invoice->unique_id = $invoiceData['unique_id'] ?? null;
            $invoice->sales_officer = $invoiceData['sales_officer'] ?? null;
            $invoice->farm = $invoiceData['farm'] ?? null;
            $invoice->company = $company ?? null;
            $invoice->remark = $invoiceData['remark'] ?? null;
            $invoice->date = $invoiceData['date'] ?? null;
            $invoice->narration = $invoiceData['narration']["$i"] ?? null;
            $invoice->cheque_no = $invoiceData['cheque_no']["$i"] ?? null;
            $invoice->cheque_date = $invoiceData['cheque_date']["$i"] ?? null;
            $invoice->cash_bank = $invoiceData['cash_bank']["$i"] ?? null;
            $invoice->amount = $invoiceData['amount']["$i"] ?? null;
            $invoice->ref_no = $invoiceData['ref_no'] ?? null;

            $lastChar = $request['company'];
            $invoice->company_ref = "B";
            $invoice->amount_total = $invoiceData['amount_total'] ?? null;
            $image = $request->file('attachment');
            if ($image) {
                $attachmentPath = $image->store('attachments');
            } else {
                $attachmentPath = $request->input('old_attachment');
            }
            $invoice->attachment = $attachmentPath;

            $invoice->save();
        }

        $data = 'Voucher added successfully!';
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
}
