<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\Interfaces\IntroInterface;

class IntroController extends Controller
{

    protected $intro;
    protected $friends;
    public function __construct(IntroInterface $intro)
    {
        $this->middleware('auth');
        $this->intro = $intro;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('intro.index');
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
        if($request->opcode == 1)
        {
            $sex = $request->sex;
            $nationality = $request->nationality;
            $residence = $request->residence;
            $state = $request->state;
            $lga = $request->lga;
            $dob = $request->dob;

            $payLoad = array(
                'gender'        =>  $sex,
                'nationality'   =>  $nationality,
                'residence'     =>  $residence,
                'state'         =>  $state,
                'lga'           =>  $lga,
                'dob'           =>  $dob,
            );

            $validator = \Validator::make($payLoad, [
                'sex'           =>  'required|integer',
                'nationality'   =>  'required',
                'residence'     =>  'required',
                'state'         =>  'required|integer',
                'lga'           =>  'required|integer',
                'dob'           =>  'required',
            ]);

            if($validator->fails())
            {
                return $validator->errors();
            }

            $status = $this->intro->updateProfile($payLoad);
            if($request->ajax())
            {
                return response()->json($status);
            }
            die("DIRECT ACCESS TO THIS PAGE NOT ALLOWED");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        if($id == 'start')
        {
            return view('onboarding.index');
            //$officeHolders = app('App\Http\Controllers\UserController')->getUsers(2);
            //return view('intro.start', ['politicals' => $officeHolders]);
        }
        if($id == 'profile-setup')
        {
            return view('onboarding.profile-setup');
        }
        if($id == 'know-your-leaders')
        {
            $president      =   app('App\Http\Controllers\UtilityController')->get_leader_identity(2, 0);
            $governor       =   app('App\Http\Controllers\UtilityController')->get_leader_identity(3, \Auth::user()->profile->state_id);
            $senator        =   app('App\Http\Controllers\UtilityController')->get_leader_identity(4, \Auth::user()->profile->state_id);
            $ward_leader    =   app('App\Http\Controllers\UtilityController')->get_leader_identity(5, \Auth::user()->profile->state_id);
            $lga            =   app('App\Http\Controllers\UtilityController')->get_leader_identity(6, \Auth::user()->profile->state_id);
            $federal_rep    =   app('App\Http\Controllers\UtilityController')->get_leader_identity(7, \Auth::user()->profile->state_id);
            $state_rep      =   app('App\Http\Controllers\UtilityController')->get_leader_identity(8, \Auth::user()->profile->state_id);
            
            if($president != "not defined") {
                $check = app('App\Http\Controllers\FriendshipController')->check($president->id);
                if($check['status'] != "friends" && $check['status'] != "pending" && $check['status'] != "waiting") {
                    \Auth::user()->add_friend($president->id);
                }
            }

            if($governor != "not defined") {
                $check = app('App\Http\Controllers\FriendshipController')->check($governor->id);
                if($check['status'] != "friends" && $check['status'] != "pending" && $check['status'] != "waiting") {
                    \Auth::user()->add_friend($governor->id);
                }
            }

            if($senator != "not defined") {
                $check = app('App\Http\Controllers\FriendshipController')->check($senator->id);
                if($check['status'] != "friends" && $check['status'] != "pending" && $check['status'] != "waiting") {
                    \Auth::user()->add_friend($senator->id);
                }
            }

            if($ward_leader != "not defined") {
                $check = app('App\Http\Controllers\FriendshipController')->check($ward_leader->id);
                if($check['status'] != "friends" && $check['status'] != "pending" && $check['status'] != "waiting") {
                    \Auth::user()->add_friend($ward_leader->id);
                }
            }

            if($lga != "not defined") {
                $check = app('App\Http\Controllers\FriendshipController')->check($lga->id);
                if($check['status'] != "friends" && $check['status'] != "pending" && $check['status'] != "waiting") {
                    \Auth::user()->add_friend($lga->id);
                }
            }

            if($federal_rep != "not defined") {
                $check = app('App\Http\Controllers\FriendshipController')->check($federal_rep->id);
                if($check['status'] != "friends" && $check['status'] != "pending" && $check['status'] != "waiting") {
                    \Auth::user()->add_friend($federal_rep->id);
                }
            }

            if($state_rep != "not defined") {
                $check = app('App\Http\Controllers\FriendshipController')->check($state_rep->id);
                if($check['status'] != "friends" && $check['status'] != "pending" && $check['status'] != "waiting") {
                    \Auth::user()->add_friend($state_rep->id);
                }
            }
            $states = app('App\Http\Controllers\UtilityController')->get_states('all');
            if(\Auth::user()->profile->lga_id) {
                $area   =   \App\Lga::find(\Auth::user()->profile->lga_id);
                $state  = \App\State::find(\Auth::user()->profile->state_id);
            } else {
                $area = "N/A";
                $state = "N/A";
            }
            return view('onboarding.states', [
                'states'        =>  $states,
                'president'		=>	$president,
                'governor'		=>	$governor,
                'senator'		=>	$senator,
                'ward'          =>	$ward_leader,
                'lga'    		=>	$lga,
                'federal'       =>	$federal_rep,
                'state'    	    =>	$state_rep,
                'area'          =>  $area->lga,
                'user_state'    =>  $state->state
            ]);
        }
        if($id == '')
        {
            return view("");
        }
        if($id == "follow")
        {
            $opcode = $request->fcode;
            if($opcode == 1)
            {
                $id = $request->id;
                
                $payLoad = array(
                    'uid'   =>  \Auth::user()->id,
                    'sid'   =>  $id
                );

                $validator = \Validator::make($payLoad, [
                    'uid'   =>  'required|integer',
                    'sid'   =>  'required|integer'
                ]);

                if($validator->fails())
                {
                    return $validator->errors();
                }
                $status = $this->intro->follow($payLoad, 1);
                if($request->ajax())
                {
                    return response()->json($status);
                }
                die("DIRECT ACCESS TO THIS PAGE NOT ALLOWED");
            }
        }
        if($id == "isfollow")
        {
            $uid = \Auth::user()->id;
            $sid = $request->sid;
            $payLoad = array(
                'uid'   =>  $uid,
                'sid'   =>  $sid
            );
            $status = $this->isFollowing($payLoad, 1);
            if($request->ajax())
            {
                return response()->json($status);
            }
            die("DIRECT ACCESS TO  THIS PAGE NOT ALLOWED");
        }
        if($id == "finish")
        {
            $status = $this->intro->finish();
            if($request->ajax())
            {
                return response()->json($status);
            }
            die("DIRECT ACCESS TO THIS PAGE NOT ALLOWED");
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

    public function lga($id)
    {
        $lgas = $this->getStateLGA($id);
        if($request->ajax())
        {
            return response()->json($lgas);
        }
        return $lgas;
    }

    public function isFollowing(array $payLoad, $option)
    {
        $status = $this->intro->isFollowing($payLoad, $option);
        return $status;
    }
}
