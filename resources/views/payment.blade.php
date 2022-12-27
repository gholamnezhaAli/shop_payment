@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">payment page</div>
                    <div>{{$leftTime}}</div>
                    <div>{{$productId}}</div>
                    <div class="card-body">


                        <form method="POST" action="{{ route('payment') }}">

                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-12" style="text-align: center" id="errors_show">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">card number</label>

                                <div class="col-md-6">
                                    <input id="card_number"
                                           type="text"
                                           class="form-control @error('card_number') is-invalid @enderror"
                                           name="card_number" value="{{ old('card_number') }}"
                                           required autocomplete="card_number"
                                           autofocus>

                                    @error('card_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">cvv2</label>

                                <div class="col-md-6">
                                    <input
                                        value="{{old('cvv2')}}"
                                        id="cvv2"
                                        type="text"
                                        class="form-control @error('cvv2') is-invalid @enderror"
                                        name="cvv2"
                                        required>

                                    @error('cvv2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">expire time</label>
                                <div class="col-md-6">


                                    <input
                                        value="{{old('expireTime')}}"
                                        id="expireTime"
                                        type="date"
                                        value=""
                                        class="form-control @error('expireTime') is-invalid @enderror"
                                        name="expireTime"
                                        required>
                                    @error('expireTime')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input
                                        id="productId"
                                        type="hidden"
                                        class="form-control @error('productId') is-invalid @enderror"
                                        name="productId"
                                        value="{{$productId}}"
                                        required>
                                    @error('productId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">expire time</label>
                                <div class="col-md-6">

                                    @if(session()->has('message'))
                                        <h1>aaaaaaaaaaa</h1>
                                        <span class="invalid-feedback" role="alert">
                                              <strong>{{ session()->get('message') }}</strong>
                                         </span>
                                    @endif
                                </div>
                            </div>


                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    {{--                                    <button type="submit" class="btn btn-primary">
                                                                            buy
                                                                        </button>--}}

                                    <a onclick="payment(event,'{{route('payment')}}')" class="btn btn-primary">
                                        buy
                                    </a>


                                </div>
                            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function payment(event, route) {
            event.preventDefault();
            var card_number = $('#card_number').val();
            var cvv2 = $('#cvv2').val();
            var expireTime = $('#expireTime').val();
            let data = {card_number: card_number, cvv2: cvv2, expireTime: expireTime};
            $.post(route, {_method: 'POST', _token: $('meta[name="csrf-token"]').attr('content'), data: data})
                .done(function (response) {
                    console.log("donedddd", response.errors)
                })
                .fail(function (response) {

                    var errors = response.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        var div = "<div> " + value + "</div>"
                        $("#errors_show").append(div)
                    });
                })
                .always(function () {

                    }
                );
        }
    </script>

    <style>
        #errors_show div {
            color: red;

        }

    </style>

@endsection


