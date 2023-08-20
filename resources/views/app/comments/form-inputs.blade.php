@php $editing = isset($comment) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.select name="photo_id" label="Photo" required>
            @php $selected = old('photo_id', ($editing ? $comment->photo_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Photo</option>
            @foreach($photos as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="comment"
            label="Comment"
            maxlength="255"
            required
            >{{ old('comment', ($editing ? $comment->comment : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
