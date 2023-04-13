@extends('layouts.app')

@section('title', '| Lista Clienti')

@section('content')
    <section id="clients-index" class="pt-4">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-solid fa-list"></i>
                        Lista Clienti
                    </h2>
                </div>

                {{-- row crea categoria --}}
                @if (Auth::user()->hasPermission('clients-create'))
                    <div class="row mb-4">
                        <div class="create-link">
                            <a class="btn btn-transparent fw-semibold shadow" href="{{route('clients.create')}}">
                                <i class="fa-solid fa-plus"></i>
                                Crea
                            </a>
                        </div>
                    </div>
                @endif

                {{-- row table clients --}}
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-dark table-striped shadow">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Descrizione</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)    
                                    <tr>
                                        <th class="d-flex gap-2">
                                            {{-- btn edit --}}
                                            @if (Auth::user()->hasPermission('clients-edit'))
                                                <a href="{{route('clients.edit', $client->id)}}" class="btn btn-violet shadow">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                            @endif

                                            {{-- btn delete --}}
                                            @if (Auth::user()->hasPermission('clients-delete'))
                                                <div class="btn-delete">
                                                    <form action="{{route('clients.destroy', $client->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-violet shadow">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </th>
                                        <th class="fw-normal">{{$client->name}}</th>
                                        <th class="fw-normal">{{$client->description}}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- row link page --}}
                <div class="row">
                    <div class="links-paginate col-12 d-flex justify-content-center mt-4">
                        {!! $clients->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection