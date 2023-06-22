<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;



class ItemController extends Controller
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
        if (Auth::user()->isAdmin == 1) {
            // $items = Items::orderBy('id', 'desc')->get();

            $items = DB::table('items')
         ->select(DB::raw('(items.quantity - (select IFNULL(sum(quantity),0) as total_qty from carts where barcode = items.barcode and isConfirmed = "1")) as total_qty'),'items.id','barcode','name','description','itemImage','cash_price','credit_price','created_at','updated_at')
         ->orderBy('items.id', 'desc')
         ->get();

            return view('pages.items', ['items' => ItemResource::collection($items)]);
        } else {
            return redirect('/order/items');
        }
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
        if (!$request->has('itemImage')) {
            $request->validate([
                'itemImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        }

        $item = new Items();
        $item->fill($request->except(['_token']));

        //GETTING IMAGE
        if (!empty($request->itemImage)) {
            $imageName = time() . '.' . $request->itemImage->extension();
            $request->itemImage->move(public_path('/assets/img'), $imageName);
            $item->itemImage = $imageName;
        } else {
            $item->itemImage = "";
        }
        $item->save();

        return response()->json(['success' => 'Item successfully added']);
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
        $request->validate([
            'itemImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $item = Items::findOrFail($id);

        $image_path = "/assets/img/" . $item->itemImage;  // Value is not URL but directory file path
        // return $image_path;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        $item->fill($request->except(['_token']));

        //GETTING IMAGE
        if ($request->itemImage) {
            $imageName = time() . '.' . $request->itemImage->extension();
            $request->itemImage->move(public_path('/assets/img'), $imageName);
            $item->itemImage = $imageName;
        }
        $item->update();

        return response()->json(['success' => 'Item successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingItem = Items::findOrFail($id);
        if ($existingItem) {
            $existingItem->delete();
            return response()->json(['deleted' => 'Item successfully deleted!']);
        }
        return "Item not found";
    }

    //IMAGE UPLOADING
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }


    public function deleteFileFromServer($fileName, $hasFullPath = false)
    {
        if (!$hasFullPath) {
            $filePath = public_path() . '/assets/img/' . $fileName;
        }

        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        return;
    }

    public function csvUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv'
        ]);

        return $request->file;

        $file = file($request->file->getRealPath());
        $data = array_slice($file, 1);

        $parts = (array_chunk($data, 5000));

        foreach ($parts as $index => $part) {
            $fileName = resource_path('pending-files/' . date('y-m-d-H-i-s') . $index . '.csv');
            file_put_contents($fileName, $part);
        }

        $items = Items::orderBy('id', 'desc')->get();
        return view('pages.items', ['items' => ItemResource::collection($items)]);
    }
}
