<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        return Rating::with(['user', 'movie'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rating::updateOrCreate(
            ['user_id' => auth()->id(), 'movie_id' => $validated['movie_id']],
            ['rating' => $validated['rating']]
        );

        return $rating;
    }

    public function show($id)
    {
        return Rating::with(['user', 'movie'])
            ->findOrFail($id);
    }
    public function update(Request $request, $id)
    {
        $rating = Rating::findOrFail($id);
        // Provjeri da korisnik može mijenjati samo svoju ocjenu
        if ($rating->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);
        
        $rating->update($validated);
        return $rating;
    }
    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        
        if ($rating->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $rating->delete();
        return response()->json(['message' => 'Rating deleted successfully']);
    }
}