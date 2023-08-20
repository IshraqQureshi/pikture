@php $editing = isset($event) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="host" value="{{ $smtpConfiguration->host ? $smtpConfiguration->host : '' }}" label="Host"
            placeholder="Host" required></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number name="port" value="{{ $smtpConfiguration->port ? $smtpConfiguration->port : '' }}"
            label="Port" placeholder="Port">
        </x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="username" value="{{ $smtpConfiguration->username ? $smtpConfiguration->username : '' }}"
            label="Username" placeholder="Username">
        </x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.password name="password"
            value="{{ $smtpConfiguration->password ? $smtpConfiguration->password : '' }}" label="Password"
            max="255" placeholder="Password" required>
        </x-inputs.password>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="encryption"
            value="{{ $smtpConfiguration->encryption ? $smtpConfiguration->encryption : '' }}" label="Encryption">
        </x-inputs.text>
    </x-inputs.group>

    {{-- <x-inputs.group class="col-sm-12">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $event->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach ($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group> --}}
    <x-inputs.group class="col-sm-12">
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
    </x-inputs.group>

</div>
