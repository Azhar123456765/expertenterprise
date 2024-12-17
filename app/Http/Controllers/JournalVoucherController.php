<?php

namespace App\Http\Controllers;

use App\Models\JournalVoucher;
use App\Models\accounts;
use App\Models\Narration;
use Illuminate\Support\Facades\DB;
use App\Models\users;
use App\Models\customization;
use App\Models\buyer;
use App\Models\Expense;
use App\Models\j_voucher;
use App\Models\SaleInvoice;
use App\Models\seller;
use App\Models\sales_officer;
use App\Models\product_sub_category;
use App\Models\product_category;
use App\Models\product_company;
use App\Models\product_type;
use App\Models\products;
use App\Models\warehouse;
use App\Models\chickenInvoice;
use App\Models\ChickInvoice;
use App\Models\feedInvoice;

use Illuminate\Http\Request;

class JournalVoucherController extends Controller
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
        $count = JournalVoucher::whereIn('journal_vouchers.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('journal_vouchers')
                ->groupBy('unique_id');
        })->count();

        $data = compact('account', 'count', 'narrations');
        return view('vouchers.journal')->with($data);
    }
    public function create_first()
    {
        $j_voucher = JournalVoucher::where("unique_id", 1)
            ->get();
        $sj_voucher = JournalVoucher::where([

            "unique_id" => 1
        ])->first();

        $account = accounts::all();

        $combinedInvoices = chickenInvoice::select(
            DB::raw("CONCAT('CH-', unique_id) as unique_id_name"),
            'unique_id' // Select the original unique_id as well
        )
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
                    ->whereIn('feed_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('feed_invoices')
                            ->groupBy('unique_id');
                    })
            )
            ->get();
        // dd($sj_voucher);
        if (count($j_voucher) > 0) {
            $data = compact('account', 'j_voucher', 'sj_voucher', 'combinedInvoices');
            return view('vouchers.e_journal')->with($data);
        } else {
            // return redirect
        }
    }
    public function create_last()
    {
        $count = JournalVoucher::whereIn('journal_vouchers.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('journal_vouchers')
                ->groupBy('unique_id');
        })->count();
        $j_voucher = JournalVoucher::where("unique_id", $count)
            ->get();
        $sj_voucher = JournalVoucher::where([

            "unique_id" => $count
        ])->first();

        $account = accounts::all();
        $combinedInvoices = chickenInvoice::select(
            DB::raw("CONCAT('CH-', unique_id) as unique_id_name"),
            'unique_id' // Select the original unique_id as well
        )
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
                    ->whereIn('feed_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('feed_invoices')
                            ->groupBy('unique_id');
                    })
            )
            ->get();
        // dd($sj_voucher);
        if (count($j_voucher) > 0) {
            $data = compact('account', 'j_voucher', 'sj_voucher', 'combinedInvoices');
            return view('vouchers.e_journal')->with($data);
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
        $invoiceData = $request->all();
        $lastChar = $request['company'];

        // $expense = new Expense;
        // $expense->category_id = $invoiceData['unique_id'];
        // $expense->category = 'Payment Voucher';
        // $expense->company_id = $invoiceData['company'];
        // $expense->company_ref = $lastChar;
        // $expense->amount = $request['amount_total'];
        // $expense->save();

        $company = $request['company'];


        $amount = $request['amount_total'];


        $arrayLength = count(array_filter($invoiceData['narration']));

        for ($i = 0; $i < $arrayLength; $i++) {

            $invoice = new JournalVoucher;

            $invoice->sales_officer = $invoiceData['sales_officer'] ?? null;
            $invoice->buyer = $company ?? null;
            $invoice->remark = $invoiceData['remark'] ?? null;
            $invoice->date = $invoiceData['date'] ?? null;

            $invoice->unique_id = $invoiceData['unique_id'] ?? null;

            $invoice->invoice_no = $invoiceData['invoice_no']["$i"] ?? null;
            $invoice->status = $invoiceData['status']["$i"] ?? null;

            $invoice->amount_total = $invoiceData['amount_total'] ?? null;
            $invoice->narration = $invoiceData['narration']["$i"] ?? null;
            $invoice->farm = $invoiceData['farm']["$i"] ?? null;
            $invoice->cheque_no = $invoiceData['cheque_no']["$i"] ?? null;
            $invoice->cheque_date = $invoiceData['cheque_date']["$i"] ?? null;
            $invoice->from_account = $invoiceData['from_account']["$i"] ?? null;
            $invoice->to_account = $invoiceData['to_account']["$i"] ?? null;
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
     * @param  \App\Models\JournalVoucher  $expenseVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(JournalVoucher $expenseVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JournalVoucher  $expenseVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $j_voucher = JournalVoucher::where("unique_id", $id)
            ->get();
        $sj_voucher = JournalVoucher::where([

            "unique_id" => $id
        ])->first();

        $account = accounts::all();
        $combinedInvoices = chickenInvoice::select(
            DB::raw("CONCAT('CH-', unique_id) as unique_id_name"),
            'unique_id' // Select the original unique_id as well
        )
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
                    ->whereIn('feed_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('feed_invoices')
                            ->groupBy('unique_id');
                    })
            )
            ->get();
        // dd($sj_voucher);
        if (count($j_voucher) > 0) {
            $data = compact('account', 'j_voucher', 'sj_voucher', 'combinedInvoices');
            return view('vouchers.e_journal')->with($data);
        } else {
            session()->flash('something_error', 'Voucher Not Found');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JournalVoucher  $expenseVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $invoiceData = $request->all();
        // dd($request->all());
        JournalVoucher::where('unique_id', $id)->delete();

        // Expense::where('category_id', $id)->update([
        //     'amount' => $request['amount_total'],
        //     'company_id' => $request['company']
        // ]);


        // $company = $invoiceData['company'] ?? null;
        $arrayLength = count(array_filter($invoiceData['narration']));

        for ($i = 0; $i < $arrayLength; $i++) {

            $invoice = new JournalVoucher;

            $invoice->unique_id = $invoiceData['unique_id'] ?? null;
            $invoice->sales_officer = $invoiceData['sales_officer'] ?? null;
            $invoice->buyer = $company ?? null;
            $invoice->remark = $invoiceData['remark'] ?? null;
            $invoice->date = $invoiceData['date'] ?? null;
            $invoice->narration = $invoiceData['narration']["$i"] ?? null;
            $invoice->farm = $invoiceData['farm']["$i"] ?? null;
            $invoice->cheque_no = $invoiceData['cheque_no']["$i"] ?? null;
            $invoice->cheque_date = $invoiceData['cheque_date']["$i"] ?? null;
            $invoice->from_account = $invoiceData['from_account']["$i"] ?? null;
            $invoice->to_account = $invoiceData['to_account']["$i"] ?? null;
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

            $invoice->invoice_no = $invoiceData['invoice_no']["$i"] ?? null;
            $invoice->status = $invoiceData['status']["$i"] ?? null;
            $invoice->save();
        }

        $data = 'Voucher added successfully!';
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JournalVoucher  $expenseVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(JournalVoucher $expenseVoucher)
    {
        //
    }
}
