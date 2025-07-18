<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.shared.title-meta', ['title' => 'Log In'])

    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/phosphor/styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <script src="{{ asset('assets/js/configurator.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

    {{-- @php
        $brandSetting = \App\Models\BrandSetting::firstOrCreate();
    @endphp --}}

    <style>
        .btn-main {
            width: 130px;
            height: 40px;
            color: #ffffff;
            border-radius: 5px;
            padding: 10px 25px;
            font-family: 'Lato', sans-serif;
            font-weight: 500;
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
            box-shadow: inset 2px 2px 2px 0px rgba(255, 255, 255, .5),
                7px 7px 20px 0px rgba(0, 0, 0, .1),
                4px 4px 5px 0px rgba(0, 0, 0, .1);
            outline: none;
        }

        .btn-main {
            border: none;
            background: rgb(36, 61, 58);
            background: linear-gradient(0deg, rgba(251, 33, 117, 1) 0%, rgba(234, 76, 137, 1) 100%);
            color: #fff;
            overflow: hidden;
        }

        .btn-main:hover {
            text-decoration: none;
            color: #fff;
        }

        .btn-main:before {
            position: absolute;
            content: '';
            display: inline-block;
            top: -180px;
            left: 0;
            width: 30px;
            height: 100%;
            background-color: #ffffff;
            animation: shiny-btn1 4s ease-in-out infinite;
        }

        .btn-main:hover {
            opacity: .7;
        }

        .btn-main:active {
            box-shadow: 4px 4px 6px 0 rgba(255, 255, 255, .3),
                -4px -4px 6px 0 rgba(103, 145, 196, 0.2),
                inset -4px -4px 6px 0 rgba(255, 255, 255, .2),
                inset 4px 4px 6px 0 rgba(0, 0, 0, .2);
        }

        @-webkit-keyframes shiny-btn1 {
            0% {
                -webkit-transform: scale(0) rotate(45deg);
                opacity: 0;
            }

            80% {
                -webkit-transform: scale(0) rotate(45deg);
                opacity: 0.5;
            }

            81% {
                -webkit-transform: scale(4) rotate(45deg);
                opacity: 1;
            }

            100% {
                -webkit-transform: scale(40) rotate(45deg);
                opacity: 0;
            }
        }



        .login-cover {



            min-height: 500px;
            background-color: #cccccc;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-image: url("{{ asset('img/education1.jpg') }}");
        }
    </style>
</head>

<body>




    <div class="page-content login-cover">
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content d-flex justify-content-center align-items-center">

                    <div class="col-md-7 col-12 offset-md-2">
                        <div class="rounded-0 mb-0">
                            <div class="row">

                                <div class="col-md-5 offset-8  border-top  border-top-width-3 border-bottom border-bottom-main  border-bottom-width-3 border-top-main rounded-0"
                                    style="background: #ffffff8e">
                                    <form action="{{ route('login') }}" method="POST" class=""
                                        autocomplete="off">
                                        @csrf

                                        <div class="border-bottom-main mb-0 pt-4">
                                            <div class="text-center mb-4 mt-2">
                                                <img src="{{ asset('img/new_zoesoma.png.png') }}" class="img-fluid" style="height: 10.2em" alt="logo">
                                            </div>

                                            @if (session()->has('password_set') && session('password_set'))
                                                <div class="alert alert-success border-0 alert-dismissible fade show mb-3">
                                                    <span class="fw-semibold">Password Updated! Please Login to Continue</span>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                </div>
                                            @endif

                                            @if (session()->has('status'))
                                                <div class="alert alert-danger border-0 alert-dismissible fade show mb-3">
                                                    <span class="fw-semibold">Oh snap!</span>
                                                    {{ session('status') }}.
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                </div>
                                            @else
                                                @if ($errors->any())
                                                    <div class="alert alert-danger border-0 alert-dismissible fade show mb-3">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <span class="fw-semibold">Oh snap! {{$error}}</span>
                                                            @endforeach
                                                        </ul>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                    </div>
                                                @endif
                                            @endif

                                            <div class="mb-3">
                                                {{-- <label class="form-label text-main font-weight-bold">Username</label> --}}
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input class="form-control @if ($errors->has('emp_id')) is-invalid @endif" name="user_code" type="text" id="emp-id" required placeholder="username" autocomplete="off">
                                                    <div class="form-control-feedback-icon">
                                                        <i toggle="#password-field" class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                {{-- <label class="form-label text-main">Password</label> --}}
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="password" id="password" class="form-control @if ($errors->has('password')) is-invalid @endif" placeholder="password" name="password" required autocomplete="off">
                                                    <div class="form-control-feedback-icon" id="showPass">
                                                        <i class="ph-eye-closed text-muted toggle-password"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-1 mt-3">
                                                <button type="submit" class="btn btn-main w-100 border-0" style="background: #00454e">Log In</button>
                                            </div>

                                            <div class="text-center mt-2">
                                                <a href="{{ url('forgot-password') }}" class="ms-auto text-main">Forgot password?</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- <div class="mb-2">
        <img src="{{ asset('img/logo.png') }}" class=" float-end"
            style="height:2.4em;width:16%;float-left;opacity:100%" alt="logo">

    </div>
    <div class="">
        <img src="{{ asset('img/top.png') }}" class=" float-end"
            style="height:3.5em;width:100%;float-left;opacity:100%" alt="logo">

    </div> -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var togglePasswords = document.querySelectorAll(".toggle-password");

            togglePasswords.forEach(function(togglePassword) {
                togglePassword.addEventListener("click", function() {
                    togglePassword.classList.toggle("ph-eye");
                    togglePassword.classList.toggle("ph-eye-closed");

                    var input = document.getElementById("password");
                    // var input = document.querySelector(targetInputId);

                    if (input.getAttribute("type") === "password") {
                        input.setAttribute("type", "text");
                    } else {
                        input.setAttribute("type", "password");
                    }
                });
            });
        });
    </script>

</body>

</html>
