@extends('layouts.app')

@section('title', "| Modifica Categoria {$category->category_name}")

@section('content')
    <section id="categories-edit">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-orange fs-4 fw-bold">
                        <i class="fa-solid fa-pen"></i>
                        Modifica Categoria {{$category->category_name}}
                    </h2>
                </div>

                {{-- row turn back categories index --}}
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
                        <form action="{{route('categories.update', $category->id)}}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- category name --}}
                            <div class="row mb-2">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-orange shadow-sm @error('category_name') is-invalid @enderror" id="category_name" name="category_name" value="{{old('category_name', $category->category_name)}}" placeholder="Nome Categoria" required>
                                        <label for="category_name" class="text-orange">Nome Categoria*</label>
    
                                        @error('category_name')
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