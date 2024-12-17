<?php

namespace App\Http\Controllers;

use App\Models\ExpenseVoucher;
use App\Models\accounts;
use App\Models\Narration;
use Illuminate\Support\Facades\DB;
use App\Models\users;
use App\Models\customization;
use App\Models\buyer;
use App\Models\Expense;
use App\Models\e_voucher;
use App\Models\SaleInvoice;
use App\Models\seller;
use App\Models\sales_officer;
use App\Models\product_sub_category;
use App\Models\product_category;
use App\Models\product_company;
use App\Models\product_type;
use App\Models\products;
use App\Models\warehouse;
use Illuminate\Http\Request;

class ExpenseVoucherController extends Controller
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
        $account = accounts::all();
        $narrations = Narration::all();
        $count = ExpenseVoucher::whereIn('expense_vouchers.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('expense_vouchers')
                ->groupBy('unique_id');
        })->count();

        $data = compact('account', 'count', 'narrations');
        return view('vouchers.expense')->with($data);
    }
    public function create_first()
    {
        $e_voucher = ExpenseVoucher::where("unique_id", 1)
            ->get();
        $se_voucher = ExpenseVoucher::where([

            "unique_id" => 1
        ])->first();

        $account = accounts::all();

        $data = compact('account', 'e_voucher', 'se_voucher');
        return view('vouchers.e_expense')->with($data);
    }
    public function create_last()
    {
        $count = ExpenseVoucher::whereIn('expense_vouchers.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('expense_vouchers')
                ->groupBy('unique_id');
        })->count();

        $e_voucher = ExpenseVoucher::where("unique_id", $count)
            ->get();
        $se_voucher = ExpenseVoucher::where([

            "unique_id" => $count
        ])->first();

        $account = accounts::all();

        $data = compact('account', 'e_voucher', 'se_voucher');
        return view('vouchers.e_expense')->with($data);
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

            $invoice = new ExpenseVoucher;

            $invoice->sales_officer = $invoiceData['sales_officer'] ?? null;
            $invoice->farm = $invoiceData['farm'] ?? null;
            $invoice->buyer = $company;
            $invoice->remark = $invoiceData['remark'] ?? null;
            $invoice->date = $invoiceData['date'] ?? null;

            $invoice->unique_id = $invoiceData['unique_id'] ?? null;
            $invoice->invoice_no = $invoiceData['invoice_no']["$i"] ?? null;

            $invoice->amount_total = $invoiceData['amount_total'] ?? null;
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
     * @param  \App\Models\ExpenseVoucher  $expenseVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseVoucher $expenseVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpenseVoucher  $expenseVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $e_voucher = ExpenseVoucher::where("unique_id", $id)
            ->get();
        $se_voucher = ExpenseVoucher::where([

            "unique_id" => $id
        ])->first();

        $account = accounts::all();

        $data = compact('account', 'e_voucher', 'se_voucher');
        return view('vouchers.e_expense')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseVoucher  $expenseVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        ExpenseVoucher::where('unique_id', $id)->delete();

        Expense::where('category_id', $id)->update([
            'amount' => $request['amount_total'],
            'company_id' => $request['company']
        ]);

        $invoiceData = $request->all();
        $company = $invoiceData['company'];
        $arrayLength = count(array_filter($invoiceData['narration']));

        for ($i = 0; $i < $arrayLength; $i++) {

            $invoice = new ExpenseVoucher;
            $invoice->invoice_no = $invoiceData['invoice_no']["$i"] ?? null;

            $invoice->unique_id = $invoiceData['unique_id'] ?? null;
            $invoice->sales_officer = $invoiceData['sales_officer'] ?? null;
            $invoice->farm = $invoiceData['farm'] ?? null;
            $invoice->buyer = $company ?? null;
            $invoice->remark = $invoiceData['remark'] ?? null;
            $invoice->date = $invoiceData['date'] ?? null;
            $invoice->narration = $invoiceData['narration']["$i"] ?? null;
            $invoice->cheque_no = $invoiceData['cheque_no']["$i"] ?? null;
            $invoice->cheque_date = $invoiceData['cheque_date']["$i"] ?? null;
            $invoice->cash_bank = $invoiceData['cash_bank']["$i"] ?? null;
            $invoice->amount = $invoiceData['amount']["$i"] ?? null;
            $invoice->ref_no = $invoiceData['ref_no'] ?? null;

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
     * @param  \App\Models\ExpenseVoucher  $expenseVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseVoucher $expenseVoucher)
    {
        //
    }
}
