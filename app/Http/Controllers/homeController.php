<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class homeController extends Controller
{
    public function index(){
        $webList = DB::table('website')->get(['id','name']);//get data from website table
        // dd($webList);
        return view('welcome',compact('webList')); // return welcome blade
    }

    public function create(Request $request){
      
        $request->validate([ // make validations
            'title' => 'required|unique:posts,title',
            'desc' => 'required',
            'website' => 'required',

        ]);

        try {
            $result = DB::table('posts')->insert([
            'title' => $request->title,
            'desc' => $request->desc,
            'website_id' => $request->website,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            ]);

            if($result){
                //to send email for website subscribers belong to that created post

                $getUsersList =  DB::table('subscribed_websites')
                ->where('subscribed_websites.website_id',$request->website)
                ->join('users', 'users.id', '=', 'subscribed_websites.user_id')
                ->select('users.email')
                ->get(); // get subscribe users email 

                //send email
                // $count = 0;
                foreach($getUsersList as $mail){ // send mails to users
                // $count = $count + 1;
                \Mail::send('sendMail', [
                    'title' => $request->title,
                    'desc' => $request->desc,
                ], function ($message) use ($mail) {
                    $message->from('jayathilaka221b@gmail.com', 'one Syntax');
                    $message->to($mail->email, 'one Syntax')->subject('Subscribers');
                });
                }
                // return $count;

                return response()->json(['code' => 200, 'msg'=> "Post Created"]);
            }
            else{
                return response()->json(['code' => 500, 'msg'=> "Something went wrong"]); 
            }

        } catch (\Throwable $th) {
            return response()->json(['code' => 500, 'msg'=> $th->getMessage()]);
        }
    }
}
