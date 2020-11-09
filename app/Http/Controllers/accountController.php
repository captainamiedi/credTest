<?php

namespace App\Http\Controllers;

use App\Models\account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class accountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $account = account::where('user_id', $request->user()->id)->first();

        return response()->json([
            $account->toArray()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user)
    {
        return account::create([
           'account_no' => rand(1111111111,9999999999),
           'user_id' => $user->id,
            'pin' => $user->password
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(account $account)
    {
        //
    }


    public function getUserAccount($id)
    {
        return account::where('user_id', $id)->first();
    }

    public function getReceiverAccount($account_no)
    {
        return account::with(['users'])->where('account_no', $account_no)->first();
    }
}
