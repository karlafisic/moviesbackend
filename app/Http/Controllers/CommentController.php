<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::with(['user', 'movie'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'content' => 'required|string',
        ]);

        return Comment::create([
            'user_id' => auth()->id(),
            'movie_id' => $validated['movie_id'],
            'content' => $validated['content']
        ]);
    }

    public function show($id)
    {
        return Comment::with(['user', 'movie'])
            ->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        
        if ($comment->user_id !== auth()->id()) { 
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string',  
        ]);

        $comment->update($validated);  
        return $comment;
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
    public function movieComments($id)
    {
        return Comment::where('movie_id', $id)
            ->with('user')
            ->get();
    }
}