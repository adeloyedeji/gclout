<?php

namespace App\Http\Controllers;

use DB;

use Auth;

use Validator;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\Interfaces\FriendInterface;
use App\Repositories\Interfaces\PostInterface;

class BudgetController extends Controller
{

    protected $friends;
    protected $post;
    public function __construct(FriendInterface $friends, PostInterface $post)
    {
        $this->middleware('auth');
        $this->friends = $friends;
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $db = DB::table('budget')
            ->join('users','budget.user_id','=','users.id')
            ->where('budget.user_id','=',Auth::user()->id)
            ->select("users.id","budget.img_path as budget_img_path",
            "users.name","budget.id as budget_id","budget.number_view",
            "budget.budget_body",
            "budget.created_at as budget_created_at","users.image","budget.user_id")
            ->orderBy("budget.created_at",'desc')
            ->get();
            $friends = $this->friends->getFriendsFromFriendRequestCount(\Auth::user()->id);
            $photos = $this->post->getPostPhotosCount(\Auth::user()->id);
            $friends_total = $this->friends->getFriendsFromFriendRequestCount(\Auth::user()->id);
        return view('budget.index',["movements"=>$db, 'friends'=> $friends, 'photos' => $photos, 'friends_total' => $friends_total]);
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
            $path = $request->file('file')->store('img/Budget','public');
            $data = array(
                'uid'           => \Auth::user()->id,
                'post'          =>  $request->status,
                'photo'         =>  $path,
            );
            
            $db = DB::table('budget')
                ->insertGetId(['user_id'=>Auth::user()->id,'img_path'=>$path,'budget_body'=>$status]);

            $post = '<div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="'.asset(Auth::user()->image).'" alt="User Image">
                <span class="username"><a href="'.url("profile").'/'.Auth::user()->id.'">'.Auth::user()->name.'</a></span>
                <span class="description">Shared publicly - '.Carbon::now().'</span>
              </div>
            </div>

            <div class="box-body" style="display: block;">
              <img class="img-responsive show-in-modal" src="'.asset($path).'" alt="Photo">
              <p>'.$status.'</p></p>
              <a type="button" href="'.url('budget').'/sign/'.$db.'" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i>0 Like</a>
              <a href="'.url('movements')/$db.'" type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Read More</a>
              <span class="pull-right text-muted">'.$this->number_signature($db).'Views</span>
            </div>
            
          </div';
        }
        else
        {
            $data = array(
                'uid'           => \Auth::user()->id,
                'post'          =>  $request->status,
            );
            $db = DB::table()->insert(['user_id'=>Auth::user()->id,'budget_body'=>$status]);
            $post = '<div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="'.asset(Auth::user()->image).'" alt="User Image">
                <span class="username"><a href="'.url("profile").'/'.Auth::user()->id.'">'.Auth::user()->name.'</a></span>
                <span class="description">Shared publicly - '.Carbon::now().'</span>
              </div>
            </div>

            <div class="box-body" style="display: block;">
              <img class="img-responsive show-in-modal" src="'.asset($path).'" alt="Photo">
              <p>'.$status.'</p></p>
              <a type="button" href="'.url('budget').'/sign/'.$db.'" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i>0 Like</a>
              <a href="'.url('movements')/$db.'" type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Read More</a>
              <span class="pull-right text-muted">'.$this->number_signature($db).'Views</span>
            </div>
            
          </div';
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
            $check = DB::table('budget_like')
                ->where([["user_id",Auth::user()->id],["budget_id",$request->id]])->first();
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
        return 1;
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
        $likes = DB::table('signs')->where('movement_id','=',$id)->count();
        return $likes;
    }

    public static function budget_like($id){
        $likes = DB::table('budget_like')->where('budget_id','=',$id)->count();
        return $likes;
    }

    public static function check_like($id){
        $likes = DB::table('budget_like')->where([['budget_id','=',$id],["user_id","=",Auth::user()->id]])->count();
        return $likes;
    }
}
