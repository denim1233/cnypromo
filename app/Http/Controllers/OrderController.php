<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Carts;
use App\Models\Items;
use App\Models\Orders;
use App\Models\Uploads;
use App\Models\Locations;
use App\Models\Wishlists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $emp_id = Auth::user()->emp_id;

        // $uploads = Uploads::where('idnum', Auth::user()->emp_id)->first();

        // if (is_null($uploads)) {
        //     return redirect('/order/uploads');
        // } else {
        $wishCount = Wishlists::where('userId', $emp_id)->get()->count();

        $cartCount = Carts::where('userId', $emp_id)->get()->sum('quantity');
        $cartTotalAmount = Carts::where('userId', $emp_id)->get()->sum('totalAmount');

        $user = User::where('emp_id', Auth::user()->emp_id)->select('emp_id', 'isValidated')->get();
        // $items = Items::orderBy('id', 'asc')->paginate(25);



        $locations = Locations::orderBy('branch_name', 'asc')->whereIn('branch_id', array(10,6,7,37,18,45,32))->get();


             

        $items = DB::table('items')
         ->select(DB::raw('(items.quantity - ((select IFNULL(sum(quantity),0) as total_qty from carts where barcode = items.barcode and isConfirmed = "1") * items.inventory_value)) as total_qty'),'barcode','name','description','itemImage','cash_price','credit_price','created_at','updated_at')
         ->paginate(15);




        // $items = DB::table('carts')
        // ->select(
        //     'users.emp_name',
        //     'carts.order_no',
        //     'carts.barcode',
        //     'items.name',
        //     'items.description',
        //     'carts.itemPrice',
        //     'carts.quantity',
        //     'carts.totalAmount',
        // )
        // ->where('carts.isConfirmed', 1)
        // ->where('carts.order_no', '!=', 0)
        // // ->where('orders.pick_location', $request->location)
        // ->join('items', 'items.barcode', '=', 'carts.barcode')
        // ->join('users', 'users.emp_id', '=', 'carts.userId')
        // ->join('orders', 'orders.id', '=', 'carts.order_no')
        // ->get();


        // $items = DB::table('carts')
        // ->select(DB::raw('items.barcode, SUM(carts.quantity) AS totalQuantity, carts.created_at,name,description,itemImage,cash_price,credit_price'))
        // ->leftJoin('items', 'items.barcode', '=', 'carts.barcode')
        // ->groupBy('barcode')
        // // ->get()
        // ->paginate(25)
        // ;

        // SELECT sum(quantity) FROM `carts` WHERE barcode = '1090100660418';

        // $items = DB::table('items')
        // ->select(DB::raw('items.barcode, SUM(carts.quantity) AS totalQuantity, carts.created_at,name,description,itemImage,cash_price,credit_price'))
        // // ->leftJoin('carts', 'carts.barcode', '=', 'items.barcode')
        //   ->join(DB::raw('(SELECT user_id, COUNT(user_id) TotalCatch,
        //        DATEDIFF(NOW(), MIN(created_at)) Days,
        //        COUNT(user_id)/DATEDIFF(NOW(), MIN(created_at))
        //        CatchesPerDay FROM `catch-text` GROUP BY barcode)
        //        TotalCatches'), 
        // function($join)
        // {
        //    $join->on('users.id', '=', 'TotalCatches.user_id');
        // })
        // // ->get()
        // ->paginate(25)
        // ;


        // return $user;
        // update this part
        $credlimit = "";
        //CHECK CREDIT LIMIT


        if (Auth::user()->emp_mode == 1) {
            $credlimit = "10000";
        } else if (Auth::user()->emp_mode == 2) {
            $credlimit = "5000";
        } else if (Auth::user()->emp_mode == 3) {
            $credlimit = "2000";
        } else if (Auth::user()->emp_mode == 4) {
            $credlimit = "3000";
        } else if (Auth::user()->emp_mode == 5) {
            $credlimit = "4000";
        } else {
            $credlimit = "CASH ONLY";
        }

        return view('orders.index', [
            'items' => ItemResource::collection($items),
            'locations' => $locations,
            'wishCount' => $wishCount,
            'cartCount' => $cartCount,
            'cartTotalAmount' => $cartTotalAmount,
            'user' => $user,
            'credlimit' => $credlimit
        ]);

        // }
    }

    public function cartIndex()
    {
        $carts = DB::table('items')
            ->select('carts.barcode', 'items.itemImage', 'items.name', 'items.description', 'carts.itemPrice', 'carts.quantity', 'carts.totalAmount', 'carts.pay_mode', 'carts.isConfirmed')
            ->where('carts.userId', Auth::user()->emp_id)
            ->where('carts.isConfirmed', 1)
            ->join('carts', 'carts.barcode', '=', 'items.barcode')
            ->get();

        $pickLocation = DB::table('orders')
            ->select('pick_location')
            ->where('user_id', Auth::user()->emp_id)
            ->distinct()->pluck('pick_location');

        $status = DB::table('orders')
            ->select('isProcessed', 'isReceived')
            ->where('user_id', Auth::user()->emp_id)
            ->get();

        $cartsCount = DB::table('carts')
            ->where('userId', Auth::user()->emp_id)
            ->where('isConfirmed', 1)
            ->get()
            ->count();

        $credlimit = "";
        //CHECK CREDIT LIMIT
        if (Auth::user()->emp_mode == 1) {
            $credlimit = "10000";
        } else if (Auth::user()->emp_mode == 2) {
            $credlimit = "5000";
        } else if (Auth::user()->emp_mode == 3) {
            $credlimit = "3000";
        } else if (Auth::user()->emp_mode == 4) {
            $credlimit = "8000";
        } else {
            $credlimit = "CASH ONLY";
        }

        // return $status[0]->isProcessed;

        // if($cartsCount != 0){
        //     $cartsCount = $cartsCount + 1;
        // }

        return view('pages.carts', [
            "carts" => $carts,
            "count" => $cartsCount,
            "picklocation" => $pickLocation,
            "status" => $status,
            'credlimit' => $credlimit
            // "received" => $received,
            // "processed" => $processed
        ]);
    }

    public function imguploads()
    {
        return view('orders.imgupload');
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
        //
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

    public function profile()
    {
        return view('orders.profile', ['user' => Auth::user()]);
    }

    public function adminFilter(Request $request){

            $pay_mode = 0;
            $location = '';

            if($request->location === 'All'){
                $location = null;
            }else{
                $location = $request->location;
            }


            // if coop show salary deduction only
            if (in_array(Auth::user()->emp_id, array("COO000004", "COO000011", "COO000013"))) {
                $pay_mode = 1;
            }else{
                $pay_mode = null;
            }
            
            $carts = DB::table('carts')
            ->select(
                'carts.id',
                'carts.order_no',
                'carts.userId',
                'users.emp_name',
                'carts.barcode',
                'items.name',
                'items.description',
                'carts.itemPrice',
                'carts.quantity',
                'carts.totalAmount',
                'carts.pay_mode',
                'carts.isConfirmed',
                'orders.isReceived',
                'orders.isProcessed',
                'carts.updated_at',
                'users.branch_name',
                DB::raw("(CASE WHEN carts.pay_mode = '1' THEN itemprice ELSE 0.00 END) as loan_price"),
                DB::raw("(CASE WHEN carts.pay_mode = '0' THEN itemprice ELSE 0.00 END) as cash_price"),
                DB::raw("(CASE WHEN carts.pay_mode = '0' THEN 'Cash Payment' ELSE 'Salary Deduction' END) as pay_mode_desc")

            )
            // ->where('carts.isConfirmed', 1)
            ->join('items', 'items.barcode', '=', 'carts.barcode')
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->join('orders', 'orders.id', '=', 'carts.order_no')
            ->whereRaw('orders.pick_location = IFNULL(?, orders.pick_location)', [$location])
            ->whereRaw('carts.pay_mode = IFNULL(?, carts.pay_mode)', [$pay_mode])
            // ->where('orders.pick_location',$location)
            // ->where('carts.pay_mode',$pay_mode)
            ->get();

            return  $carts;


    }

    public function admin()
    {


        $branches = DB::table('branches')
        ->select('branch_name')
        ->orderBy('branch_name', 'asc')
        ->get();

         if(Auth::user()->branch_name === 'SSC'){

               $carts = DB::table('carts')
            ->select(
                'carts.id',
                'carts.order_no',
                'carts.userId',
                'users.emp_name',
                'carts.barcode',
                'items.name',
                'items.description',
                'carts.itemPrice',
                'carts.quantity',
                'carts.totalAmount',
                'carts.pay_mode',
                'carts.isConfirmed',
                'orders.isReceived',
                'orders.isProcessed',
                'carts.updated_at',
                'users.branch_name',
                DB::raw("(CASE WHEN carts.pay_mode = '1' THEN itemprice ELSE 0.00 END) as loan_price"),
                DB::raw("(CASE WHEN carts.pay_mode = '0' THEN itemprice ELSE 0.00 END) as cash_price")
            )
            // ->where('carts.isConfirmed', 1)
            ->join('items', 'items.barcode', '=', 'carts.barcode')
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->join('orders', 'orders.id', '=', 'carts.order_no')
            ->get();


                //check if user is coop admin to restrict data showing salary deduction transactions only
                if (in_array(Auth::user()->emp_id, array("COO000004", "COO000011", "COO000013"))) {

                        $carts = DB::table('carts')
                            ->select(
                                'carts.id',
                                'carts.order_no',
                                'carts.userId',
                                'users.emp_name',
                                'carts.barcode',
                                'items.name',
                                'items.description',
                                'carts.itemPrice',
                                'carts.quantity',
                                'carts.totalAmount',
                                'carts.pay_mode',
                                'carts.isConfirmed',
                                'orders.isReceived',
                                'orders.isProcessed',
                                'carts.updated_at',
                                'users.branch_name',
                                DB::raw("(CASE WHEN carts.pay_mode = '1' THEN itemprice ELSE 0.00 END) as loan_price"),
                                DB::raw("(CASE WHEN carts.pay_mode = '0' THEN itemprice ELSE 0.00 END) as cash_price")
                            )
                            // ->where('carts.isConfirmed', 1)
                            ->join('items', 'items.barcode', '=', 'carts.barcode')
                            ->join('users', 'users.emp_id', '=', 'carts.userId')
                            ->join('orders', 'orders.id', '=', 'carts.order_no')
                            ->where('carts.pay_mode',1)
                            ->get();


                }

        }else{

               $carts = DB::table('carts')
                ->select(
                    'carts.id',
                    'carts.order_no',
                    'carts.userId',
                    'users.emp_name',
                    'carts.barcode',
                    'items.name',
                    'items.description',
                    'carts.quantity',
                    'carts.totalAmount',
                    'carts.pay_mode',
                    'carts.isConfirmed',
                    'orders.isReceived',
                    'orders.isProcessed',
                    'carts.updated_at',
                    'users.branch_name',
                    DB::raw("(CASE WHEN carts.pay_mode = '1' THEN itemprice ELSE 0.00 END) as loan_price"),
                    DB::raw("(CASE WHEN carts.pay_mode = '0' THEN itemprice ELSE 0.00 END) as cash_price")
                )
            // ->where('carts.isConfirmed', 1)
            ->join('items', 'items.barcode', '=', 'carts.barcode')
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->join('orders', 'orders.id', '=', 'carts.order_no')
            ->where('pick_location',Auth::user()->branch_name)
            ->get();

        }
        // return $carts;
        return view('orders.orderadmin', ['carts' => $carts, 'branch' => $branches]);
    }

    public function submituploads(Request $request)
    {
        $request->validate([
            'upload_post_like' => 'required|mimes:jpeg,png,jpg|max:2048',
            'upload_page_like' => 'required|mimes:jpeg,png,jpg|max:2048',
        ]);

        $uploads = new Uploads();

        // return $request->upload_page_like;

        //GETTING PAGE LIKE IMAGE AND POST LIKE IMAGE
        if ($request->upload_page_like && $request->upload_post_like) {
            $pagelike = time() . rand() . '.' . $request->upload_page_like->extension();
            $postlike = time() . rand() . '.' . $request->upload_post_like->extension();

            $uploads->pagelike = $pagelike;
            $uploads->postlike = $postlike;

            $request->upload_post_like->move(public_path('/assets/imguploads'), $postlike);
            $request->upload_page_like->move(public_path('/assets/imguploads'), $pagelike);
        }
        $uploads->idnum = $request->idnumber;


        // return $uploads;

        $uploads->save();

        return redirect(route('initialItems'));
    }

    public function received($id)
    {
        $order = Orders::where('id', $id)->first();
        // $order = Orders::where('user_id', $id)->first();

        if ($order) {
            $order->isReceived = 1;
            $order->update();
            return response()->json(['msg' => 'Item receieved']);
        }

        return response()->json(['error' => 'Item not found']);
    }

    public function processed($id)
    {
        $order = Orders::where('id', $id)->first();
        // $order = Orders::where('user_id', $id)->first();
        // $order = Orders::where('user_id', $id)->whereNotIn('id', [34,192,257,131,193])->first();
        if ($order) {
            $order->isProcessed = 1;
            $order->update();
            return response()->json(['msg' => 'Item processed']);
        }

        return response()->json(['error' => 'Item not found']);
    }

    public function stats()
    {

          $orders = DB::table('carts')
            ->select(
                'orders.id',
                'orders.user_id',
                'users.emp_name',
                'orders.pick_location',
                'orders.isProcessed',
                'orders.isReceived',
                'users.branch_name',
            )
            ->where('carts.isConfirmed', 1)
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->join('orders', 'orders.id', '=', 'carts.order_no')
            ->distinct('orders.id')
            ->get();



            // select  DISTINCT userId,0 as id, 'saved' as status,' ' as pickup_location, 0 as isProcessed, 0 as isReceived from carts where isConfirmed = 0;

        $saved = DB::table('carts')
            ->select(
                'carts.userId as user_id',
                DB::raw('(select users.emp_name from users where emp_id = carts.userId) as emp_name'),
                DB::raw("'0' as id"),
                DB::raw("'Saved' as status"),
                DB::raw("'0' as isProcessed"),
                DB::raw("'0' as isReceived"),
                DB::raw("'' as pick_location"),
                DB::raw('(select users.branch_name from users where emp_id = carts.userId) as branch_name')
            )
            ->where('carts.isConfirmed', 0)
            ->get();




        if(Auth::user()->branch_name === 'SSC'){
            $orders = DB::table('carts')
            ->select(
                'orders.id',
                'orders.user_id',
                'users.emp_name',
                'orders.pick_location',
                'orders.isProcessed',
                'orders.isReceived',
                DB::raw("'Confirmed' as status"),
                'users.branch_name',
            )
            ->where('carts.isConfirmed', 1)
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->join('orders', 'orders.id', '=', 'carts.order_no')
            ->distinct('orders.id')
            ->get();

            $orders = $orders->union($saved);


            if (in_array(Auth::user()->emp_id, array("COO000004", "COO000011", "COO000013"))) {

                     $orders = DB::table('carts')
                        ->select(
                            'orders.id',
                            'orders.user_id',
                            'users.emp_name',
                            'orders.pick_location',
                            'orders.isProcessed',
                            'orders.isReceived',
                            DB::raw("'Confirmed' as status"),
                            'users.branch_name',
                        )
                        ->where('carts.isConfirmed', 1)
                        ->where('carts.pay_mode', 1)
                        ->join('users', 'users.emp_id', '=', 'carts.userId')
                        ->join('orders', 'orders.id', '=', 'carts.order_no')
                        ->distinct('orders.id')
                        ->get();

                }


        }else{


             $orders = DB::table('carts')
            ->select(
                'orders.id',
                'orders.user_id',
                'users.emp_name',
                'orders.pick_location',
                'orders.isProcessed',
                'orders.isReceived',
                DB::raw("'Confirmed' as status"),
                'users.branch_name',
            )
            ->where('carts.isConfirmed', 1)
            ->join('users', 'users.emp_id', '=', 'carts.userId')
            ->join('orders', 'orders.id', '=', 'carts.order_no')
            ->where('pick_location',Auth::user()->branch_name)
            ->distinct('orders.id')
            ->get();


            $orders = $orders->union($saved);

        }


        // return $orders;
        return view('orders.orderstats', ['orders' => $orders]);
    }
}
