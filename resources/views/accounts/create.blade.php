@extends('layouts.app')

@section('title', "| Creazione Account")

@section('content')
    <section id="accounts-create">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-solid fa-plus"></i>
                        Creazione Account
                    </h2>
                </div>

                {{-- row turn back accounts index --}}
                <div class="row mb-5">
                    <div class="turn-back">
                        <a class="btn btn-transparent fw-semibold shadow" href="{{route('accounts.index')}}">
                            <i class="fa-solid fa-arrow-left"></i>
                            Torna alla lista Account
                        </a>
                    </div>
                </div>

                {{-- row form --}}
                <div class="row">
                    <div class="col-12">
                        <form action="{{route('accounts.store')}}" method="POST">
                            @csrf

                            {{-- row inputs --}}
                            <div class="row mb-2">
                                {{-- account name --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-violet shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}" placeholder="Nome Account" required>
                                        <label for="name" class="text-violet">Nome Account*</label>
    
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- client --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <select class="form-select select-violet shadow-sm" id="client_id" name="client_id" aria-label="client_id" required>
                                          <option selected>-- Seleziona un Cliente --</option>
                                            @foreach ($clients as $client)
                                                <option {{old('client_id') == $client->id ? 'selected' : ''}} value="{{$client->id}}">{{$client->name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="client_id" class="text-violet">Cliente*</label>

                                        @error('client_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- category --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <select class="form-select select-violet shadow-sm" id="category_id" name="category_id" aria-label="category_id" required>
                                          <option selected>-- Seleziona una Categoria --</option>
                                            @foreach ($categories as $category)
                                                <option {{old('category_id') == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="category_id" class="text-violet">Categoria*</label>

                                        @error('category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- url ip --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="url" class="form-control input-violet shadow-sm @error('url') is-invalid @enderror" id="url" name="url" value="{{old('url')}}" placeholder="Nome Account">
                                        <label for="url" class="text-violet">Url / Ip </label>
    
                                        @error('url')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- username --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-violet shadow-sm @error('username') is-invalid @enderror" id="username" name="username" value="{{old('username')}}" placeholder="Username" required>
                                        <label for="username" class="text-violet">Username*</label>
    
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- password --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="password" class="form-control input-violet shadow-sm @error('password') is-invalid @enderror" id="password" name="password" value="" placeholder="Password" required>
                                        <label for="password" class="text-violet">Password*</label>
    
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- password confirm --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="password" class="form-control input-violet shadow-sm @error('password') is-invalid @enderror" id="password-confirm" name="password_confirmation" value="" placeholder="Conferma Password" required>
                                        <label for="password-confirm" class="text-violet">Conferma Password*</label>
    
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- description --}}
                                <div class="col-12">
                                    <div class="form-floating mb-4">
                                        <textarea class="form-control text-area-violet shadow-sm" placeholder="Descrizione" id="description" name="description" style="height: 100px">{{old('description')}}</textarea>
                                        <label for="description" class="text-violet">Descrizione</label>
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