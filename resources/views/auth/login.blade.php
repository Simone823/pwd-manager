@extends('layouts.app')

@section('title', '| Login')

@section('content')
    <section id="auth-login">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
    
                {{-- card login --}}
                <div class="col-12 d-flex justify-content-center">
                    <div class="card border-0 bg-dark rounded-md shadow-md pt-4">
                        {{-- logo --}}
                        <a href="{{url('/')}}" alt="{{config('app.name')}}">
                            <figure class="logo-large mx-auto mb-5">
                                <img src="{{asset('assets/img/icon-site/icon-large-svg.svg')}}" alt="{{config('app.name') . ' logo'}}">
                            </figure>
                        </a>
    
                        <div class="card-body py-4">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
    
                                {{-- email --}}
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control input-orange shadow-sm @error('username') is-invalid @enderror" id="username" name="username" value="{{old('username')}}" placeholder="Nome Utente" required autocomplete="username" autofocus="false">
                                    <label for="username" class="text-orange">
                                        <i class="fa-solid fa-user"></i>
                                        Nome Utente
                                    </label>
    
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                {{-- password --}}
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control input-orange shadow-sm @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required autocomplete="new-password" autofocus="false">
                                    <label for="password" class="text-orange">
                                        <i class="fa-solid fa-lock"></i>
                                        Password
                                    </label>
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                {{-- password forgot --}}
                                @if (Route::has('password.request'))
                                    <a class="link-light-gray d-block mb-4" href="{{ route('password.request') }}">
                                        Hai dimenticato la Password?
                                    </a>
                                @endif
    
                                {{-- btn --}}
                                <div class="row mb-0">
                                    <div class="col-12 d-flex justify-content-center gap-3 gy-2 align-items-center flex-wrap">
                                        {{-- submit --}}
                                        <button type="submit" class="btn btn-orange fw-bold shadow w-100 text-uppercase">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
    </section>
@endsection