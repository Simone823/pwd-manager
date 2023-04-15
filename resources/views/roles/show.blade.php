@extends('layouts.app')

@section('title', "| Visualizza Ruolo {$role->name}")

@section('content')
    <section id="roles-show" class="pt-4">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-sharp fa-solid fa-eye"></i>
                        Visualizza Ruolo {{$role->name}}
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
                        {{-- role name --}}
                        <div class="row mb-2">
                            <div class="col-12 col-md-6">
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control input-violet shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{$role->name}}" placeholder="Nome Ruolo" readonly>
                                    <label for="name" class="text-violet">Nome Ruolo</label>
                                </div>
                            </div>
                        </div>

                        {{-- row permissions --}}
                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <h4 class="mb-0 text-violet fw-light">Permessi</h4>
                            </div>

                            <div class="col-12">
                                @foreach ($permissions as $key => $permission)
                                    <div class="form-check mb-3">
                                        <input {{$role->permissions->contains($permission) ? 'checked' : ''}} class="form-check-input" type="checkbox" id="permissions-{{$permission->id}}" name="permissions[{{$permission->id}}]"  value="{{$permission->id}}" disabled>
                                        <label class="form-check-label text-light-gray" for="permissions-{{$permission->id}}">
                                            {{$permission->name}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- row btn modifica --}}
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{route('roles.edit', $role->id)}}" class="btn btn-violet fw-bold px-4 text-uppercase">
                                    <i class="fa-solid fa-pen"></i>
                                    Modifica
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection