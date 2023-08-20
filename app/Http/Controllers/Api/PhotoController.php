<?php

namespace App\Http\Controllers\Api;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\PhotoCollection;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PhotoStoreRequest;
use App\Http\Requests\PhotoUpdateRequest;

class PhotoController extends Controller
{
    public function index(Request $request): PhotoCollection
    {
        $this->authorize('view-any', Photo::class);

        $search = $request->get('search', '');

        $photos = Photo::search($search)
            ->latest()
            ->paginate();

        return new PhotoCollection($photos);
    }

    public function store(PhotoStoreRequest $request): PhotoResource
    {
        $this->authorize('create', Photo::class);

        $validated = $request->validated();
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $photo = Photo::create($validated);

        return new PhotoResource($photo);
    }

    public function show(Request $request, Photo $photo): PhotoResource
    {
        $this->authorize('view', $photo);

        return new PhotoResource($photo);
    }

    public function update(
        PhotoUpdateRequest $request,
        Photo $photo
    ): PhotoResource {
        $this->authorize('update', $photo);

        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            if ($photo->photo) {
                Storage::delete($photo->photo);
            }

            $validated['photo'] = $request->file('photo')->store('public');
        }

        $photo->update($validated);

        return new PhotoResource($photo);
    }

    public function destroy(Request $request, Photo $photo): Response
    {
        $this->authorize('delete', $photo);

        if ($photo->photo) {
            Storage::delete($photo->photo);
        }

        $photo->delete();

        return response()->noContent();
    }
}
