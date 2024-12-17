<?php

namespace App\Http\Controllers;

use App\Models\chickenInvoice;
use App\Models\ChickInvoice;
use App\Models\ExpenseVoucher;
use App\Models\Farm;
use App\Models\FarmDailyReport;
use App\Models\FarmingPeriod;
use App\Models\feedInvoice;
use App\Models\JournalVoucher;
use App\Models\HeadAccount;
use App\Models\SubHeadAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;

use App\Models\users;
use App\Models\customization;
use App\Models\buyer;
use App\Models\seller;

use App\Models\sales_officer;
use App\Models\accounts;
use App\Models\p_voucher;
use App\Models\products;
use App\Models\ReceiptVoucher;
use App\Models\purchase_invoice;
use App\Models\purchase_return;
use App\Models\sale_return;
use App\Models\SaleInvoice;
use App\Models\zone;
use App\Models\warehouse;
use Illuminate\Support\Facades\DB;
use PurchaseInvoice;

class pdfController extends Controller
{


        // public function test_pdf(Request $post)
        // {

        //         return view('pdf.head_pdf');
        // }


        public function farm_report(Request $request)
        {
                $startDate = Carbon::parse($request->input('start_date'));
                $endDate = Carbon::parse($request->input('end_date'));
                $farm_id = $request->input('farm');
                if ($farm_id) {
                        $farm = Farm::where('id', $farm_id)->first();
                } else {
                        $farm = null;
                }
                $salary = accounts::where('account_category', 9)->pluck('id');
                $rent = accounts::where('account_category', 10)->pluck('id');
                $utility = accounts::where('account_category', 11)->pluck('id');

                $salaryAccounts = accounts::where('account_category', 9)->get();
                $rentAccounts = accounts::where('account_category', 10)->get();
                $utilityAccounts = accounts::where('account_category', 11)->get();
                // $customer = $request->input('customer');
                // $salesOfficer = $request->input('sales_officer');
                // $warehouse = $request->input('warehouse');
                // $product_category = $request->input('product_category');
                // $product_company = $request->input('product_company');
                // $product = $request->input('product');
                // $product_id = null;

                // $daily_reports = FarmDailyReport::whereBetween('date', [$startDate, $endDate])
                //         ->whereHas('farmingPeriod', function ($query) {
                //                 $query->whereRaw('farm_daily_reports.date BETWEEN farming_periods.start_date AND farming_periods.end_date');
                //         })
                //         ->get();

                // dd($daily_reports);
                // $daily_reports = FarmDailyReport::join('farming_periods', 'farm_daily_reports.farm_id', '=', 'farming_periods.farm_id')
                // ->whereBetween('date', [$startDate, $endDate])
                // ->select('farm_daily_reports.*', 'farming_periods.start_date', 'farming_periods.end_date')
                // ->get()
                // ->groupBy('farming_periods.id');
                $formattedStartDate = Carbon::parse($startDate)->format('d-m-Y');
                $formattedEndDate = Carbon::parse($endDate)->format('d-m-Y');

                $daily_reports = FarmDailyReport::whereBetween('date', [$formattedStartDate, $formattedEndDate]);

                if ($farm) {
                        $daily_reports->where('farm', $farm_id);
                }

                $chickenInvoice = chickenInvoice::whereBetween('date', [$startDate, $endDate]);

                if ($farm) {
                        $chickenInvoice->where('farm', $farm_id);
                }

                $chickInvoice = chickInvoice::whereBetween('date', [$startDate, $endDate]);

                if ($farm) {
                        $chickInvoice->where('farm', $farm_id);
                }

                $feedInvoice = feedInvoice::whereBetween('date', [$startDate, $endDate]);

                if ($farm) {
                    $feedInvoice->where(function ($query) use ($farm_id) {
                        $query->where('farm', $farm_id)
                              ->orWhere('supply_farm', $farm_id);
                    });
                }
                
                $payment_voucher = p_voucher::whereBetween('date', [$startDate, $endDate]);

                if ($farm) {
                        $payment_voucher->where('farm', $farm_id);
                }


                $receipt_voucher = ReceiptVoucher::whereBetween('date', [$startDate, $endDate]);

                if ($farm) {
                        $receipt_voucher->where('farm', $farm_id);
                }

                $expense_voucher = ExpenseVoucher::whereBetween('date', [$startDate, $endDate]);

                if ($farm) {
                        $expense_voucher->where('farm', $farm_id);
                }
                $journal_voucher = JournalVoucher::whereBetween('date', [$startDate, $endDate]);

                if ($farm) {
                        $journal_voucher->where('farm', $farm_id);
                }
               

                $daily_reports = $daily_reports->orderBy('date', 'asc')->get();
                $chickenInvoice = $chickenInvoice->orderBy('date', 'asc')->get();
                $chickInvoice = $chickInvoice->orderBy('date', 'asc')->get();
                $feedInvoice = $feedInvoice->orderBy('date', 'asc')->get();

                $chickInvoiceNum = $chickInvoice->pluck('unique_id')->toArray();
                $feedInvoiceNum = $feedInvoice->pluck('unique_id')->toArray();
        
                $chickInvoiceNum = array_map(fn($number) => 'C-' . $number, $chickInvoiceNum);
                $feedInvoiceNum = array_map(fn($number) => 'F-' . $number, $feedInvoiceNum);
                
                $payment_voucher = $payment_voucher->whereIn('invoice_no', $chickInvoiceNum)->orwhereIn('invoice_no', $feedInvoiceNum)->orderBy('date', 'asc')->get();

                $receipt_voucher = $receipt_voucher->orderBy('date', 'asc')->get();
                $expense_voucher = $expense_voucher->orderBy('date', 'asc')->get();
                $journal_voucher = $journal_voucher->orderBy('date', 'asc')->get();

                // $vc_salary = $ex_vc->whereIn('cash_bank', $salary)->get();
                // $vc_rent = $ex_vc->whereIn('cash_bank', $rent)->get();
                // $vc_utility = $ex_vc->whereIn('cash_bank', $utility)->get();
                
                $data = [
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'single_data' => $single_data ?? null,
                        'chickenInvoice' => $chickenInvoice,
                        'chickInvoice' => $chickInvoice,
                        'feedInvoice' => $feedInvoice,
                        'payment_voucher' => $payment_voucher,
                        'receipt_voucher' => $receipt_voucher,
                        'expense_voucher' => $expense_voucher,
                        'journal_voucher' => $journal_voucher,
                        'daily_reports' => $daily_reports,

                        'salary' => $salary,
                        'rent' => $rent,
                        'utility' => $utility,

                        'salaryAccounts' => $salaryAccounts,
                        'rentAccounts' => $rentAccounts,
                        'utilityAccounts' => $utilityAccounts,

                        'farm' => $farm,
                        'account' => $account->reference_id ?? null,
                ];

                session()->flash('Data', $data);


                if (session()->has('Data')) {

                        $views = 'Customer Report';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.farm.farm_report')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();
                        session()->forget('Data');

                        return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
                }
        }


        public function farm_daily_report(Request $request)
        {
                $startDate = Carbon::parse($request->input('start_date'));
                $endDate = Carbon::parse($request->input('end_date'));
                $farm_id = $request->input('farm');
                if ($farm_id) {
                        $farm = Farm::where('id', $farm_id)->first();
                        $FarmingPeriod = FarmingPeriod::where('farm_id', $farm_id)->get();
                        $FarmingDailyReport = FarmDailyReport::get();

                } else {
                        $farm = null;
                        $FarmingPeriod = FarmingPeriod::all();
                        $FarmingDailyReport = FarmDailyReport::get();
                }

                $data = [
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'farm' => $farm ?? null,
                        'farm_id' => $farm_id,
                        'FarmingPeriod' => $FarmingPeriod,
                        'FarmingDailyReport' => $FarmingDailyReport,
                ];

                session()->flash('Data', $data);


                if (session()->has('Data')) {

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.farm.farm_daily_report')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();
                        session()->forget('Data');

                        return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
                }
        }
        // {
        //         if (!session()->exists('Data')) {

        //                 $farm_id = $request->input('farm');
        //                 if ($farm_id) {
        //                         $farm = Farm::where('id', $farm_id)->first();
        //                 } else {
        //                         $farm = null;
        //                 }
        //                 $startDate = Carbon::parse($request->input('start_date'));
        //                 $endDate =Carbon::parse($request->input('end_date'))-

        //                 $expense_sub_heads = SubHeadAccount::where('head', 5)->get();
        //                 $expense_sub_heads_ids = SubHeadAccount::where('head', 5)->pluck('id');
        //                 $expense_accounts = accounts::whereIn('account_category', $expense_sub_heads_ids)->get();
        //                 // dd($expense_accounts);
        //                 $chickenInvoice = chickenInvoice::whereBetween('date', [$startDate, $endDate]);

        //                 if ($farm) {
        //                         $chickenInvoice->where('farm', $farm_id);
        //                 }

        //                 $chickInvoice = chickInvoice::whereBetween('date', [$startDate, $endDate]);

        //                 if ($farm) {
        //                         $chickInvoice->where('farm', $farm_id);
        //                 }

        //                 $feedInvoice = feedInvoice::whereBetween('date', [$startDate, $endDate]);

        //                 if ($farm) {
        //                         $feedInvoice->where('farm', $farm_id);
        //                 }

        //                 $payment_voucher = p_voucher::whereBetween('date', [$startDate, $endDate]);

        //                 if ($farm) {
        //                         $payment_voucher->where('farm', $farm_id);
        //                 }


        //                 $receipt_voucher = ReceiptVoucher::whereBetween('date', [$startDate, $endDate]);

        //                 if ($farm) {
        //                         $receipt_voucher->where('farm', $farm_id);
        //                 }

        //                 $expense_voucher = ExpenseVoucher::whereBetween('date', [$startDate, $endDate]);

        //                 if ($farm) {
        //                         $expense_voucher->where('farm', $farm_id);
        //                 }
        //                 $chickenInvoice = $chickenInvoice->orderBy('date', 'asc')->get();
        //                 $chickInvoice = $chickInvoice->orderBy('date', 'asc')->get();
        //                 $feedInvoice = $feedInvoice->orderBy('date', 'asc')->get();
        //                 $payment_voucher = $payment_voucher->orderBy('date', 'asc')->get();
        //                 $receipt_voucher = $receipt_voucher->orderBy('date', 'asc')->get();
        //                 $expense_voucher = $expense_voucher->orderBy('date', 'asc')->get();

        //                 $chickenInvoice = $chickenInvoice->groupBy('unique_id')->map(function ($group) {
        //                         $description = $group->map(function ($item) {
        //                                 return $item->product->product_name;
        //                         })->join(', ');

        //                         $groupedData = new \stdClass();
        //                         $groupedData->date = $group->first()->date;
        //                         $groupedData->unique_id = $group->first()->unique_id;
        //                         $groupedData->description = $description;
        //                         $groupedData->seller = $group->first()->seller;
        //                         $groupedData->buyer = $group->first()->buyer;
        //                         $groupedData->sale_amount_total = $group->first()->sale_amount_total;
        //                         $groupedData->amount_total = $group->first()->amount_total;

        //                         return $groupedData;
        //                 });
        //                 $chickInvoice = $chickInvoice->groupBy('unique_id')->map(function ($group) {
        //                         $description = $group->map(function ($item) {
        //                                 return $item->product->product_name;
        //                         })->join(', ');

        //                         $groupedData = new \stdClass();
        //                         $groupedData->date = $group->first()->date;
        //                         $groupedData->unique_id = $group->first()->unique_id;
        //                         $groupedData->description = $description;
        //                         $groupedData->seller = $group->first()->seller;
        //                         $groupedData->buyer = $group->first()->buyer;
        //                         $groupedData->sale_amount_total = $group->first()->sale_amount_total;
        //                         $groupedData->amount_total = $group->first()->amount_total;

        //                         return $groupedData;
        //                 });
        //                 $feedInvoice = $feedInvoice->groupBy('unique_id')->map(function ($group) {
        //                         $description = $group->map(function ($item) {
        //                                 return $item->product->product_name;
        //                         })->join(', ');

        //                         $groupedData = new \stdClass();
        //                         $groupedData->date = $group->first()->date;
        //                         $groupedData->unique_id = $group->first()->unique_id;
        //                         $groupedData->description = $description;
        //                         $groupedData->seller = $group->first()->seller;
        //                         $groupedData->buyer = $group->first()->buyer;
        //                         $groupedData->qty_total = $group->first()->qty_total;
        //                         $groupedData->sale_qty_total = $group->first()->sale_qty_total;
        //                         $groupedData->sale_amount_total = $group->first()->sale_amount_total;
        //                         $groupedData->amount_total = $group->first()->amount_total;

