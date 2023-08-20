<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.text name="full_name" label="Full Name" :value="old('full_name')" maxlength="255" placeholder="Full Name" required>
        </x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.email name="email" label="Email" :value="old('email')" maxlength="255" placeholder="Email" required>
        </x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="message"
            label="Message"
            maxlength="255"
            required
            >{{ old('message')
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
