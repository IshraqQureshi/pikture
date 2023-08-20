@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('events.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.events.show_title')
                </h4>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>@lang('crud.events.inputs.gallery_name')</h5>
                        <span>{{ $event->gallery_name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.events.inputs.max_photos')</h5>
                        <span>{{ $event->max_photos ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.events.inputs.max_users')</h5>
                        <span>{{ $event->max_users ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.events.inputs.expiration_date')</h5>
                        <span>{{ $event->expiration_date ?? '-' }}</span>
                    </div>
                    @if (auth()->check() &&
                            auth()->user()->hasRole('user|super-admin'))
                        <div class="mb-4">
                            <h5>@lang('crud.events.inputs.user_id')</h5>
                            <span>{{ optional($event->user)->name ?? '-' }}</span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between">
                        @if (auth()->check() &&
                                auth()->user()->hasRole('user|super-admin'))
                            <div class="mb-4">
                                <h5>@lang('Endpoint')</h5>
                                <span id="urlSpan">{{ url('/api/events/' . $event->id . '/photos') }}</span>
                            </div>
                        @endif

                        <div class="copy-btn">
                            <button class="btn btn-primary" onclick="copyUrl()">Copy</button>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('events.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Event::class)
                        <a href="{{ route('events.create') }}" class="btn btn-light">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function copyUrl() {
            var urlSpan = document.getElementById("urlSpan");
            var url = urlSpan.innerText;

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
