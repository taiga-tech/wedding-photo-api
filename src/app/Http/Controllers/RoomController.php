<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($roomId)
    {
        if (Auth::id() == $roomId) {
            $posts = Post::where('user_id', $roomId)
                ->with('user', 'photos')
                ->get();
            $statusCode = 200;
        } else {
            $posts = 'Object not found';
            $statusCode = 404;
        }
        return response($posts, $statusCode);
    }

    // public function show( $roomId, $id )
    // {
    //     if ( Auth::id() == $roomId )
    //     {
    //         if ( Post::find( $id ) ) {
    //             $post = Post::with( 'user', 'photos' )
    //                 ->find( $id );
    //             $statusCode = 200;
    //         }
    //         else
    //         {
    //             $post = null;
    //             $statusCode = 400;
    //         }
    //     }
    //     else
    //     {
    //         $post = null;
    //         $statusCode = 400;
    //     }

    //     return response( $post, $statusCode );
    // }
}
