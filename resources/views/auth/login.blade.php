@extends('layouts.app')

@section('title', '| Login')

@section('content')
    <section id="auth-login">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8">
    
                    {{-- logo --}}
                    <a href="{{url('/')}}" alt="{{config('app.name')}}">
                        <figure class="logo-large mx-auto mb-5">
                            <img src="{{asset('assets/img/icon-site/icon-large-svg.svg')}}" alt="{{config('app.name') . ' logo'}}">
                        </figure>
                    </a>
    
                    {{-- card login --}}
                    <div class="card border-0 bg-dark rounded-md shadow-md">
                        <div class="card-body py-4">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
    
                                {{-- email --}}
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control input-violet shadow-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}" placeholder="Indirizzo Email" required autocomplete="email">
                                    <label for="email" class="text-violet">Indirizzo Email</label>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- password --}}
                                <div class="form-floating mb-4">
                                    <input type="password" class="form-control input-violet shadow-sm @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required autocomplete="current-password">
                                    <label for="password" class="text-violet">Password</label>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
    
                                {{-- btn --}}
                                <div class="row mb-0">
                                    <div class="col-12 d-flex justify-content-center gap-3 gy-2 align-items-center flex-wrap">
                                        {{-- submit --}}
                                        <button type="submit" class="btn btn-violet fw-bold shadow">
                                            {{ __('Login') }}
                                        </button>
    
                                        {{-- password forgot --}}
                                        @if (Route::has('password.request'))
                                            <a class="link-light-gray" href="{{ route('password.request') }}">
                                                Hai dimenticaro la Password?
                                            </a>
                                        @endif
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