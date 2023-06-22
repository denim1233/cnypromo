<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Wishlists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class WishlistController extends Controller
{

    public function addWish(Request $request)
    {

        if (Wishlists::where('userId', $request->userId)->where('barcode', $request->barcode)->exists()) {
            return response()->json([
                'msg' => 'Item already added to your wishlist',
            ], 502);
        }

        DB::beginTransaction();
        try {
            $wish = new Wishlists();

            $wish->userId = $request->userId;
            $wish->barcode = $request->barcode;
            $wish->save();

            $emp_id = Auth::user()->emp_id;
            $wishCount = Wishlists::where('userId', $emp_id)->get()->count();
            DB::commit();
            return response()->json(['success' => 'Added to your wishlist', 'wishCount' => $wishCount]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }

    public function removeWish(Request $request, $id){

        $removeWishlist=Wishlists::find($id);
        $removeWishlist->delete();
        $emp_id = Auth::user()->emp_id;
        $wishCount = Wishlists::where('userId', $emp_id)->get()->count();

        if(!$removeWishlist){
             return response()->json([
                'msg' => 'Something went wrong',
            ], 502);
        }else{
            return response()->json(['success' => 'Added to your wishlist', 'wishCount' => $wishCount]);
        }
    }

    public function checkWish($id){

        $wish = Wishlists::finfOrFail($id);
        
    }
}
