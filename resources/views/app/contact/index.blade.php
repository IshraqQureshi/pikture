@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('comments.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.contact.create_title')
            </h4>

            <x-form
                method="POST"
                action="{{ route('contact.submit') }}"
                class="mt-4"
            >
                @include('app.contact.form-inputs')

                <div class="mt-4">                    
                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.contact.action')
                    </button>
                </div>
            </x-form>
        </div>
    </div>
</div>
@endsection
