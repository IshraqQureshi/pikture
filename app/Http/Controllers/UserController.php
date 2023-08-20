<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitation;
use App\Models\Setting;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Auth;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index(Request $request): View
    {
        $this->authorize('view-any', User::class);

        $user = Auth::user();
        $eventId = $request->get('event_id', '');
        $status = $request->get('status', '');
        $events = []; // Define an empty array for non-organizer case
        $organizerEvents = []; // Define an empty array for non-organizer case

        if ($user->hasRole(Role::findByName('organizer'))) {
            $invitation = Invitation::where('email', $user->email)->first();
            if ($invitation) {
                $organizerEvents = Event::where('id', $invitation->event_id)->get();
                $invitedUser = Invitation::where('event_id', $invitation->event_id)->pluck('email');
                $users = User::whereIn('email', $invitedUser);
                $eventId = $invitation->event_id;
            } else {
                $users = User::whereNull('id');
                $eventId = null;
            }
        } else {
            $users = User::query();
            $events = Event::pluck('gallery_name', 'id');
        }

        $search = $request->get('search', '');

        // Apply the search query
        if ($search) {
            $users->where(function (Builder $query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        // Filter by event
        if ($eventId) {
            $invitationEmails = Invitation::where('event_id', $eventId)->pluck('email')->all();
            $users->whereIn('email', $invitationEmails);
        }

        // Filter by status
        // ...

        $users = $users->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.users.index', compact('users', 'search', 'events', 'organizerEvents'));
    }



    // public function usersByEvenet(Request $request)
    // {
    //     $eventId = $request->input('event_id');
    //     $userId = Event::where('id', $eventId)->pluck('user_id');
    //     $users = User::whereIn('id', $userId)->get();

    //     return response()->json([
    //         'users' => $users
    //     ]);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', User::class);

        $roles = Role::get();

        return view('app.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user): View
    {
        $this->authorize('view', $user);

        return view('app.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user): View
    {
        $this->authorize('update', $user);

        $roles = Role::get();

        return view('app.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UserUpdateRequest $request,
        User $user
    ): RedirectResponse {
        $this->authorize('update', $user);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function profile(){
        $settings = Setting::findOrFail(1);
        $user = Auth::user();
        // dd($user->name);
        return view('app.profile.profile', compact('user', 'settings'));
    }

    public function profileUpdate(Request $request){
        
        if($request->new_password){
            $request->validate([
                'confirm_password'  => ['required', 'same:new_password'],
            ]);            
        }


        $settings = Setting::all();
        $authUser = Auth::user();
        $user = User::where('id', $authUser->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =$request->password;
        
        if($request->new_password) {
            $user->password =Hash::make($request->new_password);
        }

        $user->update();

        return redirect()
            ->back()
            ->withSuccess(__('crud.common.update'));
    }
}
