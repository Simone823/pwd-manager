@extends('layouts.app')

@section('title', '| Lista Account')

@section('content')
    <section id="accounts-index" class="pt-4">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-solid fa-list"></i>
                        Lista Account
                    </h2>
                </div>

                {{-- row crea account --}}
                @if (Auth::user()->hasPermission('accounts-create'))
                    <div class="row mb-4">
                        <div class="create-link">
                            <a class="btn btn-transparent fw-semibold shadow" href="{{route('accounts.create')}}">
                                <i class="fa-solid fa-plus"></i>
                                Crea
                            </a>
                        </div>
                    </div>
                @endif

                {{-- row table accounts --}}
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-dark table-striped shadow">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">@sortablelink('name', 'Nome Account', [], ['class' => 'link-violet'])</th>
                                    <th scope="col">@sortablelink('client.name', 'Cliente', [], ['class' => 'link-violet'])</th>
                                    <th scope="col">@sortablelink('category.name', 'Categoria', [], ['class' => 'link-violet'])</th>
                                    <th scope="col">@sortablelink('descrizione', 'Descrizione', [], ['class' => 'link-violet'])</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr>
                                        <th class="d-flex gap-2">
                                            {{-- btn edit --}}
                                            @if (Auth::user()->hasPermission('accounts-edit'))
                                                <a href="{{route('accounts.edit', $account->id)}}" class="btn btn-violet shadow">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                            @endif

                                            {{-- btn delete --}}
                                            @if (Auth::user()->hasPermission('accounts-delete'))
                                                <div class="btn-delete">
                                                    <form action="{{route('accounts.destroy', $account->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-violet shadow">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </th>
                                        <th class="fw-normal">{{$account->name}}</th>
                                        <th class="fw-normal">{{$account->client->name}}</th>
                                        <th class="fw-normal">{{$account->category->name}}</th>
                                        <th class="fw-normal">{{$account->description}}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- row link page --}}
                <div class="row">
                    <div class="links-paginate col-12 d-flex justify-content-center mt-4">
                        {!! $accounts->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection