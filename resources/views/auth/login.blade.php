@extends('layouts.login')

@section('content')

<form method="POST" action="{{ route('login') }}" class="login100-form validate-form">
    @csrf
    <span class="login100-form-title p-b-43">
        Ingresar
    </span>
    
    <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
        <input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        <span class="focus-input100"></span>
        <span class="label-input100">Email</span>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="wrap-input100 validate-input" data-validate="Password is required">
        <input id="password" type="password" class="input100 @error('password') is-invalid @enderror" name="password"  required autocomplete="current-password">
        <span class="focus-input100"></span>
        <span class="label-input100">Password</span>
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="flex-sb-m w-full p-t-3 p-b-32">
        <div class="contact100-form-checkbox">
            <input class="input-checkbox100" id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="label-checkbox100" for="ckb1">
                Recuerdame
            </label>
        </div>                                

        <div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="txt1">
                    Olvidé mi contraseña
                </a>
            @endif
        </div>
    </div>


    <div class="container-login100-form-btn">
        <button type="submit" class="login100-form-btn">
            Ingresar
        </button>
    </div>
</form>

@endsection
