<?php

namespace App\Http\Controllers\Api;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;

class PhotoCommentsController extends Controller
{
    public function index(Request $request, Photo $photo): CommentCollection
    {
        $this->authorize('view', $photo);

        $search = $request->get('search', '');

        $comments = $photo
            ->comments()
            ->search($search)
            ->latest()
            ->paginate();

        return new CommentCollection($comments);
    }

    public function store(Request $request, Photo $photo): CommentResource
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validate([
            'comment' => ['required', 'max:255', 'string'],
        ]);

        $comment = $photo->comments()->create($validated);

        return new CommentResource($comment);
    }
}
