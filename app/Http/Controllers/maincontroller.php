<?php

namespace App\Http\Controllers;

use App\Models\chickenInvoice;
use App\Models\ChickInvoice;
use App\Models\ExpenseVoucher;
use App\Models\feedInvoice;
use App\Models\JournalVoucher;
use App\Models\products;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;


use App\Models\users;
use App\Models\customization;
use App\Models\buyer;
use App\Models\seller;

use App\Models\warehouse;
use App\Models\zone;
use App\Models\sales_officer;



use App\Models\accounts;
use App\Models\Expense;
use App\Models\Income;
use App\Models\p_voucher;
use App\Models\SaleInvoice;
use App\Models\purchase_invoice;
use App\Models\ReceiptVoucher;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class maincontroller extends Controller
{

    function account(Request $request, $head, $sub_head)
    {

        $head_accounts = DB::table('head_accounts')->get();
        $sub_head_accounts = DB::table('sub_head_accounts')->where('head', $head)->get();
        $all_sub_head_accounts = DB::table('sub_head_accounts')->get();
        $accounts = accounts::where("account_category", $head)->get();
        $data = compact('accounts', 'head', 'sub_head', 'head_accounts', 'sub_head_accounts', 'all_sub_head_accounts');
        return view('accounts')->with($data);
    }
    function get_data_account(Request $request)
    {
        $id = $request->input('id');
        $data = accounts::where(["account_category" => $id])->get();
        return response()->json($data);
    }

    function data_account(Request $request, $head, $sub_head)
    {
        if ($sub_head) {
            $accounts = accounts::where("account_category", $sub_head)->get();
        }

        return DataTables::of($accounts)->make(true);
    }
    function add_account(Request $request)
    {
        $request->validate([
            'account_name' => 'required',
        ]);


        $add = new accounts();
        $add->account_name = $request['account_name'];
        $add->account_category = $request['account_category'];
        $add->account_qty = $request['account_qty'];
        $add->account_debit = $request['account_debit'];
        $add->account_credit = $request['account_credit'];

        $add->save();
        session()->flash('message', 'account has been added successfully');
        return redirect()->back();
    }

    function edit_account(Request $request, $id)
    {
        $request->validate([
            'account_name' => 'required',
        ]);
        if ($request['move_account']) {
            $query = accounts::where('id', $id)->update([

                'account_name' => $request['account_name'],
                'account_qty' => $request['account_qty'],
                'account_debit' => $request['account_debit'],
                'account_credit' => $request['account_credit'],
                'account_category' => $request['move_account'],
            ]);
        } else {
            $query = accounts::where('id', $id)->update([

                'account_name' => $request['account_name'],
                'account_qty' => $request['account_qty'],
                'account_debit' => $request['account_debit'],
                'account_credit' => $request['account_credit'],
            ]);
        }
        session()->flash('message', 'account has been updated successfully');


        return redirect()->back();
    }
    function delete_account(Request $request, $id)
    {
        $check1 = p_voucher::where('cash_bank', $id)->exists();
        $check2 = ReceiptVoucher::where('cash_bank', $id)->exists();
        $check3 = ExpenseVoucher::where('cash_bank', $id)->orWhere('buyer', $id)->exists();
        $check4 = JournalVoucher::where('from_account', $id)->orWhere('to_account', $id)->exists();
        if ($check1 || $check2 || $check3 || $check4) {
            session()->flash('something_error', 'Account exists somewhere else');
            return redirect()->back();
        } else {
            $query = accounts::where('id', $id)->delete();
            session()->flash('message', 'Account has been deleted successfully');
            return redirect()->back();
        }




        // Temporary 

        // $accounts = accounts::all();
        // foreach ($accounts as $accountRow) {

        //     $check1 = p_voucher::where('cash_bank', $accountRow->id)->exists();
        //     $check2 = ReceiptVoucher::where('cash_bank', $accountRow->id)->exists();
        //     $check3 = ExpenseVoucher::where('cash_bank', $accountRow->id)->orWhere('buyer', $accountRow->id)->exists();
        //     $check4 = JournalVoucher::where('from_account', $accountRow->id)->orWhere('to_account', $accountRow->id)->exists();

        //     $check5 = chickenInvoice::where('buyer', $accountRow->reference_id)->orWhere('seller', $accountRow->reference_id)->exists();
        //     $check6 = chickInvoice::where('buyer', $accountRow->reference_id)->orWhere('seller', $accountRow->reference_id)->exists();
        //     $check7 = feedInvoice::where('buyer', $accountRow->reference_id)->orWhere('seller', $accountRow->reference_id)->exists();

        //     if (!$check1 && !$check2 && !$check3 && !$check4 && !$check5 && !$check6 && !$check7) {
        //         accounts::where('id',$accountRow->id)->delete();
        //     } 
        // }
    }





























































    function warehouse(Request $request)
    {

        $search = $request->input('search');

        if ($search != '') {
            $users = warehouse::where('warehouse_name', 'LIKE', "%$search%")->get();
            $category = zone::all();
            $data = compact('users', 'category', 'search');
            return view('warehouse')->with($data);
        }
        $users = warehouse::leftJoin('zone', 'zone', '=', 'zone.zone_id')->get();
        $category = zone::all();
        $data = compact('users', 'category', 'search');
        return view('warehouse')->with($data);
    }
    function add_warehouse(Request $request)
    {
        $request->validate([
            'warehouse_name' => 'required',
        ]);

        $add = new warehouse();
        $add->warehouse_name = $request['warehouse_name'];
        $add->zone = $request['zone'];
        $add->save();

        session()->flash('message', 'Warehouse has been added successfully');
        return redirect()->back();
    }

    function edit_warehouse(Request $request, $id)
    {
        $request->validate([
            'warehouse_name' => 'required',
        ]);
        $query = warehouse::where('warehouse_id', $id)->update([

            'warehouse_name' => $request['warehouse_name'],
            'zone' => $request['zone'],


        ]);

        session()->flash('message', 'Warehouse has been updated successfully');


        return redirect()->back();
    }

    function warehouse_delete(Request $request, $id)
    {

        $query = warehouse::where('warehouse_id', $id)->delete();

        session()->flash('message', 'Warehouse has been deleted successfully');


        return redirect()->back();
    }















    function zone(Request $request)
    {
        $search = $request->input('search');

        if ($search != '') {
            $users = zone::where('zone_name', 'LIKE', "%$search%")->get();
            $data = compact('users', 'search');
            return view('zone')->with($data);
        }
        $users = zone::all();
        $data = compact('users', 'search');
        return view('zone')->with($data);
    }
    function add_zone(Request $request)
    {
        $request->validate([
            'zone_name' => 'required',
        ]);

        $add = new zone();
        $add->zone_name = $request['zone_name'];
        $add->save();

        session()->flash('message', 'Zone has been added successfully');
        return redirect()->back();
    }

    function edit_zone(Request $request, $id)
    {

        $request->validate([
            'zone_name' => 'required',
        ]);

        $query = zone::where('zone_id', $id)->update([

            'zone_name' => $request['zone_name'],


        ]);

        session()->flash('message', 'Zone has been updated successfully');


        return redirect()->back();
    }

    function zone_delete(Request $request, $id)
    {

        $query = zone::where('zone_id', $id)->delete();

        session()->flash('message', 'Zone has been deleted successfully');


        return redirect()->back();
    }






















    function sales_officer(Request $request)
    {
        $search = $request->input('search');

        if ($search != '') {
            $users = sales_officer::where('sales_officer_name', 'LIKE', "%$search%")->get();
            $data = compact('users', 'search');
            return view('sales_officer')->with($data);
        }
        $users = sales_officer::all();
        $data = compact('users', 'search');
        return view('sales_officer')->with($data);
    }
    function add_sales_officer(Request $request)
    {

        $request->validate([
            'sales_officer_name' => 'required',
        ]);
        $add = new sales_officer();
        $add->sales_officer_name = $request['sales_officer_name'];
        $add->phone_number = $request['phone_number'];
        $add->email = $request['email'];

        $add->save();


        session()->flash('message', 'Sales Officer has been added successfully');


        return redirect()->back();
    }

    function edit_sales_officer(Request $request, $id)
    {
        $request->validate([
            'sales_officer_name' => 'required',
        ]);
        $query = sales_officer::where('sales_officer_id', $id)->update([
            'sales_officer_name' => $request['sales_officer_name'],
            'phone_number' => $request['phone_number'],
            'email' => $request['email'],
        ]);

        session()->flash('message', 'Sales Officer has been updated successfully');


        return redirect()->back();
    }

    function sales_officer_delete(Request $request, $id)
    {

        $query = sales_officer::where('sales_officer_id', $id)->delete();

        session()->flash('message', 'Sales Officer has been deleted successfully');


        return redirect()->back();
    }

















    public function get_week_data(Request $request)
    {



        // Get the current date
        $currentDate = Carbon::now();

        // Calculate the start and end dates of the week
        $startOfWeek = $currentDate->startOfWeek();
        $endOfWeek = $currentDate->endOfWeek();

        $classcheck = $request->input('data');
        if ($classcheck == 'buyer') {

            $weekData = buyer::all();
        }

        // Query the database to fetch data for the week



        // Return the data as a JSON response
        return response()->json($weekData);
    }



















































    // public function pdf()
    // {

    //         // Create a new Dompdf instance
    //         $pdf = new Dompdf();

    //         // Render the static content of the specific div as HTML
    //         $html = '<div class="table-responsive table-responsive-data2">
    //                     <table class="table table-data2">
    //                         <thead>
    //                             <tr>
    //                                 <th>
    //                                     <label class="au-checkbox">
    //                                         <input type="checkbox">
    //                                         <span class="au-checkmark"></span>
    //                                     </label>
    //                                 </th>
    //                                 <th>Company name</th>
    //                                 <th>Contact Person</th>
    //                                 <th>Debit</th>
    //                                 <th>Credit</th>
    //                                 <th>no.records</th>
    //                                 <th>buyer Type</th>
    //                             </tr>
    //                         </thead>
    //                         <tbody>
    //                             <tr class="tr-shadow">
    //                                 <td>
    //                                     <label class="au-checkbox">
    //                                         <input type="checkbox">
    //                                         <span class="au-checkmark"></span>
    //                                     </label>
    //                                 </td>
    //                                 <td>Company A</td>
    //                                 <td>Contact Person A</td>
    //                                 <td>1000</td>
    //                                 <td>500</td>
    //                                 <td>10</td>
    //                                 <td>Buyer Type A</td>
    //                             </tr>
    //                             <tr class="tr-shadow">
    //                                 <td>
    //                                     <label class="au-checkbox">
    //                                         <input type="checkbox">
    //                                         <span class="au-checkmark"></span>
    //                                     </label>
    //                                 </td>
    //                                 <td>Company B</td>
    //                                 <td>Contact Person B</td>
    //                                 <td>2000</td>
    //                                 <td>1000</td>
    //                                 <td>20</td>
    //                                 <td>Buyer Type B</td>
    //                             </tr>
    //                         </tbody>
    //                     </table>
    //                 </div>';

    //         // Load the HTML content into Dompdf
    //         $pdf->loadHtml($html);

    //         // (Optional) Set any additional configuration options, such as page size or orientation
    //         $pdf->setPaper('A4', 'portrait');

    //         // Render the PDF
    //         $pdf->render();

    //         // Generate a response with the PDF content
    //         $response = new Response($pdf->output(), 200);

    //         // Set the appropriate headers for downloading the PDF
    //         $response->header('Content-Type', 'application/pdf');
    //         $response->header('Content-Disposition', 'attachment; filename="buyer_table.pdf"');

    //         return $response;




    // }









    public function back_page()
    {
        return redirect();
    }


    function dashboard_data(Request $request)
    {

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $pur_qty = ChickInvoice::whereBetween(DB::raw('DATE(chick_invoices.updated_at)'), [$start_date, $end_date])->whereIn('chick_invoices.id', function ($subQuery) {
            $subQuery->select(DB::raw('MIN(id)'))
                ->from('chick_invoices')
                ->groupBy('unique_id');
        })->sum("qty");

        $sell_qty = chickenInvoice::whereBetween(DB::raw('DATE(chicken_invoices.updated_at)'), [$start_date, $end_date])->whereIn('chicken_invoices.id', function ($subQuery) {
            $subQuery->select(DB::raw('MIN(id)'))
                ->from('chicken_invoices')
                ->groupBy('unique_id');
        })->sum("hen_qty");

        $earning = Income::whereBetween(DB::raw('DATE(incomes.updated_at)'), [$start_date, $end_date])->sum('amount');
        $expense = Expense::whereBetween(DB::raw('DATE(expenses.updated_at)'), [$start_date, $end_date])->sum('amount');

        $data = compact('sell_qty', 'pur_qty', 'earning', 'expense');
        return response()->json($data);
    }


    public function viewhome()
    {

        if (session()->has("user_id")) {
            if (session()->get("user_id")['role'] != 'farm_user') {

                $end_date = date('Y-m-d');
                $start_date = date('Y-m-d', strtotime("-1 year", strtotime($end_date)));
                $currentYear = Carbon::now()->year;
                $today = Carbon::now()->format('Y-m-d');

                $topProducts = products::select(
                    'products.product_id',
                    'products.product_name',
                    DB::raw('SUM(sale_invoices.qty) as total_quantity')
                )
                    ->join('sale_invoices', 'products.product_id', '=', 'sale_invoices.item')
                    ->whereYear('sale_invoices.updated_at', $currentYear)
                    ->groupBy(
                        'products.product_id',
                        'products.product_name',
                    )
                    ->orderByDesc('total_quantity')
                    ->take(3)
                    ->get();

                $pur_invoice_qty = ChickInvoice::whereBetween(DB::raw('DATE(chick_invoices.updated_at)'), [$start_date, $end_date])->whereIn('chick_invoices.id', function ($subQuery) {
                    $subQuery->select(DB::raw('MIN(id)'))
                        ->from('chick_invoices')
                        ->groupBy('unique_id');
                })->sum("qty");

                $SaleInvoice_qty = chickenInvoice::whereBetween(DB::raw('DATE(chicken_invoices.updated_at)'), [$start_date, $end_date])->whereIn('chicken_invoices.id', function ($subQuery) {
                    $subQuery->select(DB::raw('MIN(id)'))
                        ->from('chicken_invoices')
                        ->groupBy('unique_id');
                })->sum("hen_qty");

                // $earningQuery = chickenInvoice::select('id', 'sale_amount', 'updated_at')
                // ->union(ChickInvoice::select('id', 'amount', 'updated_at'))
                // ->union(feedInvoice::select('id', 'amount', 'updated_at'))
                // ->union();

                $earning_chartData = ReceiptVoucher::select('id', 'amount', 'updated_at')->get()->groupBy(function ($data) {
                    return Carbon::parse($data->updated_at)->format('M');
                });
                $earning_chart = [];
                foreach ($earning_chartData as $month => $value) {
                    $earning_chart[] = $value->sum('amount');
                }

                $expense_chartData = p_voucher::select('id', 'amount', 'updated_at')->get()->groupBy(function ($data) {
                    return Carbon::parse($data->updated_at)->format('M');
                });

                // dd($expense_chartData);
                $months = [];
                $expense_chart = [];
                foreach ($expense_chartData as $month => $value) {
                    $months[] = $month;
                    $expense_chart[] = $value->sum('amount');
                }
                // $earning_y = Income::select(
                //     DB::raw('MONTH(updated_at) as month'),
                //     DB::raw('SUM(amount) as total_earning')
                // )
                //     ->whereYear('updated_at', 2023)
                //     ->groupBy(DB::raw('MONTH(updated_at)'))
                //     ->orderBy(DB::raw('MONTH(updated_at)'))
                //     ->get();

                // $chartData = [];
                // foreach ($earning_y as $item) {
                //     $chartData[] = [

                //         $chartData[$item->month] = $item->total_earning
                //     ];
                // }

                // dd($chartData);
                // $expense_y = Expense::select(
                //     DB::raw('MONTH(updated_at) as month'),
                //     DB::raw('SUM(amount) as total_earning')
                // )
                //     ->whereYear('updated_at', 2023)
                //     ->groupBy(DB::raw('MONTH(updated_at)'))
                //     ->orderBy(DB::raw('MONTH(updated_at)'))
                //     ->get();

                // $chartData2 = [];
                // foreach ($expense_y as $item) {
                //     $chartData2[] = [

                //         $chartData2[$item->month] = $item->total_earning
                //     ];
                // }
                // $expense_y1 = purchase_invoice::whereRaw('purchase_invoice.id IN (SELECT MIN(id) FROM purchase_invoice GROUP BY unique_id)')
                //     ->select(
                //         DB::raw('MONTH(updated_at) as month'),
                //         DB::raw('SUM(amount_total) as total_earning')
                //     )
                //     ->whereYear('updated_at', 2023)
                //     ->groupBy(DB::raw('MONTH(updated_at)'))
                //     ->orderBy(DB::raw('MONTH(updated_at)'));

                // $expense_y2 = p_voucher::whereRaw('payment_voucher.id IN (SELECT MIN(id) FROM payment_voucher GROUP BY unique_id)')
                //     ->select(
                //         DB::raw('MONTH(updated_at) as month'),
                //         DB::raw('SUM(amount_total) as total_earning')
                //     )
                //     ->whereYear('updated_at', 2023)
                //     ->groupBy(DB::raw('MONTH(updated_at)'))
                //     ->orderBy(DB::raw('MONTH(updated_at)'));

                // $combinedResults = $expense_y1->union($expense_y2)->get();



                // $chartData2 = [];
                // foreach ($expense_y2 as $item) {
                //     $chartData2[] = [
                //         $chartData2[$item->month] = $item->total_earning
                //     ];
                // }

                // foreach ($combinedResults as $item) {
                //     $chartData2[] = [

                //         $chartData2[$item->month] = $item->total_earning
                //     ];
                // }

                // $re = ReceiptVoucher::whereDate('updated_at', $today)
                // ->whereIn('receipt_vouchers.id', function ($subQuery) {
                //     $subQuery->select(DB::raw('MIN(id)'))
                //         ->from('receipt_vouchers')
                //         ->groupBy('unique_id');
                // })
                // ->sum('amount_total');


                $si = Income::whereBetween(DB::raw('DATE(incomes.updated_at)'), [$start_date, $end_date])->sum('amount');
                $earning = $si;

                $expense = Expense::whereBetween(DB::raw('DATE(expenses.updated_at)'), [$start_date, $end_date])->sum('amount');


                $onlineUsersCount = Cache::get('user_last_seen', []);

                // Count the number of "true" values in the array
                $onlineUsersCount = count(array_filter($onlineUsersCount, function ($value) {
                    return $value === true;
                }));

                // Now $onlineUsersCount contains the count of online users
                $data = compact('SaleInvoice_qty', 'pur_invoice_qty', 'topProducts', 'earning', 'expense', 'onlineUsersCount', 'earning_chart', 'months', 'earning_chart', 'expense_chart');
                return view('dashboard')->with($data);
            } else {
                return redirect()->route('daily_reports');
            }
        } else {
            return view('login');
        }
    }


    public function logincheck(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = users::where(
            'username',
            $username
        )->first();

        if ($user && $user->access != 'denied' && Hash::check($request->input('password'), $user->password)) {
            $request->session()->put('user_id', $user);
            return redirect('/');
        } elseif ($user && $user->access == 'denied') {
            $request->session()->flash('error', 'User access denied');
            return redirect('/');
        } else {
            $request->session()->flash('error', 'Please enter valid username or password');
            return redirect('/');
        }
    }




    public function logout()
    {
        session()->forget('user_id');
        return redirect('/');
    }



















    public function purchase_invoice()
    {
        return view('purchase_invoice');
    }



















    public function view_add_user()
    {
        return view('add_user');
    }


    public function viewusers()
    {
        $users = users::orderBy('user_id', 'desc')->get();
        $data = compact('users');
        return view('users')->with($data);
    }


    public function add_user_form(Request $request)
    {

        $request->validate([
            'username' => 'required|unique:users,username,' . $request['user_id'] . ',user_id',
        ]);

        $user = new users();

        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->phone_number = $request['phone_number'];
        $user->password = Hash::make($request['password']);
        $user->role = $request['role'];
        $user->save();

        session()->flash('message', 'User has been added successfully');
        return redirect('/users');

    }

    public function view_edit_user(Request $request, $id)
    {
        $user = users::where([

            'user_id' => $id

        ])->get();

        $data = compact('user');

        return view('edit_user')->with($data);
    }



    public function user_rights(Request $request, $id)
    {
        $user = users::where([

            'user_id' => $id

        ])->get();

        $data = compact('user');

        return view('user_right')->with($data);
    }






    public function user_right_form(Request $request)
    {



        $query = users::where('user_id', $request['user_id'])->update([

            'access' => $request['access'],
            'permission' => $request['permission'],
            'role' => $request['role'],
        ]);


        if (!isset($query)) {

            session()->flash('something_error', 'Some thing went wrong please try again later.');
        } else {
            if ($request['access'] == 'denied') {

                if ($request['user_id'] == session('user_id')['user_id']) {
                    session()->forget('user_id');
                }
            }
            session()->flash('message', 'User rights has been updated successfully');
            return redirect('/users');
        }
    }



    public function edit_user_form(Request $request)
    {
        // $exist = users::where([
        //     'user_id' => $request['user_id'],
        //     'email' => $request['email'],
        //     'username' => $request['username'],
        //     'phone_number' => $request['phone_number'],
        //     'password' => $request['password'],
        //     'role' => $request['role'],
        // ])->get();

        // if (!$exist) {
        // $check = users::where('email', $request['email'])->exists()->ignore($request['user_id']);
        // $check2 = users::where('username', $request['username'])->exists()->ignore($request['user_id']);
        // $check3 = users::where('phone_number', $request['phone_number'])->exists()->ignore($request['user_id']);
        // // $check4 = users::where('password', $request['password'])->exists();
        // // $check5 = users::where('role', $request['role'])->exists();

        // if (!$check || !$check2 || !$check3) {

        $request->validate([

            'email' => 'required|unique:users,email,' . $request['user_id'] . ',user_id',

            'username' => 'required|unique:users,username,' . $request['user_id'] . ',user_id',

            'phone_number' => 'required|unique:users,phone_number,' . $request['user_id'] . ',user_id',

        ]);

        users::where('user_id', $request['user_id'])->update([
            'username' => $request['username'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'password' => Hash::make($request['password']),
            'role' => $request['role'],
        ]);

        session()->flash('message', 'User has been updated successfully');
        return redirect('/users');
    }





    public function user_delete(Request $request, $id)
    {
        users::where([
            'user_id' => $id
        ])->delete();

        session()->flash('message', 'User has been deleted successfully');
        return redirect()->back();
    }


























    public function viewcustomize()
    {

        $customization = customization::all();

        $data = compact('customization');
        return view('customize')->with($data);
    }



    public function customize_form(Request $request)
    {
        $id = session()->get('user_id')['user_id'];

        $customize = users::where('user_id', $id)->update([
            'theme' => $request["theme_color"]
        ]);

        return redirect()->back();
        // $customize->company_name = $request['company'];
        // $customize->theme_color = $request['theme_color'];
        // $customize->save();

    }

    static function theme_color()
    {

        return $theme_color = customization::all();
    }


    public function user_acces()
    {
        $id = session()->get('user_id')['user_id'];
        $user = users::where("user_id", $id)->get();
        $user2 = users::where("user_id", $id)->first();
        session()->put('user_id', $user2);

        foreach ($user as $key => $value) {
            $access = $value->access;
        }

        if ($access == "access") {

            return response()->json(true);
        } elseif ($access == "denied") {

            session()->forget("user_id");
            session()->flash('error', "Your access denied! Contact to your admin to resolve this issue.");

            return response()->json(false);
        }
    }




    public function pdf(Request $request, $view)
    {

        if (session()->has('pdf_data')) {

            $views = $view;

            $pdf = new Dompdf();

            $html = view('pdf.' . $views)->render();

            $pdf->loadHtml($html);
            $pdf->setPaper('A4', 'landscape');

            $pdf->render();

            return $pdf->stream($views . '-' . rand() . '.pdf');
            session()->forget('pdf_data');
        }
    }






























    public function view_sellers(Request $request)
    {
        $search = $request->input('search');
        $zone = zone::paginate(5);
        $seller = seller::paginate(10);
        $serial = $request->input('serial');
        $search = $request->input('search');

        $data = compact('seller', 'search', 'zone', 'serial');
        if ($search) {
            $seller = seller::where('company_name', 'like', '%' . $search . '%')->get();
            $data = compact('seller', 'search', 'zone', 'serial');
            $view = view('load.supplier', $data)->render();
            return response()->json(['view' => $view]);
        } elseif ($request->ajax()) {
            $view = view('load.supplier', $data)->render();
            return response()->json(['view' => $view, 'nextPageUrl' => $seller->nextPageUrl()]);
        }


        if ($request->ajax()) {
            $view = view('load.supplier', $data)->render();
            return response()->json(['view' => $view, 'nextPageUrl' => $seller->nextPageUrl()]);
        }
        return view('sellers')->with($data);
    }

    function data_seller()
    {
        $seller = seller::all();
        return DataTables::of($seller)->make(true);
    }


    public function view_add_seller()
    {
        return view('add_seller');
    }







    public function add_seller_form(Request $request)
    {

        $request->validate([

            'company_name' => 'required|unique:seller,company_name,' . $request['user_id'] . ',seller_id',

        ]);

        $add = new accounts();
        $add->account_name = $request['company_name'];
        $add->account_category = 3;
        $add->account_qty = 0;
        $add->account_debit = 0.00;
        $add->account_credit = 0.00;
        $add->save();


        $user = new seller();

        $user->company_name = $request['company_name'];
        $user->company_email = $request['company_email'];
        $user->company_phone_number = $request['company_phone_number'];
        $user->seller_type = $request['seller_type'];
        $user->address = $request['address'];
        $user->city = $request['city'];
        $user->contact_person_number = $request['contact_person_number'];
        $user->contact_person = $request['contact_person'];

        $user->debit = $request['debit'];
        $user->credit = $request['credit'];

        $user->save();


        session()->flash('message', 'seller has been added successfully');
        return redirect('/sellers');
        // session()->flash('message','user is added');



    }





    public function edit_seller_form(Request $request)
    {

        $request->validate([

            'company_name' => 'required|unique:seller,company_name,' . $request['user_id'] . ',seller_id',

        ]);

        seller::where('seller_id', $request['user_id'])->update([
            'company_name' => $request['company_name'],
            'company_email' => $request['company_email'],
            'company_phone_number' => $request['company_phone_number'],
            'seller_type' => $request['seller_type'],
            'address' => $request['address'],
            'city' => $request['city'],


            'contact_person_number' => $request['contact_person_number'],
            'contact_person' => $request['contact_person'],
            'debit' => $request['debit'],
            'credit' => $request['credit'],



        ]);


        // $user->company_name = $request['company_name'];
        // $user->company_email = $request['company_email'];
        // $user->seller_type = $request['seller_type'];
        // $user->address = $request['address'];
        // $user->city = $request['city'];
        // $user->contact_person_number = $request['contact_person_number'];
        // $user->contact_person = $request['bilty_number'];

        // $user->debit = $request['debit'];
        // $user->credit = $request['credit'];

        session()->flash('message', 'seller has been updated successfully');
        return redirect('/sellers');










        //$user = seller::where([
        //     'seller_id' => $request['seller_id']
        //    ]);

        //     $user->company_name = $request['company_name'];
        //     $user->company_email = $request['company_email'];
        //     $user->salesman = $request['salesman'];
        //     $user->address = $request['address'];
        //     $user->transporter = $request['transporter'];
        //     $user->reference_number	 = $request['reference_number'];
        //     $user->bilty_number = $request['bilty_number'];
        //     $user->payment_due_date = $request['payment_due_date'];

        //     $user->save();
    }



    public function view_edit_seller(Request $request, $id)
    {
        $seller = seller::where([

            'seller_id' => $id

        ])->get();

        $data = compact('seller');

        return view('edit_seller')->with($data);
    }





    public function view_single_seller(Request $request, $id)
    {
        $seller = seller::where([

            'seller_id' => $id

        ])->get();

        $data = compact('seller');

        return view('view_single_seller')->with($data);
    }



    public function view_buyers(Request $request)
    {
        $search = $request->input('search');

        // $pdf = buyer::limit(10)->get();
        $zone = zone::paginate(5);

        // if ($search != '') {
        //     $buyer = buyer::where('company_name', 'LIKE', "%$search%")->get();
        //     $pdf = buyer::where('company_name', 'LIKE', "%$search%")->limit(100)->get();

        //     $data = compact('buyer', 'search', 'pdf', 'zone');
        //     return view('buyers')->with($data);
        // }

        $buyer = buyer::paginate(10);
        $serial = $request->input('serial');
        $search = $request->input('search');
        // if ($search) {
        //     // Retrieve all fillable attributes of the Buyer model
        //     $fillableAttributes = (new Buyer())->getFillable();

        //     // Dynamically construct the query to search all fillable attributes
        //     foreach ($fillableAttributes as $attribute) {
        //         $query->orWhere($attribute, 'like', '%' . $search . '%');
        //     }
        // }
        $data = compact('buyer', 'search', 'zone', 'serial');
        if ($search) {
            $buyer = Buyer::where('company_name', 'like', '%' . $search . '%')->get();
            $data = compact('buyer', 'search', 'zone', 'serial');
            $view = view('load.buyer', $data)->render();
            return response()->json(['view' => $view]);
        } elseif ($request->ajax()) {
            $view = view('load.buyer', $data)->render();
            return response()->json(['view' => $view, 'nextPageUrl' => $buyer->nextPageUrl()]);
        }


        if ($request->ajax()) {
            $view = view('load.buyer', $data)->render();
            return response()->json(['view' => $view, 'nextPageUrl' => $buyer->nextPageUrl()]);
        }
        return view('buyers')->with($data);
    }

    function data_buyer()
    {
        $buyer = buyer::all();
        return DataTables::of($buyer)->make(true);
    }


    public function view_add_buyer()
    {
        return view('add_buyer');
    }



    public function add_buyer_form(Request $request)
    {

        // $buyers = buyer::all();

        // foreach ($buyers as $buyer) {
        //     $account = new accounts();
        //     $account->account_name = $buyer->company_name;
        //     $account->account_category = 1;
        //     $account->account_qty = 0;
        //     $account->account_debit = 0.00;
        //     $account->account_credit = 0.00;
        //     $account->reference_id = $buyer->buyer_id;
        //     $account->save();
        // }

        // die();
        $request->validate([

            'company_name' => 'required|unique:buyer,company_name,' . $request['user_id'] . ',buyer_id',

        ]);



        $user = new buyer();
        $user->company_name = $request['company_name'];
        $user->company_email = $request['company_email'];
        $user->company_phone_number = $request['company_phone_number'];
        $user->buyer_type = $request['buyer_type'];
        $user->address = $request['address'];
        $user->city = $request['city'];
        $user->contact_person = $request['contact_person'];
        $user->contact_person_number = $request['contact_person_number'];
        $user->debit = $request['debit'];
        $user->credit = $request['credit'];

        $user->save();

        $add = new accounts();
        $add->account_name = $request['company_name'];
        $add->account_category = 2;
        $add->account_qty = 0;
        $add->account_debit = 0.00;
        $add->account_credit = 0.00;
        $add->reference_id = $user->buyer_id;
        $add->save();


        session()->flash('message', 'buyer has been added successfully');
        return redirect('/buyers');
        // session()->flash('message','user is added');



    }





    public function edit_buyer_form(Request $request, $id)
    {

        $request->validate([

            'company_name' => 'required|unique:buyer,company_name,' . $id . ',buyer_id',

        ]);

        buyer::where('buyer_id', $id)->update([
            'company_name' => $request['company_name'],
            'company_email' => $request['company_email'],
            'company_phone_number' => $request['company_phone_number'],
            'buyer_type' => $request['buyer_type'],
            'address' => $request['address'],
            'city' => $request['city'],


            'contact_person_number' => $request['contact_person_number'],
            'contact_person' => $request['contact_person'],
            'debit' => $request['debit'],
            'credit' => $request['credit'],
        ]);

        $account = accounts::where('reference_id', $id)->first();
        if ($account) {
            accounts::where('reference_id', $id)->update([
                'account_name' => $request['company_name'],
            ]);
        } else {
            $add = new accounts();
            $add->account_name = $request['company_name'];
            $add->account_category = 2;
            $add->account_qty = 0;
            $add->account_debit = 0.00;
            $add->account_credit = 0.00;
            $add->reference_id = $id;
            $add->save();
        }


        // $user->company_name = $request['company_name'];
        // $user->company_email = $request['company_email'];
        // $user->buyer_type = $request['buyer_type'];
        // $user->address = $request['address'];
        // $user->city = $request['city'];
        // $user->contact_person_number = $request['contact_person_number'];
        // $user->contact_person = $request['bilty_number'];

        // $user->debit = $request['debit'];
        // $user->credit = $request['credit'];

        session()->flash('message', 'buyer has been updated successfully');
        return redirect('/buyers');


        //$user = buyer::where([
        //     'buyer_id' => $request['buyer_id']
        //    ]);

        //     $user->company_name = $request['company_name'];
        //     $user->company_email = $request['company_email'];
        //     $user->salesman = $request['salesman'];
        //     $user->address = $request['address'];
        //     $user->transporter = $request['transporter'];
        //     $user->reference_number	 = $request['reference_number'];
        //     $user->bilty_number = $request['bilty_number'];
        //     $user->payment_due_date = $request['payment_due_date'];

        //     $user->save();
    }



    public function view_edit_buyer(Request $request, $id)
    {
        $buyer = buyer::where('buyer_id', $id)->first();

        $data = compact('buyer');

        return view('edit_buyer')->with($data);
    }





    public function view_single_buyer(Request $request, $id)
    {
        $buyer = buyer::where('buyer_id', $id)->first();

        $data = compact('buyer');

        return view('view_single_buyer')->with($data);
    }
}
