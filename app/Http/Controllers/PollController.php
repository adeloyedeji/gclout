<?php

namespace App\Http\Controllers;

use ConsoleTVs\Charts\Builder\Chart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Khill\Lavacharts\Lavacharts;
use App\Http\Requests;
use Charts;

class PollController extends Controller
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
        $polls = DB::table('polls')
        ->join('users','polls.user_id','=','users.id')
        ->orderBy('polls.created_at','desc')
        ->select('polls.id as poll_id','users.id as user_id','polls.created_at','polls.poll_body','polls.poll_title','polls.answers','users.name', 'users.avatar as avatar', 'polls.figure1')
        ->get();
        return view('polls.index',[
            'polls'=>$polls, 
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
    
    if($request->opcode == 2){

	    if($request->answer=="agree"){
	     DB::table('polls_answers')
	    	->insert(["poll_id"=>$request->poll_id,"user_id"=>$request->id,"answer_yes"=>1,"answer_no"=>0,"answer_undecided"=>0]);
	    	$val = $this->check_answered($request->poll_id,$request->id);
	    }
	    elseif($request->answer=="disagree"){
	     DB::table('polls_answers')
	    	->insert(["poll_id"=>$request->poll_id,"user_id"=>$request->id,"answer_no"=>1,"answer_yes"=>0,"answer_undecided"=>0]);
	    	$val = $this->check_answered($request->poll_id,$request->id);
	    }
	    else{
	     DB::table('polls_answers')
	    	->insert(["poll_id"=>$request->poll_id,"user_id"=>$request->id,"answer_undecided"=>1,"answer_no"=>0,"answer_yes"=>0]);
	    	$val = $this->check_answered($request->poll_id,$request->id);
	    }
 
    return response()->json($val);
    
    }
    else{
        $this->validate($request,[
            'poll_title'=>'required',
            'poll_body'=>'required',
            'category'=>'required',
            'target_arm'=>'required',
            'answers'=>'required'
        ]);

        $poll_title = $request->input('poll_title');
        $poll_body = $request->input('poll_body');
        $issues = $request->input('category');
        $audience = $request->input('target_arm');
        $answer = $request->input('answers');
        if($request->file('file')) {
            $path = $request->file('imagenew')->store('img/poll');
        } else {
            $path = NULL;
        }
        DB::table('polls')
            ->insert(['poll_title'=>$poll_title,'figure1'=>$path,'poll_body'=>$poll_body,'category'=>$issues,'audience'=>$audience,'answers'=>$answer,'user_id'=>Auth::user()->id]);

        return redirect('/polls')->with('message','Poll Created Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if($request->poll != "" && $request->poll != "categories") {
            $polls = DB::table('polls')
            ->join('users','polls.user_id','=','users.id')
            ->where('polls.id', $request->poll)
            ->select('polls.id as poll_id','users.id as user_id','polls.created_at','polls.poll_body','polls.poll_title','polls.answers','users.name', 'users.avatar as avatar', 'polls.figure1')
            ->get();
            return view('polls.index',[
                'polls'=>$polls, 
            ]);
        } else if($id == 'categories') {
            $sector = $request->sector;
            $polls = DB::table('polls')
            ->join('users','polls.user_id','=','users.id')
            ->where('polls.category', $sector)
            ->select('polls.id as poll_id','users.id as user_id','polls.created_at','polls.poll_body','polls.poll_title','polls.answers','users.name', 'users.avatar as avatar', 'polls.figure1')
            ->get();
            return view('polls.index',[
                'polls'=>$polls, 
            ]);
        } else {
            abort(404);
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

    public static function check_answered($id,$user_id){
        $check = DB::table('polls_answers')
            ->where([['poll_id','=',$id],['user_id','=',$user_id]])
            ->get();
        if(count($check)==0){
            //do not return any data.


            return "empty";
        }
        else{
            //return the result overview
            $yes = DB::table('polls_answers')->where([['poll_id','=',$id]])->sum('answer_yes');
            $no = DB::table('polls_answers')->where([['poll_id','=',$id]])->sum('answer_no');
            $maybe = DB::table('polls_answers')->where([['poll_id','=',$id]])->sum('answer_undecided');
            $title = DB::table('polls_answers')->leftJoin('polls','polls_answers.id','=','polls.id')->where('poll_id',$id)->select('polls.poll_title')->first();
            $charts = Charts::create('donut', 'highcharts')
                ->title($title->poll_title." Poll Update")
                ->labels(['Yes', 'No', 'Undecided'])
                ->dimensions(0,250)
                ->values([$yes,$no,$maybe])
                ->responsive(false);
            return $charts;
        }
    }
}
