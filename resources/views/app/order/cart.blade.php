@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.cart.index_title')</h4>
            </div>
            @php
                $readyForCheckout = [];
            @endphp
            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.cart.input.photo')
                            </th>
                            <th class="text-left">
                                @lang('crud.cart.input.qty')
                            </th>
                            <th class="text-left">
                                @lang('crud.cart.input.print')
                            </th>
                            <th class="text-left">
                                @lang('crud.cart.input.price')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($cart))
                            @forelse($cart->cartItems as $item)                            
                            <tr>
                                <td>
                                    <x-partials.thumbnail
                                        src="{{ $item->photo->photo ? \Storage::url($item->photo->photo) : '' }}"
                                    />
                                </td>
                                <td>
                                    {{ $item->quantity }}
                                </td>
                                <td>
                                    <select name="print_option" style="width: 230px;padding: 8px 10px;border-radius: 5px;">
                                        <option value="">Select</option>
                                        @forelse($printOptions as $key => $option)
                                            @php
                                                $selected = $item->print_option === $option->id ? 'selected' : '';
                                            @endphp
                                            <option {{ $selected }} value={{ $option->id }} data-print-type="{{ $option->print_type }}" data-paper-type="{{ $option->paper_type }}" data-packaging="{{ $option->packaging }}" data-price="{{ $option->price }}">Option {{ $key + 1 }}</option>
                                        @empty
                                            <option value="">No Print Option</option>
                                        @endforelse
                                    </select>
                                    <div class="print_option">
                                        @if($item->print_option)                                            
                                            {{ $item->printOption->print_type }} | {{ $item->printOption->paper_type }} | {{ $item->printOption->packaging }}
                                        @else
                                            @php
                                                array_push($readyForCheckout, false);
                                            @endphp
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    $<span class="priceAmount">{{ $item->price }}</span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('order.updateCart', ['id' => $item->id]) }}" method="post">
                                        @csrf
                                        <input hidden name="print_option" value="{{ $item->print_option }}">
                                        <input hidden name="id" value="{{ $item->id }}">
                                        <input hidden name="quantity" value="{{ $item->quantity }}">
                                        <button type="submit" class="btn btn-light">
                                            Update Cart
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        @else
                            <tr>
                                <td colspan="3">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            {{-- <td colspan="3">{!! $cart->render() !!}</td> --}}
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @if(isset($cart))
        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">@lang('crud.cart.checkout_title')</h4>
                </div>          
                <x-form
                    method="Post"
                    action="{{ route('order.checkout') }}"
                    class="mt-4"
                    id="placeOrder"
                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                >
                    
                    @include('app.order.form-inputs')

                    <div class="isErrors" style="background: #ffdddd;border: 2px solid #ff6060;display: none;text-align: center;margin-top: 20px;padding: 10px 20px;"></div>
                    <div class="mt-4">                    
                        @if(!(in_array(false, $readyForCheckout)))
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="icon ion-md-save"></i>
                            @lang('crud.cart.input.submit')
                        </button>
                        @else
                            <p style="margin: 0;text-align: center;color: red;font-weight: 700;">@lang('crud.cart.no_print_option')</p>
                        @endif
                    </div>
                </x-form>  
            </div>
        </div>
    @endif
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    jQuery(function(){
        jQuery('select[name="print_option"]').change(function(){
            const printType = jQuery(this).find('option:selected').data('print-type');
            const paperType = jQuery(this).find('option:selected').data('paper-type');
            const packaging = jQuery(this).find('option:selected').data('packaging');
            const price = jQuery(this).find('option:selected').data('price');
            jQuery('input[name="print_option"]').val(jQuery(this).val());
            jQuery(this).parents('table').find('.priceAmount').text(price);
            jQuery(this).next('.print_option').html('');
            jQuery(this).next('.print_option').append(`${printType} | ${paperType} | ${packaging}`);
        })

        jQuery('#placeOrder').submit(function(e){
            e.preventDefault();
            Stripe.setPublishableKey(jQuery(this).data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('input[name="card_number"]').val(),
                cvc: $('input[name="cvc_number"]').val(),
                exp_month: $('input[name="expiry_month"]').val(),
                exp_year: $('input[name="expiry_year"]').val()
            }, stripeResponseHandler);
        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                jQuery('.isErrors').show();
                jQuery('.isErrors').html('');
                jQuery('.isErrors').append(`<p style="margin: 0;font-weight: 700;color: red;text-transform: capitalize;">${response.error.message}</p>`);
            } else {
                jQuery('.isErrors').hide();
                /* token contains id, last4, and card type */
                var token = response['id'];
                    
                jQuery('#placeOrder').append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                jQuery('#placeOrder').get(0).submit();
            }
        }
    });
    
</script>
@endsection
