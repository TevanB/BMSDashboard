@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-signin my-5 text-dark bg-dark">
                <div class="card-title text-center mt-5 text-light">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" class="form-signin" action="{{ route('login') }}">
                        @csrf
                      <div class="form-label-group">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0 justify-content-center">
                            <div class="col-md-8 text-center">
                                <button type="submit" class="btn btn-primary container-fluid">
                                    {{ __('Login') }}
                                </button>


                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">


                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                      </div>
                    </form>
                </div>
            </div>




            <div class="card card-signin my-5 mt-5 text-dark bg-dark">
                <div class="card-body">
                    <form method="POST" class="form-signin" action="{{ route('login') }}">
                        @csrf
                      <div class="form-label-group">
                        <div class="form-group row mb-0 justify-content-center mt-3">
                            <div class="row container-fluid justify-content-center">
                              <div class="col-md-8 text-center">
                                <p>Don't have an account?</p>
                              </div>
                              <div class="col-md-8 text-center">
                                  <button type="button" href="https://app.bmsboosting.com/register" class="btn btn-primary container-fluid">
                                      Register Now
                                  </button>
                              </div>

                            </div>
                        </div>

                      </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
