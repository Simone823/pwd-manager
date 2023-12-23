@extends('layouts.app')

@section('title', '| Lista Account')

@section('content')
    <section id="accounts-index">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-orange fs-4 fw-bold">
                        <i class="fa-solid fa-list"></i>
                        Lista Account
                    </h2>
                </div>

                {{-- actions --}}
                <div class="row mb-4">
                    <div class="col-12 d-flex flex-wrap gap-3">
                        {{-- row crea account --}}
                        @if (Auth::user()->hasPermission('accounts-create'))
                            <div class="create-link">
                                <a class="btn btn-transparent fw-semibold shadow" href="{{route('accounts.create')}}">
                                    <i class="fa-solid fa-plus"></i>
                                    Crea
                                </a>
                            </div>
                        @endif

                        {{-- btn other action --}}
                        <div class="dropdown">
                            <button class="btn btn-transparent dropdown-toggle shadow fw-semibold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis"></i>
                                Altro
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                @if (Auth::user()->hasPermission('accounts-delete'))
                                    <li>
                                        {{-- select all record --}}
                                        <p onclick="selectAllRecord()" id="select_all_record" class="dropdown-item mb-0 cursor-pointer">Seleziona tutto</p>
                                    </li>
                                    <li>
                                        {{-- deselect all record --}}
                                        <p onclick="deselectAllRecord()" id="deselect_all_record" class="dropdown-item mb-0 cursor-pointer d-none">Deseleziona tutto</p>
                                    </li>
                                    <li>
                                        {{-- delete selected record --}}
                                        <p onclick="deleteSelectedRecord('{{route('accounts.deleteSelected')}}')" class="dropdown-item mb-0 cursor-pointer" type="button">Elimina selezionati</p>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- row table accounts --}}
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-dark table-striped shadow">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">@sortablelink('name', 'Nome Account', [], ['class' => 'link-orange'])</th>
                                    <th scope="col">@sortablelink('client.name', 'Cliente', [], ['class' => 'link-orange'])</th>
                                    <th scope="col">@sortablelink('category.category_name', 'Categoria', [], ['class' => 'link-orange'])</th>
                                    <th scope="col">@sortablelink('descrizione', 'Descrizione', [], ['class' => 'link-orange'])</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr>
                                        <th class="d-flex align-items-center gap-2">
                                            {{-- check select --}}
                                            @if (Auth::user()->hasPermission('accounts-delete'))
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="account_id" name="account_id" value="{{$account->id}}" >
                                                </div>
                                            @endif

                                            {{-- btn show --}}
                                            <a href="{{route('accounts.show', $account->id)}}" class="btn btn-orange shadow">
                                                <i class="fa-sharp fa-solid fa-eye"></i>
                                            </a>

                                            {{-- btn edit --}}
                                            @if (Auth::user()->hasPermission('accounts-edit'))
                                                <a href="{{route('accounts.edit', $account->id)}}" class="btn btn-orange shadow">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                            @endif

                                            {{-- btn delete --}}
                                            @if (Auth::user()->hasPermission('accounts-delete'))
                                                <div class="btn-delete">
                                                    <form action="{{route('accounts.destroy', $account->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-orange shadow">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </th>
                                        <th class="fw-normal">{{$account->name}}</th>
                                        <th class="fw-normal">{{$account->client ? $account->client->name : '-'}}</th>
                                        <th class="fw-normal">{{$account->category ? $account->category->category_name : '-'}}</th>
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