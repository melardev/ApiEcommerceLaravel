<?php

namespace App\Http\Controllers;

use App\Plans;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Laravel\Cashier\Subscription;

class AdminMembershipsDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function get(Request $request)
    {
        $users = User::with('subscriptions')->has('subscriptions')->get();

        $level1 = Subscription::where('stripe_id', Plans::$LEVEL1)->count();
        $level2 = Subscription::where('stripe_id', Plans::$LEVEL2)->count();
        $fan    = Subscription::where('stripe_id', Plans::$FAN)->count();

        $levels = [
          
            'level1' => ['name' => "Level 1", 'total' => $level1],
            'level2' => ['name' => "Level 2", 'total' => $level2],
            'fan'    => ['name' => "Fan", 'total' => $fan],
        
        ];

        \JavaScript::put([
            'levels' => $levels
        ]);
        
        return view('admin.subscriptions', compact('users'));
    }
}
