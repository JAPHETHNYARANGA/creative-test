<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    // Fetch all posts for the authenticated user
    public function index()
    {
        try{
            $userId = Auth::id();

            $userId = Auth::id();
            $posts = Posts::where('user_id', $userId)->get();
            return view('posts', ['posts' => $posts]);

            // for api routes
            // return response()->json(Posts::where('user_id', $userId)->get());
            

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    // Create a new post
    public function store(Request $request)
    {

        try{

            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);
    
            $post = new Posts();
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->user_id = Auth::id();
            $post->save();

            return redirect()->route('posts.index')->with('success', 'Post created successfully.');
            // for api
            // return response()->json(['success' => true, 'post' => $post], 201);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    // Fetch a single post by ID
    public function show($id)
    {

        try{

            $post = Posts::findOrFail($id);

            // Check if the authenticated user is the owner
            if ($post->user_id !== Auth::id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            return view('posts.show', ['post' => $post]);

            // for api
            // return response()->json($post);


        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    // Update a post by ID
    public function update(Request $request, $id)
    {

        try{
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);
    
            $post = Posts::findOrFail($id);
    
            // Check if the authenticated user is the owner
            if ($post->user_id !== Auth::id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
    
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->save();

            return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
            //for api
            // return response()->json(['success' => true, 'post' => $post]);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    // Delete a post by ID
    public function destroy($id)
    {

        try{

            $post = Posts::findOrFail($id);

            // Check if the authenticated user is the owner
            if ($post->user_id !== Auth::id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $post->delete();

            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
            //fpor api routes
            // return response()->json(['success' => true, 'message' => 'Post deleted']);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }
}

