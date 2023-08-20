@php $editing = isset($event) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="name" label="Name" value="{{ $user->name }}" maxlength="255" placeholder="Name" required>
        </x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.email name="email" label="Email" value="{{ $user->email }}" placeholder="Email" disabled>
        </x-inputs.email>
    </x-inputs.group>
    <x-inputs.hidden name="email" value="{{ $user->email }}" placeholder="Email">
    </x-inputs.hidden>

    <x-inputs.group class="col-sm-12">
        <x-inputs.password type="password" name="new_password" label="New Password">
        </x-inputs.password>
    </x-inputs.group>
    <x-inputs.group class="col-sm-12">
        <x-inputs.password type="password" name="confirm_password" label="Confirm Password">
        </x-inputs.password>
    </x-inputs.group>
    <x-inputs.hidden name="password" value="{{ $user->password }}">
    </x-inputs.hidden>

    {{-- @if (Route::has('password.request'))
        <a class="btn btn-link" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
        </a>
    @endif --}}

</div>