        //                         return $groupedData;
        //                 });
        //                 // $payment_voucher = $payment_voucher->groupBy('unique_id')->map(function ($group) {
        //                 //         $description = $group->map(function ($item) {
        //                 //                 return $item->narration;
        //                 //         })->join(', ');

        //                 //         $groupedData = new \stdClass();
        //                 //         $groupedData->date = $group->first()->date;
        //                 //         $groupedData->unique_id = $group->first()->unique_id;
        //                 //         $groupedData->narration = $description;
        //                 //         $groupedData->company = $group->first()->company;
        //                 //         $groupedData->amount_total = $group->first()->amount;

        //                 //         return $groupedData;
        //                 // });

        //                 // dd($feedInvoiceGrouped);

        //                 $data = [
        //                         'startDate' => $startDate,
        //                         'endDate' => $endDate,
        //                         'single_data' => $single_data ?? null,
        //                         'chickenInvoice' => $chickenInvoice,
        //                         'chickInvoice' => $chickInvoice,
        //                         'feedInvoice' => $feedInvoice,
        //                         'payment_voucher' => $payment_voucher,
        //                         'receipt_voucher' => $receipt_voucher,
        //                         'expense_voucher' => $expense_voucher,
        //                         'farm' => $farm,
        //                         'account' => $account->reference_id ?? null,
        //                 ];
        //                 session()->flash('Data', $data);



        //         }

        //         if (session()->has('Data')) {

        //                 $views = 'General Ledger';

        //                 $pdf = new Dompdf();

        //                 $data = compact('pdf');
        //                 $html = view('pdf.farm.farm_report')->render();

        //                 $pdf->loadHtml($html);


        //                 $contentLength = strlen($html);
        //                 if ($contentLength > 5000) {
        //                         $pdf->setPaper('A3', 'portrait');
        //                 } else {
        //                         $pdf->setPaper('A4', 'portrait');
        //                 }
        //                 $pdf->render();

        //                 session()->forget('Data');

        //                 return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
        //         }
        // }

        public function gen_led(Request $request)
        {


                if (!session()->exists('Data')) {
// dd($request->all());
$startDate = Carbon::parse($request->input('start_date'))->startOfDay()->format('Y-m-d');
$endDate = Carbon::parse($request->input('end_date'))->endOfDay()->format('Y-m-d');

                        $type = $request->input('type');

                        // dd($all_accounts);
                        $head_account = $request->input('head_account');
                        $sub_head_account = $request->input('sub_head_account');
                        $all_accounts = [];
                        if($head_account){
                                $head_account = HeadAccount::where('id', $head_account)->first();
                        }

                        if($sub_head_account){
                                $all_accounts = accounts::where('account_category', $sub_head_account)->get();
                                $sub_head_account = SubHeadAccount::where('id', $sub_head_account)->get();
                        }elseif($head_account){
                                $sub_head_account = SubHeadAccount::whereIn('head', $head_account)->get();
                                $all_accounts = accounts::whereIn('account_category', $sub_head_account->pluck('id'))->get();
                        }
                        $jv_check = $request->input('jv');
                        $pv_check = $request->input('pv');
                        $rv_check = $request->input('rv');
                        $ev_check = $request->input('ev');
                        $chi_check = $request->input('chi');
                        $ci_check = $request->input('ci');
                        $fi_check = $request->input('fi');

                        $id = $request->input('account');                        // dd($id);
                        if ($id) {
                            $account = accounts::where('id', $id)->first();
                        } else {
                                $account = null;
                        }
                        $salesOfficer = $request->input('sales_officer');
                        // $accountType = $request->input('account_type');
                        // $zone = $request->input('warehouse');
                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));


                        if ($type == 1 || $type == 2) {

                                if(isset($chi_check)){
                                        $chickenInvoice = chickenInvoice::whereBetween('date', [$startDate, $endDate]);
                                        
                                        if ($account) {
                                            $chickenInvoice->where(function($query)use($account){
                                                $query->where('buyer', $account->reference_id)->orWhere('seller', $account->reference_id);
                                        });
                                        }
                                        if ($salesOfficer) {
                                                $chickenInvoice->where('sales_officer', $salesOfficer);
                                        }
                                $chickenInvoice = $chickenInvoice->orderBy('date', 'asc')->get();
                                $chickenInvoice = $chickenInvoice->groupBy('unique_id')->map(function ($group) {
                                        $description = $group->map(function ($item) {
                                                return $item->product->product_name;
                                        })->join(', ');
                                        $sale_amount_rv = ReceiptVoucher::where('invoice_no', 'CH-' . $group->first()->unique_id)->sum('amount');
                                        $sale_amount_pv = P_voucher::where('invoice_no', 'CH-' . $group->first()->unique_id)->sum('amount');
                                        $groupedData = new \stdClass();
                                        $groupedData->date = $group->first()->date;
                                        $groupedData->unique_id = $group->first()->unique_id;
                                        $groupedData->description = $description;
                                        $groupedData->seller = $group->first()->seller;
                                        $groupedData->buyer = $group->first()->buyer;
                                        $groupedData->sale_amount_total = $group->first()->sale_amount_total;
                                        $groupedData->amount_total = $group->first()->amount_total;

                                        return $groupedData;
                                });
                                }

                                if(isset($ci_check)){
                                        $chickInvoice = chickInvoice::whereBetween('date', [$startDate, $endDate]);

                                if ($account) {
                                        $chickInvoice->where(function($query)use($account){
                                                $query->where('buyer', $account->reference_id)->orWhere('seller', $account->reference_id);
                                        });
                                }
                                if ($salesOfficer) {
                                        $chickInvoice->where('sales_officer', $salesOfficer);
                                }
                                $chickInvoice = $chickInvoice->orderBy('date', 'asc')->get();
                                $chickInvoice = $chickInvoice->groupBy('unique_id')->map(function ($group) {
                                        $description = $group->map(function ($item) {
                                                return $item->product->product_name;
                                        })->join(', ');
                                        $sale_amount_rv = ReceiptVoucher::where('invoice_no', 'C-' . $group->first()->unique_id)->sum('amount');
                                        $sale_amount_pv = P_voucher::where('invoice_no', 'C-' . $group->first()->unique_id)->sum('amount');
                                        $groupedData = new \stdClass();
                                        $groupedData->date = $group->first()->date;
                                        $groupedData->unique_id = $group->first()->unique_id;
                                        $groupedData->description = $description;
                                        $groupedData->seller = $group->first()->seller;
                                        $groupedData->buyer = $group->first()->buyer;
                                        $groupedData->qty_total = $group->first()->qty_total;
                                        $groupedData->sale_qty_total = $group->first()->sale_qty_total;
                                        $groupedData->sale_amount_total = $group->first()->sale_amount_total;
                                        $groupedData->amount_total = $group->first()->amount_total;

                                        return $groupedData;
                                });
                        }

                        if(isset($fi_check)){

                                $feedInvoice = feedInvoice::whereBetween('date', [$startDate, $endDate]);

                                if ($account) {
                                        $feedInvoice->where(function($query)use($account){
                                                $query->where('buyer', $account->reference_id)->orWhere('seller', $account->reference_id);
                                        });
                                }
                                if ($salesOfficer) {
                                        $feedInvoice->where('sales_officer', $salesOfficer);
                                }
                                $feedInvoice = $feedInvoice->orderBy('date', 'asc')->get();

                                $feedInvoice = $feedInvoice->groupBy('unique_id')->map(function ($group) {
                                        $description = $group->map(function ($item) {
                                                return $item->product->product_name;
                                        })->join(', ');
                                        $sale_amount_rv = ReceiptVoucher::where('invoice_no', 'F-' . $group->first()->unique_id)->sum('amount');
                                        $sale_amount_pv = P_voucher::where('invoice_no', 'F-' . $group->first()->unique_id)->sum('amount');
                                        $groupedData = new \stdClass();
                                        $groupedData->date = $group->first()->date;
                                        $groupedData->unique_id = $group->first()->unique_id;
                                        $groupedData->description = $description;
                                        $groupedData->seller = $group->first()->seller;
                                        $groupedData->buyer = $group->first()->buyer;
                                        $groupedData->qty_total = $group->first()->qty_total;
                                        $groupedData->sale_qty_total = $group->first()->sale_qty_total;
                                        $groupedData->sale_amount_total = $group->first()->sale_amount_total;
                                        $groupedData->amount_total = $group->first()->amount_total;

                                        return $groupedData;
                                });
                        }
                        if(isset($pv_check)){

                                $payment_voucher = p_voucher::whereBetween('date', [$startDate, $endDate]);

                                if ($account) {
                                        $payment_voucher->where(function($query)use($id, $account){
                                                $query->where('cash_bank', $id)->orWhere('company', $account->reference_id);
                                        });
                                }
                                if ($salesOfficer) {
                                        $payment_voucher->where('sales_officer', $salesOfficer);
                                }
                                $payment_voucher = $payment_voucher->orderBy('date', 'asc')->get();

                        }
                        if(isset($rv_check)){

                                $receipt_voucher = ReceiptVoucher::whereBetween('date', [$startDate, $endDate]);

                                if ($account) {
                                        $receipt_voucher->where(function($query)use($id, $account){
                                                $query->where('cash_bank', $id)->orWhere('company', $account->reference_id);
                                        });
                                }
                                if ($salesOfficer) {
                                        $receipt_voucher->where('sales_officer', $salesOfficer);
                                }
                                $receipt_voucher = $receipt_voucher->orderBy('date', 'asc')->get();

                        }
                        if(isset($ev_check)){

                                $expense_voucher = ExpenseVoucher::whereBetween('date', [$startDate, $endDate]);

                                if ($account) {
                                        $expense_voucher->where(function ($query) use ($id, $account) {
                                                $query->where('cash_bank', $id)->orWhere('buyer', $account->id);
                                            });
                                }
                                if ($salesOfficer) {
                                        $expense_voucher->where('sales_officer', $salesOfficer);
                                }
                                $expense_voucher = $expense_voucher->orderBy('date', 'asc')->get();

                        }
                        if(isset($jv_check)){

                                $journal_voucher = JournalVoucher::whereBetween('date', [$startDate, $endDate]);

                                if ($account) {
                                    $journal_voucher->where(function ($query) use ($id) {
                                        $query->where('from_account', $id)
                                              ->orWhere('to_account', $id);
                                    });
                                }
                                
                                if ($salesOfficer) {
                                    $journal_voucher->where('sales_officer', $salesOfficer);
                                }
                                
                                
                                $journal_voucher = $journal_voucher->orderBy('date', 'asc')->get();

                        }

                               
                               
                                // $payment_voucher = $payment_voucher->groupBy('unique_id')->map(function ($group) {
                                //         $description = $group->map(function ($item) {
                                //                 return $item->narration;
                                //         })->join(', ');

                                //         $groupedData = new \stdClass();
                                //         $groupedData->date = $group->first()->date;
                                //         $groupedData->unique_id = $group->first()->unique_id;
                                //         $groupedData->narration = $description;
                                //         $groupedData->company = $group->first()->company;
                                //         $groupedData->amount_total = $group->first()->amount;

                                //         return $groupedData;
                                // });

                                // dd($feedInvoiceGrouped);
                                if ($id) {
                                        $single_data = accounts::where('id', $id)->first();
                                }
                                

                                $data = [
                                        'startDate' => $startDate,
                                        'endDate' => $endDate,
                                        'single_data' => $single_data ?? null,
                                        'chickenInvoice' => $chickenInvoice ?? [],
                                        'chickInvoice' => $chickInvoice ?? [],
                                        'feedInvoice' => $feedInvoice ?? [],
                                        'payment_voucher' => $payment_voucher ?? [],
                                        'receipt_voucher' => $receipt_voucher ?? [],
                                        'expense_voucher' => $expense_voucher ?? [],
                                        'journal_voucher' => $journal_voucher ?? [],
                                        'account' => $account->reference_id ?? null,
                                        'type' => $type,

                                        'head_account' => $head_account,
                                        'sub_head_account' => $sub_head_account,
                                        'accounts' => $all_accounts,
                                ];

                                session()->flash('Data', $data);
                        }
                        //    elseif ($type == 2) {
                        //         $chickenInvoice = chickenInvoice::whereBetween('date', [$startDate, $endDate]);

                        //         if ($account) {
                        //                 $chickenInvoice->where('buyer', $account->reference_id)->orWhere('seller', $account->reference_id);
                        //         }
                        //         if ($salesOfficer) {
                        //                 $chickenInvoice->where('sales_officer', $salesOfficer);
                        //         }

                        //         // dd($chickenInvoice->get());
                        //         $chickInvoice = chickInvoice::whereBetween('date', [$startDate, $endDate]);

                        //         if ($account) {
                        //                 $chickInvoice->where('buyer', $account->reference_id)->orWhere('seller', $account->reference_id);
                        //         }
                        //         if ($salesOfficer) {
                        //                 $chickInvoice->where('sales_officer', $salesOfficer);
                        //         }

