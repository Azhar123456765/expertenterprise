<?php

namespace App\Http\Controllers;

use App\Models\chickenInvoice;
use App\Models\ChickInvoice;
use App\Models\feedInvoice;
use App\Models\ReceiptVoucher;
use Illuminate\Http\Request;

use App\Models\accounts;
use Illuminate\Support\Facades\DB;

use App\Models\buyer;
use App\Models\Income;
use App\Models\SaleInvoice;
use App\Models\seller;
use App\Models\sales_officer;


use App\Models\warehouse;

class ReceiptVoucherController extends Controller
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
        $count = ReceiptVoucher::whereIn('receipt_vouchers.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('receipt_vouchers')
                ->groupBy('unique_id');
        })->count();

        $data = compact('count');
        return view('vouchers.receipt')->with($data);
    }
    public function create_first()
    {
        $ReceiptVoucher = ReceiptVoucher::where("unique_id", 1)
            ->get();
        $sReceiptVoucher = ReceiptVoucher::where([

            "unique_id" => 1
        ])->first();
        $combinedInvoices = chickenInvoice::select(
            DB::raw("CONCAT('CH-', unique_id) as unique_id_name"),
            'unique_id' // Select the original unique_id as well
        )
            ->where('buyer', $sReceiptVoucher->company)
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
                    ->where('buyer', $sReceiptVoucher->company)
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
                    ->where('buyer', $sReceiptVoucher->company)
                    ->whereIn('feed_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('feed_invoices')
                            ->groupBy('unique_id');
                    })
            )
            ->get();

        if (count($ReceiptVoucher) > 0) {
            $data = compact('ReceiptVoucher', 'sReceiptVoucher', 'combinedInvoices');
            return view('vouchers.e_reciept')->with($data);
        } else {
            session()->flash('something_error', 'Voucher Not Found');
            return redirect()->back();
        }
    }
    public function create_last()
    {
        $count = ReceiptVoucher::whereIn('receipt_vouchers.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('receipt_vouchers')
                ->groupBy('unique_id');
        })->count();

        $ReceiptVoucher = ReceiptVoucher::where("unique_id", $count)
            ->get();
        $sReceiptVoucher = ReceiptVoucher::where([
            "unique_id" => $count
        ])->first();
        $combinedInvoices = chickenInvoice::select(
            DB::raw("CONCAT('CH-', unique_id) as unique_id_name"),
            'unique_id' // Select the original unique_id as well
        )
            ->where('buyer', $sReceiptVoucher->company)
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
                    ->where('buyer', $sReceiptVoucher->company)
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
                    ->where('buyer', $sReceiptVoucher->company)
                    ->whereIn('feed_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('feed_invoices')
                            ->groupBy('unique_id');
                    })
            )
            ->get();
        if (count($ReceiptVoucher) > 0) {
            $data = compact('ReceiptVoucher', 'sReceiptVoucher', 'combinedInvoices');
            return view('vouchers.e_reciept')->with($data);
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
        $invoiceData = $request->all();

        $lastChar = substr($request['company'], -1);

        // Check if the last character is a letter using ctype_alpha
        $income = new Income;
        $income->category_id = $invoiceData['unique_id'];
        $income->category = 'Receipt Voucher';
        $income->amount = $request['amount_total'];
        $income->save();



        $arrayLength = count(array_filter($invoiceData['narration']));

        for ($i = 0; $i < $arrayLength; $i++) {

            $invoice = new ReceiptVoucher;

            $invoice->sales_officer = $invoiceData['sales_officer'] ?? null;
            $invoice->farm = $invoiceData['farm'] ?? null;
            $company = $invoiceData['company'];
            $invoice->company = $company;


            $invoice_no = $invoiceData['invoice_no']["$i"] ?? null;
            $amount = $request['amount']["$i"];
            $amount_total = $request['amount_total'];
            $lastChar = substr($request['company'], -1);
            $invoice->company_ref = "B";
            $invoice->remark = $invoiceData['remark'] ?? null;
            $invoice->date = $invoiceData['date'] ?? null;
            $invoice->unique_id = $invoiceData['unique_id'] ?? null;
            $invoice->amount_total = $invoiceData['amount_total'] ?? null;

            $invoice->narration = $invoiceData['narration']["$i"] ?? null;
            $invoice->invoice_no = $invoiceData['invoice_no']["$i"] ?? null;
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
     * @param  \App\Models\ReceiptVoucher  $receiptVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(ReceiptVoucher $receiptVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReceiptVoucher  $receiptVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // $seller = seller::all();
        // $buyer = buyer::all();

        // $warehouse = warehouse::all();

        // $sales_officer = sales_officer::all();

        $ReceiptVoucher = ReceiptVoucher::where("unique_id", $id)->get();

        $sReceiptVoucher = ReceiptVoucher::where([
            "unique_id" => $id
        ])->first();

        $account = accounts::all();
        $combinedInvoices = chickenInvoice::select(
            DB::raw("CONCAT('CH-', unique_id) as unique_id_name"),
            'unique_id'  // Select the original unique_id as well
        )
            ->where('buyer', $sReceiptVoucher->company)
            ->whereIn('chicken_invoices.id', function ($subQuery) {
                $subQuery->select(DB::raw('MIN(id)'))
                    ->from('chicken_invoices')
                    ->groupBy('unique_id');
            })
            ->union(
                ChickInvoice::select(
                    DB::raw("CONCAT('C-', unique_id) as unique_id_name"),
                    'unique_id'  // Select the original unique_id as well
                )
                    ->where('buyer', $sReceiptVoucher->company)
                    ->whereIn('chick_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('chick_invoices')
                            ->groupBy('unique_id');
                    })
            )->union(
                feedInvoice::select(
                    DB::raw("CONCAT('F-', unique_id) as unique_id_name"),
                    'unique_id'  // Select the original unique_id as well
                )
                    ->where('buyer', $sReceiptVoucher->company)
                    ->whereIn('feed_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('feed_invoices')
                            ->groupBy('unique_id');
                    })
            )
            ->get();

        if (count($ReceiptVoucher) > 0) {
            $data = compact('account', 'ReceiptVoucher', 'sReceiptVoucher', 'combinedInvoices');
            return view('vouchers.e_reciept')->with($data);
        } else {
            return redirect()->route('receipt_voucher.create');
        }
        // $invoices = SaleInvoice::where('company', $company)->get();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReceiptVoucher  $receiptVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        ReceiptVoucher::where('unique_id', $id)->delete();

        Income::where('category_id', $id)->update([
            'amount' => $request['amount_total']
        ]);

        $invoiceData = $request->all();

        $arrayLength = count(array_filter($invoiceData['narration']));

        for ($i = 0; $i < $arrayLength; $i++) {

            $invoice = new ReceiptVoucher;

            $invoice->sales_officer = $invoiceData['sales_officer'] ?? null;
            $invoice->farm = $invoiceData['farm'] ?? null;
            $company = $invoiceData['company'];
            $invoice->company = $company;

            $lastChar = $request['company'];

            $invoice_no = $invoiceData['invoice_no']["$i"] ?? null;
            $amount = $request['amount']["$i"];
            $amount_total = $request['amount_total'];
            $invoice->company_ref = "B";
            $invoice->remark = $invoiceData['remark'] ?? null;
            $invoice->date = $invoiceData['date'] ?? null;
            $invoice->unique_id = $invoiceData['unique_id'] ?? null;
            $invoice->amount_total = $invoiceData['amount_total'] ?? null;

            $invoice->narration = $invoiceData['narration']["$i"] ?? null;
            $invoice->invoice_no = $invoiceData['invoice_no']["$i"] ?? null;
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReceiptVoucher  $receiptVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReceiptVoucher $receiptVoucher)
    {
        //
    }
}
