<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MovementController extends Controller
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
        $user = Auth::user();
        $movement = DB::table('movements')
            ->leftJoin('users','movements.user_id', '=', 'users.id')
            ->orderBy('movements.created_at',"desc")
            ->select("users.name", "users.avatar as avatar", "movements.movement_title","movements.movement_body","movements.id as movement_id"
                    ,"movements.img_path","movements.created_at as created_at","movements.target_arm"       
            )
            ->get();

        return view('movements.index',[
            'user'=>$user,
            'movements'=>$movement, 
        ]);
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
        $this->validate($request,[
            'movement_title'=>'required',
            'movement_body'=>'required',
        ]);

        $movement_body = $request->input('movement_body');
        $movement_title = $request->input('movement_title');
        $movement_category = $request->input('category');
        $movement_target_arm = $request->input('target_arm');
        $movement_timeframe = $request->input('timeframe');

        if($movement_target_arm == "President") {
            $movement_targetnumber = 5000;
        } elseif($movement_target_arm == "Governor") {
            $movement_targetnumber = 3000;
        } elseif($movement_target_arm == "Senate") {
            $movement_targetnumber = 1500;
        } elseif($movement_target_arm == "House of Reps") {
            $movement_targetnumber = 1000;
        } elseif($movement_target_arm == "State Reps") {
            $movement_targetnumber = 750;
        } elseif($movement_target_arm == "Local Govt") {
            $movement_targetnumber = 500;
        }
        
        if($request->file('file')){
            $path = $request->file('file')->store('img/movement');
            $db = DB::table('movements')->insertGetId([
                'movement_title'=>$movement_title,
                'movement_body'=>$movement_body,
                'category'=>$movement_category,
                'user_id'=>Auth::user()->id,
                'targetnumber'=>$movement_targetnumber,
                'timeframe'=>$movement_timeframe,
                'target_arm'=>$movement_target_arm,
                'img_path'=>$path
            ]);

            $data = '<div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="'.\Storage::URL(Auth::user()->avatar).'" alt="User Image">
                <span class="username"><a href="'.url("profile").'/'.Auth::user()->id.'">'.Auth::user()->name.'</a></span>
                <span class="description">Shared publicly - '.Carbon::now().'</span>
              </div>
            </div>

            <div class="box-body" style="display: block;">
              <img class="img-responsive show-in-modal" src="'.\Storage::URL($path).'" alt="Photo">
              <p>'.$movement_body.'</p></p>
              <a type="button" href="'.url('movements').'/sign/'.$db.'" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i>0 Like</a>
              <a href="'.url('movements').'/'.$db.'" type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Read More</a>
              <span class="pull-right text-muted">'. $this->number_signature($db) ? $this->number_signature($db) : 0 .'Views</span>
            </div>
            
          </div';
        }
        else{
            $db = DB::table('movements')->insertGetId([
                'movement_title'=>$movement_title,
                'movement_body'=>$movement_body,
                'category'=>$movement_category,
                'user_id'=>Auth::user()->id,
                'targetnumber'=>$movement_targetnumber,
                'timeframe'=>$movement_timeframe,
                'target_arm'=>$movement_target_arm
            ]);

            $data = '<div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="'.asset(Auth::user()->avatar).'" alt="User Image">
                <span class="username"><a href="'.url("profile").'/'.Auth::user()->id.'">'.Auth::user()->name.'</a></span>
                <span class="description">Shared publicly - '.Carbon::now().'</span>
              </div>
            </div>

            <div class="box-body" style="display: block;">
              <p>'.$movement_body.'</p></p>
              <a type="button" href="'.url('movements').'/sign/'.$db.'" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i>0 Like</a>
              <a href="'.url('movements').'/'.$db.'" type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Read More</a>
              <span class="pull-right text-muted">'. $this->number_signature($db) ? $this->number_signature($db) : 0 .'Views</span>
            </div>
            
          </div';
        }
        return $data;
        //return redirect('/movements')->with('message','Movement Posted Successfully');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        if($request->input('op') ==1){
            $pre_check = DB::table('signs')->where([['user_id','=',Auth::user()->id],['movement_id','=',$request->input('id')]])->first();
            if(empty($pre_check)){
                $insert = DB::table('signs')->insert(['user_id'=>Auth::user()->id,'movement_id'=>$request->input('id')]);
               //return redirect('/movements')->with('message','2. Movement Signed Successfully');
               return "1";
            }
        }
        elseif(is_int($id)){
            $user = Auth::user();
            $movement = DB::table('movements')
                            ->leftJoin('users','movements.user_id', '=', 'users.id')
                            ->where('movements.id','=',$id)
                            ->orderBy('movements.created_at',"desc")
                            ->get();
            return view('movements.view',[
                'id'=>$id,
                'movements'=>$movement
            ]);
        }
        else if($id == 'categories') {
            $sector = $request->sector;
            $movement = DB::table('movements')
            ->leftJoin('users','movements.user_id', '=', 'users.id')
            ->where('movements.category','=',$sector)
            ->select("users.name", "users.avatar as avatar", "movements.movement_title","movements.movement_body","movements.id as movement_id"
            ,"movements.img_path","movements.created_at as created_at","movements.target_arm")
            ->orderBy('movements.created_at',"desc")
            ->get();
            
            return view('movements.index',[ 
                'id'=>$id,
                'movements'=>$movement,
            ]);
        }
        else
        {
            $movement = DB::table('movements')
            ->leftJoin('users','movements.user_id', '=', 'users.id')
            ->where('movements.id','=',$id)
            ->select("users.name", "users.avatar as avatar", "movements.movement_title","movements.movement_body","movements.id as movement_id"
            ,"movements.img_path","movements.created_at as created_at","movements.target_arm")
            ->orderBy('movements.created_at',"desc")
            ->get();
            
            return view('movements.index',[ 
                'id'=>$id,
                'movements'=>$movement,
            ]);
        }
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

    public function signature($id,Request $request){
       $pre_check = DB::table('signs')->where([['user_id','=',Auth::user()->id],['movement_id','=',$request->input(id)]])->first();
       return $pre_check;exit;
       if(empty($pre_check)){
           $insert = DB::table('signs')->insert(['user_id'=>Auth::user()->id,'movement_id'=>$request->input(id)]);
          //return redirect('/movements')->with('message','2. Movement Signed Successfully');
          return "1";
       }
      //return redirect('/movements')->with('message','1.You have signed this movement previously');
      return "2";
    }

    public static function number_signature($id){
        $likes = DB::table('signs')->where('movement_id','=',$id)->count();
        return $likes;
    }

    public static function check_sign($id){
        $likes = DB::table('signs')->where([['movement_id','=',$id],["user_id","=",Auth::user()->id]])->count();
        return $likes;
    }
    
    public static function suppose_sign($id){
        $likes = DB::table('target_count')->where([['target_arm','=',$id]])->first();
        return compact($likes);
    }
}
