<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlashcardRequest;
use App\Http\Requests\UpdateFlashcardRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\FlashcardResource;
use App\Http\Resources\SubcategoryResource;
use Illuminate\Http\Request;
use App\Models\Flashcard;
use App\Models\Category;
use App\Models\Option;
use App\Models\Subcategory;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FlashcardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flashcards = Flashcard::with('category', 'subcategory', 'options')->paginate();

        return Inertia::render('Flashcards/Index', [
            'flashcards' => FlashcardResource::collection($flashcards),
            'categories' => CategoryResource::collection(Category::all()),
            'subcategories' => SubcategoryResource::collection(Subcategory::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(FlashcardRequest $request)
    {
        $data = $request->validated();

        if(isset($data['options'])) {
            $data['options'] = array_filter($data['options'], function($option) {
                return !empty($option['option']) && !empty($option['option_number']);
            });
        }

        $file = $request->file('image');

        try {
                $obj = Cloudinary::upload($file->getRealPath(), ['folder' => 'Cards']);
                $public_id = $obj->getPublicId();
                $url = $obj->getSecurePath();

            $flashcard = Flashcard::create([
                'title' => $data['title'],
                'category_id' => $data['category_id'],
                'subcategory_id' => $data['subcategory_id'],
                'url' => $url,
                'public_id' => $public_id,
            ]);

            foreach($data['options'] as $option) {
                Option::create([
                    'option' => $option['option'],
                    'option_number' => $option['option_number'],
                    'flashcard_id' => $flashcard->id,
                ]);
            }

            return redirect()->route('flashcards.index')->with('success', 'FlashCard creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear FlashCard: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al crear la FlashCard. Inténtalo nuevamente.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $flashcard = Flashcard::with('category', 'subcategory', 'options')->findOrFail($id);

        return Inertia::render('Flashcards/Show', [
            'flashcard' => new FlashcardResource($flashcard),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFlashcardRequest $request, string $id)
    {   
        $data = $request->validated();

        if(isset($data['options'])) {
            $data['options'] = array_filter($data['options'], function($option) {
                return !empty($option['option']) && !empty($option['option_number']);
            });
        
            foreach($data['options'] as $option) {
                Option::updateOrCreate([
                    'option_number' => $option['option_number'],
                    'flashcard_id' => $id,
                ], [
                    'option' => $option['option'],
                ]);
            }
        }

        $flashcard = Flashcard::findOrFail($id);
        
        if ($request->hasFile('image')) {
            
            Cloudinary::destroy($flashcard->public_id);

            $file = $request->file('image');
            $obj = Cloudinary::upload($file->getRealPath(), ['folder' => 'Cards']);
            $flashcard->public_id = $obj->getPublicId();
            $flashcard->url = $obj->getSecurePath();
        }

        $flashcard->update([
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'],
        ]);

        $flashcard->save();

        return redirect()->route('flashcards.index')->with('success', 'FlashCard actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $flashcard = Flashcard::findOrFail($id);
        Cloudinary::destroy($flashcard->public_id);
        $flashcard->delete();
    }
}
