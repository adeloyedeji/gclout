<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DistrictController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //select record from users where role!=1 and your state id = other person state id and local_govt record = other person local_govt id etc
        //you have to left join with role def table so as to get the role of this office holders.

        $check = DB::table('users')
            ->where([["id",'=',Auth::user()->id]])->first();

        // $pol_holders = DB::table("users")
        //     ->where([["users.id","=",Auth::user()->id]])
        //     ->leftJoin('states','users.state','=','states.id')
        //     ->leftJoin('l_g_as','users.lga','=','l_g_as.id')
        //     ->leftJoin('account_roles','users.role','=','account_roles.id')
        //     ->where([
        //         ["role",">",1]
        //          ])
        //     ->get();
        $state_pol = DB::table("users")
            ->join("states",function($join){
                $join->on("users.state","=","states.id")
                    ->where([["users.state","=",Auth::user()->state],["users.role","=","2"]]);
            })
            ->select("users.id","users.role","users.name","states.id as stateid")
            ->first();

        $lg_pol = DB::table("users")
        ->join("l_g_as",function($join){
            $join->on("users.lga","=","l_g_as.id")
                ->where([["users.lga","=",Auth::user()->state],["users.role","=","3"]]);
        })
        ->select("users.id","users.role","users.name","l_g_as.id as lgaid")
        ->first();
        
        return view('district.index',["pol_holders"=>$state_pol,"lga_pol"=>$lg_pol]);
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
        //Get post which is meant for this user... soft

        $records = DB::table("posts")
            ->where("posts.uid","=",$id)
            ->get();

        $user_rec = DB::table("users")
        ->where("users.id","=",$id)
        ->first();
        //Build element to return
        if($records===null or !isset($records) or count($records)==0){
            return "Nothing to show here";
    }
    else{
        foreach($records as $record){
            $data = '<li class="timeline-inverted">
                <div class="timeline-circ circ-xl style-primary"><span class="glyphicon glyphicon-asterisk"></span></div>
                <div class="timeline-entry">
                    <div class="card style-default-bright">
                        <div class="card-body small-padding">
                            <img class="img-circle img-responsive pull-left width-1" src="img/avatar9.jpg?1404026744" alt="">
                            <span class="text-center">'.$record->category.'By <a class="text-primary" href="../../html/mail/inbox.html">'.$user_rec->name.'</a> </span><br>
                            <span class="text-medium">'.$record->post.'</span>... <a href="movements/'.$record->id.'" class="tile-content ink-reaction">Read More...</a> <br>
                            <span class="opacity-50">
                                <a href="movements/sign/'.$id.'"><span class="glyphicon glyphicon-thumbs-up"></span>Like Post</a>
                            </span>
                </div>
                </div>
                </div>
                </li>';
        }
        return $data;
    }

        
        //return view('district.index');
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
    
    public static function account_roles($id){
        $result = DB::table('account_roles')
            ->where("id",$id)->select('description')
            ->first();

           return $result;
    }
}
