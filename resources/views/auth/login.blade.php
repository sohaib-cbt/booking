@extends('layouts.auth')

@section('style')
    <style>
        .login-main {
            border: 1px solid var(--theme-deafult);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card">
                    <div>
                        <div class="login-main">
                            <div><a class="logo" href="index.html"><img class="img-fluid for-dark" src="{{ asset('assets/images/thrive_logo.jpg') }}" alt="looginpage"><img class="img-fluid for-light" src="{{ asset('assets/images/thrive_logo.png') }}" alt="looginpage" style="height: 100px"></a></div>
                            <form method="POST" action="{{ route('login') }}" class="theme-form">
                                @csrf

                                {{-- Session error --}}
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                {{-- Validation errors --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif
                                <h4>Sign in to account</h4>
                                <p>Enter your email & password to login</p>

                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input class="form-control" type="email" name="email" required
                                        placeholder="email@example.com" value="{{ old('email') }}">
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="password" required
                                            placeholder="*********">
                                        <div class="show-hide"><span class="show"></span></div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input id="checkbox1" type="checkbox" name="remember">
                                        <label class="text-muted" for="checkbox1">Remember password</label>
                                    </div>
                                    <a class="link" href="{{ route('password.request') }}">Forgot password?</a>
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const showHide = document.querySelector(".show-hide");
            const passwordInput = document.querySelector('input[name="password"]');

            if (showHide && passwordInput) {
                showHide.addEventListener("click", function() {
                    const inputType = passwordInput.getAttribute("type");
                    if (inputType === "password") {
                        passwordInput.setAttribute("type", "text");
                        showHide.classList.add("active");
                    } else {
                        passwordInput.setAttribute("type", "password");
                        showHide.classList.remove("active");
                    }
                });
            }
        });
    </script>
@endsection
