<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrintOptionRequest;
use App\Models\PrintOption;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrintOptionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', PrintOption::class);

        $user = Auth::user();

        $print_options = PrintOption::all();

        return view('app.print_option.index', compact('print_options'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', PrintOption::class);

        return view('app.print_option.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrintOptionRequest $request): RedirectResponse
    {
        $this->authorize('create', PrintOption::class);

        $validated = $request->validated();
        $option = PrintOption::create($validated);
        
        return redirect()
            ->route('print-option.edit', $option)
            ->withSuccess(__('crud.common.created'));
    }

    public function show(Request $request, $id): View
    {
        $option = PrintOption::where('id', $id)->first();

        $this->authorize('view', $option);

        return view('app.print_option.show', compact('option'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id): View
    {
        $option = PrintOption::where('id', $id)->first();

        $this->authorize('update', $option);

        return view('app.print_option.edit', compact('option'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PrintOptionRequest $request,
        $id
    ): RedirectResponse {

        $option = PrintOption::where('id', $id)->first();

        $validated = $request->validated();

        $option->update($validated);

        return redirect()
            ->route('print-option.edit', $option)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        $id
    ): RedirectResponse {

        $option = PrintOption::where('id', $id)->first();
        $this->authorize('delete', $option);

        $option->delete();

        return redirect()
            ->route('print-option.index')
            ->withSuccess(__('crud.common.removed'));
    }

}
