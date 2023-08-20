<?php

namespace App\Http\Controllers;

use App\Mail\EventMail;
use App\Models\Invitation;
use App\Models\Photo;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Event::class);

        $search = $request->get('search', '') ? $request->get('search', '') : '';
        $user = Auth::user();

        // Get the current date and time
        $currentDate = Carbon::now();

        if ($user->hasRole(Role::findByName('organizer'))) {
            $events = Event::where('organizer_id', $user->id)
                ->withCount('photos')
                ->where(function ($query) use ($search) {
                    $query->where('gallery_name', 'like', '%' . $search . '%');
                })
                ->latest()
                ->paginate(5)
                ->appends(['search' => $search]);
        } else {
            $events = Event::search($search)
                ->withCount('photos')
                ->latest()
                ->paginate(5)
                ->appends(['search' => $search]);

            $events->load('invitations');

            foreach ($events as $event) {
                $event->userCount = Invitation::where('event_id', $event->id)
                    ->whereIn('email', function ($query) {
                        $query->select('email')
                            ->from('users');
                    })
                    ->count();

                // Check if the event's expiration date is less than the current date
                // 28 < 27
                if (Carbon::parse($currentDate)->greaterThan($event->expiration_date)) {
                    // If the event is expired, delete it
                    $event->delete();
                }
            }
        }

        return view('app.events.index', compact('events', 'search'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Event::class);

        $users = User::pluck('name', 'id');

        return view('app.events.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Event::class);

        $validated = $request->validated();
        $event = Event::create($validated);

        $event->invitaion_key = Str::random(15);
        $event->save();

        if ($request->has('email') && !empty($request->email)) {
            Invitation::create([
                'event_id' => $event->id,
                'email' => $request->email,
            ]);

            $existing_user = true;
            $userPassword = '';

            $organizer_event = Event::where('id', $event->id)->first();
            $organizer = User::where('email', $request->email)->first();

            if(!($organizer)){
                $user = new User;
                $user->email = $request->email;
                $user->name = $request->organizer_name;
                $userPassword = Str::random(8);
                $user->password = Hash::make($userPassword);
                $user->save();
                
                $organizer_event->organizer_id = $user->id;
                $organizer_event->save();

                // Assign "organizer" role to the created user
                $organizerRole = Role::findByName('organizer');
                $user->assignRole($organizerRole);

                $existing_user = false;
            } else {
                $organizer_event->organizer_id = $organizer->id;
                $organizer_event->save();
            }

            Mail::to($request->email)->send(new EventMail($request->email, $event->gallery_name, $userPassword, $existing_user));
        }

        return redirect()
            ->route('events.edit', $event)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Event $event): View
    {
        $this->authorize('view', $event);

        return view('app.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Event $event): View
    {
        $this->authorize('update', $event);

        $users = User::pluck('name', 'id');
        $invitation = Invitation::where('event_id', $event->id)->pluck('email');
        $user = User::whereIn('email', $invitation)
            ->whereHas('roles', function ($query) {
                // Check if the user has the "organizer" role
                $query->where('name', 'organizer');
            })
            ->first();

        return view('app.events.edit', compact('event', 'users', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        EventUpdateRequest $request,
        Event $event
    ): RedirectResponse {
        $this->authorize('update', $event);

        $validated = $request->validated();

        $event->update($validated);

        return redirect()
            ->route('events.edit', $event)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()
            ->route('events.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
