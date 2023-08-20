<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventCollection;

class UserEventsController extends Controller
{
    public function index(Request $request, User $user): EventCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $events = $user
            ->events()
            ->search($search)
            ->latest()
            ->paginate();

        return new EventCollection($events);
    }

    public function store(Request $request, User $user): EventResource
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'gallery_name' => ['required', 'max:255', 'string'],
            'max_photos' => ['nullable', 'numeric'],
            'max_users' => ['required', 'numeric'],
            'expiration_date' => ['nullable', 'date'],
        ]);

        $event = $user->events()->create($validated);

        return new EventResource($event);
    }
}
