<?php

namespace App\Http\Controllers;

use DB;

use Auth;

use Validator;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\Interfaces\MovementInterface;

class PressReleaseController extends Controller
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

        //pick data from press_release table... For this particular user... 

        //$pre_check = DB::table('press')

        $db = DB::table('press')
            ->join('users','press.user_id','=','users.id')
            ->where('press.user_id',Auth::user()->id)
            ->select("users.id","press.img_path as press_img_path", "users.name","press.id as press_id","press.number_view", "press.press_body",
                "press.created_at as press_created_at","users.avatar","press.user_id")
            ->orderBy("press.created_at")
            ->get();
        return view('press.index',[
            'movements'=>$db, 
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
        $status     =   $request->status;
        if($request->file('file'))
        {
            $path = $request->file('file')->store('img/press','public');
            $data = array(
                'uid'           => \Auth::user()->id,
                'post'          =>  $request->status,
                'photo'         =>  $path,
            );

            $db = DB::table('press')
                ->insertGetId(['user_id'=>Auth::user()->id,'img_path'=>$path,'press_body'=>$status]);

            $post = '<div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="'.asset(Auth::user()->avatar).'" alt="User Image">
                <span class="username"><a href="'.url("profile").'/'.Auth::user()->id.'">'.Auth::user()->name.'</a></span>
                <span class="description">Shared publicly - '.Carbon::now().'</span>
              </div>
            </div>

            <div class="box-body" style="display: block;">
              <img class="img-responsive show-in-modal" src="'.asset($path).'" alt="Photo">
              <p>'.$status.'</p></p>
              <a type="button" href="'.url('budget').'/sign/'.$db.'" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i>0 Like</a>
              <a href="'.url('press').'/'.$db.'" type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Read More</a>
              <span class="pull-right text-muted">'.$this->number_signature($db).'Views</span>
            </div>
            
          </div>';
        }
        else
        {
            $data = array(
                'uid'           => \Auth::user()->id,
                'post'          =>  $request->status,
            );
            $db = DB::table('press')->insert(['user_id'=>Auth::user()->id,'press_body'=>$status]);
            $post = '<div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="'.asset(Auth::user()->image).'" alt="User Image">
                <span class="username"><a href="'.url("profile").'/'.Auth::user()->id.'">'.Auth::user()->name.'</a></span>
                <span class="description">Shared publicly - '.Carbon::now().'</span>
              </div>
            </div>

            <div class="box-body" style="display: block;">
              <p>'.$status.'</p></p>
              <a type="button" href="'.url('press').'/sign/'.$db.'" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i>0 Like</a>
              <a href="'.url('press').'/'.$db.'" type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Read More</a>
              <span class="pull-right text-muted">'.$this->number_signature($db).'Views</span>
            </div>
            
          </div>';
        }

        $validator = \Validator::make($data, [
            'post'          =>  'nullable|string',
        ]);

        if($validator->fails())
        {
            return $validator->errors();
        }
        ///$savePost = $this->post->setPost($data);
        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {

        if($request->op == 1){
            $check = DB::table('press_like')
                ->where([["user_id",Auth::user()->id],["press_id",$request->id]])->first();
            if(empty($check)){
                $insert = DB::table("budget_like")
                    ->insert(["user_id"=>Auth::user()->id,"budget_id"=>$request->id,"likes"=>1]);
                return 1;
            }
            else{
                return 2;
            }
            return "hey";
        }

        elseif($request->op == '2'){
            return "hi";
        }
        else{
            return "nonsense";
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

    public static function number_signature($id){
        $likes = DB::table('press_like')->where('press_id','=',$id)->count();
        return $likes;
    }

    public static function press_like($id){
        $likes = DB::table('press_like')->where('press_id','=',$id)->count();
        return $likes;
    }

    public static function check_like($id){
        $likes = DB::table('press_like')->where([['press_id','=',$id],["user_id","=",Auth::user()->id]])->count();
        return $likes;
    }
}
