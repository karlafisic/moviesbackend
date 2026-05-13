<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::with('genres');

        if ($request->has('search')) {
            $query->where('title', 'ILIKE', '%' . $request->search . '%');
        }
        return $query->get();
    }

    public function show($id)
    {
        return Movie::with(['genres', 'ratings', 'comments'])
            ->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'release_year' => 'required|integer',
        ]);

        return Movie::create($validated);
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $movie->update($request->all());

        return $movie;
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);

        $movie->delete();

        return response()->json([
            'message' => 'Movie deleted successfully'
        ]);
    }
    public function attachGenre(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $request->validate([
            'genre_id' => 'required|exists:genres,id'
        ]);

        $movie->genres()->attach($request->genre_id);

        return response()->json([
            'message' => 'Genre added to movie'
        ]);
    }
}