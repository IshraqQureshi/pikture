@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="input-group">
                            <input id="indexSearch" type="text" name="search" placeholder="{{ __('crud.common.search') }}"
                                value="{{ $search ?? '' }}" class="form-control" autocomplete="off" />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary ml-1">
                                    <i class="icon ion-md-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    @can('create', App\Models\Event::class)
                        <a href="{{ route('events.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">@lang('crud.events.index_title')</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th>
                                    @lang('crud.events.inputs.gallery_name')
                                </th>
                                <th>
                                    @lang('crud.events.inputs.max_photos')
                                </th>
                                <th>
                                    @lang('crud.events.inputs.max_users')
                                </th>
                                <th>
                                    @lang('crud.events.inputs.expiration_date')
                                </th>
                                @if (auth()->check() &&
                                        auth()->user()->hasRole('user|super-admin'))
                                    <th>
                                        @lang('Created By')
                                    </th>
                                    <th>
                                        @lang('Endpoint')
                                    </th>
                                @endif
                                <th>
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                                <tr>
                                    <td>{{ $event->gallery_name ?? '-' }}</td>
                                    <td>{{ $event->photos_count ?? '-' }}/{{ $event->max_photos ?? '-' }}</td>
                                    <td>
                                        {{ $event->userCount ?? '-' }} / {{ $event->max_users ?? '-' }}
                                    </td>
                                    <td>{{ $event->expiration_date ?? '-' }}</td>
                                    @if (auth()->check() &&
                                            auth()->user()->hasRole('user|super-admin'))
                                        <td>{{ optional($event->user)->name ?? '-' }}</td>
                                        <td><a
                                                href="{{ url('/api/events/' . $event->id . '/photos') }}"onclick="copyUrl(event)">Copy
                                                Link</a>
                                        </td>
                                    @endif


                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $event)
                                                <a href="{{ route('events.edit', $event) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-create"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('view', $event)
                                                <a href="{{ route('events.show', $event) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-eye"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $event)
                                                <form action="{{ route('events.destroy', $event) }}" method="POST"
                                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-light text-danger">
                                                        <i class="icon ion-md-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">{!! $events->render() !!}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function copyUrl(event) {
            event.preventDefault();
            var url = event.target.href;
            navigator.clipboard.writeText(url)
                .then(function() {
                    toastr.success("URL copied to clipboard!");
                })
                .catch(function(error) {
                    console.error("Unable to copy URL: ", error);
                });
        }
    </script>
@endsection
