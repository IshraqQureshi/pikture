@php $editing = isset($option) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text name="print_type" label="Print Type" :value="old('print_type', $editing ? $option->print_type : '')" maxlength="255" placeholder="Print Type" required>
        </x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text name="paper_type" label="Paper Type" :value="old('paper_type', $editing ? $option->paper_type : '')" maxlength="255" placeholder="Paper Type" required>
        </x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text name="packaging" label="Packaging" :value="old('packaging', $editing ? $option->packaging : '')" maxlength="255" placeholder="Packaging" required>
        </x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text name="price" label="Price" :value="old('price', $editing ? $option->price : '')" maxlength="255" placeholder="Price" required>
        </x-inputs.text>
    </x-inputs.group>
</div>