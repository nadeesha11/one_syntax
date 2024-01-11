<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class apiController extends Controller
{
    public function getUserData(Request $request){
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'website' => 'required' // validation for api data
        ]);

        try {
            $create_user = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            ]);

            if($create_user){
                // $count = 0;
             foreach($request->website as $item){
                // $count = $count + 1;
                DB::table('subscribed_websites')->insert([
                'user_id' => $create_user,
                'website_id' => $item,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                ]);
             }
            //  return $count;
            return response()->json(['code' => 200 , "msg" => "You have subscribed to website(s)"]); 
            }
            else{
            return response()->json(['code' => 500 , "msg" => "Something went wrong"]);   
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500 , "msg" => $th->getMessage()]);
        }
    }
}
