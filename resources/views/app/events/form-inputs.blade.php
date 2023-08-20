@php $editing = isset($event) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="gallery_name" label="Gallery Name" :value="old('gallery_name', $editing ? $event->gallery_name : '')" maxlength="255" placeholder="Gallery Name"
            required></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="organizer_name" label="Organizer Name" :value="old('organizer_name', $editing ? $user->name : '')" maxlength="255" placeholder="Organizer Name"
            required></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        @if (Route::currentRouteName() === 'events.edit')
            <x-inputs.email name="email" label="Organizer Email" :value="old('email', $editing ? $user->email : '')" placeholder="Email" required disabled>
            </x-inputs.email>
        @else
            <x-inputs.email name="email" label="Organizer Email" :value="old('email', $editing ? $user->email : '')" placeholder="Email" required>
            </x-inputs.email>
        @endif
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number name="max_photos" label="Max Photos" :value="old('max_photos', $editing ? $event->max_photos : '')" max="255" placeholder="Max Photos">
        </x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number name="max_users" label="Max Users" :value="old('max_users', $editing ? $event->max_users : '')" max="255" placeholder="Max Users"
            required></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date name="expiration_date" label="Expiration Date"
            value="{{ old('expiration_date', $editing ? optional($event->expiration_date)->format('Y-m-d') : '') }}"
            max="255"></x-inputs.date>
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
