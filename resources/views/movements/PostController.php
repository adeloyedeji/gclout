<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use App\Repositories\Interfaces\PostInterface;

class PostController extends Controller
{

    protected $post;
    public function __construct(PostInterface $post)
    {
        $this->middleware('auth');
        $this->post = $post;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $opcode = $request->opcode;
        if($opcode == 1)
        {
            $data;
            $status     =   $request->status;
            $location   =   $request->location;
            $audience   =   $request->audience;
            if($request->file('file'))
            {
                $path = $request->file('file')->store('img/Post','public');
                $data = array(
                    'uid'           => \Auth::user()->id,
                    'post'          =>  $request->status,
                    'photo'         =>  $path,
                    'location'      =>  $request->location,
                    'audience'      =>  $request->audience,
                    'allow_comment' =>  0
                );
            }
            else
            {
                $data = array(
                    'uid'           => \Auth::user()->id,
                    'post'          =>  $request->status,
                    'photo'         =>  NULL,
                    'location'      =>  $request->location,
                    'audience'      =>  $request->audience,
                    'allow_comment' =>  0
                );
            }

            $validator = \Validator::make($data, [
                'post'          =>  'nullable|string',
                'photo'         =>  'nullable|string',
                'location'      =>  'nullable|string',
                'audience'      =>  'nullable|integer',
                'allow_comment' =>  'nullable|integer'
            ]);

            if($validator->fails())
            {
                return $validator->errors();
            }
            $savePost = $this->post->setPost($data);
            return response()->json($savePost);
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
        if($id == 'more')
        {
            $count = $request->count;
            $posts = $this->post->getMorePost($count);
            return $posts;
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

    public function all($id)
    {
        $posts = $this->post->getPost($id);
        return $posts;
    }
}
