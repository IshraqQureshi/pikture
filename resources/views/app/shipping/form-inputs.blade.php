@php $editing = isset($shipping) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text name="name" label="Shipping Name" :value="old('name', $editing ? $shipping->name : '')" maxlength="255" placeholder="Shipping Name" required>
        </x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text name="price" label="Price" :value="old('price', $editing ? $shipping->price : '')" maxlength="255" placeholder="Price" required>
        </x-inputs.text>
    </x-inputs.group>    
</div>