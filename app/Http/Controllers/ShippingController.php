<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingRequest;
use App\Models\Shipping;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Shipping::class);

        $user = Auth::user();

        $shippings = Shipping::all();

        return view('app.shipping.index', compact('shippings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Shipping::class);

        return view('app.shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingRequest $request): RedirectResponse
    {
        $this->authorize('create', Shipping::class);

        $validated = $request->validated();
        $shipping = Shipping::create($validated);
        
        return redirect()
            ->route('shipping.edit', $shipping)
            ->withSuccess(__('crud.common.created'));
    }

    public function show(Request $request, $id): View
    {
        $shipping = Shipping::where('id', $id)->first();

        $this->authorize('view', $shipping);

        return view('app.shipping.show', compact('shipping'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id): View
    {
        $shipping = Shipping::where('id', $id)->first();

        $this->authorize('update', $shipping);

        return view('app.shipping.edit', compact('shipping'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ShippingRequest $request,
        $id
    ): RedirectResponse {

        $shipping = Shipping::where('id', $id)->first();

        $validated = $request->validated();

        $shipping->update($validated);

        return redirect()
            ->route('shipping.edit', $shipping)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        $id
    ): RedirectResponse {

        $shipping = Shipping::where('id', $id)->first();
        $this->authorize('delete', $shipping);

        $shipping->delete();

        return redirect()
            ->route('shipping.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
