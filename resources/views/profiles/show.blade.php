@extends('layouts.app')

@section('title', "| Visualizza Profilo")

@section('content')
    <section id="profiles-edit">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-orange fs-4 fw-bold">
                        <i class="fa-sharp fa-solid fa-eye"></i>
                        Visualizza Profilo
                    </h2>
                </div>

                {{-- row buttons actions --}}
                <div class="row mb-5">
                    <div class="col-12 d-flex flex-wrap gap-3">
                        {{-- btn edit --}}
                        <a href="{{route('profiles.edit', $user->id)}}" class="btn btn-transparent fw-semibold shadow">
                            <i class="fa-solid fa-pen"></i>
                            Modifica
                        </a>
                    </div>
                </div>

                {{-- row form --}}
                <div class="row">
                    <div class="col-12">
                        {{-- row input --}}
                        <div class="row mb-5">
                            {{-- name --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control input-orange shadow-sm" id="name" name="name" value="{{$user->name}}" placeholder="Nome" readonly>
                                    <label for="name" class="text-orange">Nome</label>
                                </div>
                            </div>

                            {{-- surname --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control input-orange shadow-sm" id="surname" name="surname" value="{{$user->surname}}" placeholder="Cognome" readonly>
                                    <label for="surname" class="text-orange">Cognome</label>
                                </div>
                            </div>

                            {{-- username --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control input-orange shadow-sm" id="username" name="username" value="{{$user->username}}" placeholder="Username" readonly>
                                    <label for="username" class="text-orange">Username</label>
                                </div>
                            </div>

                            {{-- email --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating mb-4">
                                    <input type="email" class="form-control input-orange shadow-sm" id="email" name="email" value="{{$user->email}}" placeholder="email" readonly>
                                    <label for="email" class="text-orange">Email</label>
                                </div>
                            </div>

                            {{-- ruolo --}}
                            <div class="col-12 col-md-6">
                                <div class="form-floating mb-4">
                                    <select class="form-select select-orange shadow-sm" id="role_id" name="role_id" aria-label="role_id" disabled>
                                        @foreach ($roles as $role)
                                            <option {{$user->role->id == $role->id ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="role_id" class="text-orange">Ruolo</label>
                                </div>
                            </div>

                            {{-- change password --}}
                            <div class="col-12 col-md-6">
                                @include('profiles.modalChangePassword')
                            </div>
                        </div>

                        {{-- row log activities --}}
                        @include('profiles.logActivities')
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection