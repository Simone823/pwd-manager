@extends('layouts.app')

@section('title', "| Creazione Categoria")

@section('content')
    <section id="categories-create">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-solid fa-pen"></i>
                        Creazione Categoria
                    </h2>
                </div>

                {{-- row turn back categories index --}}
                <div class="row mb-5">
                    <div class="turn-back">
                        <a class="btn btn-transparent fw-semibold shadow" href="{{route('categories.index')}}">
                            <i class="fa-solid fa-arrow-left"></i>
                            Torna alla lista Categorie
                        </a>
                    </div>
                </div>

                {{-- row form --}}
                <div class="row">
                    <div class="col-12">
                        <form action="{{route('categories.store')}}" method="POST">
                            @csrf

                            {{-- category name --}}
                            <div class="row mb-2">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-violet shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}" placeholder="Nome Categoria" required>
                                        <label for="name" class="text-violet">Nome Categoria</label>
    
                                        @error('name')
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