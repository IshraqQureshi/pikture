@php $editing = isset($invitation) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.email name="email" label="Email" :value="old('email', $editing ? $invitation->email : '')" maxlength="255" placeholder="Email" required>
        </x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.select name="event_id" label="Event" required>
            @php $selected = old('event_id', ($editing ? $invitation->event_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Event</option>
            @if (isset($events))
                @foreach ($events as $value => $label)
                <option value="{{ $label->id }}" {{ $selected == $label->id ? 'selected' : '' }}>{{ $label->gallery_name }}
                </option>
                @endforeach
            @else
                @foreach ($organizerEvents as $value => $label)
                    <option value="{{ $label->id }}" {{ $selected == $label->id ? 'selected' : '' }}>{{ $label->gallery_name }}
                    </option>
                @endforeach
            @endif

        </x-inputs.select>
    </x-inputs.group>
</div>
