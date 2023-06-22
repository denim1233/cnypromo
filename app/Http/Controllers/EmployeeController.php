<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Uploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\DB;

$idnumber;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isAdmin == 1) {

            $employees = DB::table('users')
            ->select(
                'users.id',
                'users.emp_id',
                'users.emp_name',
                'users.username',
                'users.password',
                'users.emp_mode',
                'users.isAdmin',
                'users.isValidated',
                'users.created_at',
                'users.updated_at',
                'users.branch_name',
                'users.department',
                'users.position',
                // 'user_contact.contact as contact_number',
                DB::raw('(select contact from user_contact where emp_id = users.emp_id limit 1) as contact_number')
            )
            // ->leftJoin('user_contact', 'user_contact.emp_id', '=', 'users.emp_id')
            ->orderBy('id', 'asc')
            ->get();
            
            return view('pages.employees', ['employees' => EmployeeResource::collection($employees)]);
            // return ItemResource::collection($items);
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

    public function signin()
    {
        // return;
        return view('frontend.auth.login');
    }

    function checkAuth(Request $request)
    {

        //dito mag add ng insert log sa login ng employee

        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $ip = $_SERVER['REMOTE_ADDR'];

    

        // return;

        $request->validate([
            'idnum' => 'required',
            'logpass' => 'required|min:7',
        ]);

        // return;

        $uploads = Uploads::where('idnum', $request->idnum)->first();

        if (Auth::attempt(['username' => $request->idnum, 'password' => $request->logpass])) {
            // if (is_null($uploads)) {
            //     return redirect('/order/uploads');
            // } else {

                // Auth::user()->emp_id


                $values = array('ip_address' => $ip ,'user_name' => $userAgent,'reserved_var' => $request->idnum);
                DB::table('system_log')->insert($values);


            return redirect('/order/items');
            // }
        } else {
            return back()->with('error', 'Invalid login credentials');
        }
    }

    function changepass($idnumber)
    {
        return view('frontend.auth.newpass', compact('idnumber'));
    }

    function checkPass(Request $request)
    {
        $request->validate([
            'oldPass' => 'required',
            'newPass' => 'required|min:8',
            'confirmPass' => 'required|same:newPass',
        ]);

        $user = auth()->user();

        if (Hash::check($request->oldPass, $user->password)) {
            $user->update([
                'password' => bcrypt($request->newPass)
            ]);
            return redirect()->back()->with('success', 'Password updated successfully');
        } else {
            return redirect()->back()->with('error', 'Old password invalid');
        }
    }
    function newpass()
    {
        return view('frontend.auth.newpass');
    }

    public function logout()
    {
        Auth::logout();
        return \redirect('auth/signin');
    }
}
