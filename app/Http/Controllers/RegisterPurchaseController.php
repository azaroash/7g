<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Purchase;
use App\Transactions;
use Auth;
use App\User;
use DevMarketer\LaraFlash;

class RegisterPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $id = $request->input('userId');
        $us = DB::table('users')->where('id','=', $id)->get();
        $userdata = json_decode(json_encode($us), true);

        return view('client')->with('userdata', $userdata);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('client');
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
        //$client = Auth::guard('client')->user()->id;
        $amount = $request->input('amount');
        $commission = ($amount * 15) / 100;

        $deferredExpense = ($amount * 10) / 100;
        $grossProfit = ($amount * 5) / 100;
        $contingency = $amount / 100;

        $purchase = new Purchase;
        $transaction = new Transactions;

        //Store purchase in purchase table
        $purchase->client_id = Auth::guard('client')->user()->id;
        $purchase->member_id = $request->input('userId');
        $purchase->amount = $amount;
        $purchase->commission = $commission;
        $purchase->purchaseDate = date_create();
        $purchase->save();

        //Store transaction in transactions table without totaldeferred and paid value
        $transaction->member_id = $request->input('userId');
        $transaction->amount = $amount;
        $transaction->commission = $commission;
        $transaction->memberCount = 1;
        $transaction->deferredExpense = $deferredExpense;
        $transaction->grossProfit = $grossProfit;
        $transaction->contingency = $contingency;
        $transaction->save();

        //update totaldeferred and paid based on the conditions below
        $getId = DB::table('transactions')->select('id')->where('paid', '=', '0')->first();
        $array = json_decode(json_encode($getId),true);
        $id = $array['id'];

        $firstAmount = DB::table('transactions')->where('id', '=', $id)->value('amount');
        $secondAmount = DB::table('transactions')->where('id', '=', $id + 1)->value('amount');
        $thirdAmount = DB::table('transactions')->where('id', '=', $id + 2)->value('amount');
        $fourthAmount = DB::table('transactions')->where('id', '=', $id + 3)->value('amount');

        $totalDeferred = DB::table('transactions')->where('paid', '=', 0)->value('totalDeferredExpense');

        $t = $totalDeferred + $deferredExpense;

        $update = Transactions::find($id);
        $updateTwo = Transactions::find($id + 1);
        $updateThree = Transactions::find($id + 2);
        $updateFour = Transactions::find($id + 3);
        $updateFive = Transactions::find($id + 4);

        $updatePointRow = DB::table('points')->where('member_id', '=', $request->input('userId'))->first();
        $updatePoint = json_decode(json_encode($updatePointRow) , true);
        if($updatePoint['points'] < 400) {
            DB::table('points')->where('member_id', '=', $request->input('userId'))->update(['points' => 400]);
        } else {
            DB::table('points')->insert(['member_id' => $request->input('userId'), 'points' => 150]);
        }

        if($t < $firstAmount){
            $update->update(['totalDeferredExpense'=> $t]);
        }
        if ($t >= $firstAmount) {
            $diff = $t - $firstAmount;
            $toadd = $firstAmount - $totalDeferred;
            $newvalue = $totalDeferred + $toadd;
            $update->update(['totalDeferredExpense'=> $newvalue]);
            $update->update(['paid' => 1]);

            if ($diff < $secondAmount) {
                $updateTwo->update(['totalDeferredExpense' => $diff]);
            }
            if ($diff >= $secondAmount) {
                $diffTwo = $diff - $secondAmount;
                $updateTwo->update(['totalDeferredExpense'=> $secondAmount]);
                $updateTwo->update(['paid' => 1]);
                if ($diffTwo < $thirdAmount) {
                    $updateThree->update(['totalDeferredExpense' => $diffTwo]);
                }
                if ($diffTwo >= $thirdAmount) {
                    $diffThree = $diffTwo - $thirdAmount;
                    $updateThree->update(['totalDeferredExpense'=> $thirdAmount]);
                    $updateThree->update(['paid' => 1]);
                    if($diffThree < $fourthAmount) {
                        $updateFour->update(['totalDeferredExpense'=> $diffThree]);
                    }
                    if($diffThree >= $fourthAmount){
                        $difffour = $diffThree - $fourthAmount;
                        $updateFour->update(['totalDeferredExpense'=> $fourthAmount]);
                        $updateFour->update(['paid' => 1]);
                        $updateFive->update(['totalDeferredExpense' => $difffour]);
                    }
                }
            }
        }

        return view('home')->with('success', "Successful!!!");
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
        //
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
