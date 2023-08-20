@extends('layouts.app')

<style>
    .card-counter {
        box-shadow: 2px 2px 10px #DADADA;
        margin: 5px;
        padding: 20px 10px;
        background-color: #fff;
        height: 100px;
        border-radius: 5px;
        transition: .3s linear all;
    }

    .card-counter:hover {
        box-shadow: 4px 4px 20px #DADADA;
        transition: .3s linear all;
    }

    .card-counter.primary {
        /* background-color: #007bff; */
        color: #FFF;
    }

    .card-counter.danger {
        /* background-color: #ef5350;
        color: #FFF; */
    }

    .card-counter.success {
        /* background-color: #66bb6a;
        color: #FFF; */
    }

    .card-counter.info {
        /* background-color: #26c6da; */
        /* color: #FFF; */
    }

    .card-counter i {
        font-size: 5em;
        opacity: 0.2;
    }

    .card-counter .count-numbers {
        font-size: 32px;
        display: block;
    }

    .card-counter .count-name {
        /* font-style: italic; */
        text-transform: capitalize;
        opacity: 0.5;
        display: block;
        font-size: 18px;
        font-weight: bold
    }
</style>
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="background-color: #f4f6f9 !important ; box-shadow: none">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card-counter d-flex justify-content-between align-items-center">
                                    {{-- <i class="icon ion-ios-people"></i> --}}
                                    <div class="count-name">Users</div>
                                    <div class="count-numbers">{{ $users }}</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card-counter d-flex justify-content-between align-items-center">
                                    {{-- <i class="icon ion-ios-timer"></i> --}}
                                    <span class="count-name">Invitations</span>
                                    <span class="count-numbers">{{ $invitations }}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card-counter d-flex justify-content-between align-items-center">
                                    {{-- <i class="icon ion-ios-analytics"></i> --}}
                                    <span class="count-name">Events</span>
                                    <span class="count-numbers">{{ $events }}</span>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
