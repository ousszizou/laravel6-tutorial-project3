<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ReplyResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reply;
use Validator;
use App\Notifications\ReplyAdded;

class ReplyController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $v = Validator::make($request->all(), [
          "content" => "required"
      ]);

      if ($v->fails()) {
        return response()->json([
          "error" => true,
          "errors" => $v->errors()
        ],422);
      }

      $reply = new Reply([
        "content" => $request->content,
        "user_id" => $request->user_id,
        "discussion_id" => $request->discussion_id
      ]);

      $reply->save();

      $reply->discussion->user->notify(new ReplyAdded($reply));

      return new ReplyResource($reply);
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
}
