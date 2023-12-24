@extends('layouts.app')

@section('title', '| Creazione Ruolo')

@section('content')
    <section id="roles-create">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-orange fs-4 fw-bold">
                        <i class="fa-solid fa-medal me-1"></i>
                        Creazione Ruolo
                    </h2>
                </div>

                {{-- row turn back role index --}}
                <div class="row mb-5">
                    <div class="turn-back">
                        <a class="btn btn-transparent fw-semibold shadow" href="{{route('roles.index')}}">
                            <i class="fa-solid fa-arrow-left"></i>
                            Torna alla lista Ruoli
                        </a>
                    </div>
                </div>

                {{-- row form --}}
                <div class="row">
                    <div class="col-12">
                        <form action="{{route('roles.store')}}" method="POST">
                            @csrf

                            {{-- role name --}}
                            <div class="row mb-2">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-orange shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}" placeholder="Nome Ruolo" required>
                                        <label for="name" class="text-orange">Nome Ruolo*</label>
    
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- row permissions --}}
                            <div class="row mb-4">
                                <div class="col-12 mb-3">
                                    <h4 class="mb-0 text-orange fw-light">Permessi</h4>
                                </div>

                                <div class="col-12">
                                    @foreach ($permissions as $key => $permission)
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="permissions-{{$permission->id}}" name="permissions[{{$permission->id}}]"  value="{{$permission->id}}">
                                            <label class="form-check-label text-light-gray" for="permissions-{{$permission->id}}">
                                                {{$permission->name}}
                                            </label>
                                        </div>
                                    @endforeach

                                    {{-- Errors types --}}
                                    @error('permissions')
                                        <span class="text-danger fw-bold">
                                            {{ $message }}
                                        </span>
                                    @enderror
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