<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = users::select('username', 'email', 'role', 'access')->where('access', 'denied')->where('role', 'admin')->get();

        if (count($user) > 0) {
            # code...
            $response = [
                'message' => count($user) . ' users found',
                'data' => $user
            ];
        } else {

            $response = [
                'message' => count($user) . ' users found',
            ];
        }

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'username' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ];
        DB::beginTransaction();
        try {

            users::create($data);
            DB::commit();

            print_r($data->getMessage());
        } catch (\Exception $e) {

            DB::rollBack();
            print_r($e->getMessage());
        }
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
        //
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

        $data = [
            'username' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ];
        $user = users::find($id);
        if (is_null($user)) {
            $response = [
                'message' => 'User does not exist!',
            ];

            return response()->json($response, 404);
        } else {
            DB::beginTransaction();
            try {
                $user->username = $request['name'];
                $user->email = $request['email'];
                $user->password = $request['password'];

                $user->save();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $user = null;
            }
            if (is_null($user)) {
                $response = [
                    'message' => 'Internal Server Error',
                    'msg' => $e->getMessage()
                ];

                return response()->json($response, 500);
            } else {
                $response = [
                    'message' => 'User Updated Sucessfully',
                ];

                return response()->json($response, 200);
            }
        }
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
