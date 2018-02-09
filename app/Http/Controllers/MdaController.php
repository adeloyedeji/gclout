<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\FriendInterface;
use App\Repositories\Interfaces\PostInterface;

class MdaController extends Controller
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
        $log_state = Auth::user()->state;
        // $db2 = DB::table("press")
        // ->join("users","users.id","=","press.user_id")
        // ->join("account_roles","account_roles.id","=","users.role")
        // ->select("users.id","press.img_path as interview_img_path",
        //     "users.name","press.id as interview_id",".number_view",
        //     "press.press_body as interview_body","account_roles.description",
        //     "press.created_at as interview_created_at","users.image","press.user_id")
        // ->where([["mda_check",1],
        // ["users.state","=",Auth::user()->state]
        // ])
        // ->orderBy("press.created_at")
        // ->get();

        $first = DB::table(DB::raw("(select users.id,users.name,press.img_path as interview_img_path,press.mda_check,users.state as press_state,
        press.press_body as press_body,press.number_view as press_number_view,press.gov_type,press.id as press_id,account_roles.description,press.created_at as interview_created_at,users.image,press.user_id
        from press 
        left join users on press.user_id = users.id
        left join account_roles  on account_roles.id = users.role
        where press.mda_check = 1 and users.state = $log_state
        ) as A"))
        ->get();

        $second = DB::table(DB::raw("(select users.id,users.name,interviews.img_path as interview_img_path,interviews.mda_check,users.state as interview_state,
        interviews.interview_body as interview_body,interviews.number_view as interviews_number_view,interviews.id as interviews_id,interviews.gov_type,account_roles.description,interviews.created_at as interview_created_at,users.image,interviews.user_id
        from interviews 
        left join users on interviews.user_id = users.id
        left join account_roles  on account_roles.id = users.role
        where interviews.mda_check = 1 and users.state = $log_state
        ) as B"))
        ->get();

        $third = DB::table(DB::raw("(select users.id,users.name,budget.img_path as interview_img_path,budget.mda_check,users.state as budget_state,
        budget.budget_body as budget_body,budget.number_view as budget_number_view,budget.gov_type,budget.id as budget_id,account_roles.description,budget.created_at as interview_created_at,users.image,budget.user_id
        from budget 
        left join users on budget.user_id = users.id
        left join account_roles  on account_roles.id = users.role
        where budget.mda_check = 1 and users.state = $log_state
        ) as C"))
        ->get();

        $fourth = DB::table(DB::raw("(select users.id,users.name,speeches.img_path as interview_img_path,speeches.mda_check,users.state as speeches_state,
        speeches.speech_body as speeches_body,speeches.number_view as speeches_number_view,speeches.gov_type,speeches.id as speeches_id,account_roles.description,speeches.created_at as interview_created_at,users.image,speeches.user_id
        from speeches 
        left join users on speeches.user_id = users.id
        left join account_roles  on account_roles.id = users.role
        where speeches.mda_check = 1 and users.state = $log_state
        ) as D"))
        ->get();

        $friends = $this->friends->getFriendsFromFriendRequestCount(\Auth::user()->id);
        $photos = $this->post->getPostPhotosCount(\Auth::user()->id);
        $friends_total = $this->friends->getFriendsFromFriendRequestCount(\Auth::user()->id);

        $db = $first->merge($second)->merge($third)->merge($fourth);

        return view('mda.index',["movements"=>$db, 'friends'=> $friends, 'photos' => $photos, 'friends_total' => $friends_total]);
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
    public static function budget_like($id){
        $likes = DB::table('budget_like')->where('budget_id','=',$id)->count();
        return $likes;
    }

    public static function budget_check_like($id){
        $likes = DB::table('budget_like')->where([['budget_id','=',$id],["user_id","=",Auth::user()->id]])->count();
        return $likes;
    }

    public static function speech_like($id){
        $likes = DB::table('speech_like')->where('speech_id','=',$id)->count();
        return $likes;
    }

    public static function speech_check_like($id){
        $likes = DB::table('speech_like')->where([['speech_id','=',$id],["user_id","=",Auth::user()->id]])->count();
        return $likes;
    }

    public static function interview_like($id){
        $likes = DB::table('interview_like')->where('interview_id','=',$id)->count();
        return $likes;
    }

    public static function interviews_check_like($id){
        $likes = DB::table('interview_like')->where([['interview_id','=',$id],["user_id","=",Auth::user()->id]])->count();
        return $likes;
    }

    public static function press_like($id){
        $likes = DB::table('press_like')->where('press_id','=',$id)->count();
        return $likes;
    }

    public static function press_check_like($id){
        $likes = DB::table('press_like')->where([['press_id','=',$id],["user_id","=",Auth::user()->id]])->count();
        return $likes;
    }
}
