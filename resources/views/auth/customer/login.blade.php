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
            background-image: url("{{ asset('img/study.jpg') }}");
        }
    </style>
</head>

<body>
    <div class="page-content login-cover">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Login form -->
                    <form class="login-form" action="{{ route('customer-login') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="">
                            <div class="card" style="background: #ffffff8e">
                                <div class="card-body ">
                                    <div class="text-center mb-3">
                                        <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                            <img src="{{ asset('img/new_zoesoma.png.png') }}" class="img-fluid"
                                                style="height: 9.2em" alt="logo">
                                        </div>
                                        <h5 class="mb-0">Welcome Back Customer!!!</h5>
                                        <span class="d-block text-muted">Enter your credentials below</span>
                                        @if ($errors->any())
                                            <div class="alert alert-danger border-0 alert-dismissible fade show mb-3">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                         <span class="fw-semibold">Oh snap! {{$error}}</span>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input type="text" name="username" class="form-control" placeholder="Enter Username">
                                            <div class="form-control-feedback-icon">
                                                <i class="ph-user-circle text-muted"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input type="password" name="password" class="form-control" placeholder="•••••••••••">
                                            <div class="form-control-feedback-icon">
                                                <i class="ph-lock text-muted"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                                    </div>

                                    <div class="text-center">
                                        <a href="login_password_recover.html">Forgot password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /login form -->

                </div>
                <!-- /content area -->


                <!-- Footer -->
                {{-- <div class="navbar navbar-sm navbar-footer border-top">
					<div class="container-fluid">
						<span>&copy; 2022 <a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328">Limitless Web App Kit</a></span>

						<ul class="nav">
							<li class="nav-item">
								<a href="https://kopyov.ticksy.com/" class="navbar-nav-link navbar-nav-link-icon rounded" target="_blank">
									<div class="d-flex align-items-center mx-md-1">
										<i class="ph-lifebuoy"></i>
										<span class="d-none d-md-inline-block ms-2">Support</span>
									</div>
								</a>
							</li>
							<li class="nav-item ms-md-1">
								<a href="https://demo.interface.club/limitless/demo/Documentation/index.html" class="navbar-nav-link navbar-nav-link-icon rounded" target="_blank">
									<div class="d-flex align-items-center mx-md-1">
										<i class="ph-file-text"></i>
										<span class="d-none d-md-inline-block ms-2">Docs</span>
									</div>
								</a>
							</li>
							<li class="nav-item ms-md-1">
								<a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov" class="navbar-nav-link navbar-nav-link-icon text-primary bg-primary bg-opacity-10 fw-semibold rounded" target="_blank">
									<div class="d-flex align-items-center mx-md-1">
										<i class="ph-shopping-cart"></i>
										<span class="d-none d-md-inline-block ms-2">Purchase</span>
									</div>
								</a>
							</li>
						</ul>
					</div>
				</div> --}}
                <!-- /footer -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

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