                        //         $feedInvoice = feedInvoice::whereBetween('date', [$startDate, $endDate]);

                        //         if ($account) {
                        //                 $feedInvoice->where('buyer', $account->reference_id)->orWhere('seller', $account->reference_id);
                        //         }
                        //         if ($salesOfficer) {
                        //                 $feedInvoice->where('sales_officer', $salesOfficer);
                        //         }

                        //         $payment_voucher = p_voucher::whereBetween('date', [$startDate, $endDate]);

                        //         if ($account) {
                        //                 $payment_voucher->where('cash_bank', $id)->orWhere('company', $account->reference_id);
                        //         }
                        //         if ($salesOfficer) {
                        //                 $payment_voucher->where('sales_officer', $salesOfficer);
                        //         }


                        //         $receipt_voucher = ReceiptVoucher::whereBetween('date', [$startDate, $endDate]);

                        //         if ($account) {
                        //                 $receipt_voucher->where('cash_bank', $id)->orWhere('company', $account->reference_id);
                        //         }
                        //         if ($salesOfficer) {
                        //                 $receipt_voucher->where('sales_officer', $salesOfficer);
                        //         }

                        //         $expense_voucher = ExpenseVoucher::whereBetween('date', [$startDate, $endDate]);

                        //         if ($account) {
                        //                 $expense_voucher->where('cash_bank', $id)->orWhere('buyer', $account->reference_id)->orWhere('buyer', $account->id);
                        //         }
                        //         if ($salesOfficer) {
                        //                 $expense_voucher->where('sales_officer', $salesOfficer);
                        //         }

                        //         $chickenInvoice = $chickenInvoice->orderBy('date', 'asc')->get();
                        //         $chickInvoice = $chickInvoice->orderBy('date', 'asc')->get();
                        //         $feedInvoice = $feedInvoice->orderBy('date', 'asc')->get();
                        //         $payment_voucher = $payment_voucher->orderBy('date', 'asc')->get();
                        //         $receipt_voucher = $receipt_voucher->orderBy('date', 'asc')->get();
                        //         $expense_voucher = $expense_voucher->orderBy('date', 'asc')->get();

                        //         $chickenInvoice = $chickenInvoice->groupBy('unique_id')->map(function ($group) {
                        //                 $description = $group->map(function ($item) {
                        //                         return $item->product->product_name;
                        //                 })->join(', ');
                        //                 $sale_amount_rv = ReceiptVoucher::where('invoice_no', 'CH-' . $group->first()->unique_id)->sum('amount');
                        //                 $sale_amount_pv = P_voucher::where('invoice_no', 'CH-' . $group->first()->unique_id)->sum('amount');
                        //                 $groupedData = new \stdClass();
                        //                 $groupedData->date = $group->first()->date;
                        //                 $groupedData->unique_id = $group->first()->unique_id;
                        //                 $groupedData->description = $description;
                        //                 $groupedData->seller = $group->first()->seller;
                        //                 $groupedData->buyer = $group->first()->buyer;
                        //                 $groupedData->sale_amount_total = $group->first()->sale_amount_total;
                        //                 $groupedData->amount_total = $group->first()->amount_total;

                        //                 return $groupedData;
                        //         });
                        //         $chickInvoice = $chickInvoice->groupBy('unique_id')->map(function ($group) {
                        //                 $description = $group->map(function ($item) {
                        //                         return $item->product->product_name;
                        //                 })->join(', ');
                        //                 $sale_amount_rv = ReceiptVoucher::where('invoice_no', 'C-' . $group->first()->unique_id)->sum('amount');
                        //                 $sale_amount_pv = P_voucher::where('invoice_no', 'C-' . $group->first()->unique_id)->sum('amount');
                        //                 $groupedData = new \stdClass();
                        //                 $groupedData->date = $group->first()->date;
                        //                 $groupedData->unique_id = $group->first()->unique_id;
                        //                 $groupedData->description = $description;
                        //                 $groupedData->seller = $group->first()->seller;
                        //                 $groupedData->buyer = $group->first()->buyer;
                        //                 $groupedData->sale_amount_total = $group->first()->sale_amount_total;
                        //                 $groupedData->amount_total = $group->first()->amount_total;

                        //                 return $groupedData;
                        //         });
                        //         $feedInvoice = $feedInvoice->groupBy('unique_id')->map(function ($group) {
                        //                 $description = $group->map(function ($item) {
                        //                         return $item->product->product_name;
                        //                 })->join(', ');
                        //                 $sale_amount_rv = ReceiptVoucher::where('invoice_no', 'F-' . $group->first()->unique_id)->sum('amount');
                        //                 $sale_amount_pv = P_voucher::where('invoice_no', 'F-' . $group->first()->unique_id)->sum('amount');
                        //                 $groupedData = new \stdClass();
                        //                 $groupedData->date = $group->first()->date;
                        //                 $groupedData->unique_id = $group->first()->unique_id;
                        //                 $groupedData->description = $description;
                        //                 $groupedData->seller = $group->first()->seller;
                        //                 $groupedData->buyer = $group->first()->buyer;
                        //                 $groupedData->qty_total = $group->first()->qty_total;
                        //                 $groupedData->sale_qty_total = $group->first()->sale_qty_total;
                        //                 $groupedData->sale_amount_total = $group->first()->sale_amount_total;
                        //                 $groupedData->amount_total = $group->first()->amount_total;

                        //                 return $groupedData;
                        //         });
                        //         // $payment_voucher = $payment_voucher->groupBy('unique_id')->map(function ($group) {
                        //         //         $description = $group->map(function ($item) {
                        //         //                 return $item->narration;
                        //         //         })->join(', ');

                        //         //         $groupedData = new \stdClass();
                        //         //         $groupedData->date = $group->first()->date;
                        //         //         $groupedData->unique_id = $group->first()->unique_id;
                        //         //         $groupedData->narration = $description;
                        //         //         $groupedData->company = $group->first()->company;
                        //         //         $groupedData->amount_total = $group->first()->amount;

                        //         //         return $groupedData;
                        //         // });

                        //         // dd($feedInvoiceGrouped);
                        //         if ($id) {
                        //                 $single_data = accounts::where('id', $id)->first();
                        //         }
                        //         $data = [
                        //                 'startDate' => $startDate,
                        //                 'endDate' => $endDate,
                        //                 'single_data' => $single_data ?? null,
                        //                 'chickenInvoice' => $chickenInvoice,
                        //                 'chickInvoice' => $chickInvoice,
                        //                 'feedInvoice' => $feedInvoice,
                        //                 'payment_voucher' => $payment_voucher,
                        //                 'receipt_voucher' => $receipt_voucher,
                        //                 'expense_voucher' => $expense_voucher,
                        //                 'account' => $account->reference_id ?? null,
                        //                 'type' => $type
                        //         ];
                        //         session()->flash('Data', $data);
                        // }
                }


                if (session()->has('Data')) {

                        $views = 'General Ledger';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.ledger.gen_led')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();

                        session()->forget('Data');

                        return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
                }
        }


     public function balance_sheet(Request $request)
        {


                if (!session()->exists('Data')) {

                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));
                        $type = $request->input('type');
                               
                        $chickenInvoice = chickenInvoice::whereBetween('date', [$startDate, $endDate]);

                        $chickInvoice = chickInvoice::whereBetween('date', [$startDate, $endDate]);

                        $feedInvoice = feedInvoice::whereBetween('date', [$startDate, $endDate]);

                        $payment_voucher = p_voucher::whereBetween('date', [$startDate, $endDate]);

                        $receipt_voucher = ReceiptVoucher::whereBetween('date', [$startDate, $endDate]);

                        $expense_voucher = ExpenseVoucher::whereBetween('date', [$startDate, $endDate]);

                        $journal_voucher = JournalVoucher::whereBetween('date', [$startDate, $endDate]);

                        $chickenInvoice = $chickenInvoice->orderBy('date', 'asc')->get();
                        $chickInvoice = $chickInvoice->orderBy('date', 'asc')->get();
                        $feedInvoice = $feedInvoice->orderBy('date', 'asc')->get();
                        $payment_voucher = $payment_voucher->orderBy('date', 'asc')->get();
                        $receipt_voucher = $receipt_voucher->orderBy('date', 'asc')->get();
                        $expense_voucher = $expense_voucher->orderBy('date', 'asc')->get();
                        $journal_voucher = $journal_voucher->orderBy('date', 'asc')->get();


                        $heads = HeadAccount::all();
                        
                                $sub_heads = SubHeadAccount::all();
                                $accounts = accounts::all();

                                $data = [
                                        'startDate' => $startDate,
                                        'endDate' => $endDate,

                                        'chickenInvoice' => $chickenInvoice,
                                        'chickInvoice' => $chickInvoice,
                                        'feedInvoice' => $feedInvoice,
                                        'payment_voucher' => $payment_voucher,
                                        'receipt_voucher' => $receipt_voucher,
                                        'expense_voucher' => $expense_voucher,
                                        'journal_voucher' => $journal_voucher,

                                        'heads' => $heads,
                                        'sub_heads' => $sub_heads,
                                        'accounts' => $accounts,

                                        'type' => $type
                                ];
                                session()->flash('Data', $data);
                        }


                if (session()->has('Data')) {


                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.ledger.balance_sheet')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();

                        session()->forget('Data');

                        return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
                }
        }


        public function expense_report(Request $request)
        {
                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));

                        $account = $request->input('account');
                        $farm = $request->input('farm');
                        $salesOfficer = $request->input('sales_officer');

                        $salaryAccounts = accounts::where('account_category', 9)->get();
                        $rentAccounts = accounts::where('account_category', 10)->get();
                        $utilityAccounts = accounts::where('account_category', 11)->get();
                        
                        $salary = accounts::where('account_category', 9)->pluck('id');
                        $rent = accounts::where('account_category', 10)->pluck('id');
                        $utility = accounts::where('account_category', 11)->pluck('id');

                        if ($account) {
                                $accountDetails = accounts::where('id', $account)->first();
                        }
                        if ($farm) {
                                $farmDetails = Farm::where('id', $farm)->first();
                                }

                        $expense_voucher = ExpenseVoucher::whereBetween('date', [$startDate, $endDate]);

if ($account) {
        $expense_voucher->where('cash_bank', $account);
}
if ($farm) {
        $expense_voucher->where('farm', $farm);
}
if ($salesOfficer) {
        $expense_voucher->where('sales_officer', $salesOfficer);
}

$journal_voucher = JournalVoucher::whereBetween('date', [$startDate, $endDate]);
$salaryjv = JournalVoucher::whereBetween('date', [$startDate, $endDate])->
where(function ($query) {
    $query->where(function ($query) {
        $query->whereHas('fromAccount', function ($query) {
            $query->where('account_category', [9]);
        })->where('status', 'credit');
    })
    ->orWhere(function ($query) {
        $query->whereHas('toAccount', function ($query) {
            $query->where('account_category', [9]);
        })->where('status', 'debit');
    });
})
;
$rentjv = JournalVoucher::whereBetween('date', [$startDate, $endDate])->
where(function ($query) {
    $query->where(function ($query) {
        $query->whereHas('fromAccount', function ($query) {
            $query->where('account_category', [10]);
        })->where('status', 'credit');
    })
    ->orWhere(function ($query) {
        $query->whereHas('toAccount', function ($query) {
            $query->where('account_category', [10]);
        })->where('status', 'debit');
    });
})
;
$utilityjv = JournalVoucher::whereBetween('date', [$startDate, $endDate])->
where(function ($query) {
    $query->where(function ($query) {
        $query->whereHas('fromAccount', function ($query) {
            $query->where('account_category', [11]);
        })->where('status', 'credit');
    })
    ->orWhere(function ($query) {
        $query->whereHas('toAccount', function ($query) {
            $query->where('account_category', [11]);
        })->where('status', 'debit');
    });
})
;


if ($account) {
        $journal_voucher->where(function($query)use($account){
                $query->where('from_account', $account)->orWhere('to_account', $account);
        });
        $salaryjv->where(function($query)use($account){
                $query->where('from_account', $account)->orWhere('to_account', $account);
        });
        $rentjv->where(function($query)use($account){
                $query->where('from_account', $account)->orWhere('to_account', $account);
        });
        $utilityjv->where(function($query)use($account){
                $query->where('from_account', $account)->orWhere('to_account', $account);
        });
}
if ($farm) {
        $journal_voucher->where('farm', $farm);
        $salaryjv->where('farm', $farm);
        $rentjv->where('farm', $farm);
        $utilityjv->where('farm', $farm);
}
if ($salesOfficer) {
        $journal_voucher->where('sales_officer', $salesOfficer);
        $salaryjv->where('sales_officer', $salesOfficer);
        $rentjv->where('sales_officer', $salesOfficer);
        $utilityjv->where('sales_officer', $salesOfficer);
}

$expense_voucher = $expense_voucher->orderBy('date', 'asc')->get();

$salaryjv = $salaryjv->orderBy('date', 'asc')->get();
$rentjv = $rentjv->orderBy('date', 'asc')->get();
$utilityjv = $utilityjv->orderBy('date', 'asc')->get();

$salary = $expense_voucher->whereIn('cash_bank', $salary);
        $rent = $expense_voucher->whereIn('cash_bank', $rent);
        $utility = $expense_voucher->whereIn('cash_bank', $utility);



 
                        $data = [
                                'expense_voucher' => $expense_voucher,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'accountDetails' => $accountDetails ?? null,
                                'farmDetails' => $farmDetails ?? null,
                                
                                'journal_voucher' => $journal_voucher,

                                'salaryAccounts' => $salaryAccounts,
                        'rentAccounts' => $rentAccounts,
                        'utilityAccounts' => $utilityAccounts,
                                
                                'salary' => $salary,
                                'rent' => $rent,
                                'utility' => $utility,
                                'salaryjv' => $salaryjv,
                                'rentjv' => $rentjv,
                                'utilityjv' => $utilityjv,
                        ];

                        session()->flash('Data', $data);


                if (session()->has('Data')) {

                        $views = 'Customer Report';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.ledger.expense_report')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();
                        session()->forget('Data');

                        return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
                }
        }



        public function sale_report(Request $request)
        {
                $type = $request['type'];
                $startDate = Carbon::parse($request->input('start_date'));
                $endDate = Carbon::parse($request->input('end_date'));

                $customer = $request->input('customer');
                $salesOfficer = $request->input('sales_officer');
                $warehouse = $request->input('warehouse');
                $product_category = $request->input('product_category');
                $product_company = $request->input('product_company');
                $product = $request->input('product');
                $product_id = null;
                if ($type == 1) {

                        if ($customer) {
                                $company = buyer::whereIn('buyer_id', $customer)->get();
                        }

                        $chickenInvoice = chickenInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($customer) {
                                $chickenInvoice->whereIn('buyer', $customer);
                        }

                        if ($salesOfficer) {
                                $chickenInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $chickenInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $chickenInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $chickenInvoice->where('item', $product);
                        }

                        $chickInvoice = ChickInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($customer) {
                                $chickInvoice->whereIn('buyer', $customer);
                        }

                        if ($salesOfficer) {
                                $chickInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $chickInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $chickInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $chickInvoice->where('item', $product);
                        }

                        $feedInvoice = feedInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($customer) {
                                $feedInvoice->whereIn('buyer', $customer);
                        }

                        if ($salesOfficer) {
                                $feedInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $feedInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $feedInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $feedInvoice->where('item', $product);
                        }

                        $chickenData = $chickenInvoice->orderBy('date', 'asc')->get();
                        $chickData = $chickInvoice->orderBy('date', 'asc')->get();
                        $feedData = $feedInvoice->orderBy('date', 'asc')->get();

                        $data = [
                                'chickenData' => $chickenData,
                                'chickData' => $chickData,
                                'feedData' => $feedData,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'company' => $company ?? null,
                                'type' => $type,
                        ];

                        session()->flash('Data', $data);
                } elseif ($type == 2) {

                        if ($customer) {
                                $company = buyer::whereIn('buyer_id', $customer)->get();
                        }

                        $chickenInvoice = chickenInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($customer) {
                                $chickenInvoice->whereIn('buyer', $customer);
                        }

                        if ($salesOfficer) {
                                $chickenInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $chickenInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $chickenInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $chickenInvoice->where('item', $product);
                        }

                     

                        $chickenData = $chickenInvoice->orderBy('date', 'asc')->get();

                        $data = [
                                'chickenData' => $chickenData,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'company' => $company ?? null,
                                'type' => $type,
                        ];
                        session()->flash('Data', $data);

                } elseif ($type == 3) {

                        if ($customer) {
                                $company = buyer::whereIn('buyer_id', $customer)->get();
                        }
                        $chickInvoice = ChickInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($customer) {
                                $chickInvoice->whereIn('buyer', $customer);
                        }

                        if ($salesOfficer) {
                                $chickInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $chickInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $chickInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $chickInvoice->where('item', $product);
                        }

                        $chickData = $chickInvoice->orderBy('date', 'asc')->get();

                        $data = [
                                'chickData' => $chickData,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'company' => $company ?? null,
                                'type' => $type,
                        ];
                        session()->flash('Data', $data);

                }
               elseif ($type == 4) {

                        if ($customer) {
                                $company = buyer::whereIn('buyer_id', $customer)->get();
                        }
                        $feedInvoice = feedInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($customer) {
                                $feedInvoice->whereIn('buyer', $customer);
                        }

                        if ($salesOfficer) {
                                $feedInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $feedInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $feedInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $feedInvoice->where('item', $product);
                        }

                        $feedData = $feedInvoice->orderBy('date', 'asc')->get();

                        $data = [
                                'feedData' => $feedData,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'company' => $company ?? null,
                                'type' => $type,
                        ];
                        session()->flash('Data', $data);
                }
        

                if (session()->has('Data')) {

                        $views = 'Customer Report';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.ledger.sale_report')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();
                        session()->forget('Data');

                        return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
                }
        }







        public function sale_r_report(Request $request)
        {

                $type = $request['type'];
                if ($type == 1) {
                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));

                        // Retrieve form data
                        $customer = $request->input('customer');
                        $salesOfficer = $request->input('sales_officer');
                        $warehouse = $request->input('warehouse');
                        $product_category = $request->input('product_category');
                        $product_company = $request->input('product_company');
                        $product = $request->input('product');
                        $product_id = null;



                        $query = sale_return::whereBetween(DB::raw('DATE(sale_returns.updated_at)'), [$startDate, $endDate])
                                ->whereIn('sale_returns.id', function ($subQuery) {
                                        $subQuery->select(DB::raw('MIN(id)'))
                                                ->from('sale_returns')
                                                ->groupBy('unique_id');
                                });

                        if ($customer) {
                                $query->where('company', $customer);
                        }

                        if ($salesOfficer) {
                                $query->where('sales_officer', $salesOfficer);
                        }

                        if ($warehouse) {
                                $query->where('warehouse', $warehouse);
                        }

                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $query->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $query->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $query->where('item', $product);
                        }

                        $ledgerDatasi = $query->get();

                        $data = [
                                'invoice' => $ledgerDatasi,
                                'credit' => $ledgerDatasi->sum('amount_paid'),
                                'total_amount' => $ledgerDatasi->sum('amount_total'),
                                'balance_amount' => $ledgerDatasi->sum('amount_total'),
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'type' => $type,
                        ];

                        session()->flash('Data', $data);
                } elseif ($type == 2) {

                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));

                        // Retrieve form data
                        $customer = $request->input('customer');
                        $salesOfficer = $request->input('sales_officer');
                        $warehouse = $request->input('warehouse');
                        $product_category = $request->input('product_category');
                        $product_company = $request->input('product_company');
                        $product = $request->input('product');
                        $product_id = null;

                        $query = sale_return::whereBetween(DB::raw('DATE(sale_returns.updated_at)'), [$startDate, $endDate]);

                        if ($customer) {
                                $query->where('company', $customer);
                        }

                        if ($salesOfficer) {
                                $query->where('sales_officer', $salesOfficer);
                        }

                        if ($warehouse) {
                                $query->where('warehouse', $warehouse);
                        }

                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $query->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $query->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $query->where('item', $product);
                        }

                        $query->orderBy('created_at'); // Order by date within each group


                        $ledgerDatasi = $query->get();

                        $data = [
                                'invoice' => $ledgerDatasi,
                                'credit' => $ledgerDatasi->sum('amount_paid'),
                                'total_amount' => $ledgerDatasi->sum('amount_total'),
                                'balance_amount' => $ledgerDatasi->sum('amount_total'),
                                'qty_total' => $ledgerDatasi->sum('qty_total'),
                                'dis_total' => $ledgerDatasi->sum('dis_total'),
                                'amount_total' => $ledgerDatasi->sum('amount_total'),
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'type' => $type,
                        ];

                        session()->flash('Data', $data);
                }


                if (session()->has('Data')) {

                        $views = 'Sale Return Report';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.sale_r_report')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();
                        session()->forget('Data');

                        return view('pdf.pdf_view', ['pdf' => $pdf->output()]);
                }
        }
        public function pur_report(Request $request)
        {
                $type = $request['type'];
                $startDate = Carbon::parse($request->input('start_date'));
                $endDate = Carbon::parse($request->input('end_date'));

                $supplier = $request->input('supplier');
                $salesOfficer = $request->input('sales_officer');
                $warehouse = $request->input('warehouse');
                $product_category = $request->input('product_category');
                $product_company = $request->input('product_company');
                $product = $request->input('product');
                $product_id = null;
                if ($type == 1) {

                        if ($supplier) {
                                $company = buyer::where('buyer_id', $supplier)->first();
                        }

                        $chickenInvoice = chickenInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($supplier) {
                                $chickenInvoice->where('seller', $supplier);
                        }

                        if ($salesOfficer) {
                                $chickenInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $chickenInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $chickenInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $chickenInvoice->where('item', $product);
                        }

                        $chickInvoice = ChickInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($supplier) {
                                $chickInvoice->where('seller', $supplier);
                        }

                        if ($salesOfficer) {
                                $chickInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $chickInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $chickInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $chickInvoice->where('item', $product);
                        }

                        $feedInvoice = feedInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($supplier) {
                                $feedInvoice->where('seller', $supplier);
                        }

                        if ($salesOfficer) {
                                $feedInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $feedInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $feedInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $feedInvoice->where('item', $product);
                        }

                        $chickenData = $chickenInvoice->orderBy('date', 'asc')->get();
                        $chickData = $chickInvoice->orderBy('date', 'asc')->get();
                        $feedData = $feedInvoice->orderBy('date', 'asc')->get();

                        $data = [
                                'chickenData' => $chickenData,
                                'chickData' => $chickData,
                                'feedData' => $feedData,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'company' => $company ?? null,
                                'type' => $type,
                        ];

                        session()->flash('Data', $data);
                } elseif ($type == 2) {

                        if ($supplier) {
                                $company = buyer::where('buyer_id', $supplier)->first();
                        }

                        $chickenInvoice = chickenInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($supplier) {
                                $chickenInvoice->where('seller', $supplier);
                        }

                        if ($salesOfficer) {
                                $chickenInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $chickenInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $chickenInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $chickenInvoice->where('item', $product);
                        }

                     

                        $chickenData = $chickenInvoice->orderBy('date', 'asc')->get();

                        $data = [
                                'chickenData' => $chickenData,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'company' => $company ?? null,
                                'type' => $type,
                        ];
                        session()->flash('Data', $data);

                } elseif ($type == 3) {

                        if ($supplier) {
                                $company = buyer::where('buyer_id', $supplier)->first();
                        }
                        $chickInvoice = ChickInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($supplier) {
                                $chickInvoice->where('seller', $supplier);
                        }

                        if ($salesOfficer) {
                                $chickInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $chickInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $chickInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $chickInvoice->where('item', $product);
                        }

                        $chickData = $chickInvoice->orderBy('date', 'asc')->get();

                        $data = [
                                'chickData' => $chickData,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'company' => $company ?? null,
                                'type' => $type,
                        ];
                        session()->flash('Data', $data);

                }
               elseif ($type == 4) {

                        if ($supplier) {
                                $company = buyer::where('buyer_id', $supplier)->first();
                        }
                        $feedInvoice = feedInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($supplier) {
                                $feedInvoice->where('seller', $supplier);
                        }

                        if ($salesOfficer) {
                                $feedInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $feedInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $feedInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $feedInvoice->where('item', $product);
                        }

                        $feedData = $feedInvoice->orderBy('date', 'asc')->get();

                        $data = [
                                'feedData' => $feedData,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'company' => $company ?? null,
                                'type' => $type,
                        ];
                        session()->flash('Data', $data);
                }
        

                if (session()->has('Data')) {

                        $views = 'Customer Report';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.ledger.pur_report')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();
                        session()->forget('Data');

                        return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
                }
        }

        public function pur_r_report(Request $request)
        {

                if (!session()->exists('Data')) {
                        $type = $request['type'];
                        if ($type == 1) {
                                # code...

                                $startDate = Carbon::parse($request->input('start_date'));
                                $endDate = Carbon::parse($request->input('end_date'));

                                // Retrieve form data
                                $supplier = $request->input('supplier');
                                $salesOfficer = $request->input('sales_officer');
                                $warehouse = $request->input('warehouse');
                                $product_category = $request->input('product_category');
                                $product_company = $request->input('product_company');
                                $product = $request->input('product');
                                $product_id = [];




                                $query = purchase_return::whereBetween(DB::raw('DATE(purchase_returns.updated_at)'), [$startDate, $endDate])
                                        ->whereIn('purchase_returns.id', function ($subQuery) {
                                                $subQuery->select(DB::raw('MIN(id)'))
                                                        ->from('purchase_returns')
                                                        ->groupBy('unique_id');
                                        });

                                if ($supplier) {
                                        $query->where('company', $supplier);
                                }

                                if ($salesOfficer) {
                                        $query->where('sales_officer', $salesOfficer);
                                }

                                if ($warehouse) {
                                        $query->where('warehouse', $warehouse);
                                }

                                if ($product_category) {
                                        //I want to get data where category
                                        $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                        $query->whereIn('item', $productIds);
                                }

                                if ($product_company) {
                                        $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                        $query->whereIn('item', $productIds);
                                }
                                if ($product) {
                                        $query->where('item', $product);
                                }

                                $ledgerDatasi = $query->get();

                                $data = [
                                        'invoice' => $ledgerDatasi,
                                        'credit' => $ledgerDatasi->sum('amount_paid'),
                                        'total_amount' => $ledgerDatasi->sum('amount_total'),
                                        'balance_amount' => $ledgerDatasi->sum('amount_total'),
                                        'startDate' => $startDate,
                                        'endDate' => $endDate,
                                        'type' => $type,
                                ];

                                session()->flash('Data', $data);
                        } elseif ($type == 2) {
                                $startDate = Carbon::parse($request->input('start_date'));
                                $endDate = Carbon::parse($request->input('end_date'));

                                // Retrieve form data
                                $supplier = $request->input('supplier');
                                $salesOfficer = $request->input('sales_officer');
                                $warehouse = $request->input('warehouse');
                                $product_category = $request->input('product_category');
                                $product_company = $request->input('product_company');
                                $product = $request->input('product');
                                $product_id = [];




                                $query = purchase_return::whereBetween(DB::raw('DATE(purchase_returns.updated_at)'), [$startDate, $endDate]);

                                if ($supplier) {
                                        $query->where('company', $supplier);
                                }

                                if ($salesOfficer) {
                                        $query->where('sales_officer', $salesOfficer);
                                }

                                if ($warehouse) {
                                        $query->where('warehouse', $warehouse);
                                }

                                if ($product_category) {
                                        $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                        $query->whereIn('item', $productIds);
                                }

                                if ($product_company) {
                                        $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                        $query->whereIn('item', $productIds);
                                }
                                if ($product) {
                                        $query->where('item', $product);
                                }

                                $query->orderBy('created_at');
                                $ledgerDatasi = $query->get();

                                $data = [
                                        'invoice' => $ledgerDatasi,
                                        'credit' => $ledgerDatasi->sum('amount_paid'),
                                        'total_amount' => $ledgerDatasi->sum('amount_total'),
                                        'balance_amount' => $ledgerDatasi->sum('amount_total'),
                                        'startDate' => $startDate,
                                        'endDate' => $endDate,
                                        'type' => $type,
                                ];

                                session()->flash('Data', $data);
                        }
                }


                if (session()->has('Data')) {

                        $views = 'Purchase Return Report';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.pur_r_report')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();
                        ;
                        session()->forget('Data');

                        return view('pdf.pdf_view', ['pdf' => $pdf->output()]);
                }
        }

        public function cus_led(Request $request)
        {
                if (!session()->exists('Data')) {
                        $type = $request->input('type');
                        if ($type == 1) {
                                # code...


                                $startDate = Carbon::parse($request->input('start_date'));
                                $endDate = Carbon::parse($request->input('end_date'));

                                // Retrieve form data
                                $customer = $request->input('customer');
                                $salesOfficer = $request->input('sales_officer');
                                $warehouse = $request->input('warehouse');
                                $product_category = $request->input('product_category');
                                $product_company = $request->input('product_company');
                                $product = $request->input('product');
                                $product_id = null;



                                $query = SaleInvoice::whereBetween(DB::raw('DATE(sale_invoices.updated_at)'), [$startDate, $endDate])
                                        ->whereIn('sale_invoices.id', function ($subQuery) {
                                                $subQuery->select(DB::raw('MIN(id)'))
                                                        ->from('sale_invoices')
                                                        ->groupBy('unique_id');
                                        });

                                if ($customer) {
                                        $query->where('company', $customer);
                                }

                                if ($salesOfficer) {
                                        $query->where('sales_officer', $salesOfficer);
                                }

                                if ($warehouse) {
                                        $query->where('warehouse', $warehouse);
                                }

                                if ($product_category) {
                                        $pr = products::where('category', $product_category)->get();
                                        foreach ($pr as $key => $value) {
                                                $product_id = $value->product_id;
                                        }
                                        $query->where('item', $product_id);
                                }

                                if ($product_company) {
                                        $pr = products::where('company', $product_company)->get();
                                        foreach ($pr as $key => $value) {
                                                $product_id = $value->product_id;
                                        }
                                        $query->where('item', $product_id);
                                }
                                if ($product) {
                                        $query->where('item', $product);
                                }

                                $ledgerDatasi = $query->get();
                                $customerData = buyer::where('buyer_id', $customer)->get();
                                foreach ($customerData as $key => $value) {
                                        $customerName = $value->company_name;
                                }


                                // $debit1 = SaleInvoice::where('company', $customer)->whereBetween(DB::raw('DATE(sale_invoices.updated_at)'), [$startDate, $endDate])
                                //         ->whereIn('id', function ($query2) {
                                //                 $query2->select(DB::raw('MIN(id)'))
                                //                         ->from('sale_invoices')
                                //                         ->groupBy('unique_id');
                                //         })->sum('amount_paid');

                                // $debit2 = ReceiptVoucher::where('company', $customer)->where('company_ref', 'B')->whereBetween(DB::raw('DATE(receipt_vouchers.updated_at)'), [$startDate, $endDate])
                                //         ->whereIn('id', function ($query2) {
                                //                 $query2->select(DB::raw('MIN(id)'))
                                //                         ->from('receipt_vouchers')
                                //                         ->groupBy('unique_id');
                                //         })->sum('amount_total');

                                // $debit = $debit1 ?? 0 + $debit2 ?? 0;

                                // $credit1 = p_voucher::where('company', $customer)->where('company_ref', 'B')->whereBetween(DB::raw('DATE(payment_voucher.updated_at)'), [$startDate, $endDate])
                                //         ->whereIn('payment_voucher.id', function ($query2) {
                                //                 $query2->select(DB::raw('MIN(id)'))
                                //                         ->from('payment_voucher')
                                //                         ->groupBy('unique_id');
                                //         })->sum('amount_total');

                                // $credit2 = SaleInvoice::where('company', $customer)->whereBetween(DB::raw('DATE(sale_invoices.updated_at)'), [$startDate, $endDate])
                                //         ->whereIn('id', function ($query2) {
                                //                 $query2->select(DB::raw('MIN(id)'))
                                //                         ->from('sale_invoices')
                                //                         ->groupBy('unique_id');
                                //         })->sum('grand_total');
                                // $credit = $credit1 + $credit2;
                                // $balance = $debit ?? 0 - $credit ?? 0;

                                $data = [
                                        'invoice' => $ledgerDatasi,
                                        'credit' => $ledgerDatasi->sum('amount_paid'),
                                        'total_amount' => $ledgerDatasi->sum('amount_total'),
                                        'debit' => $ledgerDatasi->sum('previous_balance'),
                                        'balance_amount' => $ledgerDatasi->sum('balance_amount'),
                                        'startDate' => $startDate,
                                        'endDate' => $endDate,
                                        'customerName' => $customerName ?? 'Not Selected',
                                        'type' => $type,

                                ];

                                session()->flash('Data', $data);
                        }

                        if ($type == 2) {

                                $startDate = Carbon::parse($request->input('start_date'));
                                $endDate = Carbon::parse($request->input('end_date'));

                                // Retrieve form data
                                $customer = $request->input('customer');

                                // Start building the query
                                $query = ReceiptVoucher::whereBetween('date', [$startDate, $endDate])
                                        ->whereBetween(DB::raw('DATE(receipt_vouchers.updated_at)'), [$startDate, $endDate])
                                        ->where('receipt_vouchers.company', $customer)  // Specify 'receipt_vouchers.company'
                                ;

                                $ledgerDatasi = $query->leftJoin('buyer', 'buyer.buyer_id', '=', DB::raw('LEFT(receipt_vouchers.company, LENGTH(receipt_vouchers.company) - 1)'))
                                        ->get();

                                $customerData = buyer::where('buyer_id', $customer)->get();
                                foreach ($customerData as $key => $value) {
                                        $customerName = $value->company_name;
                                        $customerDebit = $value->debit;
                                }

                                $debit1 = SaleInvoice::where('company', $customer)->whereBetween(DB::raw('DATE(sale_invoices.updated_at)'), [$startDate, $endDate])
                                        ->whereIn('id', function ($query2) {
                                                $query2->select(DB::raw('MIN(id)'))
                                                        ->from('sale_invoices')
                                                        ->groupBy('unique_id');
                                        })->sum('amount_paid');

                                $debit2 = ReceiptVoucher::where('company', $customer)->where('company_ref', 'B')->whereBetween(DB::raw('DATE(receipt_vouchers.updated_at)'), [$startDate, $endDate])
                                        ->whereIn('id', function ($query2) {
                                                $query2->select(DB::raw('MIN(id)'))
                                                        ->from('receipt_vouchers')
                                                        ->groupBy('unique_id');
                                        })->sum('amount_total');

                                $debit = $debit1 ?? 0 + $debit2 ?? 0;

                                $credit1 = p_voucher::where('company', $customer)->where('company_ref', 'B')->whereBetween(DB::raw('DATE(payment_voucher.updated_at)'), [$startDate, $endDate])
                                        ->whereIn('payment_voucher.id', function ($query2) {
                                                $query2->select(DB::raw('MIN(id)'))
                                                        ->from('payment_voucher')
                                                        ->groupBy('unique_id');
                                        })->sum('amount_total');

                                $credit2 = SaleInvoice::where('company', $customer)->whereBetween(DB::raw('DATE(sale_invoices.updated_at)'), [$startDate, $endDate])
                                        ->whereIn('id', function ($query2) {
                                                $query2->select(DB::raw('MIN(id)'))
                                                        ->from('sale_invoices')
                                                        ->groupBy('unique_id');
                                        })->sum('grand_total');
                                $credit = $credit1 + $credit2;
                                $balance = $debit ?? 0 - $credit ?? 0;

                                $data = [
                                        'invoice' => $ledgerDatasi,
                                        'credit' => $ledgerDatasi->sum('invoice.balance_amount') - $ledgerDatasi->sum('amount'),
                                        'total_amount' => $ledgerDatasi->sum('amount'),
                                        'debit' => $balance,
                                        'balance_amount' => $ledgerDatasi->sum('balance_amount'),
                                        'startDate' => $startDate,
                                        'endDate' => $endDate,
                                        'customerName' => $customerName,
                                        'type' => $type,

                                ];

                                session()->flash('Data', $data);
                        }

                        $type = $request->input('type');
                        if ($type == 3) {

                                $startDate = Carbon::parse($request->input('start_date'));
                                $endDate = Carbon::parse($request->input('end_date'));
                                $customer = $request->input('customer');

                                $query = SaleInvoice::whereBetween(DB::raw('DATE(sale_invoices.updated_at)'), [$startDate, $endDate])
                                        ->where('company', $customer)
                                        ->whereIn('sale_invoices.id', function ($subQuery) {
                                                $subQuery->select(DB::raw('MIN(id)'))
                                                        ->from('sale_invoices')
                                                        ->groupBy('unique_id');
                                        });

                                $query2 = ReceiptVoucher::where('company', $customer)->where('company_ref', 'B')->whereBetween(DB::raw('DATE(receipt_vouchers.updated_at)'), [$startDate, $endDate])
                                        ->whereIn('id', function ($query2) {
                                                $query2->select(DB::raw('MIN(id)'))
                                                        ->from('receipt_vouchers')
                                                        ->groupBy('unique_id');
                                        });

                                $query3 = p_voucher::where('company', $customer)->where('company_ref', 'B')->whereBetween(DB::raw('DATE(payment_voucher.updated_at)'), [$startDate, $endDate])
                                        ->whereIn('payment_voucher.id', function ($query2) {
                                                $query2->select(DB::raw('MIN(id)'))
                                                        ->from('payment_voucher')
                                                        ->groupBy('unique_id');
                                        });

                                $ledgerDatasi = $query->get();
                                $ledgerDatarv = $query2->get();
                                $ledgerDatapv = $query3->get();
                                $customerData = buyer::where('buyer_id', $customer)->get();
                                foreach ($customerData as $key => $value) {
                                        $customerName = $value->company_name;
                                }


                                $debit1 = SaleInvoice::where('company', $customer)->whereBetween(DB::raw('DATE(sale_invoices.updated_at)'), [$startDate, $endDate])
                                        ->whereIn('id', function ($query2) {
                                                $query2->select(DB::raw('MIN(id)'))
                                                        ->from('sale_invoices')
                                                        ->groupBy('unique_id');
                                        })->sum('grand_total');

                                $debit2 = ReceiptVoucher::where('company', $customer)->where('company_ref', 'B')->whereBetween(DB::raw('DATE(receipt_vouchers.updated_at)'), [$startDate, $endDate])
                                        ->whereIn('id', function ($query2) {
                                                $query2->select(DB::raw('MIN(id)'))
                                                        ->from('receipt_vouchers')
                                                        ->groupBy('unique_id');
                                        })->sum('amount_total');

                                $debit = $debit1 ?? 0 + $debit2 ?? 0;

                                $credit1 = p_voucher::where('company', $customer)->where('company_ref', 'B')->whereBetween(DB::raw('DATE(payment_voucher.updated_at)'), [$startDate, $endDate])
                                        ->whereIn('payment_voucher.id', function ($query2) {
                                                $query2->select(DB::raw('MIN(id)'))
                                                        ->from('payment_voucher')
                                                        ->groupBy('unique_id');
                                        })->sum('amount_total');

                                $credit2 = SaleInvoice::where('company', $customer)->whereBetween(DB::raw('DATE(sale_invoices.updated_at)'), [$startDate, $endDate])
                                        ->whereIn('id', function ($query2) {
                                                $query2->select(DB::raw('MIN(id)'))
                                                        ->from('sale_invoices')
                                                        ->groupBy('unique_id');
                                        })->sum('amount_paid');

                                $credit = $credit1 + $credit2;

                                $data = [
                                        'ledgerDatasi' => $ledgerDatasi,
                                        'ledgerDatarv' => $ledgerDatarv,
                                        'ledgerDatapv' => $ledgerDatapv,
                                        'credit' => $credit,
                                        'debit' => $debit,
                                        'total_amount' => $ledgerDatasi->sum('amount_total'),
                                        'balance_amount' => $ledgerDatasi->sum('balance_amount'),
                                        'startDate' => $startDate,
                                        'endDate' => $endDate,
                                        'customerName' => $customerName ?? 'Not Selected',
                                        'type' => $type,
                                ];

                                session()->flash('Data', $data);
                        }
                }


                if (session()->has('Data')) {

                        $views = 'Customer Ledger';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.cus_led')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();
                        ;
                        session()->forget('Data');

                        return view('pdf.pdf_view', ['pdf' => $pdf->output()]);
                }
        }


        public function supplier_led(Request $request)
        {

                if (!session()->exists('Data')) {
                        $type = $request->input('type');

                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));

                        // Retrieve form data
                        $supplier = $request->input('supplier');

                        // Start building the query
                        $query = purchase_invoice::whereBetween(DB::raw('DATE(purchase_invoice.updated_at)'), [$startDate, $endDate])
                                ->where('company', $supplier)
                                ->whereIn('purchase_invoice.id', function ($subQuery) {
                                        $subQuery->select(DB::raw('MIN(id)'))
                                                ->from('purchase_invoice')
                                                ->groupBy('unique_id');
                                });

                        $ledgerDatasi = $query->get();
                        $supplierData = seller::where('seller_id', $supplier)->get();
                        foreach ($supplierData as $key => $value) {
                                $supplierName = $value->company_name;
                        }

                        $credit1 = purchase_invoice::where('company', $supplier)->whereBetween(DB::raw('DATE(purchase_invoice.updated_at)'), [$startDate, $endDate])
                                ->whereIn('id', function ($query2) {
                                        $query2->select(DB::raw('MIN(id)'))
                                                ->from('purchase_invoice')
                                                ->groupBy('unique_id');
                                })->sum('amount_total');


                        $credit2 = p_voucher::where('company', $supplier)->where('company_ref', 'S')->whereBetween(DB::raw('DATE(payment_voucher.updated_at)'), [$startDate, $endDate])
                                ->whereIn('payment_voucher.id', function ($query2) {
                                        $query2->select(DB::raw('MIN(id)'))
                                                ->from('payment_voucher')
                                                ->groupBy('unique_id');
                                })->sum('amount_total');

                        $debit = ReceiptVoucher::where('company', $supplier)->where('company_ref', 'S')->whereBetween(DB::raw('DATE(receipt_vouchers.updated_at)'), [$startDate, $endDate])
                                ->whereIn('receipt_vouchers.id', function ($query2) {
                                        $query2->select(DB::raw('MIN(id)'))
                                                ->from('receipt_vouchers')
                                                ->groupBy('unique_id');
                                })->sum('amount_total');

                        $balance = $credit1 + $credit2 - $debit;

                        $data = [
                                'invoice' => $ledgerDatasi,
                                'credit' => $ledgerDatasi->sum('amount_paid'),
                                'total_amount' => $ledgerDatasi->sum('amount_total'),
                                'debit' => $balance,
                                'balance_amount' => $ledgerDatasi->sum('balance_amount'),
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'supplierName' => $supplierName,
                                'type' => $type,

                        ];

                        session()->flash('Data', $data);
                }


                if (session()->has('Data')) {

                        $views = 'Supplier Ledger';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.supplier_led')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();
                        ;
                        session()->forget('Data');

                        return view('pdf.pdf_view', ['pdf' => $pdf->output()]);
                }
        }


        public function pdf_limit(Request $post, $view)
        {

                if (!session()->exists('pdf_data')) {
                        if ($post['limit'] >= 500) {
                                $limit = 500;
                        } else {
                                $limit = $post['limit'];
                        }
                        if ($view == 'users') {

                                $pdf = users::limit($limit)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "Users");
                        } elseif ($view == 'supplier') {

                                $pdf = seller::limit($limit)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "Suppliers");
                        } elseif ($view == 'buyer') {

                                $pdf = buyer::limit($limit)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "Buyers");
                        } elseif ($view == 'zone') {

                                $pdf = zone::limit($limit)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "zones");
                        } elseif ($view == 'warehouse') {

                                $pdf = warehouse::limit($limit)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "Warehouses");
                        } elseif ($view == 'sales_officer') {

                                $pdf = sales_officer::limit($limit)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "sales officers");
                        } elseif ($view == 'account') {

                                $pdf = accounts::limit($limit)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "Accounts");
                        }
                }

                if (session()->has('pdf_data')) {

                        $views = $view;

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.main')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();

                        session()->forget("pdf_data");
                        session()->forget("pdf_title");
                        return $pdf->stream($views . '-' . rand(1111, 9999));
                }
        }



        public function pdf(Request $post, $view)
        {

                if (!session()->has('pdf_data')) {

                        if ($view == 'users') {

                                $pdf = users::limit(500)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "Users");
                        } elseif ($view == 'supplier') {

                                $pdf = seller::limit(500)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "Suppliers");
                        } elseif ($view == 'buyer') {

                                $pdf = buyer::limit(500)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "Buyers");
                        } elseif ($view == 'zone') {

                                $pdf = zone::limit(500)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "zones");
                        } elseif ($view == 'warehouse') {

                                $pdf = warehouse::limit(500)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "Warehouses");
                        } elseif ($view == 'sales_officer') {

                                $pdf = sales_officer::limit(500)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "sales officers");
                        } elseif ($view == 'account') {

                                $pdf = accounts::limit(500)->get();

                                session()->flash("pdf_data", $pdf);
                                session()->flash("pdf_title", "Accounts");
                        }
                }

                if (session()->has('pdf_data')) {

                        $views = $view;

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.main')->with($data)->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();

                        session()->forget("pdf_data");
                        session()->forget("pdf_title");
                        return view('pdf.pdf_view', ['pdf' => $pdf->output()]);
                }
        }




        public function profit_rep(Request $request)
        {


                if (!session()->exists('Data')) {

                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));

                        // Start building the query
                        $query1 = SaleInvoice::whereBetween(DB::raw('DATE(sale_invoices.updated_at)'), [$startDate, $endDate])->whereIn('sale_invoices.id', function ($subQuery) {
                                $subQuery->select(DB::raw('MIN(id)'))
                                        ->from('sale_invoices')
                                        ->groupBy('unique_id');
                        })->get();
                        $query2 = purchase_invoice::whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])->whereIn('purchase_invoice.id', function ($subQuery) {
                                $subQuery->select(DB::raw('MIN(id)'))
                                        ->from('purchase_invoice')
                                        ->groupBy('unique_id');
                        })->get();
                        $query3 = ReceiptVoucher::whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
                                ->whereIn('receipt_vouchers.id', function ($subQuery) {
                                        $subQuery->select(DB::raw('MIN(id)'))
                                                ->from('receipt_vouchers')
                                                ->groupBy('unique_id');
                                })->get();
                        $query4 = p_voucher::whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])->whereIn('payment_voucher.id', function ($subQuery) {
                                $subQuery->select(DB::raw('MIN(id)'))
                                        ->from('payment_voucher')
                                        ->groupBy('unique_id');
                        })->get();


                        // $credit = $query->sum('amount_paid') + $rc->sum('credit');
                        // $debit = $query->sum('previous_balance');
                        // $amount = $query->sum('amount_total') + $rc->sum('amount_total');


                        $data = [
                                'query1' => $query1,
                                'query2' => $query2,
                                'query3' => $query3,
                                'query4' => $query4,
                                'debit' => $query3->sum('amount_total') + $query1->sum('amount_paid'),
                                'credit' => $query2->sum('amount_total') + $query4->sum('amount_total'),
                                '' => $query4,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                        ];
                        session()->flash('Data', $data);
                }


                if (session()->has('Data')) {

                        $views = 'Profit Report';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.profit')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();

                        session()->forget('Data');
                        return view('pdf.pdf_view', ['pdf' => $pdf->output()]);
                }
        }

        public function stock_rep(Request $request)
        {


                if (!session()->exists('Data')) {

                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));
                        $product = $request->input('product');
                        $warehouse = $request->input('warehouse');
                        $product_category = $request->input('product_category');
                        $product_company = $request->input('product_company');


                        $query = $sellInvoices = SaleInvoice::select('item')
                                ->whereBetween(DB::raw('DATE(sale_invoices.updated_at)'), [$startDate, $endDate]);

                        if ($product) {
                                $sellInvoices->where('item', $product);
                        }

                        if ($warehouse) {
                                $sellInvoices->where('warehouse', $warehouse);
                        }

                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $query->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $query->whereIn('item', $productIds);
                        }




                        $query2 = $purchaseInvoices = purchase_invoice::select('item')->whereBetween(DB::raw('DATE(purchase_invoice.updated_at)'), [$startDate, $endDate]);

                        if ($product) {
                                $purchaseInvoices->where('item', $product);
                        }

                        if ($warehouse) {
                                $purchaseInvoices->where('warehouse', $warehouse);
                        }

                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $query2->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $query2->whereIn('item', $productIds);
                        }

                        $si = $query->groupBy('item')->get();
                        $pi = $query2->groupBy('item')->get();

                        $data = [
                                'si' => $si,
                                'pi' => $pi,
                                'sale_qty' => $si->sum('sale_qty'),
                                'pur_qty' => $pi->sum('pur_qty'),
                                'avail_qty' => $pi->sum('pur_qty') - $si->sum('sale_qty'),
                                'product' => $product_name ?? null,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'type' => 1,
                        ];

                        session()->flash('Data', $data);
                }


                if (session()->has('Data')) {

                        $views = 'Stock Report';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.stock')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();

                        session()->forget('Data');
                        return view('pdf.pdf_view', ['pdf' => $pdf->output()]);
                }
        }



        public function warehouse_rep(Request $request)
        {


                if (!session()->exists('Data')) {

                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));
                        $warehouse = $request->input('warehouse');

                        $query = purchase_invoice::whereBetween('date', [$startDate, $endDate]);
                        $query->whereBetween(DB::raw('DATE(purchase_invoice.updated_at)'), [$startDate, $endDate]);
                        $data1 = $query->get();

                        $warehouses = warehouse::where('warehouse_id', $warehouse)->get();
                        foreach ($warehouses as $key => $value) {
                                $warehouse_name = $value->warehouse_name;
                        }
                        $data = [
                                'query' => $data1,
                                'qty' => $data1->sum('pur_qty'),
                                'warehouse' => $warehouse_name ?? '',
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                        ];
                        session()->flash('Data', $data);
                }


                if (session()->has('Data')) {

                        $views = 'Warehouse Report';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.warehouse_rep')->render();

                        $pdf->loadHtml($html);


                        $contentLength = strlen($html);
                        if ($contentLength > 5000) {
                                $pdf->setPaper('A3', 'portrait');
                        } else {
                                $pdf->setPaper('A4', 'portrait');
                        }
                        $pdf->render();

                        session()->forget('Data');
                        return view('pdf.pdf_view', ['pdf' => $pdf->output()]);
                }
        }


        public function pdf_check(Request $request)
        {
                $pdf = users::limit(10)->get();

                return response()->json($pdf);
        }



        public function pdf_all(Request $post)
        {


                if (session()->has('pdf_data')) {

                        $pdf = new Dompdf();

                        $html = view('pdf.main')->render();

                        $pdf->loadHtml($html);
                        $pdf->setPaper('A4', 'portrait');

                        $pdf->render();

                        return $pdf->stream("P" . '-' . rand(1111, 9999) . '.pdf');
                        session()->forget('pdf_data');
                }
        }


        function sale_invoice_pdf(Request $post, $id)
        {


                $SaleInvoice = SaleInvoice::where("unique_id", $id)
                        ->leftJoin('buyer', 'sale_invoices.company', '=', 'buyer.buyer_id')
                        ->leftJoin('sales_officer', 'sale_invoices.sales_officer', '=', 'sales_officer.sales_officer_id')
                        ->leftJoin('products', 'sale_invoices.item', '=', 'products.product_id')
                        ->get();

                $s_SaleInvoice = SaleInvoice::where("unique_id", $id)
                        ->leftJoin('buyer', 'sale_invoices.company', '=', 'buyer.buyer_id')
                        ->leftJoin('sales_officer', 'sale_invoices.sales_officer', '=', 'sales_officer.sales_officer_id')
                        ->leftJoin('products', 'sale_invoices.item', '=', 'products.product_id')
                        ->limit(1)->get();

                session()->flash("sale_invoice_pdf_data", $SaleInvoice);
                session()->flash("s_sale_invoice_pdf_data", $s_SaleInvoice);




                $views = $id;

                $pdf = new Dompdf();

                $html = view('pdf.sale_pdf')->render();

                $pdf->loadHtml($html);

                $contentLength = strlen($html);
                if ($contentLength > 5000) {
                        $pdf->setPaper('A3', 'portrait');
                } else {
                        $pdf->setPaper('A4', 'portrait');
                }

                $pdf->render();

                return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
        }


        function purchase_invoice_pdf(Request $post, $id)
        {


                $purchase_invoice = purchase_invoice::where("unique_id", $id)
                        ->leftJoin('seller', 'purchase_invoice.company', '=', 'seller.seller_id')
                        ->leftJoin('sales_officer', 'purchase_invoice.sales_officer', '=', 'sales_officer.sales_officer_id')
                        ->leftJoin('products', 'purchase_invoice.item', '=', 'products.product_id')
                        ->get();

                $s_purchase_invoice = purchase_invoice::where("unique_id", $id)
                        ->leftJoin('seller', 'purchase_invoice.company', '=', 'seller.seller_id')
                        ->leftJoin('sales_officer', 'purchase_invoice.sales_officer', '=', 'sales_officer.sales_officer_id')
                        ->leftJoin('products', 'purchase_invoice.item', '=', 'products.product_id')
                        ->limit(1)->get();

                session()->flash("purchase_invoice_pdf_data", $purchase_invoice);
                session()->flash("s_purchase_invoice_pdf_data", $s_purchase_invoice);




                $views = $id;

                $pdf = new Dompdf();

                $html = view('pdf.purchase_pdf')->render();

                $pdf->loadHtml($html);

                $contentLength = strlen($html);
                if ($contentLength > 5000) {
                        $pdf->setPaper('A3', 'portrait');
                } else {
                        $pdf->setPaper('A4', 'portrait');
                }

                $pdf->render();

                return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
        }








        function pv_pdf(Request $post, $id)
        {


                $p_voucher = p_voucher::where("unique_id", $id)
                        // ->leftJoin('buyer', 'payment_voucher.company', '=', 'buyer.buyer_id')
                        // ->leftJoin('sales_officer', 'payment_voucher.sales_officer', '=', 'sales_officer.sales_officer_id')
                        // ->leftJoin('products', 'payment_voucher.item', '=', 'products.product_id')
                        ->get();

                $s_p_voucher = p_voucher::where("unique_id", $id)
                        // ->leftJoin('buyer', 'payment_voucher.company', '=', 'buyer.buyer_id')
                        // ->leftJoin('sales_officer', 'payment_voucher.sales_officer', '=', 'sales_officer.sales_officer_id')
                        // ->leftJoin('products', 'payment_voucher.item', '=', 'products.product_id')
                        ->first();

                session()->flash("p_voucher_pdf_data", $p_voucher);
                session()->flash("s_p_voucher_pdf_data", $s_p_voucher);




                $views = $id;

                $pdf = new Dompdf();

                $html = view('pdf.p_voucher')->render();

                $pdf->loadHtml($html);

                $contentLength = strlen($html);
                if ($contentLength > 5000) {
                        $pdf->setPaper('A3', 'portrait');
                } else {
                        $pdf->setPaper('A4', 'portrait');
                }

                $pdf->render();

                return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
        }



        function rv_pdf(Request $post, $id)
        {


                $receipt_vouchers = ReceiptVoucher::where("unique_id", $id)
                        ->leftJoin('buyer', 'receipt_vouchers.company', '=', 'buyer.buyer_id')
                        ->leftJoin('sales_officer', 'receipt_vouchers.sales_officer', '=', 'sales_officer.sales_officer_id')
                        ->get();

                $s_receipt_vouchers = ReceiptVoucher::where("unique_id", $id)
                        ->leftJoin('buyer', 'receipt_vouchers.company', '=', 'buyer.buyer_id')
                        ->leftJoin('sales_officer', 'receipt_vouchers.sales_officer', '=', 'sales_officer.sales_officer_id')
                        ->first();

                session()->flash("receipt_vouchers_pdf_data", $receipt_vouchers);
                session()->flash("s_receipt_vouchers_pdf_data", $s_receipt_vouchers);




                $views = $id;

                $pdf = new Dompdf();

                $html = view('pdf.r_voucher')->render();

                $pdf->loadHtml($html);

                $contentLength = strlen($html);
                if ($contentLength > 5000) {
                        $pdf->setPaper('A3', 'portrait');
                } else {
                        $pdf->setPaper('A4', 'portrait');
                }

                $pdf->render();

                return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
        }


        function ev_pdf(Request $post, $id)
        {


                $expense_vouchers = ExpenseVoucher::where("unique_id", $id)
                        ->get();

                $s_expense_vouchers = ExpenseVoucher::where("unique_id", $id)
                        ->first();

                session()->flash("expense_vouchers_pdf_data", $expense_vouchers);
                session()->flash("s_expense_vouchers_pdf_data", $s_expense_vouchers);


                $views = $id;

                $pdf = new Dompdf();

                $html = view('pdf.e_voucher')->render();

                $pdf->loadHtml($html);

                $contentLength = strlen($html);
                if ($contentLength > 5000) {
                        $pdf->setPaper('A3', 'portrait');
                } else {
                        $pdf->setPaper('A4', 'portrait');
                }

                $pdf->render();

                return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
        }

        function jv_pdf(Request $post, $id)
        {


                $journal_vouchers = JournalVoucher::where("unique_id", $id)
                        ->leftJoin('buyer', 'journal_vouchers.buyer', '=', 'buyer.buyer_id')
                        ->leftJoin('sales_officer', 'journal_vouchers.sales_officer', '=', 'sales_officer.sales_officer_id')
                        ->get();

                $s_journal_vouchers = JournalVoucher::where("unique_id", $id)
                        ->leftJoin('buyer', 'journal_vouchers.buyer', '=', 'buyer.buyer_id')
                        ->leftJoin('sales_officer', 'journal_vouchers.sales_officer', '=', 'sales_officer.sales_officer_id')
                        ->first();

                $debit_total = JournalVoucher::where("unique_id", $id)->where('status', 'debit')->sum('amount');
                $credit_total = JournalVoucher::where("unique_id", $id)->where('status', 'credit')->sum('amount');

                session()->flash("journal_vouchers_pdf_data", $journal_vouchers);
                session()->flash("s_journal_vouchers_pdf_data", $s_journal_vouchers);
                session()->flash("debit_total", $debit_total);
                session()->flash("credit_total", $credit_total);




                $views = $id;

                $pdf = new Dompdf();

                $html = view('pdf.j_voucher')->render();

                $pdf->loadHtml($html);

                $contentLength = strlen($html);
                if ($contentLength > 5000) {
                        $pdf->setPaper('A3', 'portrait');
                } else {
                        $pdf->setPaper('A4', 'portrait');
                }

                $pdf->render();

                return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
        }

        function product_detail(Request $request, $id)
        {
                $product = products::where("product_id", $id)->get();

                session()->flash("product", $product);

                $views = $id;

                $pdf = new Dompdf();

                $html = view('pdf.product_detail')->render();

                $pdf->loadHtml($html);

                $contentLength = strlen($html);
                if ($contentLength > 5000) {
                        $pdf->setPaper('A3', 'portrait');
                } else {
                        $pdf->setPaper('A4', 'portrait');
                }

                $pdf->render();

                return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
        }


        function p_voucher_report(Request $request)
        {
                if (!session()->exists('Data')) {

                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));

                        $contra_account = $request->input('contra_account');
                        $salesOfficer = $request->input('sales_officer');

                        $company = $request->input('company');

                        $type = $request->input('type');

