<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Event;
use App\Models\Photo;
use App\Models\User;
use Illuminate\View\View;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\InvitationStoreRequest;
use App\Http\Requests\InvitationUpdateRequest;
use Illuminate\Support\Facades\Mail;
use Auth;
use Spatie\Permission\Models\Role;


class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Invitation::class);

        $user = Auth::user();
        $search = $request->get('search', '');

        if ($user->hasRole(Role::findByName('organizer'))) {

            $events = Event::where('organizer_id', $user->id)->pluck('id')->toArray();
            
            $invitations = Invitation::whereIn('event_id', $events)
                ->where(function ($query) use ($search) {
                    $query->where('email', 'like', '%' . $search . '%')
                        ->orWhereHas('event', function ($query) use ($search) {
                            $query->where('gallery_name', 'like', '%' . $search . '%');                            
                        });                        
                })
                ->where('email', '!=', $user->email)
                ->latest()
                ->paginate(5)
                ->appends(['search' => $search]);

            
        } else {
            $invitations = Invitation::where(function ($query) use ($search) {
                $query->where('email', 'like', '%' . $search . '%')
                    ->orWhereHas('event', function ($query) use ($search) {
                        $query->where('gallery_name', 'like', '%' . $search . '%');
                    });
            })
                ->latest()
                ->paginate(5)
                ->appends(['search' => $search]);
        }

        return view('app.invitations.index', compact('invitations', 'search'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Invitation::class);

        $user = Auth::user();

        if ($user->hasRole(Role::findByName('organizer'))) {            
            $organizerEvents = Event::where('organizer_id', $user->id)->get();
            return view('app.invitations.create', compact('organizerEvents'));
        }

        $events = Event::pluck('gallery_name', 'id');
        $users = User::query();
        $eventId = null;

        return view('app.invitations.create', compact('events', 'users', 'eventId'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(InvitationStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Invitation::class);

        $validated = $request->validated();

        $event = Event::where('id', $request->event_id)->first();
        $maxUsers = $event->max_users;
        // dd($maxUsers);

        if ($maxUsers !== null && $maxUsers >= 0) {

            $currentInvitations = Invitation::where('event_id', $request->event_id)->pluck('email');
            // dd($currentInvitations);
            $users = User::whereIn('email', $currentInvitations)->count();
            // dd($users);
            if ($users < $maxUsers) {

                $isEmailEvent = Invitation::where('email', $request->email)
                    ->where('event_id', $request->event_id)->first();

                if ($isEmailEvent) {
                    return back()->withError(__('This user has already invited for this event'));
                } else {

                    $invitation = Invitation::create($validated);
                    $event = Event::where('id', $invitation->event_id)->first();

                    // Mail
                    Mail::to($invitation->email)->send(new InvitationMail($event->gallery_name, $invitation->email, $event->invitaion_key));

                    return redirect()
                        ->route('invitations.edit', $invitation)
                        ->withSuccess(__('crud.common.created'));
                }

            } else {
                // Handling the case when the limit is exceeded
                return redirect()
                    ->route('invitations.index')
                    ->withError(__('Users limit exceeded for this event'));
            }


        } else {
            // Handling the case when the max_photos value is null or negative
            return redirect()
                ->route('invitations.index')
                ->withError(__('Invalid max_users value for this event'));
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Invitation $invitation): View
    {
        $this->authorize('view', $invitation);

        return view('app.invitations.show', compact('invitation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Invitation $invitation): View
    {
        $this->authorize('update', $invitation);

        $user = Auth::user();

        if ($user->hasRole(Role::findByName('organizer'))) {            
            $events = Event::where('organizer_id', $user->id)->get();
            return view('app.invitations.edit', compact('invitation', 'events'));
        }

        $events = Event::pluck('gallery_name', 'id');

        return view('app.invitations.edit', compact('invitation', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        InvitationUpdateRequest $request,
        Invitation $invitation
    ): RedirectResponse {
        $this->authorize('update', $invitation);

        $validated = $request->validated();

        $invitation->update($validated);

        return redirect()
            ->route('invitations.edit', $invitation)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Invitation $invitation
    ): RedirectResponse {
        $this->authorize('delete', $invitation);

        $invitation->delete();

        return redirect()
            ->route('invitations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
