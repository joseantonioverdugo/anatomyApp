<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Flashcard;
use App\Http\Resources\FlashcardResource;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::paginate()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Users/Show', [
            'user' => User::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
    }

    public function game()
    {
        $flashcards = Flashcard::with('category', 'subcategory')->get();
        return Inertia::render('Game', [
            'flashcards' => FlashcardResource::collection($flashcards),
            'user' => Auth::user()
        ]);
    }

    public function updateBestScore(Request $request, string $id)
    {
        $request->validate([
            'score' => 'required|integer'
        ]);

        $user = User::findOrFail($id);

        if ($request->score >= $user->best_score) {
            $user->best_score = $request->score;
            $user->save();
        }
    }
}
