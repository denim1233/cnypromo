<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Carts;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->isAdmin == 1) {

            $userValid = User::where('isValidated', '=', 1)->get()->count();
            $userInValid = User::where('isValidated', '=', 0)->get()->count();
            $carts = Carts::where('isConfirmed', 1)->get()->count();
            $items = Items::get()->count();

            return view('pages.dashboard', [
                'itemsCount' => $items,
                'validCount' => $userValid,
                'invalidCount' => $userInValid,
                'orderCount' => $carts
            ]);
        } else {
            return redirect('/order/items');
        }
    }



    public function signout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function notfound()
    {
        return view('errors.notfound');
    }
}
