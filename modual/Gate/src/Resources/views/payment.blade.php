@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">payment page</div>
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
                                <div class="col-md-6">
                                    <input
                                        id="userId"
                                        type="hidden"
                                        class="form-control @error('userId') is-invalid @enderror"
                                        name="userId"
                                        value="{{$userId}}"
                                        required>
                                    @error('userId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">

                                    <a onclick="payment(event,'{{route('payment')}}')" class="btn btn-primary">
                                        buy
                                    </a>


                                </div>
                            </div>

                            <div class="box">left time <span id="time">{{\Gate\Models\Payment::getMinute()}}:00</span></div>


                        </form>
                    </div>
                </div>
            </div>

        </div>


    </div>
    <script>
        function payment(event, route) {
            event.preventDefault();
            $("#errors_show div").remove();
            var card_number = $('#card_number').val();
            var cvv2 = $('#cvv2').val();
            var expireTime = $('#expireTime').val();
            var userId = $('#userId').val();
            var productId = $('#productId').val();
            $.post(route, {
                _method: 'POST',
                _token: $('meta[name="csrf-token"]').attr('content'),
                card_number: card_number,
                cvv2: cvv2,
                expireTime: expireTime,
                userId: userId,
                productId: productId,
            })
                .done(function (response) {

                })
                .fail(function (response) {


                    if (response.status == 400) {

                        var message = response.responseJSON.message;
                        var div = "<div> " + message + "</div>"
                        $("#errors_show").append(div)

                    } else if (response.status == 422) {
                        var errors = response.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            var div = "<div> " + value + "</div>"
                            $("#errors_show").append(div)
                        });

                    }

                })
                .always(function () {

                    }
                );
        }

        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;

            var timerfunc = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(timerfunc);
                }
            }, 1000);


        }

        window.onload = function () {
            var time = "{{\Gate\Models\Payment::time}}";
            var fiveMinutes = 60 * "{{\Gate\Models\Payment::getMinute()}}",
                display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
        };
    </script>

    <style>
        #errors_show div {
            color: red;
        }

        .box {
            color: red;
            font-size: 26px;
            font-weight: 900;
        }

    </style>

@endsection


