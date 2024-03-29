@extends('layouts.app')

@section('title', '| Email Reset Password')

@section('content')
<section id="auth-passwords-email">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">

            {{-- card form email reset pass --}}
            <div class="col-12 d-flex justify-content-center">
                <div class="card border-0 bg-dark rounded-md shadow-md">
                    <div class="card-body py-4">
                        {{-- logo --}}
                        <a href="{{url('/')}}" alt="{{config('app.name')}}">
                            <figure class="logo-large mx-auto mb-5">
                                <img src="{{asset('assets/img/icon-site/icon-large-svg.svg')}}" alt="{{config('app.name') . ' logo'}}">
                            </figure>
                        </a>

                        {{-- turn back login --}}
                        <div class="turn-back mb-4">
                            <a href="{{route('login')}}" class="btn btn-transparent fw-semibold">
                                <i class="fa-solid fa-arrow-left"></i>
                                Torna alla pagina Login
                            </a>
                        </div>

                        {{-- flash message session --}}
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
    
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
    
                            {{-- email --}}
                            <div class="form-floating mb-4">
                                <input type="email" class="form-control input-orange shadow-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}" placeholder="Indirizzo Email" required autocomplete="email">
                                <label for="email" class="text-orange">
                                    <i class="fa-solid fa-envelope"></i>
                                    Indirizzo Email
                                </label>
    
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            {{-- btn submit --}}
                            <div class="row mb-0">
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-orange shadow fw-bold">
                                        Invia link per il reset della Password
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
