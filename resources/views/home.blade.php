@extends('layouts.app')

@section('title', '| Home')

@section('content')
<section id="home">
    <div class="container">

        {{-- row accounts --}}
        @if (Auth::user()->hasPermission('accounts-view'))    
            <div class="row gy-5">
                {{-- search --}}
                <div class="col-12">
                    <form action="{{route('home.search-accounts')}}" class="search-fields py-3 px-3 bg-dark shadow rounded" method="GET">
                        @csrf

                        {{-- inputs--}}
                        <div class="row align-items-center row-gap-3">
                            {{-- account name --}}
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control input-orange shadow-sm @error('account_name') is-invalid @enderror" id="account_name" name="account_name" value="{{old('account_name', Session::get('home-account_name-filter'))}}" placeholder="Nome Account" autofocus="false">
                                    <label for="account_name" class="text-orange">Nome Account</label>

                                    @error('account_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- client --}}
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-floating">
                                    <select class="form-select select-orange shadow-sm" id="client_id" name="client_id" aria-label="client_id">
                                      <option value="" selected>-- Seleziona un Cliente --</option>
                                        @foreach ($clients as $client)
                                            <option {{old('client_id', Session::get('home-client_id-filter')) == $client->id ? 'selected' : ''}} value="{{$client->id}}">{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="client_id" class="text-orange">Cliente</label>

                                    @error('client_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- category --}}
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-floating">
                                    <select class="form-select select-orange shadow-sm" id="category_id" name="category_id" aria-label="category_id">
                                      <option value="" selected>-- Seleziona una Categoria --</option>
                                        @foreach ($categories as $category)
                                            <option {{old('category_id', Session::get('home-category_id-filter')) == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->category_name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="category_id" class="text-orange">Categoria</label>

                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- buttons --}}
                            <div class="col-12 col-md-6 col-lg-3 d-flex flex-wrap gap-3">
                                {{-- btn submit --}}
                                <button type="submit" class="btn btn-orange fw-semibold shadow">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    Cerca
                                </button>

                                {{-- btn create account --}}
                                @if (Auth::user()->hasPermission('accounts-create'))
                                    <a href="{{route('accounts.create')}}" class="btn btn-orange fw-semibold shadow">
                                        <i class="fa-solid fa-plus"></i>
                                        Crea Account
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                {{-- sortable --}}
                <div class="col-12">
                    <ul class="list-sortable border-bottom-violet text-white d-flex flex-wrap justify-content-center justify-content-md-between gap-3 mb-0">
                        <li>@sortablelink('name', 'Nome Account', [], ['class' => 'link-orange text-decoration-none'])</li>
                        <li>@sortablelink('category.category_name', 'Categoria', [], ['class' => 'link-orange text-decoration-none'])</li>
                        <li>@sortablelink('client.name', 'Cliente', [], ['class' => 'link-orange text-decoration-none'])</li>
                        <li>@sortablelink('username', 'Username', [], ['class' => 'link-orange text-decoration-none'])</li>
                        <li>@sortablelink('url', 'URL / IP', [], ['class' => 'link-orange text-decoration-none'])</li>
                        <li>@sortablelink('created_at', 'Data Creazione', [], ['class' => 'link-orange text-decoration-none'])</li>
                    </ul>
                </div>

                {{-- accounts --}}
                @foreach ($accounts as $account)
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="card bg-dark text-white shadow h-100 d-flex">
                            {{-- card body --}}
                            <div class="card-body flex-grow-1">
                                {{-- client name --}}
                                <p class="badge-orange rounded-pill py-2 px-3 fw-bold fs-6">{{$account->client ? $account->client->name : '-'}}</p>

                                {{-- account name --}}
                                <div class="field-wrapper mb-3">
                                    <p class="field-name text-orange fw-semibold border-bottom-violet mb-1">Nome Account</p>
                                    <p>{{$account->name}}</p>
                                </div>

                                {{-- category name --}}
                                <div class="field-wrapper mb-3">
                                    <p class="field-name text-orange fw-semibold border-bottom-violet mb-1">Categoria</p>
                                    <p>{{$account->category ? $account->category->category_name : '-'}}</p>
                                </div>

                                {{-- username --}}
                                <div class="field-wrapper mb-3">
                                    <p class="field-name text-orange fw-semibold border-bottom-violet mb-1">Username</p>
                                    <p>{{$account->username}}</p>
                                </div>

                                {{-- url --}}
                                <div class="field-wrapper">
                                    <p class="field-name text-orange fw-semibold border-bottom-violet mb-1">URL / IP</p>
                                    @if(str_contains($account->url, 'http') || str_contains($account->url, 'https'))
                                        <a target="__balnk" class="link-light-gray" href="{{$account->url}}">{{$account->url}}</a>
                                        @else
                                            <p class="mb-0">{{$account->url}}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- tooltip info description --}}
                            <div class="card-info border-bottom-violet p-3">
                                @if ($account->description != null)
                                    <div class="tooltip-wrapper">
                                        <i class="fa-solid fa-message fs-5 shadow text-orange"></i>
                                        {{-- <i class="fa-sharp fa-solid fa-circle-info fs-4 shadow text-orange"></i> --}}
                                        <div class="tooltiptext-right">{{$account->description}}</div>
                                    </div>
                                @endif
                            </div>

                            {{-- card btn --}}
                            <div class="card-btn p-3">
                                <div class="row">
                                    <div class="col-12 d-flex flex-wrap justify-content-end gap-2">
                                        {{-- btn show --}}
                                        <a href="{{route('accounts.show', $account->id)}}" class="btn btn-orange shadow">
                                            <i class="fa-sharp fa-solid fa-eye"></i>
                                            <span class="tooltiptext-bottom">Visualizza</span>
                                        </a>

                                        {{-- btn view password account --}}
                                        <button onclick="apiViewPasswordAccount('{{Session::get('Api_Token')}}', {{$account->id}})" type="button" class="btn btn-orange shadow">
                                            <i class="fa-solid fa-unlock"></i>
                                            <span class="tooltiptext-bottom">Vedi Password</span>
                                        </button>

                                        {{-- btn edit --}}
                                        @if (Auth::user()->hasPermission('accounts-edit'))
                                            <a href="{{route('accounts.edit', $account->id)}}" class="btn btn-orange shadow">
                                                <i class="fa-solid fa-pen"></i>
                                                <span class="tooltiptext-bottom">Modifica</span>
                                            </a>
                                        @endif

                                        {{-- btn delete --}}
                                        @if (Auth::user()->hasPermission('accounts-delete'))
                                            <form class="m-0" action="{{route('accounts.destroy', $account->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-orange shadow">
                                                    <i class="fa-solid fa-trash"></i>
                                                    <span class="tooltiptext-bottom">Elimina</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- paginate --}}
                @if ($accounts->lastPage() > 1)    
                    <div class="col-12">
                        <div class="paginate-wrapper bg-dark px-3 bg-dark shadow rounded">
                            {{!! $accounts->appends(\Request::except('page'))->render() !!}}
                        </div>
                    </div>
                @endif
            </div>
        @endif

    </div>
</section>
@endsection