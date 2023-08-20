@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('print-option.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.print_option.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.print_option.inputs.print_type')</h5>
                    <span>{{ $option->print_type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.print_option.inputs.paper_type')</h5>
                    <span>{{ $option->paper_type ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.print_option.inputs.packaging')</h5>
                    <span>{{ $option->packaging ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.print_option.inputs.price')</h5>
                    <span>${{ $option->price ?? '-' }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('shipping.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\PrintOption::class)
                <a
                    href="{{ route('print-option.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
