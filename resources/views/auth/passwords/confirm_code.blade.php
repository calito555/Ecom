@extends('layout.app')

@section('content')

<div class="main_content">

    <!-- START LOGIN SECTION -->
    <div class="login_register_wrap section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-10">
                    <div class="login_wrap">
                        <div class="padding_eight_all bg-white">
                            <div class="heading_s1">
                                <h3>Confirm Password Reset Code</h3>
                                <p>A code has been sent to <span style="color: blueviolet"> {{ $email }}</span></p>
                                <span>Enter the code to reset password in your account</span>
                            </div>
                            <form method="POST" action="{{ route('submitPasswordResetCode') }}">
                            @csrf

                            <div class="row mb-3">

                                <input class="form-control" hidden type="text" value="{{ $email }}" name="user_email">

                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control @error('code') is-invalid @enderror" name="code" required autofocus>

                                    @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Reset code CountDown -->
                            <div class="code-not-received">
                                <p id="resendLink">
                                    Didn't Receive code? <a href="{{ route('resend_code', $email) }}">Resend Code</a>
                                </p>
                            </div>
                            <div id="countDownWrapper">
                                <p id="countdown">Resend code in <span id="timer">01:00</span></p>
                            </div>

                            <button type="submit" id="submitButtonX">Submit</button>

                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LOGIN SECTION -->

</div>
<!-- END MAIN CONTENT -->

<script>
    // JavaScript code for countdown timer
    function startCountdown(duration, display) {
        var timer = duration, minutes, seconds;
        var intervalId = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                clearInterval(intervalId); // Clear the interval when timer reaches 0
                display.textContent = "00:00";
                document.getElementById("resendLink").style.display = "block"; // Show resend link
                document.getElementById("submitButtonX").style.display = "none"; // Hide submit form
            } else {
                document.getElementById("resendLink").style.display = "none"; // Hide resend link
                document.getElementById("submitButtonX").style.display = "block"; // Show submit form
            }
        }, 1000);
    }

    window.onload = function () {
        var duration = 60 * 1; // 1 minute countdown
        var display = document.querySelector('#timer');
        startCountdown(duration, display);
    };
</script>

@endsection