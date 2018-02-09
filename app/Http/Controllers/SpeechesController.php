<?php

namespace App\Http\Controllers;

use DB;

use Auth;

use Validator;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Interfaces\FriendInterface;
use App\Repositories\Interfaces\PostInterface;

class SpeechesController extends Controller
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
    {
        $db = DB::table("speeches")
        ->join("users","users.id","=","speeches.user_id")
        ->select("users.id","speeches.img_path as interview_img_path",
            "users.name","speeches.id as interview_id","speeches.number_view",
            "speeches.speech_body",
            "speeches.created_at as interview_created_at","users.image","speeches.user_id")
        ->where("speeches.user_id",Auth::user()->id)
        ->orderBy("speeches.created_at")
        ->get();
        $friends = $this->friends->getFriendsFromFriendRequestCount(\Auth::user()->id);
        $photos = $this->post->getPostPhotosCount(\Auth::user()->id);
        $friends_total = $this->friends->getFriendsFromFriendRequestCount(\Auth::user()->id);
        return view('speeches.index',["movements"=>$db, 'friends'=> $friends, 'photos' => $photos, 'friends_total' => $friends_total]);
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
            $path = $request->file('file')->store('img/speech','public');
            $data = array(
                'uid'           => \Auth::user()->id,
                'post'          =>  $request->status,
                'photo'         =>  $path,
            );

            $db = DB::table('speeches')
                ->insertGetId(['user_id'=>Auth::user()->id,'img_path'=>$path,'speech_body'=>$status]);

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
              <a type="button" href="'.url('speeches').'/sign/'.$db.'" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i>0 Like</a>
              <a href="'.url('speeches')/$db.'" type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Read More</a>
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
            $db = DB::table('speeches')->insert(['user_id'=>Auth::user()->id,'speech_body'=>$status]);
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
              <a type="button" href="'.url('speeches').'/sign/'.$db.'" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i>0 Like</a>
              <a href="'.url('speeches')/$db.'" type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Read More</a>
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

    public static function number_signature($id){
        $likes = DB::table('speech_like')->where('speech_id','=',$id)->count();
        return $likes;
    }

    public static function speech_like($id){
        $likes = DB::table('speech_like')->where('speech_id','=',$id)->count();
        return $likes;
    }

    public static function check_like($id){
        $likes = DB::table('speech_like')->where([['speech_id','=',$id],["user_id","=",Auth::user()->id]])->count();
        return $likes;
    }
}
