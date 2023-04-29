@extends('layouts.app')

@section('title', "| Visualizza Utente {$user->username}")

@section('content')
    <section id="users-edit">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-sharp fa-solid fa-eye"></i>
                        Visualizza Utente {{$user->username}}
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
                        {{-- row input --}}
                        <div class="row mb-2">
                            {{-- name --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control input-violet shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{$user->name}}" placeholder="Nome" readonly>
                                    <label for="name" class="text-violet">Nome</label>
                                </div>
                            </div>

                            {{-- username --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control input-violet shadow-sm @error('username') is-invalid @enderror" id="username" name="username" value="{{$user->username}}" placeholder="Username" readonly>
                                    <label for="username" class="text-violet">Username</label>
                                </div>
                            </div>

                            {{-- email --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating mb-4">
                                    <input type="email" class="form-control input-violet shadow-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{$user->email}}" placeholder="email" readonly>
                                    <label for="email" class="text-violet">Email</label>
                                </div>
                            </div>
                        </div>

                        {{-- row ruolo --}}
                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <h4 class="mb-0 text-violet fw-light">Ruolo</h4>
                            </div>

                            <div class="col-12 col-md-6">
                                <select class="form-select form-select-md shadow-sm" name="role_id" id="role_id" aria-label="role" disabled>
                                    @foreach ($roles as $role)
                                        <option {{$user->role->id == $role->id ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- row btn modifica --}}
                        @if ($user->username != 'admin')
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <a href="{{route('users.edit', $user->id)}}" class="btn btn-violet fw-bold px-4 text-uppercase">
                                        <i class="fa-solid fa-pen"></i>
                                        Modifica
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection