<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\Farm;
use App\Models\FarmingPeriod;
use App\Models\HeadAccount;
use App\Models\product_category;
use App\Models\product_company;
use App\Models\product_type;
use App\Models\sales_officer;
use App\Models\SubHeadAccount;
use App\Models\warehouse;
use App\Models\seller;
use App\Models\buyer;
use App\Models\products;
use App\Models\chickenInvoice;
use App\Models\ChickInvoice;
use App\Models\feedInvoice;
use App\Models\zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class select2Controller extends Controller
{
    function farm(Request $request)
    {
        $search = $request->get('q');

        $results = Farm::where('name', 'LIKE', "%{$search}%")
            ->limit(10)->get(['id', 'name']);

        return response()->json($results);
    }
    function farming_period(Request $request)
    {
        $search = $request->get('q');

        $results = FarmingPeriod::where('start_date', 'LIKE', "%{$search}%")
            ->where('end_date', 'LIKE', "%{$search}%")
            ->limit(10)->get(['id', 'start_date', 'end_date']);

        return response()->json($results);
    }
    function head_account(Request $request)
    {
        $search = $request->get('q');

        $results = HeadAccount::where('name', 'LIKE', "%{$search}%")
            ->limit(10)->get(['id', 'name']);

        return response()->json($results);
    }
    function sub_head_account(Request $request)
    {
        $search = $request->get('q');
        $head = $request->get('head');

        $results = SubHeadAccount::where('head', $head)->where('name', 'LIKE', "%{$search}%")
            ->limit(10)->get(['id', 'name']);

        return response()->json($results);
    }
    function dynamic_account(Request $request)
    {
        $search = $request->get('q');
        $sub_head = $request->get('sub_head');

        $results = accounts::where('account_category', $sub_head)->where('account_name', 'LIKE', "%{$search}%")
            ->limit(10)->get(['id', 'account_name']);

        return response()->json($results);
    }
    function account(Request $request)
    {
        $search = $request->get('q');

        $results = accounts::where('account_name', 'LIKE', "%{$search}%")
            ->limit(10)->get(['id', 'account_name']);

        // $buyers = buyer::where('company_name', 'LIKE', "%{$search}%")
        //     ->limit(10)->get(['buyer_id', 'company_name']);

        // $combinedResults = [];
        // foreach ($accounts as $account) {
        //     $combinedResults[$account->account_name] = [
        //         'id' => $account->id,
        //         'account_name' => $account->account_name
        //     ];
        // }

        // foreach ($buyers as $buyer) {
        //     $combinedResults = [
        //         'buyer_id' => $buyer->buyer_id,
        //         'company_name' => $buyer->company_name
        //     ];
        // }

        return response()->json($results);
    }
    function assets_account(Request $request)
    {
        $search = $request->get('q');

        $results = accounts::where('account_name', 'LIKE', "%{$search}%")
            ->whereHas('sub_head', function ($query) {
                $query->where('head', 1);
            })
            ->limit(10)->get(['id', 'account_name']);

        return response()->json($results);
    }
    function liability_account(Request $request)
    {
        $search = $request->get('q');

        $results = accounts::where('account_name', 'LIKE', "%{$search}%")
            ->whereHas('sub_head', function ($query) {
                $query->where('head', 2);
            })
            ->limit(10)->get(['id', 'account_name']);

        return response()->json($results);
    }
    function expense_account(Request $request)
    {
        $search = $request->get('q');

        $results = accounts::where('account_name', 'LIKE', "%{$search}%")
            ->whereHas('sub_head', function ($query) {
                $query->where('head', 5);
            })
            ->limit(10)->get(['id', 'account_name']);

        return response()->json($results);
    }
    function warehouse(Request $request)
    {
        $search = $request->get('q');

        $results = warehouse::where('warehouse_name', 'LIKE', "%{$search}%")
            ->limit(10)->get(['warehouse_id', 'warehouse_name']);

        return response()->json($results);
    }
    function zone(Request $request)
    {
        $search = $request->get('q');

        $results = zone::where('zone_name', 'LIKE', "%{$search}%")
            ->limit(10)->get(['zone_id', 'zone_name']);

        return response()->json($results);
    }

    function sales_officer(Request $request)
    {
        $search = $request->get('q');

        $results = sales_officer::where('sales_officer_name', 'LIKE', "%{$search}%")
            ->limit(10)->get(['sales_officer_id', 'sales_officer_name']);

        return response()->json($results);
    }
    function product_category(Request $request)
    {
        $search = $request->get('q');

        $results = product_category::where('category_name', 'LIKE', "%{$search}%")
            ->limit(10)->get(['product_category_id', 'category_name']);

        return response()->json($results);
    }

    function product_company(Request $request)
    {
        $search = $request->get('q');

        $results = product_company::where('company_name', 'LIKE', "%{$search}%")
            ->limit(10)->get(['product_company_id', 'company_name']);

        return response()->json($results);
    }
   
    function product_type(Request $request)
    {
        $search = $request->get('q');

        $results = product_type::where('type', 'LIKE', "%{$search}%")
            ->limit(10)->get(['product_type_id', 'type']);

        return response()->json($results);
    }
    function buyer(Request $request)
    {
        $search = $request->get('q');

        $results = buyer::where('company_name', 'LIKE', "%{$search}%")
            ->limit(10)->get(['buyer_id', 'company_name']);

        return response()->json($results);
    }
    function seller(Request $request)
    {
        $search = $request->get('q');

        $results = seller::where('company_name', 'LIKE', "%{$search}%")
            ->limit(10)->get(['seller_id', 'company_name']);

        return response()->json($results);
    }

    function products(Request $request)
    {
        $search = $request->get('q');

        $results = products::where('product_name', 'LIKE', "%{$search}%")
            ->limit(10)->get();

        return response()->json($results);
    }
    function seller_buyer(Request $request)
    {
        $search = $request->get('q');

        $resultsS = seller::where('company_name', 'LIKE', "%{$search}%")
            ->select('seller_id as id', 'company_name', DB::raw('"S" as comp_ref'))
            ->toBase();

        $results = buyer::where('company_name', 'LIKE', "%{$search}%")
            ->select('buyer_id as id', 'company_name', DB::raw('"B" as comp_ref'))
            ->union($resultsS)
            ->get();

        return response()->json($results);

    }

    function buyer_invoice_no(Request $request)
    {
        $search = $request->get('q');

        $id = $request->input('id');
        $combinedInvoices = chickenInvoice::select(
            DB::raw("CONCAT('CH-', unique_id) as unique_id_name"),
            'unique_id'  // Select the original unique_id as well
        )
            ->where('buyer', $id)
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
                    ->where('buyer', $id)
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
                    ->where('buyer', $id)
                    ->whereIn('feed_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('feed_invoices')
                            ->groupBy('unique_id');
                    })
            )
            ->get() -> filter(function ($invoice) use ($search) {
                return stripos($invoice->unique_id_name, $search) !== false;
            });


        return response()->json($combinedInvoices);
    }
    function seller_invoice_no(Request $request)
    {
        $search = $request->get('q');

        $id = $request->input('id');
        $combinedInvoices = chickenInvoice::select(
            DB::raw("CONCAT('CH-', unique_id) as unique_id_name"),
            'unique_id'  // Select the original unique_id as well
        )
            ->where('seller', $id)
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
                    ->where('seller', $id)
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
                    ->where('seller', $id)
                    ->whereIn('feed_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('feed_invoices')
                            ->groupBy('unique_id');
                    })
            )
            ->get() -> filter(function ($invoice) use ($search) {
                return stripos($invoice->unique_id_name, $search) !== false;
            });


        return response()->json($combinedInvoices);
    }
    function all_invoice_no(Request $request)
    {
        // dd(1);
        $search = $request->get('q');

        $id = $request->input('id');
        $combinedInvoices = chickenInvoice::select(
            DB::raw("CONCAT('CH-', unique_id) as unique_id_name"),
            'unique_id'  // Select the original unique_id as well
        )
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
                    ->whereIn('feed_invoices.id', function ($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('feed_invoices')
                            ->groupBy('unique_id');
                    })
            )

            ->get()->filter(function ($invoice) use ($search) {
                return stripos($invoice->unique_id_name, $search) !== false;
            });


        return response()->json($combinedInvoices);
    }
}
