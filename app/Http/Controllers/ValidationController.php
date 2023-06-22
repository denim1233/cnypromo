<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Uploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ValidationResource;

class ValidationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->isAdmin == 1) {

            $validation = DB::table('users')
                ->select(
                    'uploads.id',
                    'users.emp_id',
                    'users.emp_name',
                    'uploads.pagelike',
                    'uploads.postlike',
                    'users.isValidated'
                )
                ->join('uploads', 'uploads.idnum', '=', 'users.emp_id')
                ->where('isValidated', '=', 0)
                ->get();

            return view('validation.validate', ['validation' => ValidationResource::collection($validation)]);
        } else {
            return redirect('/order/items');
        }
    }

    public function validation($id)
    {
        $users = User::where('emp_id', '=', $id)->first();

        // return $users;

        $users->isValidated = 1;
        $users->save();

        return response()->json(['msg' => 'User validation successful']);
    }
}
