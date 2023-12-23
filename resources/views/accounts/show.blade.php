@extends('layouts.app')

@section('title', "| Visualizza Account {$account->name}")

@section('content')
    <section id="accounts-create">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-orange fs-4 fw-bold">
                        <i class="fa-sharp fa-solid fa-eye"></i>
                        Visualizza Account {{$account->name}}
                    </h2>
                </div>

                {{-- row buttons actions --}}
                <div class="row mb-5">
                    <div class="col-12 d-flex flex-wrap gap-3">
                        <a class="turn-back btn btn-transparent fw-semibold shadow" href="{{url()->previous()}}">
                            <i class="fa-solid fa-arrow-left"></i>
                            Torna indietro
                        </a>
    
                        {{-- btn edit --}}
                        @if (Auth::user()->hasPermission('accounts-edit'))
                            <a href="{{route('accounts.edit', $account->id)}}" class="btn btn-transparent fw-semibold shadow">
                                <i class="fa-solid fa-pen"></i>
                                Modifica
                            </a>
                        @endif
                    </div>
                </div>

                {{-- row form --}}
                <div class="row">
                    {{-- account name --}}
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control input-orange shadow-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{$account->name}}" placeholder="Nome Account" readonly>
                            <label for="name" class="text-orange">Nome Account</label>
                        </div>
                    </div>

                    {{-- client --}}
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <select class="form-select select-orange shadow-sm" id="client_id" name="client_id" aria-label="client_id" disabled>
                                @if ($account->client)    
                                    @foreach ($clients as $client)
                                        <option {{$account->client_id == $client->id ? 'selected' : ''}} value="{{$client->id}}">{{$client->name}}</option>
                                    @endforeach

                                    @else
                                        <option selected value="">--</option>
                                @endif
                            </select>
                            <label for="client_id" class="text-orange">Cliente</label>
                        </div>
                    </div>

                    {{-- category --}}
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <select class="form-select select-orange shadow-sm" id="category_id" name="category_id" aria-label="category_id" disabled>
                                @if ($account->category)
                                    @foreach ($categories as $category)
                                        <option {{$account->category->id == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                    
                                    @else
                                        <option selected value="">--</option>
                                @endif
                            </select>
                            <label for="category_id" class="text-orange">Categoria</label>
                        </div>
                    </div>

                    {{-- url ip --}}
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control input-orange shadow-sm @error('url') is-invalid @enderror" id="url" name="url" value="{{$account->url}}" placeholder="Url / Ip" readonly>
                            <label for="url" class="text-orange">Url / Ip</label>
                        </div>
                    </div>

                    {{-- username --}}
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control input-orange shadow-sm @error('username') is-invalid @enderror" id="username" name="username" value="{{$account->username}}" placeholder="Username" readonly>
                            <label for="username" class="text-orange">Username</label>
                        </div>
                    </div>

                    {{-- btn view password account --}}
                    <div class="col-12 col-md-6 mb-4">
                        <button onclick="apiViewPasswordAccount('{{Session::get('Api_Token')}}', {{$account->id}})" type="button" class="link-light-gray border-0 bg-transparent">
                            Visualizza Password
                        </button>
                    </div>

                    {{-- change password --}}
                    <div class="col-12 col-md-6 mb-4">
                        @include('accounts.modalChangePassword')
                    </div>

                    {{-- description --}}
                    <div class="col-12">
                        <div class="form-floating mb-4">
                            <textarea class="form-control text-area-orange shadow-sm" placeholder="Descrizione" id="description" name="description" style="height: 100px" readonly>{{$account->description}}</textarea>
                            <label for="description" class="text-orange">Descrizione</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection