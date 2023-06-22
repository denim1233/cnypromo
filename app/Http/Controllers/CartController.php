<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Carts;
use App\Models\Items;
use App\Models\Orders;
use App\Models\Locations;
use App\Models\Wishlists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function employeeCart(){

        $user;

        if(Auth::user()->branch_name === 'SSC'){

            $user = User::whereRaw("emp_id in (select userId from carts where isConfirmed = 0)")->get();


        }else if(Auth::user()->branch_name === 'DC'){

              $user = User::whereRaw("emp_id in (select userId from carts where isConfirmed = 0)")->get();


        }else{

            $user = User::where('branch_name',Auth::user()->branch_name)
            ->whereRaw("emp_id in (select userId from carts where isConfirmed = 0)")
            ->get();

        }

        return view('pages.employees-cart', [
            'employees' => ItemResource::collection($user),
            'locations' => Auth::user()->branch_name
        ]);

    }

    public function addCart(Request $request)
    {
        // return $request->all();
        $emp_id = Auth::user()->emp_id;

        //CHECK IF QUANTITY IS GREATER THAN 5
        $cartCount = Carts::where('userId', $emp_id)->get()->sum('quantity');

        // $itemStocks = Items::where('userId', $emp_id)->select('barcode')->first();

        if (($cartCount + (int)$request->quantity) > 15) {
            return response()->json([
                'msg' => 'Sorry, but maximum quantity is 15 only',
            ], 502);
        }

        if (($cartCount + (int)$request->quantity) <= 0) {
            return response()->json([
                'msg' => 'Please select enter a quantity more than 0',
            ], 502);
        }


        // if ($request->quantity > $itemStocks) {
        //     return response()->json([
        //         'msg' => 'Sorry, not enough stocks',
        //     ], 502);
        // }
        $totalPriceAmount = (float)$request->itemPrice * ($request->quantity);
        $cartCountAmount = Carts::where('userId', $emp_id)->where('pay_mode', 1)->get()->sum('totalAmount');
        $cartCountItems = Carts::where('userId', $emp_id)->where('pay_mode', 1)->get()->count('barcode');
        // dd($request->payType);

        if ($request->payType == 1) {

            // 1 = regular
            // 2 = agency

            //CHECK AMOUNT
            if (Auth::user()->emp_mode == 1) {

                // dd($cartCountItems);

                if($cartCountItems >= 1){

                        if (($cartCountAmount + $totalPriceAmount) >= 10000){

                                  return response()->json([
                                'msg' => 'Sorry, but your maximum loan amount is up to ₱ 10,000 only',
                                    ], 502);

                        }

                }
              
            } else if (Auth::user()->emp_mode == 2) {
                if (($cartCountAmount + $totalPriceAmount) >= 5000) {
                    return response()->json([
                        'msg' => 'Sorry, but your maximum loan amount is up to ₱ 5,000 only',
                    ], 502);
            }
            } else if (Auth::user()->emp_mode == 3) {
                if (($cartCountAmount + $totalPriceAmount) >= 2000) {
                    return response()->json([
                        'msg' => 'Sorry, but your maximum loan amount is up to ₱ 2,000 only',
                    ], 502);
                }
            } else if (Auth::user()->emp_mode == 4) {
                if (($cartCountAmount + $totalPriceAmount) >= 3000) {
                    return response()->json([
                        'msg' => 'Sorry, but your maximum loan amount is up to ₱ 3,000 only',
                    ], 502);
                }
            } else if (Auth::user()->emp_mode == 5) {
                if (($cartCountAmount + $totalPriceAmount) >= 4000) {
                    return response()->json([
                        'msg' => 'Sorry, but your maximum loan amount is up to ₱ 4,000 only',
                    ], 502);
                }
            }  else if (Auth::user()->emp_mode == 6) {
                if (($cartCountAmount + $totalPriceAmount) >= 1000) {
                    return response()->json([
                        'msg' => 'Sorry, but your maximum loan amount is up to ₱ 1,000 only',
                    ], 502);
                }
            }   else {
                return response()->json([
                    'msg' => 'Sorry, but you are not allowed to loan.',
                ], 502);
            }
        }


        $items = DB::table('items')
         ->select(DB::raw('(items.quantity - ((select IFNULL(sum(quantity),0) as total_qty from carts where barcode = items.barcode and isConfirmed = "1") * items.inventory_value)) as total_qty'))
         ->Where('items.barcode',$request->barcode)
         ->get();

       
         if($items[0]->total_qty < $request->quantity){
            $cartCount = Carts::where('userId', $emp_id)->get()->sum('quantity');
            $cartTotalAmount = Carts::where('userId', $emp_id)->get()->sum('itemPrice');

            return response()->json([
                'msg' => 'Sorry, but the current quantity of the item is insufficient',
                'cartCount' => $cartCount,
                'cartTotalAmount' => $cartTotalAmount,
            ], 502);

         }
        // $(this)
        //         .find("img")

        //         .attr("src")

        DB::beginTransaction();
        try {


        $items = DB::table('carts')
         ->Where('barcode',$request->barcode)
         ->Where('userId',$request->userId)
         ->Where('pay_mode',$request->payType)
         ->Where('isConfirmed',0)
         ->get();

         // echo count($items);


         if (count($items) === 0){

            $cart = new Carts();
            $cart->userId = $request->userId;
            $cart->barcode = $request->barcode;
            $cart->order_no = 0;
            $cart->itemPrice = $request->itemPrice;
            $cart->quantity = (intval($cart->quantity) + intval($request->quantity));
            $cart->pay_mode = $request->payType;
            $cart->isConfirmed = 0;
            $cart->totalAmount = $cart->totalAmount + $totalPriceAmount;
            $cart->save();


         }else{


            Carts::where('barcode',$request->barcode)
            ->where('userId',$request->userId)
            ->where('pay_mode',$request->payType)
            ->Where('isConfirmed',0)
            ->update(['quantity'=> $items[0]->quantity + $request->quantity,'totalAmount'=> $items[0]->totalAmount + $totalPriceAmount]);

         }

         
        DB::commit();

        $cartCount = Carts::where('userId', $emp_id)->get()->sum('quantity');
        $cartTotalAmount = Carts::where('userId', $emp_id)->get()->sum('totalAmount');

            // dd($cartTotalAmount);
  // $cartTotalAmount = 69.00;
            return response()->json([
                'success' => 'Item Added to your Cart',
                'cartCount' => $cartCount,
                'cartTotalAmount' => $cartTotalAmount
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }

    public function removeCart($barcode)
    {
        $existingItem = Carts::where('barcode', $barcode)->where('userId', '=', Auth::user()->emp_id)->first();
        if ($existingItem) {
            $existingItem->delete();
            return response()->json(['deleted' => 'Item successfully deleted!']);
        }
        return "Item not found";
    }


    public function showCart($id)
    {

        // $items = DB::table('items')->where("barcode", $id)->get();

        $items = DB::table('items')
         ->select(DB::raw('(items.quantity - ((select IFNULL(sum(quantity),0) as total_qty from carts where barcode = items.barcode and isConfirmed = "1") * items.inventory_value)) as total_qty'),'barcode','name','description','itemImage','cash_price','credit_price','created_at','updated_at')
         ->where("barcode", $id)
         ->get();

        return response()->json(['items' => $items]);
    }

    public function getItems()
    {
        $carts = DB::table('items')
            ->where('carts.userId', Auth::user()->emp_id)
            ->where('carts.isConfirmed', 0)
            ->select(
                'carts.barcode',
                'items.itemImage',
                'items.name',
                'items.description',
                'carts.itemPrice',
                'carts.quantity',
                'carts.totalAmount',
                'carts.pay_mode',
                'carts.isConfirmed'
            )
            ->join('carts', 'carts.barcode', '=', 'items.barcode')
            ->get();

        $cartsTotal = DB::table('carts')->where('userId', Auth::user()->emp_id)->sum('totalAmount');

        return response()->json(['carts' => $carts]);
    }

    public function adminCartItems($id){
        $carts = DB::table('items')
            ->where('carts.userId', $id)
            ->where('carts.isConfirmed', 0)
            ->select(
                'carts.barcode',
                'items.itemImage',
                'items.name',
                'items.description',
                'carts.itemPrice',
                'carts.quantity',
                'carts.totalAmount',
                'carts.pay_mode',
                'carts.isConfirmed'
            )
            ->join('carts', 'carts.barcode', '=', 'items.barcode')
            ->get();

        $cartsTotal = DB::table('carts')->where('userId', Auth::user()->emp_id)->sum('totalAmount');

        return response()->json(['carts' => $carts]);
    }


    public function getWishes()
    {

        $wishlist = DB::table('items')->where('wishlists.userId', '=', Auth::user()->emp_id)
            ->select('wishlists.barcode', 'items.itemImage', 'items.name', 'items.description', 'items.cash_price', 'items.credit_price', 'items.quantity','wishlists.id')
            ->join('wishlists', 'wishlists.barcode', '=', 'items.barcode')
            ->get();

        return response()->json(['wishlists' => $wishlist]);
    }

    public function confirmCart(Request $request)
    {

        // return $request->all();

        // $orderNum = (Carts::where('userId', $request->employeeId)->distinct()->get()->count()) + 1;
        $orderNum = (DB::table('orders')
            ->select('id')
            ->get()
            ->count()) + 1;

        $carts = Carts::where('userId', $request->employeeId)->where('isConfirmed', 0)->get();
        $test = 0;
        //for checking
        // ->select(DB::raw("(items.quantity - (select IFNULL(sum(quantity),0) as total_qty from carts where items.barcode = '".$cart->barcode."' and userId = '".$request->employeeId."')) as total_qty"),'id','barcode')

        foreach ($carts as $cart) {
       
            //check the current quantity of the item
            // ->select(DB::raw("(items.quantity - (select IFNULL(sum(quantity),0) as total_qty from carts where items.barcode = '".$cart->barcode."' and userId = '".$request->employeeId."' and isConfirmed = '1')) as total_qty"),'id','barcode')


            $itemQuantity = DB::table('items')
            ->select(DB::raw("(items.quantity - ((select IFNULL(sum(quantity),0) as total_qty from carts where carts.barcode = '".$cart->barcode."' and isConfirmed = '1') * items.inventory_value)) as total_qty"),'id','barcode')
            ->where('items.barcode',$cart->barcode)
            ->get();

            $test = $cart->quantity;
            if (intval($itemQuantity[0]->total_qty) >= intval($cart->quantity)){
                // echo "save inventory is greater than cart quantity-".$cart->barcode;
            // dd("quanity:".intval($itemQuantity[0]->total_qty)."---Cart Quantity:".$cart->quantity);

                $cart->isConfirmed = 1;
                $cart->order_no = $orderNum;
            }else{
                // echo "dont save inventory is less than cart quantity-".$cart->barcode;
                // echo "quanity:".intval($itemQuantity[0]->total_qty)."---Cart Quantity:".$cart->quantity;
                $cart->isConfirmed = 0;
                $cart->order_no = $orderNum;
            }

            $saved = $cart->save();


            // if(!$saved){
            //    dd('error');
            // }else{
            //    dd('save success');
            // }

        }

        $orders = new Orders();

        $orders->id = $orderNum;
        $orders->user_id = $request->employeeId;
        $orders->pick_location = $request->location;
        $orders->isProcessed = 0;
        $orders->isReceived = 0;
        $orders->save();


        return response()->json(['msg' => 'cart confirmed successfully']);
        // return response()->json(['msg' => $itemQuantity[0]->total_qty .$cart->barcode.$request->employeeId]);

    }

    public function search(Request $request)
    {
        $search_query = $request->searchquery;
        $credlimit = "";

        $items = DB::table('items')
        ->select(DB::raw('(items.quantity - ((select IFNULL(sum(quantity),0) as total_qty from carts where barcode = items.barcode and isConfirmed = "1") * items.inventory_value)) as total_qty'),'barcode','name','description','itemImage','cash_price','credit_price','created_at','updated_at')
        ->where('barcode', 'LIKE', '%' . $search_query . '%')
        ->orWhere('barcode', 'LIKE', '%' . $search_query . '%')
        ->orWhere('name', 'LIKE', '%' . $search_query . '%')
        ->orWhere('description', 'LIKE', '%' . $search_query . '%')
        ->orWhere('cash_price', '=', $search_query)
        ->orWhere('credit_price', '=', $search_query)
        ->orderBy('id', 'asc')
        ->paginate(25);


        // $items = DB::table('items')
        //     ->where('barcode', 'LIKE', '%' . $search_query . '%')
        //     ->orWhere('barcode', 'LIKE', '%' . $search_query . '%')
        //     ->orWhere('name', 'LIKE', '%' . $search_query . '%')
        //     ->orWhere('description', 'LIKE', '%' . $search_query . '%')
        //     ->orWhere('cash_price', '=', $search_query)
        //     ->orWhere('credit_price', '=', $search_query)
        //     ->orderBy('id', 'asc')
        //     ->paginate(15);

        $emp_id = Auth::user()->emp_id;
        $wishCount = Wishlists::where('userId', $emp_id)->get()->count();
        $cartCount = Carts::where('userId', $emp_id)->get()->sum('quantity');
        $cartTotalAmount = Carts::where('userId', $emp_id)->get()->sum('totalAmount');
        $user = User::where('emp_id', Auth::user()->emp_id)->select('emp_id', 'isValidated')->get();
        // $locations = Locations::orderBy('branch_id', 'asc')->get();
        $locations = Locations::orderBy('branch_name', 'asc')->whereIn('branch_id', array(10,6,7,37,18,45,32))->get();


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
        }else if (Auth::user()->emp_mode == 6) {
            $credlimit = "1000";
        } 
        
        else {
            $credlimit = "NOT ALLOWED";
        }

        // return $credlimit;

        return view('orders.index', [
            'items' => ItemResource::collection($items),
            'locations' => $locations,
            'wishCount' => $wishCount,
            'cartCount' => $cartCount,
            'cartTotalAmount' => $cartTotalAmount,
            'user' => $user,
            'credlimit' => $credlimit

        ]);
    }
}
