<?php

namespace App\Http\Controllers;

use App\Notifications\SuccessfulPurchase;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Notifications\Notification;
use Illuminate\Routing\Controller;
//use Illuminate\Support\Facades\DB;
use App\Purchase;
use App\Transactions;
use Auth;
use PDF;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $id = $request->input('userId');
        $users = DB::table('users')->select('id', 'firstName', 'lastName', 'phone');
        $allUsers = json_decode(json_encode($users), true);

        $client_id = Auth::guard('client')->user()->id;
        $name = DB::table('clients')->where('id', '=', $client_id)->value('companyName');
        $history = DB::table('purchase')->select('amount', 'purchase_date', 'commission')->where('client_id', '=', $client_id)->get();
        $logo = DB::table('clients')->where('id',  '=', $client_id)->value('logo');
        $averageRating = DB::table('ratings')->where('client_id', '=', $client_id)->value('averageRating');

        if(isset($_POST['userId'])){
            $us = DB::table('users')->where('id','=', $id)->get();
            $userdata = array();
            while($rows = $us){
                $userdata = $rows;
            }
            return view('client')->with('userdata', json_encode($userdata));
        }

        return view('client')->with('allUsers', $allUsers)->with('name', $name)->with('purchaseHistory', $history)->with('logo', $logo)->with('averageRating', $averageRating);
    }

    public function store(Request $request)
    {
        //
        //$client = Auth::guard('client')->user()->id;
        $amount = $request->input('amount');
        $commission = ($amount * 15) / 100;

        $deferredExpense = ($amount * 10) / 100;
        $grossProfit = ($amount * 5) / 100;
        $contingency = $amount / 100;

        $companyName = DB::table('clients')->where('id', '=', Auth::guard('client')->user()->id)->value('companyName');

        $purchase = new Purchase;
        $transaction = new Transactions;

        //Store purchase in purchase table
        $purchase->client_id = Auth::guard('client')->user()->id;
        $purchase->companyName = $companyName;
        $purchase->member_id = $request->input('userId');
        $purchase->amount = $amount;
        $purchase->commission = $commission;
        $purchase->purchase_date = date_create();
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

        $updatePointRow = DB::table('points')->where('member_id', '=', $request->input('userId'))->where('reached_max', '=', 0)->first();
        $updatePoint = json_decode(json_encode($updatePointRow) , true);
        if($updatePoint['points'] == 250) {
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
        User::find($request->input('userId'))->notify(new SuccessfulPurchase);
        DB::table('users')->where('id', '=', $request->input('userId'))->increment('lastAdvertId');

        return redirect()->to('client')->with('success', "Registration is Successful!!!");
    }
    public function markAllAsRead(){
        auth()->guard('client')->user()->unreadNotifcations->markAsRead();

        return redirect()->back();
    }
    public function markThisAsRead(){
        $id = auth()->user()->unreadNotifications[0]->id;
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();

        return redirect()->back();
    }

    public function getReport(Request $request) {

        $selectedMonth = $request->input('month');
        
    }

    public function getUserData(Request $request){
        //$id = $request->input('userId');
//        $userData = DB::table('users')->where('id', '=', $id)->get('firstName', 'lastName', 'phone', 'email');
//        return view('client')->with('userData', $userData);

        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                //$data = DB::table('users')->where('id', '=', $query)->get();
                $data = DB::table('users')->where('id', 'like', '%'.$query.'%')->get();
            }
            else
            {
                //$data = DB::table('users')->orderBy('id', 'desc')->get();
            }
            $data = collect($data);
            $total_row = $data->count();

            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr>
                         <td>'.$row->firstName.'</td>
                         <td>'.$row->lastName.'</td>
                         <td>'.$row->phone.'</td>
                         <td>'.$row->email.'</td>
                        </tr>
                    ';
                }
            }
            else
            {
                $output .= '
                   <tr>
                    <td align="center" colspan="5">No User Found</td>
                   </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }

    }
    public function downloadPDF(Request $request){
       // $month = $_GET['month'];

        if($request->has('download')){

            $pdf = PDF::loadView('pdf');

            return $pdf->download('purchaseHistory.pdf');

        }
        return view('pdf');

    }
    public function viewPDF(Request $request){
        $month = $request->input('month');
        $id = Auth::guard('client')->user()->id;
        //$purchase_date = DB::table('purchase')->select('puchase_date')->where('client_id', '=', $id);
        switch ($month) {
            case '1':
                $date = DB::table('purchase')->select('companyName', 'amount', 'commission', 'purchase_date')->where('client_id', '=', $id)->whereMonth('purchase_date', '=', 01 )->get();
                return view('pdf')->with('date', $date);
                break;
            case '2':
                $date = DB::table('purchase')->select('companyName', 'amount', 'commission', 'purchase_date')->where('client_id', '=', $id)->whereMonth('purchase_date', '=', 02 )->get();
                return view('pdf')->with('date', $date);
                break;
            case '3':
                $date = DB::table('purchase')->select('companyName', 'amount', 'commission', 'purchase_date')->where('client_id', '=', $id)->whereMonth('purchase_date', '=', 03 )->get();
                return view('pdf')->with('date', $date);
                break;
            case '4':
                $date = DB::table('purchase')->select('companyName', 'amount', 'commission', 'purchase_date')->where('client_id', '=', $id)->whereMonth('purchase_date', '=', 04 )->get();
                return view('pdf')->with('date', $date);
                break;
            case '5':
                $date = DB::table('purchase')->select('companyName', 'amount', 'commission', 'purchase_date')->where('client_id', '=', $id)->whereMonth('purchase_date', '=', 05 )->get();
                return view('pdf')->with('date', $date);
                break;
            case '6':
                $date = DB::table('purchase')->select('companyName', 'amount', 'commission', 'purchase_date')->where('client_id', '=', $id)->whereMonth('purchase_date', '=', 06 )->get();
                return view('pdf')->with('date', $date);
                break;
            case '7':
                $date = DB::table('purchase')->select('companyName', 'amount', 'commission', 'purchase_date')->where('client_id', '=', $id)->whereMonth('purchase_date', '=', 07 )->get();
                return view('pdf')->with('date', $date);
                break;
            case '8':
                $date = DB::table('purchase')->select('companyName', 'amount', 'commission', 'purchase_date')->where('client_id', '=', $id)->whereMonth('purchase_date', '=', '08' )->get();
                //$date = json_decode(json_encode($date), true);

                view()->share('date', $date);

                return view('pdf')->with('date', $date);
                break;
            case '9':
                $date = DB::table('purchase')->select('companyName', 'amount', 'commission', 'purchase_date')->where('client_id', '=', $id)->whereMonth('purchase_date', '=', '09' )->get();
                return view('pdf')->with('date', $date);
                break;
            case '10':
                $date = DB::table('purchase')->select('companyName', 'amount', 'commission', 'purchase_date')->where('client_id', '=', $id)->whereMonth('purchase_date', '=', 10 )->get();
                return view('pdf')->with('date', $date);
                break;
            case '11':
                $date = DB::table('purchase')->select('companyName', 'amount', 'commission', 'purchase_date')->where('client_id', '=', $id)->whereMonth('purchase_date', '=', 11 )->get();
                return view('pdf')->with('date', $date);
                break;
            case '12':
                $date = DB::table('purchase')->select('companyName', 'amount', 'commission', 'purchase_date')->where('client_id', '=', $id)->whereMonth('purchase_date', '=', 12 )->get();
                return view('pdf')->with('date', $date);
                break;
            default:
                $date = 0;
                return view('pdf')->with('date', $date);
        }
        return view('pdf')->with('date', $date);
    }
}