if($type == 1){

                        $query = p_voucher::whereBetween('payment_voucher.date', [$startDate, $endDate]);

                        if ($contra_account) {
                                $query->where('cash_bank', $contra_account);
                        }

                        if ($salesOfficer) {
                                $query->where('sales_officer', $salesOfficer);
                        }

                        if ($company) {
                                $query->where('company', $company);
                                $company = buyer::where('buyer_id', $company)->first();
                        }

                        $p_voucher = $query->orderBy('date', 'asc')->get();

                        $data = [
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'contra_account' => $contra_account,
                                'p_voucher' => $p_voucher,
                                'company' => $company,
                                'type' => $type ?? null
                        ];

                        session()->flash('Data', $data);
                }
elseif($type == 2){

                        $query = p_voucher::whereBetween('payment_voucher.date', [$startDate, $endDate]);
                        $query2 = JournalVoucher::whereBetween('journal_vouchers.date', [$startDate, $endDate]);

                        if ($company) {
                                $query->where('company', $company);
                                $query2->where(function ($query) use ($company) {
                                        $query->where('from_account', $company)
                                              ->where('status', 'credit');
                                    })->orWhere(function ($query) use ($company) {
                                        $query->where('to_account', $company)
                                              ->where('status', 'debit');
                                    });
                                    
                                $company = buyer::where('buyer_id', $company)->first();
                        }

                        if ($contra_account) {
                                $query->where('cash_bank', $contra_account);
                        }

                        if ($salesOfficer) {
                                $query->where('sales_officer', $salesOfficer);
                        }

                        if ($contra_account) {
                                $query2->where(function ($query) use ($contra_account) {
                                        $query->where('from_account', $contra_account)
                                              ->where('status', 'debit');
                                    })->orWhere(function ($query) use ($contra_account) {
                                        $query->where('to_account', $contra_account)
                                              ->where('status', 'credit');
                                    });                        }

                        if ($salesOfficer) {
                                $query2->where('sales_officer', $salesOfficer);
                        }

                        if ($company) {
                                $account = accounts::where('reference_id', $company->buyer_id)->pluck('id');
                                $query2->where(function($query)use($account){
$query->where('from_account', $account)->orWhere('to_account', $account);
                                });
                        }

                        $p_voucher = $query->orderBy('date', 'asc')->get();
                        $journal_voucher = $query2->orderBy('date', 'asc')->get();
                        $data = [
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'contra_account' => $contra_account,
                                'p_voucher' => $p_voucher,
                                'journal_voucher' => $journal_voucher,
                                'company' => $company,
                                'type' => $type ?? null
                        ];

                        session()->flash('Data', $data);
                }
        }


                if (session()->has('Data')) {
                        $html = view('pdf.voucher.p_voucher_rep')->render();
                        return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
                }
        }




        function r_voucher_report(Request $request)
        {
                if (!session()->exists('Data')) {

                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));

                        $contra_account = $request->input('contra_account');
                        $salesOfficer = $request->input('sales_officer');

                        $company = $request->input('company');



                        $type = $request->input('type');

