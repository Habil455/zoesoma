@extends('layouts.vertical', ['title' => 'Employee Password'])

@section('content')

<div class="row">
    <div class="col-md-6 offset-3">
        <div class="card  border-top  border-top-width-3 border-top-main rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="text-main">Update Password</h4>

                    <a href="{{route('dashboard')}}" class="btn btn-main btn-xs">Back</a>
                </div>

                @if (session()->has('status'))
                <div class="alert alert-success border-0 alert-dismissible fade show">
                    <span class="fw-semibold">Well done!</span> You successfully <a href="#" class="alert-link">{{ session('status') }}</a> your password.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
            </div>

            <div class="card-body">
                <form action="{{ route('save_new_password') }}" method="POST" autocomplete="off">
                    @csrf
                    {{-- @method('PUT') --}}

                    <input type="hidden" name="user_code" value="{{ auth()->user()->user_code }}">

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>

                        <div class="form-control-feedback form-control-feedback-start">
                            <input
                            type="password"
                            name="current_password"
                            id="current_password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            required
                            autocomplete="off"
                            value="{{ old('current_password') }}"
                        >


                        <div class="form-control-feedback-icon" id="showPass">
                            <i class="ph-eye-closed text-muted toggle-password"></i>
                        </div>

                        @error('current_password')
                        <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>

                        <div class="form-control-feedback form-control-feedback-start">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            autocomplete="off"
                            value="{{ old('password') }}"
                        >

                        @error('password')
                        <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror

                        <div class="form-control-feedback-icon" id="showPass">
                            <i class="ph-eye-closed text-muted toggle-password"></i>
                        </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>

                        <div class="form-control-feedback form-control-feedback-start">

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password"
                            class="form-control @error('password', 'confirmed') is-invalid @enderror"
                            required
                            autocomplete="off"
                            value="{{ old('password_confirmation') }}"
                        >

                        @error('password', 'confirmed')
                        <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                        <div class="form-control-feedback-icon" id="password">
                            <i class="ph-eye-closed text-muted toggle-password"></i>
                        </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-main">Update password</button>
                    </div>

                </form>
            </div>
        </div>


    </div>
</div>

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


@endsection
