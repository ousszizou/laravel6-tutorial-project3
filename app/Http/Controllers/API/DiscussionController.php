<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\DiscussionResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Discussion;
use Validator;
use Illuminate\Support\Str;


class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DiscussionResource::collection(Discussion::all());
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
            "title" => "required|unique:discussions",
            "content" => "required"
        ]);

        if ($v->fails()) {
            return response()->json([
                "error" => true,
                "errors" => $v->errors()
            ],422);
        }

        $discussion = new Discussion([
            "title" => $request->title,
            "content" => $request->content,
            "slug" => Str::slug($request->title, "-"),
            "user_id" => $request->user_id,
            "channel_id" => $request->channel_id
        ]);

        $discussion->save();

        return new DiscussionResource($discussion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
      $discussion = Discussion::whereSlug($slug)->firstOrFail();
      return new DiscussionResource($discussion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Discussion $discussion)
    {
        $v = Validator::make($request->all(), [
            "title" => "required|unique:discussions",
            "content" => "required"
        ]);

        if ($v->fails()) {
            return response()->json([
                "error" => true,
                "errors" => $v->errors()
            ],422);
        }

        $discussion->title = $request->title;
        $discussion->content = $request->content;
        $discussion->slug = Str::slug($request->title, "-");
        $discussion->channel_id = $request->channel_id;

        $discussion->save();

        return new DiscussionResource($discussion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discussion $discussion)
    {
        $discussion->delete();

        return response()->json(null, 204);
    }
}
