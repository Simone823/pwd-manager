@extends('layouts.app')

@section('title', '| Creazione Utente')

@section('content')
    <section id="users-create">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-orange fs-4 fw-bold">
                        <i class="fa-solid fa-user me-1"></i>
                        Creazione Utente
                    </h2>
                </div>

                {{-- row turn back users index --}}
                <div class="row mb-5">
                    <div class="turn-back">
                        <a class="btn btn-transparent fw-semibold shadow" href="{{route('users.index')}}">
                            <i class="fa-solid fa-arrow-left"></i>
                            Torna alla lista Utenti
                        </a>
                    </div>
                </div>

                {{-- row form --}}
                <div class="row">
                    <div class="col-12">
                        <form action="{{route('users.store')}}" method="POST">
                            @csrf
                            
                            {{-- row input --}}
                            <div class="row mb-2">
                                {{-- name --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-orange shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}" placeholder="Nome" required>
                                        <label for="name" class="text-orange">Nome*</label>
    
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- surname --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-orange shadow-sm @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{old('surname')}}" placeholder="Cognome" required>
                                        <label for="surname" class="text-orange">Cognome*</label>
    
                                        @error('surname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- username --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-orange shadow-sm @error('username') is-invalid @enderror" id="username" name="username" value="{{old('username')}}" placeholder="Username" required autocomplete="username">
                                        <label for="username" class="text-orange">Username*</label>
    
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- email --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="email" class="form-control input-orange shadow-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}" placeholder="email" required>
                                        <label for="email" class="text-orange">Email*</label>
    
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- password --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="password" class="form-control input-orange shadow-sm @error('password') is-invalid @enderror" id="password" name="password" value="" placeholder="Password" required autocomplete="new-password">
                                        <label for="password" class="text-orange">Password*</label>
    
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- password confirm --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="password" class="form-control input-orange shadow-sm @error('password') is-invalid @enderror" id="password-confirm" name="password_confirmation" value="" placeholder="Conferma Password" required>
                                        <label for="password-confirm" class="text-orange">Conferma Password*</label>
    
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- ruolo --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <select class="form-select select-orange shadow-sm @error('role_id') is-invalid @enderror" id="role_id" name="role_id" aria-label="role_id" required>
                                            <option selected hidden>-- Seleziona un Ruolo --</option>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="role_id" class="text-orange">Ruolo*</label>

                                        @error('role_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- row btn submit --}}
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-orange fw-bold px-4 text-uppercase">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Salva
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection