<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        return Genre::all();
    }

    public function show($id)
    {
        return Genre::with('movies')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        return Genre::create($validated);
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);

        $genre->update($request->all());

        return $genre;
    }

    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);

        $genre->delete();

        return response()->json([
            'message' => 'Genre deleted successfully'
        ]);
    }
}