@extends('layouts.app')

@section('content')
<style>
    .row{
        margin-bottom: 20px
    }
</style>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">@lang('crud.order.index_title')</h4>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <strong>@lang('crud.order.inputs.name')</strong>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        {{ $order->first_name }} {{ isset($order->last_name) ? $order->last_name : '' }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <strong>@lang('crud.order.inputs.email')</strong>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        {{ $order->email }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <strong>@lang('crud.order.inputs.phone')</strong>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        {{ $order->phone }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <strong>@lang('crud.order.inputs.postal_code')</strong>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        {{ $order->postal_code }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <strong>@lang('crud.order.inputs.address')</strong>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        {{ $order->address }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <strong>@lang('crud.order.inputs.country')</strong>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        {{ $order->country }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <strong>@lang('crud.order.inputs.city')</strong>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        {{ $order->city }}
                    </div>
                </div>
                @if($order->has_billing)
                    <div style="display: flex; justify-content: space-between;">
                        <h4 class="card-title">@lang('crud.order.input.billing')</h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <strong>@lang('crud.order.inputs.name')</strong>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            {{ $order->billing_first_name }} {{ isset($order->billing_last_name) ? $order->billing_last_name : '' }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <strong>@lang('crud.order.inputs.email')</strong>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            {{ $order->billing_email }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <strong>@lang('crud.order.inputs.phone')</strong>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            {{ $order->billing_phone }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <strong>@lang('crud.order.inputs.postal_code')</strong>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            {{ $order->billing_postal_code }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <strong>@lang('crud.order.inputs.address')</strong>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            {{ $order->billing_address }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <strong>@lang('crud.order.inputs.country')</strong>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            {{ $order->billing_country }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <strong>@lang('crud.order.inputs.city')</strong>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            {{ $order->billing_city }}
                        </div>
                    </div>
                @endif 
                <hr>
                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th>
                                    @lang('crud.order.item.photo')
                                </th>
                                <th>
                                    @lang('crud.order.item.print_option')
                                </th>
                                <th>
                                    @lang('crud.order.item.price')
                                </th>
                                <th>
                                    @lang('crud.order.item.quantity')
                                </th>
                                <th>
                                    @lang('crud.order.item.total_price')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <x-partials.thumbnail
                                            src="{{ $item->photo->photo ? \Storage::url($item->photo->photo) : '' }}"
                                        />
                                    </td>
                                    <td>
                                        {{ $item->printOption->print_type }} | {{ $item->printOption->paper_type }} | {{ $item->printOption->packaging }}
                                    </td>
                                    <td>
                                        ${{ $item->price }}
                                    </td>
                                    <td>
                                        {{ $item->quantity }}
                                    </td>
                                    <td>
                                        ${{ number_format((float)$item->quantity * $item->price, 2, '.', '') }}
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

                    </table>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <strong>@lang('crud.order.inputs.sub_total')</strong>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        ${{ $order->total_price - $order->shipping_price }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <strong>@lang('crud.order.inputs.shipping')</strong>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        {{ $order->shipping->name }} - ${{ $order->shipping_price }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <strong>@lang('crud.order.inputs.total_price')</strong>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        ${{ $order->total_price }}
                    </div>
                </div>   
                <div class="row">
                    <a href="{{ route('order.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>
                </div>            
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>    
@endsection
