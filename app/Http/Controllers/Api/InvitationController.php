<?php

namespace App\Http\Controllers\Api;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvitationResource;
use App\Http\Resources\InvitationCollection;
use App\Http\Requests\InvitationStoreRequest;
use App\Http\Requests\InvitationUpdateRequest;

class InvitationController extends Controller
{
    public function index(Request $request): InvitationCollection
    {
        $this->authorize('view-any', Invitation::class);

        $search = $request->get('search', '');

        $invitations = Invitation::search($search)
            ->latest()
            ->paginate();

        return new InvitationCollection($invitations);
    }

    public function store(InvitationStoreRequest $request): InvitationResource
    {
        $this->authorize('create', Invitation::class);

        $validated = $request->validated();

        $invitation = Invitation::create($validated);

        return new InvitationResource($invitation);
    }

    public function show(
        Request $request,
        Invitation $invitation
    ): InvitationResource {
        $this->authorize('view', $invitation);

        return new InvitationResource($invitation);
    }

    public function update(
        InvitationUpdateRequest $request,
        Invitation $invitation
    ): InvitationResource {
        $this->authorize('update', $invitation);

        $validated = $request->validated();

        $invitation->update($validated);

        return new InvitationResource($invitation);
    }

    public function destroy(Request $request, Invitation $invitation): Response
    {
        $this->authorize('delete', $invitation);

        $invitation->delete();

        return response()->noContent();
    }
}
