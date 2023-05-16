@extends('layouts.app')

@section('title', "| Visualizza Account {$account->name}")

@section('content')
    <section id="accounts-create">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-sharp fa-solid fa-eye"></i>
                        Visualizza Account {{$account->name}}
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
                    {{-- account name --}}
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control input-violet shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{$account->name}}" placeholder="Nome Account" readonly>
                            <label for="name" class="text-violet">Nome Account</label>
                        </div>
                    </div>

                    {{-- client --}}
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <select class="form-select select-violet shadow-sm" id="client_id" name="client_id" aria-label="client_id" disabled>
                                <option selected>-- Seleziona un Cliente --</option>
                                @foreach ($clients as $client)
                                    <option {{$account->client_id == $client->id ? 'selected' : ''}} value="{{$client->id}}">{{$client->name}}</option>
                                @endforeach
                            </select>
                            <label for="client_id" class="text-violet">Cliente</label>
                        </div>
                    </div>

                    {{-- category --}}
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <select class="form-select select-violet shadow-sm" id="category_id" name="category_id" aria-label="category_id" disabled>
                                @foreach ($categories as $category)
                                    <option {{old('category_id') == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                            <label for="category_id" class="text-violet">Categoria</label>
                        </div>
                    </div>

                    {{-- url ip --}}
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="url" class="form-control input-violet shadow-sm @error('url') is-invalid @enderror" id="url" name="url" value="{{$account->url}}" placeholder="Nome Account" readonly>
                            <label for="url" class="text-violet">Url / Ip </label>
                        </div>
                    </div>

                    {{-- username --}}
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control input-violet shadow-sm @error('username') is-invalid @enderror" id="username" name="username" value="{{$account->username}}" placeholder="Username" readonly>
                            <label for="username" class="text-violet">Username</label>
                        </div>
                    </div>

                    {{-- description --}}
                    <div class="col-12">
                        <div class="form-floating mb-4">
                            <textarea class="form-control text-area-violet shadow-sm" placeholder="Descrizione" id="description" name="description" style="height: 100px" readonly>{{old('description')}}</textarea>
                            <label for="description" class="text-violet">Descrizione</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection