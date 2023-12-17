@extends('layouts.app')

@section('title', "| Modifica Profilo")

@section('content')
    <section id="profiles-edit">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-solid fa-pen"></i>
                        Modifica Profilo
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
                        <form action="{{route('profiles.update', $user->id)}}" method="POST">
                            @csrf
                            
                            {{-- row input --}}
                            <div class="row mb-2">
                                {{-- name --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input {{$user->isAdmin() ? 'readonly' : ''}} type="text" class="form-control input-violet shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $user->name)}}" placeholder="Nome" required>
                                        <label for="name" class="text-violet">Nome*</label>
    
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
                                        <input {{$user->isAdmin() ? 'readonly' : ''}} type="text" class="form-control input-violet shadow-sm @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{old('surname', $user->surname)}}" placeholder="Cognome" required>
                                        <label for="surname" class="text-violet">Cognome*</label>
    
                                        @error('surname')
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
                                        <label for="email" class="text-violet">Email*</label>
    
                                        @error('email')
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