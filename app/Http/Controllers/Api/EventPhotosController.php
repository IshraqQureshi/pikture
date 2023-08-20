<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\PhotoCollection;

class EventPhotosController extends Controller
{
    public function index(Request $request, Event $event): PhotoCollection
    {
        $this->authorize('view', $event);

        $search = $request->get('search', '');

        $photos = $event
            ->photos()
            ->search($search)
            ->latest()
            ->paginate();

        return new PhotoCollection($photos);
    }

    public function store(Request $request, Event $event): PhotoResource
    {
        $this->authorize('create', Photo::class);

        $validated = $request->validate([
            'photo' => ['required', 'file'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $photo = $event->photos()->create($validated);

        return new PhotoResource($photo);
    }
}
