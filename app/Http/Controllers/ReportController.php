<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function cutOff(){


        if (in_array(Auth::user()->emp_id, array("COO000004", "COO000011", "COO000013"))) {

            $itemOrder = DB::table('carts')
            ->select(
                'users.emp_id',
                'users.emp_name',
                'carts.order_no',
                'carts.barcode',
                'items.name',
                'items.description',
                'carts.itemPrice',
                'carts.quantity',
                'carts.totalAmount',
                'carts.updated_at',
            )
            ->join('items', 'items.barcode', '=', 'carts.barcode')
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->join('orders', 'orders.id', '=', 'carts.order_no')
            ->where('carts.id', '=', 0)
            ->where('users.branch_name', Auth::user()->branch_name)
            ->where('carts.pay_mode', '=', 1)
            ->get();

        }else{
            $itemOrder = DB::table('carts')
            ->select(
                'users.emp_id',
                'users.emp_name',
                'carts.order_no',
                'carts.barcode',
                'items.name',
                'items.description',
                'carts.itemPrice',
                'carts.quantity',
                'carts.totalAmount',
                'carts.updated_at',
            )
            ->join('items', 'items.barcode', '=', 'carts.barcode')
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->join('orders', 'orders.id', '=', 'carts.order_no')
            ->where('carts.id', '=', 0)
            ->where('users.branch_name', Auth::user()->branch_name)
            ->get();


        }

      

            $branches = DB::table('branches')
                ->select('branch_name')
                ->orderBy('branch_name', 'asc')
                ->get();

            return view('reports.cutoff', ['items' => $itemOrder, 'branch' => $branches]);
        
    }


    public function generateCutOff(Request $request){

        $location = '';
        $dateFrom =  date('Y-m-d', strtotime('-1 day', strtotime($request->dateFrom)));
        $dateTo =  $request->dateFrom;

        if($request->location === 'All'){
            $location = null;
        }else{
            $location = $request->location;
        }



        if (in_array(Auth::user()->emp_id, array("COO000004", "COO000011", "COO000013"))) {

          

            $cutOffData = DB::table('carts')
            ->select(
                'users.emp_id',
                'users.branch_name',
                'users.emp_name',
                'carts.order_no',
                'carts.barcode',
                'items.name',
                'items.description',
                'carts.itemPrice',
                'carts.quantity',
                'carts.totalAmount',
                'carts.updated_at',

        )
        ->join('items', 'items.barcode', '=', 'carts.barcode')
        ->join('users', 'users.emp_id', '=', 'carts.userId')
        ->join('orders', 'orders.id', '=', 'carts.order_no')
        ->where('carts.isConfirmed', '=', 1)
        ->whereBetween('carts.updated_at', [ $dateFrom .' 15:00:01', $dateTo .' 15:00:00'])
        // ->whereBetween(DB::raw("DATE_FORMAT('created_at','%H:%i:%s')"), ["15:00:00", "23:59:59"])
        // ->whereRaw("DATE_FORMAT(carts.updated_at,'%H:%i:%s') between '00:00:01' and '15:00:00'")
        // ->where('users.branch_name', $request->location)
        ->where('carts.pay_mode', '=', 1)
        ->whereRaw('orders.pick_location = IFNULL(?, orders.pick_location)', [$location])
        ->get();





        }else{

            $cutOffData = DB::table('carts')
            ->select(
                'users.emp_id',
                'users.branch_name',
                'users.emp_name',
                'carts.order_no',
                'carts.barcode',
                'items.name',
                'items.description',
                'carts.itemPrice',
                'carts.quantity',
                'carts.totalAmount',
                'carts.updated_at',

        )
        ->join('items', 'items.barcode', '=', 'carts.barcode')
        ->join('users', 'users.emp_id', '=', 'carts.userId')
        ->join('orders', 'orders.id', '=', 'carts.order_no')
        ->where('carts.isConfirmed', '=', 1)
        ->whereBetween('carts.updated_at', [ $dateFrom .' 15:00:01', $dateTo .' 15:00:00'])
        // ->whereBetween(DB::raw("DATE_FORMAT('created_at','%H:%i:%s')"), ["15:00:00", "23:59:59"])
        // ->whereRaw("DATE_FORMAT(carts.updated_at,'%H:%i:%s') between '00:00:01' and '15:00:00'")
        // ->where('users.branch_name', $request->location)
        ->whereRaw('orders.pick_location = IFNULL(?, orders.pick_location)', [$location])
        ->get();


        }
        

        return $cutOffData;
}



    public function employeeCart()
    {

            //  if (in_array(Auth::user()->emp_id, array("DMI000983", "DMI000983", "DMI000983", "DMI000983"))) {

                 $itemOrder = DB::table('carts')
                ->select(
                    'users.emp_id',
                    'users.emp_name',
                    'carts.order_no',
                    'carts.barcode',
                    'items.name',
                    'items.description',
                    'carts.itemPrice',
                    'carts.quantity',
                    'carts.totalAmount',
                )
                ->join('items', 'items.barcode', '=', 'carts.barcode')
                ->join('users', 'users.emp_id', '=', 'carts.userId')
                ->join('orders', 'orders.id', '=', 'carts.order_no')
                ->where('carts.id', '=', 0)
                ->where('users.branch_name', Auth::user()->branch_name)
                ->get();

            //  }


        $branches = DB::table('branches')
            ->select('branch_name')
            ->orderBy('branch_name', 'asc')
            ->get();

        // return $itemOrder;
        // return $branches;
        return view('pages.employees-cart', ['items' => $itemOrder, 'branch' => $branches]);
    }


    public function emporders()
    {
        $carts = DB::table('carts')
            ->select('carts.userId', 'users.emp_name')
            ->where('carts.isConfirmed', 1)
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->distinct()
            ->get();
        // return $carts;
        return view('reports.empreport', ['carts' => $carts]);
    }

    public function forPurchase()
    {
        $carts = DB::table('carts')
            ->select(
                'users.emp_name',
                'carts.order_no',
                'carts.barcode',
                'items.name',
                'items.description',
                'carts.quantity'
            )
            ->where('carts.isConfirmed', 1)
            ->join('items', 'items.barcode', '=', 'carts.barcode')
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->get();
        // return $carts;
        return view('reports.forpurchase', ['carts' => $carts]);
    }

    public function forRelease()
    {
        $carts = DB::table('carts')
            ->select(
                'users.emp_name',
                'carts.order_no',
                'carts.barcode',
                'items.name',
                'items.description',
                'carts.quantity',
                'carts.itemPrice',
                'carts.totalAmount'
            )
            ->where('carts.isConfirmed', 1)
            ->join('items', 'items.barcode', '=', 'carts.barcode')
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->get();
        // return $carts;
        return view('reports.forrelease', ['carts' => $carts]);
    }

    public function itemOrder()
    {
        $itemOrder = DB::table('carts')
            ->select(
                'users.emp_id',
                'users.emp_name',
                'users.branch_name',
                'carts.order_no',
                'carts.barcode',
                'items.name',
                'items.description',
                'carts.itemPrice',
                'carts.quantity',
                'carts.totalAmount',
            )
            ->where('carts.isConfirmed', 1)
            ->where('carts.order_no', '!=', 0)
            ->where('orders.pick_location', 'Davao - Balusong')
            ->join('items', 'items.barcode', '=', 'carts.barcode')
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->join('orders', 'orders.id', '=', 'carts.order_no')
            ->get();


            if (in_array(Auth::user()->emp_id, array("COO000004", "COO000011", "COO000013"))) {

                 $itemOrder = DB::table('carts')
                ->select(
                    'users.emp_id',
                    'users.emp_name',
                    'users.branch_name',
                    'carts.order_no',
                    'carts.barcode',
                    'items.name',
                    'items.description',
                    'carts.itemPrice',
                    'carts.quantity',
                    'carts.totalAmount',
                )
                ->where('carts.isConfirmed', 1)
                ->where('carts.order_no', '!=', 0)
                ->where('carts.pay_mode', '=', 1)
                ->where('orders.pick_location', 'Davao - Balusong')
                ->join('items', 'items.barcode', '=', 'carts.barcode')
                ->join('users', 'users.emp_id', '=', 'carts.userId')
                ->join('orders', 'orders.id', '=', 'carts.order_no')
                ->get();

             }


        $branches = DB::table('branches')
            ->select('branch_name')
            ->orderBy('branch_name', 'asc')
            ->get();

        // return $itemOrder;
        // return $branches;
        return view('reports.itemorder', ['items' => $itemOrder, 'branch' => $branches]);
    }

    public function locations(Request $request)
    {
        $locationquery = DB::table('carts')
            ->select(
                'users.emp_id',
                'users.emp_name',
                'users.branch_name',
                'carts.order_no',
                'carts.barcode',
                'items.name',
                'items.description',
                'carts.itemPrice',
                'carts.quantity',
                'carts.totalAmount',
            )
            ->where('carts.isConfirmed', 1)
            ->where('carts.order_no', '!=', 0)
            ->where('orders.pick_location', $request->location)
            ->join('items', 'items.barcode', '=', 'carts.barcode')
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->join('orders', 'orders.id', '=', 'carts.order_no')
            ->get();

        return $locationquery;
    }

    public function locationsEmployeeCart(Request $request)
    {
        $locationquery = DB::table('carts')
            ->select(
                'users.emp_id',
                'users.emp_name',
                'carts.order_no',
                'carts.barcode',
                'items.name',
                'items.description',
                'carts.itemPrice',
                'carts.quantity',
                'carts.totalAmount',
            )
            ->where('carts.isConfirmed', 0)
            ->where('users.branch_name', $request->location)
            ->join('items', 'items.barcode', '=', 'carts.barcode')
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->get();

        return $locationquery;
    }

    // public function claimstub(Request $request)
    // {

    //     $stubquery = DB::table('carts')
    //         ->select(
    //             'users.emp_name',
    //             'carts.order_no',
    //             'items.name',
    //             'items.description',
    //             'carts.quantity',
    //             'orders.pick_location'
    //         )
    //         ->where('carts.isConfirmed', 1)
    //         ->where('carts.order_no', '!=', 0)
    //         ->where('orders.pick_location', $request->picklocation)
    //         ->join('items', 'items.barcode', '=', 'carts.barcode')
    //         ->join('users', 'users.emp_id', '=', 'carts.userId')
    //         ->join('orders', 'orders.id', '=', 'carts.order_no')
    //         ->get();

    //     return $stubquery;
    //     // return response()->json(['success' => 'Item successfully added']);
    //     // return view('layouts.claimstub', ['stubinfo' => $stubquery]);
    // }

    public function printstub($location)
    {
        $stubquery = DB::table('carts')
            ->select(
                'users.emp_name',
                'carts.order_no',
                'items.name',
                'items.description',
                'carts.quantity',
                'orders.pick_location'
            )
            ->where('carts.isConfirmed', 1)
            ->where('carts.order_no', '!=', 0)
            ->where('orders.pick_location', $location)
            ->join('items', 'items.barcode', '=', 'carts.barcode')
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->join('orders', 'orders.id', '=', 'carts.order_no')
            ->get();

        // return $stubquery;
        return view('layouts.claimstub', ['stubinfo' => $stubquery]);
    }

    public function itemqtysummary()
    {
        DB::statement("SET SQL_MODE=''");

        $itemqtyquery = DB::table('carts')
            ->select(DB::raw('barcode, SUM(quantity) AS totalQuantity, created_at'))
            ->groupBy('barcode')
            ->get();

        // $itemqtyquery = DB::select("SELECT barcode, SUM(quantity) AS totalQuantity, created_at FROM `carts` GROUP BY barcode");

        // return $itemqtyquery;
        return view('reports.itemqtysummary', ['itemqty' => $itemqtyquery]);
    }

    public function checkout($location)
    {

        $stubquery = DB::table('carts')
            ->select(
                'users.emp_name',
                'carts.order_no',
                'items.name',
                'items.description',
                'carts.quantity',
                'orders.pick_location'
            )
            ->where('carts.isConfirmed', 1)
            ->where('carts.order_no', '!=', 0)
            ->where('orders.pick_location', $location)
            ->join('items', 'items.barcode', '=', 'carts.barcode')
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->join('orders', 'orders.id', '=', 'carts.order_no')
            ->get();

        // return $stubquery;
        return view('layouts.checkoutstub', ['stubinfo' => $stubquery]);
    }
}