if($type == 1){

                        $query = ReceiptVoucher::whereBetween('receipt_vouchers.date', [$startDate, $endDate]);

                        if ($company) {
                                $query->where('company', $company);
                                $company = buyer::where('buyer_id', $company)->first();
                        }
                        if ($contra_account) {
                                $query->where('cash_bank', $contra_account);
                        }

                        if ($salesOfficer) {
                                $query->where('sales_officer', $salesOfficer);
                        }


                        $r_voucher = $query->orderBy('date', 'asc')->get();

                        $data = [
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'contra_account' => $contra_account,
                                'r_voucher' => $r_voucher,
                                'company' => $company,
                                'type' => $type ?? null
                        ];

                        session()->flash('Data', $data);
                }
elseif($type == 2){

                        $query = ReceiptVoucher::whereBetween('receipt_vouchers.date', [$startDate, $endDate]);

                      
                        if ($contra_account) {
                                $query->where('cash_bank', $contra_account);
                        }

                        if ($salesOfficer) {
                                $query->where('sales_officer', $salesOfficer);
                        }
                        if ($company) {
                                $query->where('company', $company);
                                $company = buyer::where('buyer_id', $company)->first();
                        }
                        $query2 = JournalVoucher::whereBetween('date', [$startDate, $endDate]);

                        if ($contra_account) {
                                $query2->where(function ($query) use ($company) {
                                        $query->where('from_account', $company)
                                              ->where('status', 'credit');
                                    })->orWhere(function ($query) use ($company) {
                                        $query->where('to_account', $company)
                                              ->where('status', 'debit');
                                    });
                                    
                        } 

                        if ($salesOfficer) {
                                $query2->where('sales_officer', $salesOfficer);
                        }

                        if ($company) {
                                $account = accounts::where('reference_id', $company->buyer_id)->pluck('id');
                                $query2->where(function ($query) use ($account) {
                                        $query->where('from_account', $account)->orWhere('to_account', $account);;
                                    });
                        }
                       
                        $r_voucher = $query->orderBy('date', 'asc')->get();
                        $journal_voucher = $query2->orderBy('date', 'asc')->get();

                        $data = [
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'contra_account' => $contra_account,
                                'r_voucher' => $r_voucher,
                                'journal_voucher' => $journal_voucher,
                                'company' => $company,
                                'type' => $type ?? null
                        ];

                        session()->flash('Data', $data);
                }
        }

                if (session()->has('Data')) {
                        $html = view('pdf.voucher.r_voucher_rep')->render();
                        return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
                }
        }


        function e_voucher_report(Request $request)
        {
                if (!session()->exists('Data')) {

                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));

                        $expense_account = $request->input('expense_account');
                        $salesOfficer = $request->input('sales_officer');

                        $company = $request->input('company');


                        $type = $request->input('type');


                        $query = ExpenseVoucher::whereBetween('expense_vouchers.date', [$startDate, $endDate]);

                        if ($company) {
                                // $ex_buyer_id = $query->pluck('buyer');
                                // $ex_accounts = accounts::whereIn('id', $ex_buyer_id)->firstOrFail();
                                // if ($ex_accounts->reference_id != null) {
                                // }
                                $query->where('buyer', $company);
                                $company = buyer::where('buyer_id', $company)->first();
                        }
                        if ($expense_account) {
                                $query->where('cash_bank', $expense_account);
                        }

                        if ($salesOfficer) {
                                $query->where('sales_officer', $salesOfficer);
                        }


                        $e_voucher = $query->get();

                        $data = [
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'expense_account' => $expense_account,
                                'e_voucher' => $e_voucher,
                                'company' => $company,
                                'type' => $type ?? null
                        ];

                        session()->flash('Data', $data);
                }


                if (session()->has('Data')) {
                        $html = view('pdf.voucher.e_voucher_rep')->render();
                        return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
                }
        }

        function j_voucher_report(Request $request)
        {
                if (!session()->exists('Data')) {

                        $startDate = Carbon::parse($request->input('start_date'));
                        $endDate = Carbon::parse($request->input('end_date'));

                        $from_account = $request->input('from_account');
                        $to_account = $request->input('to_account');
                        $salesOfficer = $request->input('sales_officer');

                        $type = $request->input('type');


                        $query = JournalVoucher::whereBetween('journal_vouchers.date', [$startDate, $endDate]);

                        if ($from_account) {
                                $query->where('from_account', $from_account);
                                $from_account = accounts::where('id', $from_account)->first();
                        }
                        if ($to_account) {
                                $query->where('to_account', $to_account);
                                $to_account = accounts::where('id', $to_account)->first();
                        }

                        if ($salesOfficer) {
                                $query->where('sales_officer', $salesOfficer);
                        }


                        $j_voucher = $query->get();

                        $data = [
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'from_account' => $from_account,
                                'to_account' => $to_account,
                                'j_voucher' => $j_voucher,
                                'type' => $type ?? null
                        ];

                        session()->flash('Data', $data);
                }


                if (session()->has('Data')) {
                        $html = view('pdf.voucher.j_voucher_rep')->render();
                        return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
                }
        }


        function invoice_chicken(Request $request, $id, $method)
        {
                $single_data = ChickenInvoice::where('unique_id', $id)->first();
                $data = ChickenInvoice::where('unique_id', $id)->get();
                session()->flash("pdf_data", $data);
                session()->flash("single_pdf_data", $single_data);

                $pdf = new Dompdf();

                $html = view('pdf.farm.invoice_chicken', compact('method'))->render();

                $pdf->loadHtml($html);

                $contentLength = strlen($html);
                if ($contentLength > 5000) {
                        $pdf->setPaper('A3', 'portrait');
                } else {
                        $pdf->setPaper('A4', 'portrait');
                }

                $pdf->render();

                return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
        }
        function invoice_chick(Request $request, $id)
        {
                $single_data = ChickInvoice::where('unique_id', $id)->first();
                $data = ChickInvoice::where('unique_id', $id)->get();
                session()->flash("pdf_data", $data);
                session()->flash("single_pdf_data", $single_data);

                $pdf = new Dompdf();

                $html = view('pdf.farm.invoice_chick')->render();

                $pdf->loadHtml($html);

                $contentLength = strlen($html);
                if ($contentLength > 5000) {
                        $pdf->setPaper('A3', 'portrait');
                } else {
                        $pdf->setPaper('A4', 'portrait');
                }

                $pdf->render();

                return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
        }

        function invoice_feed(Request $request, $id, $method)
        {
                $single_data = feedInvoice::where('unique_id', $id)->first();
                $data = feedInvoice::where('unique_id', $id)->get();
                session()->flash("pdf_data", $data);
                session()->flash("single_pdf_data", $single_data);

                $pdf = new Dompdf();

                $html = view('pdf.farm.invoice_feed', compact('method'))->render();

                $pdf->loadHtml($html);

                $contentLength = strlen($html);
                if ($contentLength > 5000) {
                        $pdf->setPaper('A3', 'portrait');
                } else {
                        $pdf->setPaper('A4', 'portrait');
                }

                $pdf->render();

                return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
        }



        function invoice_sale(Request $request, $id, $method)
        {
                $single_data = SaleInvoice::where('unique_id', $id)->first();
                $data = SaleInvoice::where('unique_id', $id)->get();
                session()->flash("pdf_data", $data);
                session()->flash("single_pdf_data", $single_data);

                $pdf = new Dompdf();

                $html = view('pdf.invoice_sale', compact('method'))->render();

                $pdf->loadHtml($html);

                $contentLength = strlen($html);
                if ($contentLength > 5000) {
                        $pdf->setPaper('A3', 'portrait');
                } else {
                        $pdf->setPaper('A4', 'portrait');
                }

                $pdf->render();

                return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
        }



        public function sale_pur_report(Request $request)
        {
                $type = $request['type'];
                $startDate = Carbon::parse($request->input('start_date'));
                $endDate = Carbon::parse($request->input('end_date'));

                // Retrieve form data
                $customer = $request->input('customer');
                $supplier = $request->input('supplier');
                $salesOfficer = $request->input('sales_officer');
                $warehouse = $request->input('warehouse');
                $product_category = $request->input('product_category');
                $product_company = $request->input('product_company');
                $product = $request->input('product');
                $product_id = null;
                if ($customer && $supplier) {
                    $customerCompany = buyer::where('buyer_id', $customer)->first();
                        $supplierCompany = buyer::where('buyer_id', $customer)->first();
                }elseif ($customer) {
                        $customerCompany = buyer::where('buyer_id', $customer)->first();
                } elseif ($supplier) {
                        $supplierCompany = buyer::where('buyer_id', $supplier)->first();
                }
                if ($type == 1) {



                        $chickenInvoice = chickenInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($customer) {
                                $chickenInvoice->Where('buyer', $customer);
                        }
                        if ($supplier) {
                                $chickenInvoice->Where('seller', $supplier);
                        }

                        if ($salesOfficer) {
                                $chickenInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $chickenInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $chickenInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $chickenInvoice->where('item', $product);
                        }

                        $chickInvoice = ChickInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($customer) {
                                $chickInvoice->Where('buyer', $customer);
                        }
                        if ($supplier) {
                                $chickInvoice->Where('seller', $supplier);
                        }


                        if ($salesOfficer) {
                                $chickInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $chickInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $chickInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $chickInvoice->where('item', $product);
                        }

                        $feedInvoice = feedInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($customer) {
                                $feedInvoice->Where('buyer', $customer);
                        }

                        if ($supplier) {
                                $feedInvoice->Where('seller', $supplier);
                        }

                        if ($salesOfficer) {
                                $feedInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $feedInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $feedInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $feedInvoice->where('item', $product);
                        }

                        $chickenData = $chickenInvoice->orderBy('date', 'asc')->get();
                        $chickData = $chickInvoice->orderBy('date', 'asc')->get();
                        $feedData = $feedInvoice->orderBy('date', 'asc')->get();

                        $data = [
                                'chickenData' => $chickenData,
                                'chickData' => $chickData,
                                'feedData' => $feedData,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'customerCompany' => $customerCompany ?? null,
                                'supplierCompany' => $supplierCompany ?? null,
                                'type' => $type,
                        ];

                        session()->flash('Data', $data);
                } elseif ($type == 2) {

                        $chickenInvoice = chickenInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($customer) {
                                $chickenInvoice->Where('buyer', $customer);
                        }
                        if ($supplier) {
                                $chickenInvoice->Where('seller', $supplier);
                        }

                        if ($salesOfficer) {
                                $chickenInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $chickenInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $chickenInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $chickenInvoice->where('item', $product);
                        }


                        $chickenData = $chickenInvoice->orderBy('date', 'asc')->get();
                        $data = [
                                'chickenData' => $chickenData,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'company' => $company ?? null,
                                'type' => $type,
                        ];

                        session()->flash('Data', $data);
                } elseif ($type == 3) {

                        $chickInvoice = ChickInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($customer) {
                                $chickInvoice->Where('buyer', $customer);
                        }
                        if ($supplier) {
                                $chickInvoice->Where('seller', $supplier);
                        }


                        if ($salesOfficer) {
                                $chickInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $chickInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $chickInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $chickInvoice->where('item', $product);
                        }


                        $chickData = $chickInvoice->orderBy('date', 'asc')->get();

                        $data = [
                                'chickData' => $chickData,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'company' => $company ?? null,
                                'type' => $type,
                        ];

                        session()->flash('Data', $data);
                } elseif ($type == 4) {




                        $feedInvoice = feedInvoice::whereBetween('date', [$startDate, $endDate]);
                        if ($customer) {
                                $feedInvoice->Where('buyer', $customer);
                        }

                        if ($supplier) {
                                $feedInvoice->Where('seller', $supplier);
                        }

                        if ($salesOfficer) {
                                $feedInvoice->where('sales_officer', $salesOfficer);
                        }
                        if ($product_category) {
                                $productIds = Products::where('category', $product_category)->pluck('product_id')->toArray();
                                $feedInvoice->whereIn('item', $productIds);
                        }

                        if ($product_company) {
                                $productIds = Products::where('company', $product_company)->pluck('product_id')->toArray();
                                $feedInvoice->whereIn('item', $productIds);
                        }
                        if ($product) {
                                $feedInvoice->where('item', $product);
                        }


                        $feedData = $feedInvoice->orderBy('date', 'asc')->get();

                        $data = [

                                'feedData' => $feedData,
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'company' => $company ?? null,
                                'type' => $type,
                        ];

                        session()->flash('Data', $data);
                }
                if (session()->has('Data')) {

                        $views = 'Sale + Supplier Report';

                        $pdf = new Dompdf();

                        $data = compact('pdf');
                        $html = view('pdf.ledger.sale_pur_report')->render();

                        // $pdf->loadHtml($html);


                        // $contentLength = strlen($html);
                        // if ($contentLength > 5000) {
                        //         $pdf->setPaper('A3', 'portrait');
                        // } else {
                        //         $pdf->setPaper('A4', 'portrait');
                        // }
                        // $pdf->render();
                        // session()->forget('Data');

                        return view('pdf.pdf_view_bootstrap', ['pdf' => $html]);
                }
        }

}
