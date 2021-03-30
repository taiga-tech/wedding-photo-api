<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\PostPhotos;
use Storage;

class PostsController extends Controller
{
    protected $posts;

    public function __construct(Post $posts)
    {
        // $this->middleware('auth');
        $this->posts = $posts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = $this->posts->all();
        $posts = Post::with('user', 'photos')->get();

        return response($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $files = $request->file('files');
        $post = $this->posts->create($input);
        $timeStamp = date('Ymd-His');
        if ($files)
        {
            foreach ($files as $index=> $e)
            {
                $ext = $e['photo']->guessExtension();
                $filename = "{$timeStamp}_{$index}.{$ext}";
                $photo = Storage::disk('s3')
                    ->putFileAs(
                        Auth::user()->name.'/post/photos/'.$post->id,
                        $e['photo'], $filename,
                        'public'
                    );
                // $path = Storage::disk('s3')->url($photo);
                // $path = config('app.cdn_url') . $photo;
                $post->photos()->create([ 'path' => $photo ]);
            }
        }

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
        // $post = $this->posts->find($id);
        $post = Post::with('user', 'photos')->find($id);

        return $post;
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
        $post = $this->posts->find($id);
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $files = $request->file('files');
        $post->update($input);
        $timeStamp = date('Ymd-His');

        if ($files)
        {
            foreach ($files as $index=> $e)
            {
                $ext = $e['photo']->guessExtension();
                $filename = "{$timeStamp}_{$index}.{$ext}";
                $photo = Storage::disk('s3')
                    ->putFileAs(
                        Auth::user()->name.'post/photos/'.$post->id,
                        $e['photo'], $filename,
                        'public'
                    );
                // $path = Storage::disk('s3')->url($photo);
                // $path = config('app.cdn_url') . $photo;
                $post->photos()->create(['path'=> $photo]);
            }
        }

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->posts->find($id);
        if (Auth::id() === 2)
        {
            $post->delete();
        }

        return $post;
    }

    public function imageDestroy($id)
    {
        $image = PostImage::find($id);
        $image->delete();

        return $image;
    }
}
