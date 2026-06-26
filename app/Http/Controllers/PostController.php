<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::latest()->get();
            return response()->json(['posts' => $posts]);
        }

        return view("posts");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "body" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }

        $post = Post::create([
            "title" => $request->title,
            "body" => $request->body
        ]);

        return response()->json(["success" => $post]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return response()->json(["post" => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "body" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }

        $post = Post::find($id);

        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

         return response()->json(["success" => $post]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $post->delete();

        return response()->json(["success" => 1]);
    }
}
