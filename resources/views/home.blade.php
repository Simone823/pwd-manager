@extends('layouts.app')

@section('title', '| Dashboard')

@section('content')
<section id="home">
    <div class="container">

        {{-- row accounts --}}
        @if (Auth::user()->hasPermission('accounts-view'))    
            <div class="row gy-4">
                {{-- search --}}
                <div class="col-12">
                    <form action="{{route('home.search-accounts')}}" class="search-fields py-3 px-3 bg-dark shadow rounded" method="GET">
                        @csrf

                        {{-- inputs--}}
                        <div class="row align-items-center row-gap-3">
                            {{-- account name --}}
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control input-violet shadow-sm @error('account_name') is-invalid @enderror" id="account_name" name="account_name" value="{{old('account_name', Session::get('home-account_name-filter'))}}" placeholder="Nome Account">
                                    <label for="account_name" class="text-violet">Nome Account</label>

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
                                    <select class="form-select select-violet shadow-sm" id="client_id" name="client_id" aria-label="client_id">
                                      <option value="" selected>-- Seleziona un Cliente --</option>
                                        @foreach ($clients as $client)
                                            <option {{old('client_id', Session::get('home-client_id-filter')) == $client->id ? 'selected' : ''}} value="{{$client->id}}">{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="client_id" class="text-violet">Cliente</label>

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
                                    <select class="form-select select-violet shadow-sm" id="category_id" name="category_id" aria-label="category_id">
                                      <option value="" selected>-- Seleziona una Categoria --</option>
                                        @foreach ($categories as $category)
                                            <option {{old('category_id', Session::get('home-category_id-filter')) == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->category_name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="category_id" class="text-violet">Categoria</label>

                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- btn submit --}}
                            <div class="col-12 col-md-6 col-lg-3">
                                <button type="submit" class="btn btn-violet">Cerca</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- sortable --}}
                <div class="col-12">
                    <ul class="list-sortable border-bottom-violet text-white d-flex flex-wrap justify-content-center justify-content-md-between gap-3 mb-0">
                        <li>@sortablelink('name', 'Nome Account', [], ['class' => 'link-violet text-decoration-none'])</li>
                        <li>@sortablelink('category.category_name', 'Categoria', [], ['class' => 'link-violet text-decoration-none'])</li>
                        <li>@sortablelink('client.name', 'Cliente', [], ['class' => 'link-violet text-decoration-none'])</li>
                        <li>@sortablelink('username', 'Username', [], ['class' => 'link-violet text-decoration-none'])</li>
                        <li>@sortablelink('url', 'URL / IP', [], ['class' => 'link-violet text-decoration-none'])</li>
                        <li>@sortablelink('created_at', 'Data Creazione', [], ['class' => 'link-violet text-decoration-none'])</li>
                    </ul>
                </div>

                {{-- accounts --}}
                @foreach ($accounts as $account)
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card bg-dark text-white shadow h-100 d-flex">
                            {{-- card body --}}
                            <div class="card-body flex-grow-1 border-bottom-violet">
                                {{-- client name --}}
                                <p class="badge-violet rounded-pill py-2 px-3 fw-bold fs-6">{{$account->client->name}}</p>

                                {{-- account name --}}
                                <div class="field-wrapper mb-3">
                                    <p class="field-name text-violet fw-semibold border-bottom-violet mb-1">Nome Account</p>
                                    <p>{{$account->name}}</p>
                                </div>

                                {{-- category name --}}
                                <div class="field-wrapper mb-3">
                                    <p class="field-name text-violet fw-semibold border-bottom-violet mb-1">Categoria</p>
                                    <p>{{$account->category->category_name}}</p>
                                </div>

                                {{-- username --}}
                                <div class="field-wrapper mb-3">
                                    <p class="field-name text-violet fw-semibold border-bottom-violet mb-1">Username</p>
                                    <p>{{$account->username}}</p>
                                </div>

                                {{-- url --}}
                                <div class="field-wrapper mb-3">
                                    <p class="field-name text-violet fw-semibold border-bottom-violet mb-1">URL / IP</p>
                                    <a target="__balnk" class="link-light-gray" href="{{$account->url}}">{{$account->url}}</a>
                                </div>
                            </div>

                            {{-- card btn --}}
                            <div class="card-btn p-3">
                                <div class="row">
                                    <div class="col-12 d-flex flex-wrap justify-content-end gap-2">
                                        {{-- btn show --}}
                                        <a href="{{route('accounts.show', $account->id)}}" class="btn btn-violet shadow">
                                            <i class="fa-sharp fa-solid fa-eye"></i>
                                            <span class="tooltiptext-bottom">Visualizza</span>
                                        </a>

                                        {{-- btn view password account --}}
                                        <button onclick="viewPasswordAccount('{{Session::get('Api_Token')}}', {{$account->id}})" type="button" class="btn btn-violet shadow">
                                            <i class="fa-solid fa-unlock"></i>
                                            <span class="tooltiptext-bottom">Vedi Password</span>
                                        </button>

                                        {{-- btn edit --}}
                                        @if (Auth::user()->hasPermission('accounts-edit'))
                                            <a href="{{route('accounts.edit', $account->id)}}" class="btn btn-violet shadow">
                                                <i class="fa-solid fa-pen"></i>
                                                <span class="tooltiptext-bottom">Modifica</span>
                                            </a>
                                        @endif

                                        {{-- btn delete --}}
                                        @if (Auth::user()->hasPermission('accounts-delete'))
                                            <form class="m-0" action="{{route('accounts.destroy', $account->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-violet shadow">
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
                        <div class="paginate-wrapper bg-dark py-3 px-3 bg-dark shadow rounded">
                            {{!! $accounts->appends(\Request::except('page'))->render() !!}}
                        </div>
                    </div>
                @endif
            </div>
        @endif

    </div>
</section>
@endsection