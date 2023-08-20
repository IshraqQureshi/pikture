@extends('layouts.app')

@section('content')
    <style>
        .vertical-divider {
            border-right: 1px solid #ccc;
        }
    </style>
    <div class="container">

        @auth
            @role('super-admin')
                {{-- Full content for super-admin --}}
                <div class="card postion-relative">
                    <div class="row">
                        <div class="col-md-6 vertical-divider">
                            <div class="card-body">
                                <h4 class="card-title text-center w-100" style="font-weight: 600">
                                    <a href="{{ route('events.index') }}">
                                        {{-- <i class="icon ion-md-arrow-back"></i> --}}
                                    </a>
                                    @lang('Profile Setting')
                                </h4>

                                <x-form method="POST" action="{{ route('profile.update') }}" class="mt-5 py-3">
                                    @include('app.profile.form-inputs')

                                    <div class="mt-4">
                                        {{-- <a href="{{ route('events.index') }}" class="btn btn-light">
                                <i class="icon ion-md-return-left text-primary"></i>
                                @lang('crud.common.back')
                            </a> --}}

                                        <button type="submit" class="btn btn-primary float-right"
                                            style="position: absolute;bottom: 20px;right: 20px;">
                                            <i class="icon ion-md-save"></i>
                                            @lang('crud.common.update')
                                        </button>
                                    </div>
                                </x-form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h4 class="card-title text-center w-100" style="font-weight: 600">
                                    <a href="{{ route('events.index') }}">
                                        {{-- <i class="icon ion-md-arrow-back"></i> --}}
                                    </a>
                                    @lang('Plateform Setting')
                                </h4>

                                <x-form method="POST" action="{{ route('setting.update') }}" class="mt-5 py-3"
                                    enctype="multipart/form-data">
                                    @php $editing = isset($event) @endphp

                                    <div class="row">
                                        <x-inputs.group class="col-sm-12">
                                            <div x-data="imageViewer('{{ $settings->logo ? \Storage::url($settings->logo) : '' }}')">
                                                <x-inputs.partials.label name="logo" label="Logo (Recommended Size: 250px56px)">
                                                </x-inputs.partials.label>
                                                <br />

                                                <!-- Show the image -->
                                                <template x-if="imageUrl">
                                                    <img :src="imageUrl" class="object-cover rounded border border-gray-200"
                                                        style="width: 100px; height: 100px;" />
                                                </template>

                                                <!-- Show the gray box when image is not available -->
                                                <template x-if="!imageUrl">
                                                    <div class="border rounded border-gray-200 bg-gray-100"
                                                        style="width: 100px; height: 100px;"></div>
                                                </template>

                                                <div class="mt-2">
                                                    <input type="file" name="logo" id="logo" @change="fileChosen" />
                                                </div>

                                                @error('photo')
                                                    @include('components.inputs.partials.error')
                                                @enderror
                                            </div>
                                        </x-inputs.group>
                                        <x-inputs.group class="col-sm-12">
                                            <div x-data="imageViewer('{{ $settings->fav_icon ? \Storage::url($settings->fav_icon) : '' }}')">
                                                <x-inputs.partials.label name="fav_icon" label="Fav Icon"></x-inputs.partials.label>
                                                <br />

                                                <!-- Show the image -->
                                                <template x-if="imageUrl">
                                                    <img :src="imageUrl" class="object-cover rounded border border-gray-200"
                                                        style="width: 100px; height: 100px;" />
                                                </template>

                                                <!-- Show the gray box when image is not available -->
                                                <template x-if="!imageUrl">
                                                    <div class="border rounded border-gray-200 bg-gray-100"
                                                        style="width: 100px; height: 100px;"></div>
                                                </template>

                                                <div class="mt-2">
                                                    <input type="file" name="fav_icon" id="fav_icon" @change="fileChosen" />
                                                </div>

                                                @error('photo')
                                                    @include('components.inputs.partials.error')
                                                @enderror
                                            </div>
                                        </x-inputs.group>
                                    </div>

                                    <div class="mt-4">
                                        {{-- <a href="{{ route('events.index') }}" class="btn btn-light">
                                <i class="icon ion-md-return-left text-primary"></i>
                                @lang('crud.common.back')
                            </a> --}}

                                        <button type="submit" class="btn btn-primary float-right">
                                            <i class="icon ion-md-save"></i>
                                            @lang('crud.common.update')
                                        </button>
                                    </div>
                                </x-form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Content for user/organizer with profile setting portion in full screen --}}
                <div class="card postion-relative">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <h4 class="card-title text-center w-100" style="font-weight: 600">
                                    <a href="{{ route('events.index') }}">
                                        {{-- <i class="icon ion-md-arrow-back"></i> --}}
                                    </a>
                                    @lang('Profile Setting')
                                </h4>

                                <x-form method="POST" action="{{ route('profile.update') }}" class="mt-5 py-3">
                                    @include('app.profile.form-inputs')

                                    <div class="mt-4">
                                        {{-- <a href="{{ route('events.index') }}" class="btn btn-light">
                                <i class="icon ion-md-return-left text-primary"></i>
                                @lang('crud.common.back')
                            </a> --}}

                                        <button type="submit" class="btn btn-primary float-right"
                                            style="position: absolute;bottom: 20px;right: 20px;">
                                            <i class="icon ion-md-save"></i>
                                            @lang('crud.common.update')
                                        </button>
                                    </div>
                                </x-form>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole
        @endauth

    </div>
@endsection
