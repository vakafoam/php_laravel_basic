<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use App\Tag;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function getIndex()
    {
        // $posts = Post::all();
        // or alternative approach is DB::table('posts')-> ...
        // or to sort:

        $posts = Post::orderBy('created_at', 'desc')->get();

        return view('blog.index', ['posts' => $posts]);
    }

    public function getAdminIndex()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('admin.index', ['posts' => $posts]);
    }

    public function getPost($id)
    {
        // $post = Post::find($id); //short, or
        $post = Post::where('id', '=', $id)->with('likes')->first(); // with() Eagerly pre-loads the connected likes too 
        return view('blog.post', ['post' => $post]);
    }

    public function getLikePost($id)
    {
        $post = Post::where('id', '=', $id)->first();
        $like = new Like();
        $post->likes()->save($like);
        return redirect()->back();
    }

    public function getAdminCreate()
    {
        $tags = Tag::all();
        return view('admin.create', ['tags' => $tags]);
    }

    public function getAdminEdit($id)
    {
        // $post = Post::find($id); //short, or
        $post = Post::where('id', '=', $id)->first();
        $tags = Tag::all();
        return view('admin.edit', ['post' => $post, 'postId' => $id, 'tags' => $tags]);
    }

    public function postAdminCreate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        $post = new Post([    // array of fileds that are declared fillable in Post model
            'title'=> $request->input('title'),
            'content'=> $request->input('content'),
        ]);
        $post->save();
        $post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags'));

        // $post->addPost($session, $request->input('title'), $request->input('content')); //dummy data

        return redirect()->route('admin.index')->with('info', 'Post created, Title is: ' . $request->input('title'));
    }

    public function postAdminUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        $post = Post::find($request->input('id'));
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        // $post->tags()->detach();
        // $post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags'));
        $post->tags()->sync($request->input('tags') === null ? [] : $request->input('tags'));  // a more efficient way to do the above 2 lines
        return redirect()->route('admin.index')->with('info', 'Post edited, new Title is: ' . $request->input('title'));
    }

    public function getAdminDelete($id) {
        $post = Post::find($id);
        $post->likes()->delete(); // if you delete a Post, remove the connections too
        $post->tags()->detach();
        $post->delete();  // hard deletion (if you want to be able to restore it, use Soft Delete)
        return redirect()->route('admin.index')->with('info', 'Post ' .$post->title . ' deleted!');
    }
}