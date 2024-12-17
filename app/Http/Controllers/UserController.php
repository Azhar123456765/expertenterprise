<?php

namespace App\Http\Controllers;

use App\Models\purchase_invoice;
use App\Models\SaleInvoice;
use App\Models\users;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resouwrce.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $id = session()->get('user_id')['user_id'];

        if ($search != '') {
            $users = users::where('user_id', '!=', $id)->where('username', 'LIKE', "%$search%")->get();
            $data = compact('users', 'search');
            return view('users')->with($data);
        }
        $users = users::where('user_id', '!=', $id)->orderBy('user_id', 'desc')->simplepaginate();
        $data = compact('users', 'search');
        return view('users')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add_user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = session()->get('user_id')['role'];
        $user_id = session()->get('user_id')['user_id'];
        $users = users::where('user_id', $id)->get();
        foreach ($users as $key => $value) {
            $role2 = $value->role;
        }
        if ($role == 'admin' && $role2 == 'admin' && $user_id != 1) {
            return redirect('/403');
        } elseif ($role2 != 'admin' || $user_id == 1) {
            $user = users::where([

                'user_id' => $id

            ])->get();

            $data = compact('user');

            return view('edit_user')->with($data);
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
        $request->validate([
            'username' => 'required|unique:users,username,' . $request['user_id'] . ',user_id',
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


    public function user_records(Request $request, $id)
    {
        $sale_invoice = SaleInvoice::where('user_id', $id)->whereIn('sale_invoices.id', function ($query) {
            $query->select(DB::raw('MIN(id)'))
                ->from('sale_invoices')
                ->groupBy('unique_id');
        })->get();

        $purchase_invoice = purchase_invoice::where('user_id', $id)->whereIn('purchase_invoice.id', function ($query) {
            $query->select(DB::raw('MIN(id)'))
                ->from('purchase_invoice')
                ->groupBy('unique_id');
        })->get();

        $users = users::where('user_id', $id)->get();

        $data = compact('sale_invoice', 'purchase_invoice', 'users');

        return view('user-records')->with($data);
    }


    public function user_rights(Request $request, $id)
    {
        $role = session()->get('user_id')['role'];
        $user_id = session()->get('user_id')['user_id'];
        $users = users::where('user_id', $id)->get();
        foreach ($users as $key => $value) {
            $role2 = $value->role;
        }
        if ($role == 'admin' && $role2 == 'admin' && $user_id != 1) {
            return redirect('/403');
        } elseif ($role2 != 'admin' || $user_id == 1) {
            $user = users::where([

                'user_id' => $id

            ])->get();

            $data = compact('user');

            return view('user_right')->with($data);
        }
    }

    public function user_right_form(Request $request)
    {

        $query = users::where('user_id', $request['user_id'])->update([

            'access' => $request['access'],
            'setup_permission' => $request['setup_permission'],
            'finance_permission' => $request['finance_permission'],
            'report_permission' => $request['report_permission'],
            'product_permission' => $request['product_permission'],
            'select_permission' => $request['select_permission'],
            'role' => $request['role'],
        ]);


        if (!isset($query)) {

            session()->flash('something_error', 'Some thing went wrong please try again later.');
        } else {
            session()->flash('message', 'User rights has been updated successfully');
            return redirect('/users');
        }
    }
}
