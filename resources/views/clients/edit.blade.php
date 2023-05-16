@extends('layouts.app')

@section('title', "| Modifica Cliente {$client->name}")

@section('content')
    <section id="clients-edit">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-solid fa-pen"></i>
                        Modifica Cliente {{$client->name}}
                    </h2>
                </div>

                {{-- row turn back clients index --}}
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
                        <form action="{{route('clients.update', $client->id)}}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- client name --}}
                            <div class="row mb-2">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-violet shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $client->name)}}" placeholder="Nome Cliente" required>
                                        <label for="name" class="text-violet">Nome Cliente*</label>
    
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
                                        <textarea class="form-control text-area-violet shadow-sm" placeholder="Descrizione" id="description" name="description" style="height: 100px">{{old('description', $client->description)}}</textarea>
                                        <label for="description" class="text-violet">Descrizione</label>
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