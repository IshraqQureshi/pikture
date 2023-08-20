<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Photo;
use App\Models\Event;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PhotoStoreRequest;
use App\Http\Requests\PhotoUpdateRequest;
use Auth;
use Spatie\Permission\Models\Role;


class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */public function index(Request $request): View
    {
        $this->authorize('view-any', Photo::class);

        $user = Auth::user();
        $search = $request->get('search', '');

        $photosQuery = Photo::where(function ($query) use ($search) {
            $query->whereHas('event', function ($query) use ($search) {
                $query->where('gallery_name', 'like', '%' . $search . '%');
            });
        })
            ->latest();

        if ($user->hasRole(Role::findByName('organizer'))) {
            $events = Event::where('organizer_id', $user->id)->pluck('id')->toArray();
            $photosQuery->whereIn('event_id', $events);
        }

        $photos = $photosQuery->paginate(5)->appends(['search' => $search]);

        return view('app.photos.index', compact('photos', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Photo::class);

        $user = Auth::user();
        $events = Event::where('organizer_id', $user->id)->pluck('gallery_name', 'id');

        return view('app.photos.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PhotoStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Photo::class);

        $validated = $request->validated();
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $event = Event::where('id', $request->event_id)->first();
        $maxPhoto = $event->max_photos;

        if ($maxPhoto !== null && $maxPhoto >= 0) {
            $currentPhotos = Photo::where('event_id', $request->event_id)->count();

            if ($currentPhotos < $maxPhoto) {
                // Your code for creating and redirecting
                $photo = Photo::create($validated);

                return redirect()
                    ->route('photos.edit', $photo)
                    ->withSuccess(__('crud.common.created'));
            } else {
                // Handling the case when the limit is exceeded
                return redirect()
                    ->route('photos.index')
                    ->withError(__('Photo limit exceeded for this event'));
            }
        } else {
            // Handling the case when the max_photos value is null or negative
            return redirect()
                ->route('photos.index')
                ->withError(__('Invalid max_photos value for this event'));
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Photo $photo): View
    {
        $this->authorize('view', $photo);

        return view('app.photos.show', compact('photo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Photo $photo): View
    {
        $this->authorize('update', $photo);

        $events = Event::pluck('gallery_name', 'id');

        return view('app.photos.edit', compact('photo', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PhotoUpdateRequest $request,
        Photo $photo
    ): RedirectResponse {
        $this->authorize('update', $photo);

        $validated = $request->validated();
        if ($request->hasFile('photo')) {
            if ($photo->photo) {
                Storage::delete($photo->photo);
            }

            $validated['photo'] = $request->file('photo')->store('public');
        }

        $photo->update($validated);

        return redirect()
            ->route('photos.edit', $photo)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Photo $photo): RedirectResponse
    {
        $this->authorize('delete', $photo);

        if ($photo->photo) {
            Storage::delete($photo->photo);
        }

        $photo->delete();

        return redirect()
            ->route('photos.index')
            ->withSuccess(__('crud.common.removed'));
    }
    public function gallery()
    {
        $user = auth()->user();        
        $events = '';

        if ($user->hasRole(Role::findByName('super-admin'))) {
            $events = Event::pluck('gallery_name', 'id');
            $photos = Photo::with('event')->get();
        } elseif ($user->hasRole(Role::findByName('user'))) {
            $invitation = Invitation::where('email', $user->email)->pluck('event_id');
            $events = Event::whereIn('id', $invitation)->get();
            $eventIds = $events->pluck('id')->all();
            $photos = Photo::whereIn('event_id', $eventIds)->with('event')->get();
        } else {
            $invitation = Invitation::where('email', $user->email)->first();
            $events = Event::where('id', $invitation ? $invitation->event_id : '')->get();
            $photos = [];

            $photos = Photo::where('event_id', $invitation ? $invitation->event_id : '')->with('event')->get();


        }

        // $this->authorize('view gallery', Photo::class);

        return view('app.gallery.index', compact('photos', 'events'));
    }

    public function eventGallery(Request $request)
    {
        $user = auth()->user();
        $selectedEvent = $request->event_id;

        if ($user->hasRole(Role::findByName('user'))) {
            $invitation = Invitation::where('email', $user->email)->pluck('event_id');
            $events = Event::whereIn('id', $invitation)->get();

            if ($selectedEvent == 'all') {
                $photos = Photo::whereIn('event_id', $invitation)->with('event')->get();
            } else {
                $photos = Photo::where('event_id', $selectedEvent)->whereIn('event_id', $invitation)->get();
            }
        } elseif ($user->hasRole(Role::findByName('organizer'))) {

            $invitation = Invitation::where('email', $user->email)->first();
            $events = Event::where('id', $invitation->event_id)->get();

            if ($selectedEvent == 'all') {
                $photos = Photo::whereIn('event_id', $invitation)->with('event')->get();
                // dd($photos);
            } else {
                $photos = Photo::where('event_id', $selectedEvent)->whereIn('event_id', $invitation)->get();
                // dd($photos);
            }
        } else {
            $events = Event::pluck('gallery_name', 'id');

            if ($selectedEvent == 'all') {
                $photos = Photo::with('event')->get();
            } else {
                $photos = Photo::where('event_id', $selectedEvent)->get();
            }

        }

        return view('app.gallery.index', compact('photos', 'events', 'selectedEvent'));
    }




}
