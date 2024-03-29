@extends('layouts.app')

@section('title', "| Creazione Cliente")

@section('content')
    <section id="clients-create">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-orange fs-4 fw-bold">
                        <i class="fa-solid fa-plus"></i>
                        Creazione Cliente
                    </h2>
                </div>

                {{-- row turn back clients index --}}
                <div class="row mb-5">
                    <div class="turn-back">
                        <a class="btn btn-transparent fw-semibold shadow" href="{{route('clients.index')}}">
                            <i class="fa-solid fa-arrow-left"></i>
                            Torna alla lista Clienti
                        </a>
                    </div>
                </div>

                {{-- row form --}}
                <div class="row">
                    <div class="col-12">
                        <form action="{{route('clients.store')}}" method="POST">
                            @csrf

                            {{-- client name --}}
                            <div class="row mb-2">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-orange shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}" placeholder="Nome Cliente" required>
                                        <label for="name" class="text-orange">Nome Cliente*</label>
    
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- description --}}
                            <div class="row mb-2">
                                <div class="col-12">
                                    <div class="form-floating mb-4">
                                        <textarea class="form-control text-area-orange shadow-sm" placeholder="Descrizione" id="description" name="description" style="height: 100px">{{old('description')}}</textarea>
                                        <label for="description" class="text-orange">Descrizione</label>
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