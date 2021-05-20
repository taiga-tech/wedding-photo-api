<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\PostPhotos;

class AdminController extends Controller
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
        if (Auth::user()->role == 1) {
            $users = User::all();
            $statusCode = 200;
        } else {
            $users = 'Object not found';
            $statusCode = 404;
        }
        return response($users, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->role == 1) {
            // $user = User::with('posts.photos')->get();
            $user = User::with('posts.photos')->find($id);
            $statusCode = 200;
        } else {
            $user = 'Object not found';
            $statusCode = 404;
        }
        return response($user, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Receives an array and deletes the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function delete(Request $request)
    {
        if (Auth::user()->role == 1) {
            $input = $request->all();
            foreach ($input as $index => $e) {
                $post = Post::find($e['id']);
                $post->delete();
                $statusCode = 200;
            }
        } else {
            $post = 'Object not found';
            $statusCode = 404;
        }
        return response($post, $statusCode);
    }
}
