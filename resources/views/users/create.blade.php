@extends('layouts.app')

@section('title', '| Creazione Utente')

@section('content')
    <section id="users-create" class="pt-4">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-solid fa-plus"></i>
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
                                        <input type="text" class="form-control input-violet shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}" placeholder="Nome" required>
                                        <label for="name" class="text-violet">Nome</label>
    
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- username --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-violet shadow-sm @error('username') is-invalid @enderror" id="username" name="username" value="{{old('username')}}" placeholder="Username" required>
                                        <label for="username" class="text-violet">Username</label>
    
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
                                        <input type="email" class="form-control input-violet shadow-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}" placeholder="email" required>
                                        <label for="email" class="text-violet">Email</label>
    
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
                                        <input type="password" class="form-control input-violet shadow-sm @error('password') is-invalid @enderror" id="password" name="password" value="" placeholder="Password" required>
                                        <label for="password" class="text-violet">Password</label>
    
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
                                        <input type="password" class="form-control input-violet shadow-sm @error('password') is-invalid @enderror" id="password-confirm" name="password_confirmation" value="" placeholder="Conferma Password" required>
                                        <label for="password-confirm" class="text-violet">Conferma Password</label>
    
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- row ruolo --}}
                            <div class="row mb-4">
                                <div class="col-12 mb-3">
                                    <h4 class="mb-0 text-violet fw-light">Ruolo</h4>
                                </div>

                                <div class="col-12 col-md-6">
                                    <select class="form-select form-select-md shadow-sm" name="role_id" id="role_id" aria-label="role" required>
                                        <option selected>-- Seleziona un Ruolo --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- row btn submit --}}
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-violet fw-bold px-4 text-uppercase">
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