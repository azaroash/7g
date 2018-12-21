<?php

namespace App\Http\Controllers;

use App\Adverts;
use App\Notifications\ViewAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Notifications\AppNotification;
use Datetime;
use Carbon\Carbon;
use App\Client;
use willvincent\Rateable\Rating;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $id = auth()->user()->id;
        $name = DB::table('users')->where('id', '=', $id)->value('firstName');
        $history = DB::table('purchase')->select('companyName', 'amount', 'purchase_date')->where('member_id', '=', $id)->get();
        //$client = DB::table('clients')->select('companyName', 'categories')->get();
        $cafe = DB::table('clients')->select('companyName', 'location', 'email')->where('categories', '=', 'cafeRestaurant')->get();
        $Point = DB::table('points')->select('points')->where('member_id', '=', $id)->where('reached_max', '=', 0)->first();
        $Point = json_decode(json_encode($Point), true);
        $userPoint = $Point['points'];

//        //start to calculate date to show Advertisement
        $pdate = DB::table('transactions')->where('member_id','=', $id )->where('paid', '=', 0)->value('date');
        $da = strtotime($pdate);
        $purchaseDate = date('Y-m-d', $da);
        $currentDate = new DateTime(Carbon::now());
        $purchaseDate = new DateTime($purchaseDate);
        $interval = $currentDate->diff($purchaseDate);
        $dateInterval = $interval->format('%a');

