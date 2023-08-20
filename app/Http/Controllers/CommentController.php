<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitation;
use App\Models\Photo;
use App\Models\Comment;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use Auth;
use Spatie\Permission\Models\Role;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Comment::class);

        $user = Auth::user();
        $search = $request->get('search', '');
        if ($user->hasRole(Role::findByName('organizer'))) {
            $invitation = Invitation::where('email', $user->email)->first();
            $events = Event::where('id', $invitation ? $invitation->event_id : '')->first();
            // dd($events);
            $photos = Photo::where('event_id', $events ? $events->id: '')->pluck('id');
            $comments = Comment::whereIn('photo_id', $photos)
                ->search($search)
                ->latest()
                ->paginate(5)
                ->withQueryString();

        } else {

            $comments = Comment::search($search)
                ->latest()
                ->paginate(5)
                ->withQueryString();
        }



        return view('app.comments.index', compact('comments', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Comment::class);

        $photos = Photo::pluck('photo', 'id');

        return view('app.comments.create', compact('photos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validated();

        $validated['user_id'] = auth()->user()->id; // Assign the current user's ID to the user_id column

        $comment = Comment::create($validated);

        return redirect()
            ->route('comments.index', $comment)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Comment $comment): View
    {
        $this->authorize('view', $comment);

        return view('app.comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Comment $comment): View
    {
        $this->authorize('update', $comment);

        $photos = Photo::pluck('photo', 'id');

        return view('app.comments.edit', compact('comment', 'photos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CommentUpdateRequest $request,
        Comment $comment
    ): RedirectResponse {
        $this->authorize('update', $comment);

        $validated = $request->validated();

        $comment->update($validated);

        return redirect()
            ->route('comments.edit', $comment)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Comment $comment
    ): RedirectResponse {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()
            ->route('comments.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function getComments(Request $request)
    {
        $this->authorize('view-any', Comment::class);
        $photoID = $request->input('photoID');

        // Retrieve the comments associated with the photo ID
        $comments = Comment::with('user')->where('photo_id', $photoID)->get();
        // You can further process or manipulate the comments and users as per your requirements

        return response()->json([
            'comments' => $comments,
        ]);
    }

}
