@extends('layouts.app')

@section('title', "| Modifica Utente {$user->username}")

@section('content')
    <section id="users-edit">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-solid fa-pen"></i>
                        Modifica Utente {{$user->username}}
                    </h2>
                </div>

                {{-- row turn back users index --}}
                <div class="row mb-5">
                    <div class="turn-back">
                        <a class="btn btn-transparent fw-semibold shadow" href="{{request()->headers->get('referer')}}">
                            <i class="fa-solid fa-arrow-left"></i>
                            Torna indietro
                        </a>
                    </div>
                </div>

                {{-- row form --}}
                <div class="row">
                    <div class="col-12">
                        <form action="{{route('users.update', $user->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            {{-- row input --}}
                            <div class="row mb-2">
                                {{-- name --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-violet shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $user->name)}}" placeholder="Nome" required>
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
                                        <input type="text" class="form-control input-violet shadow-sm @error('username') is-invalid @enderror" id="username" name="username" value="{{old('username', $user->username)}}" placeholder="Username" required>
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
                                        <input type="email" class="form-control input-violet shadow-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email', $user->email)}}" placeholder="email" required>
                                        <label for="email" class="text-violet">Email</label>
    
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
                                        <select class="form-select select-violet shadow-sm" id="role_id" name="role_id" aria-label="role_id" required>
                                            @foreach ($roles as $role)
                                                <option {{old('role_id', $user->role->id == $role->id) ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="role_id" class="text-violet">Ruolo*</label>

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
                                    <button type="submit" class="btn btn-violet fw-bold px-4 text-uppercase">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Salva Modifica
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