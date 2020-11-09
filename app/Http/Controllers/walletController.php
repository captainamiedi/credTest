<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountRequest;
use App\Models\Wallet;
use App\Traits\KYCResponseTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class walletController extends Controller
{
    use KYCResponseTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    public function balance(Request $request)
    {
        $wallet = Wallet::with(['users'])->where('user_id', $request->user()->id)->latest()->first();
        return response()->json([
            $wallet
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return Wallet::create([
            'user_id' => $request->user()->id,
            'amount' => $request->amount
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
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }

    public function creditUserWithReferrer($user, $account)
    {
        return Wallet::create([
            'user_id' => $user->id,
            'amount' => 1000,
            'account_id' => $account->id,
            'balance' => 1000
        ]);
    }

    public function transfer(Request $request)
    {
        $kycResponse = $this->KYCResponse($request->user()->name);
        $acc = new accountController();
        $account =$acc->getUserAccount($request->user()->id);
        $receiverAcct = $acc->getReceiverAccount($request->receiver_account);
        $wallet = Wallet::where('user_id', $request->user()->id)->latest()->first();
        $receiverWallet = Wallet::where('user_id', $receiverAcct->id)->latest()->first();
        if($wallet === null) {
            return response()->json(['message' => 'insufficient amount'], 403);
        }
        if ($kycResponse) {
            if ( $request->withdraw_amount < $wallet->balance) {
                if (Hash::check($request->pin, $account->pin)) {
                    Wallet::create([
                        'user_id' =>  $receiverAcct->user_id,
                        'amount' => $receiverWallet->balance + $request->withdraw_amount,
                        'balance' => $receiverWallet->balance + $request->withdraw_amount,
                        'account_id' => $receiverAcct->id,
                    ]);
                    Wallet::create([
                        'user_id' =>  $request->user()->id,
                        'amount' => $wallet->balance - $request->withdraw_amount,
                        'balance' => $wallet->balance - $request->withdraw_amount,
                        'account_id' => $account->id,
                    ]);
                    return response()->json([
                       'message' => 'transfer successful'
                    ], 201);
                } else {
//                    wrong password
                    return response()->json([
                        'message' => 'wrong pin'
                    ], 409);
                }
            } else {
//                insufficient amount
                return response()->json([
                    'message' => 'insufficient amount'
                ], 403);
            }
        } else {
            if ($request->withdraw_amount < 50000) {
                if ($request->withdraw_amount < $account->amount) {
                    if (Hash::check($request->pin, $account->pin)) {
                        Wallet::create([
                            'user_id' =>  $receiverAcct->user_id,
                            'amount' => $wallet->amount,
                            'balance' => $wallet->amount - $request->withdraw_amount,
                            'account_id' => $receiverAcct->id,
                        ]);
                    } else {
//                    wrong password
                        return response()->json([
                            'message' => 'wrong pin'
                        ], 409);
                    }
                } else {
//                insufficient amount
                    return response()->json([
                        'message' => 'insufficient amount'
                    ], 403);
                }
            } else {
//                not permitted
                return response()->json([
                    'message' => 'not permited'
                ], 403);
            }
        }
    }
}
