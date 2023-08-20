<div class="row">
    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="first_name" label="First Name" :value="old('first_name')" maxlength="255" placeholder="First Name"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="last_name" label="Last Name" :value="old('last_name')" maxlength="255" placeholder="Last Name"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="email" label="Email Address" :value="old('email')" maxlength="255" placeholder="Email Adress"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="phone" label="Phone Number" :value="old('phone')" maxlength="255" placeholder="Phone Number"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="postal_code" label="Postal Code" :value="old('postal_code')" maxlength="255" placeholder="Postal Code"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="city" label="City" :value="old('city')" maxlength="255" placeholder="City"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-6">
        <x-inputs.text name="country" label="Country" :value="old('country')" maxlength="255" placeholder="Country"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-6">
        <x-inputs.text name="address" label="Street Address" :value="old('address')" maxlength="255" placeholder="Street # and Name"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox name="isBilling" value="1" label="Billing Adress is different" :value="old('isBilling')"
            ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.select name="shipping_id" label="Shipping" required>
            @php $selected = old('shipping_id') @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the shipping</option>
            @foreach($shippings as $shipping)
            <option value="{{ $shipping->id }}" {{ $selected == $shipping->id ? 'selected' : '' }} >{{ $shipping->name }} - ${{ $shipping->price }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>

<div class="row" style="display: none" id="billingForm">
    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="billing_first_name" label="First Name" :value="old('billing_first_name')" maxlength="255" placeholder="First Name"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="billing_last_name" label="Last Name" :value="old('billing_last_name')" maxlength="255" placeholder="Last Name"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="billing_email" label="Email Address" :value="old('billing_email')" maxlength="255" placeholder="Email Adress"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="billing_phone" label="Phone Number" :value="old('billing_phone')" maxlength="255" placeholder="Phone Number"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="billing_postal_code" label="Postal Code" :value="old('billing_postal_code')" maxlength="255" placeholder="Postal Code"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="billing_city" label="City" :value="old('billing_city')" maxlength="255" placeholder="City"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-6">
        <x-inputs.text name="billing_country" label="Country" :value="old('billing_country')" maxlength="255" placeholder="Country"
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-6">
        <x-inputs.text name="billing_address" label="Street Address" :value="old('billing_address')" maxlength="255" placeholder="Street # and Name"
            ></x-inputs.text>
    </x-inputs.group>

</div>

<div class="row">
    <x-inputs.group class="col-sm-4">
        <x-inputs.text name="card_number" label="Card Number" :value="old('card_number')" maxlength="255" placeholder="Card Number"
            ></x-inputs.text>
    </x-inputs.group>
    <x-inputs.group class="col-sm-2">
        <x-inputs.password name="cvc_number" label="CVC" :value="old('cvc_number')" maxlength="3" placeholder="***"
            ></x-inputs.password>
    </x-inputs.group>
    <x-inputs.group class="col-sm-3">
        <x-inputs.text name="expiry_month" label="Month" :value="old('expiry_month')" maxlength="2" placeholder="Expiry Month"
            ></x-inputs.text>
    </x-inputs.group>
    <x-inputs.group class="col-sm-3">
        <x-inputs.text name="expiry_year" label="Year" :value="old('expiry_year')" maxlength="4" placeholder="Expiry Year"
            ></x-inputs.text>
    </x-inputs.group>
</div>

<script>
    jQuery(function(){
        jQuery('input[name="isBilling"]').change(function(){
            if(jQuery(this).prop('checked')){
                jQuery('#billingForm').show();
            } else {
                jQuery('#billingForm').hide();
            }
        })
    })
</script>