//        //get viewed Ad, the last user's id, total deferred and amount for the specific user
        $totalDeffered = DB::table('transactions')->select('totalDeferredExpense')->where('member_id', '=', $id)->where('paid', '=', 0)->first();
        $totalDeffered = json_decode(json_encode($totalDeffered), true);
        $totalDef = $totalDeffered['totalDeferredExpense'];
        $purchaseAmount = DB::table('transactions')->select('amount')->where('member_id', '=', $id)->where('paid', '=', 0)->first();
        $purchaseAmount = json_decode(json_encode($purchaseAmount), true);
        $amount = $purchaseAmount['amount'];

        $viewedAd = DB::table('users')->where('id', '=', $id)->value('viewedAd');
        $advertId = DB::table('users')->where('id', '=', $id)->value('lastAdvertId');

        $beforePreviousAd = DB::table('adverts')->where('id', '=', $advertId-2)->get();
        $previousAd = DB::table('adverts')->where('id', '=', $advertId-1)->get();
        $advertOne = DB::table('adverts')->where('id', '=', $advertId)->get();
       // $advertOne = DB::table('adverts')->where('id', '=', $advertId)->get();
        // $advertTwo = DB::table('adverts')->where('id', '=', $advertId+1)->get();
       // $advertThree = DB::table('adverts')->where('id', '=', $advertId+2)->get();

        if($userPoint == 150 || $userPoint == 250){
            return view('home')->with('name', $name)->with('cafe', $cafe)->with('purchaseHistory', $history)->with('userPoint', $userPoint);
        }
        if($userPoint == 400) {
            DB::table('users')->where('id',$id)->update(['activationKey'=>1]);
            return view('home')->with('name', $name)->with('cafe', $cafe)->with('purchaseHistory', $history)->with('userPoint', $userPoint)->with('advertOne', $advertOne);
        }
        if ($userPoint == 600){
            if ($dateInterval >= 15 && $viewedAd > 0) {
                DB::table('users')->where('id',$id)->update(['activationKey'=>2]);
                return view('home')->with('name', $name)->with('cafe', $cafe)->with('purchaseHistory', $history)->with('userPoint', $userPoint)->with('advertOne', $advertOne)->with('previousAd', $previousAd);
            }
            return view('home')->with('name', $name)->with('cafe', $cafe)->with('purchaseHistory', $history)->with('userPoint', $userPoint)->with('previousAd', $previousAd);
        }
        if ($userPoint == 800) {
            if ($dateInterval >= 30 && $viewedAd > 1 && $totalDef == $amount){
                DB::table('users')->where('id',$id)->update(['activationKey'=>3]);
                return view('home')->with('name', $name)->with('cafe', $cafe)->with('purchaseHistory', $history)->with('userPoint', $userPoint)->with('advertOne', $advertOne)->with('previousAd', $previousAd)->with('beforePreviousAd', $beforePreviousAd);
            }
            return view('home')->with('name', $name)->with('cafe', $cafe)->with('purchaseHistory', $history)->with('userPoint', $userPoint)->with('previousAd', $previousAd)->with('beforePreviousAd', $beforePreviousAd);
        }
        if ($userPoint == 1000){
            $message = "Congratulations, you've reached 1000 points. Now you can collect your money from 7G office. But first take your time and rate the service you get when you make purchase to get your next 250 points.";
            return view('home')->with('name', $name)->with('cafe', $cafe)->with('purchaseHistory', $history)->with('userPoint', $userPoint)->with('advertOne', $advertOne)->with('previousAd', $previousAd)->with('beforePreviousAd', $beforePreviousAd)->with('message', $message);
        }

        return view('home')->with('name', $name)->with('cafe', $cafe)->with('purchaseHistory', $history);
    }
    public function viewRating(Request $request){
        $id = auth()->user()->id;
        $c_id = DB::table('purchase')->select('client_id')->where('member_id', '=', $id)->first();
        $c_id = json_decode(json_encode($c_id), true);
        $client_id = $c_id['client_id'];

        $averageRating = DB::table('ratings')->where('client_id', '=', $client_id)->value('averageRating');
        $client_info = DB::table('clients')->select('companyName', 'categories', 'logo')->where('id', '=', $client_id)->get();

        DB::table('points')->where('member_id',$id)->where('points', '=', 1000)->update(['reached_max' => 1]);

        return view('rating')->with('client_id', $client_id)->with('client_info', $client_info)->with('averageRating', $averageRating);
    }
    public function rateClient(Request $request)
    {
        $id = auth()->user()->id;
        $currentDate = new DateTime(Carbon::now());

        $c_id = DB::table('purchase')->select('client_id')->where('member_id', '=', $id)->first();
        $c_id = json_decode(json_encode($c_id), true);
        $client_id = $c_id['client_id'];
        $client = Client::find($client_id);
        $client_rating = DB::table('ratings')->where('client_id', '=', $client_id)->get();

        //resetting everything to zero and start over again after user rates
        DB::table('users')->where('id',$id)->update(['activationKey' => 0, 'viewedAd' => 0]);
        //DB::table('points')->where('member_id',$id)->where('points', '=', 1000)->update(['reached_max' => 1]);

        $date = DB::table('points')->select('date')->where('member_id', $id)->first();
        $date = json_decode(json_encode($date), true);
        $da = $date['date'];
        $point = DB::table('points')->where('member_id',$id)->where('reached_max', '=', 0)->get();
        if($point->isEmpty()){
            DB::table('points')->insert(['member_id' => $id, 'points' => 250, 'date' => $currentDate, 'reached_max' => 0]);
        }
        else{
            DB::table('points')->where('member_id',$id)->where('reached_max','=', 0)->where('date',$da)->update(['points' => 400]);
        }

        if($client_rating->isEmpty()){
                $rating = new \willvincent\Rateable\Rating;
                $rating->totalRating = $request->rate;
                $rating->client_id = $client_id;
                $rating->averageRating = $request->rate;
                $rating->memberCount = 1;
                $client->ratings()->save($rating);

        }else {
                $id = DB::table('ratings')->where('client_id', '=', $client_id)->value('id');
                $memberCount = DB::table('ratings')->where('id', '=', $id)->value('memberCount');
                $totalRating = DB::table('ratings')->where('id', '=', $id)->value('totalRating');
                $totalRating = $totalRating + $request->rate;
                $memberCount = $memberCount + 1;
                $averageRating = $totalRating / $memberCount;

                $rating = Rating::find($id);
                $rating->increment('totalRating', $request->rate);
                $rating->averageRating = $averageRating;
                $rating->increment('memberCount', 1);
                $client->ratings()->save($rating);
        }

        return redirect()->route('home');

    }

    public function markAllAsRead(){
        auth()->user()->unreadNotifcations->markAsRead();

        return redirect()->back();
    }
    public function markThisAsRead($id){
        $user = Auth::user();
        $notification = $user->notifications()->where('id',$id)->first();
        if ($notification)
        {
            $notification->markAsRead();
            return back();
        }
        else{
            return back()->withErrors('we could not found the specified notification');
        }

        return redirect()->back();
    }

    public function viewAd(){

    }
    public function viewAdDone(){
        $id = auth()->user()->id;
        $activationKey = DB::table('users')->where('id', '=', $id)->value('activationKey');
        $viewedAd = DB::table('users')->where('id', '=', $id)->value('viewedAd');
        $point = DB::table('points')->where('member_id', '=', $id)->value('points');



        DB::table('adverts')->where('id', '=', $id)->increment('views');
        if ($point == 400 && $activationKey == $viewedAd +1) {
            if ($viewedAd <3) {
                DB::table('users')->where('id',$id)->increment('viewedAd');
            } else {
                DB::table('users')->where('id',$id)->update(['viewedAd' => 0]);
            }

            DB::table('points')->where('member_id',$id)->where('points', '=', 400)->increment('points',200);
            DB::table('users')->where('id',$id)->increment('lastAdvertId');
            auth()->user()->notify(new ViewAd);
        }
        if ($point == 600 && $activationKey == $viewedAd +1) {
            if ($viewedAd <3) {
                DB::table('users')->where('id',$id)->increment('viewedAd');
            } else {
                DB::table('users')->where('id',$id)->update(['viewedAd' => 0]);
            }

            DB::table('points')->where('member_id',$id)->where('points', '=', 600)->increment('points',200);
            DB::table('users')->where('id',$id)->increment('lastAdvertId');
            auth()->user()->notify(new ViewAd);
        }
        if ($point == 800 && $activationKey == $viewedAd +1) {
            if ($viewedAd <3) {
                DB::table('users')->where('id',$id)->increment('viewedAd');
            } else {
                DB::table('users')->where('id',$id)->update(['viewedAd' => 0]);
            }

            $pdate = DB::table('transactions')->where('member_id','=', $id )->where('paid', '=', 0)->value('date');


            DB::table('points')->where('member_id',$id)->where('points', '=', 800)->update(['points' => 1000]);
           // DB::table('points')->where('member_id',$id)->where('points', '=', 1000)->update(['reached_max' => 1]);
            DB::table('transactions')->where('member_id',$id)->where('date',$pdate)->update(['paid' => 1]);
            //DB::table('users')->where('id',$id)->increment('lastAdvertId');
            //DB::table('users')->where('id',$id)->increment('lastAdvertId');
        }
        if ($point == 1000) {
            $message = "congratulations, now you can get your money from 7G office.";
        }

        //DB::table('users')->where('id',$id)->increment('lastAdvertId');

        return redirect()->to('/home');
    }
    public function viewAdFull($id) {
        //$user = Auth::user();
        $advert = DB::table('adverts')->where('id', $id)->get();
        if($advert){
            return view('ViewAdvert')->with('advert', $advert);
        }
        return view('home');
    }
}
