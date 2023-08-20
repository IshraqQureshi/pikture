<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvitationResource;
use App\Http\Resources\InvitationCollection;

class EventInvitationsController extends Controller
{
    public function index(Request $request, Event $event): InvitationCollection
    {
        $this->authorize('view', $event);

        $search = $request->get('search', '');

        $invitations = $event
            ->invitations()
            ->search($search)
            ->latest()
            ->paginate();

        return new InvitationCollection($invitations);
    }

    public function store(Request $request, Event $event): InvitationResource
    {
        $this->authorize('create', Invitation::class);

        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $invitation = $event->invitations()->create($validated);

        return new InvitationResource($invitation);
    }
}
