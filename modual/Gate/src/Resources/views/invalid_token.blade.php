@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">invalid token page</div>
                    <div class="card-body">

                        <div class="card-body">
                            <h1 class="card-title">{{isset($mess) ? $mess: "your payment is failed"}}</h1>
                        </div>

                    </div>
                </div>
            </div>

        </div>


    </div>
    <style>

        h1 {
            color: red;
            font-weight: 900;
        }

    </style>

@endsection


