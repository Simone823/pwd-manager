@extends('layouts.app')

@section('title', "| Modifica Account {$account->name}")

@section('content')
    <section id="accounts-create">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-orange fs-4 fw-bold">
                        <i class="fa-solid fa-pen"></i>
                        Modifica Account {{$account->name}}
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
                        <form action="{{route('accounts.update', $account->id)}}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- row inputs --}}
                            <div class="row mb-2">
                                {{-- account name --}}
                                <div class="col-12 col-md-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control input-orange shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $account->name)}}" placeholder="Nome Account" required>
                                        <label for="name" class="text-orange">Nome Account*</label>
    
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
                                        <select class="form-select select-orange shadow-sm" id="client_id" name="client_id" aria-label="client_id" required>
                                            @if (!$account->client)
                                                <option selected hidden value="">--</option>
                                            @endif

                                            @foreach ($clients as $client)
                                                <option {{old('client_id', $account->client_id) == $client->id ? 'selected' : ''}} value="{{$client->id}}">{{$client->name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="client_id" class="text-orange">Cliente*</label>

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
                                        <select class="form-select select-orange shadow-sm" id="category_id" name="category_id" aria-label="category_id" required>
                                            @if (!$account->category)
                                                <option selected hidden value="">--</option>
                                            @endif

                                            @foreach ($categories as $category)
                                                <option {{old('category_id', $account->category_id) == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="category_id" class="text-orange">Categoria*</label>

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
                                        <input type="text" class="form-control input-orange shadow-sm @error('url') is-invalid @enderror" id="url" name="url" value="{{old('url', $account->url)}}" placeholder="Nome Account">
                                        <label for="url" class="text-orange">Url / Ip </label>
    
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
                                        <input type="text" class="form-control input-orange shadow-sm @error('username') is-invalid @enderror" id="username" name="username" value="{{old('username', $account->username)}}" placeholder="Username" required autocomplete="username">
                                        <label for="username" class="text-orange">Username*</label>
    
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- description --}}
                                <div class="col-12">
                                    <div class="form-floating mb-4">
                                        <textarea class="form-control text-area-orange shadow-sm" placeholder="Descrizione" id="description" name="description" style="height: 100px">{{old('description', $account->description)}}</textarea>
                                        <label for="description" class="text-orange">Descrizione</label>
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