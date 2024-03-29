@extends('layouts.app')

@section('title', '| Lista Utenti')

@section('content')
    <section id="users-index">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-orange fs-4 fw-bold">
                        <i class="fa-solid fa-user me-1"></i>
                        Lista Utenti
                    </h2>
                </div>

                {{-- row crea utente --}}
                <div class="row mb-4">
                    <div class="create-link">
                        <a class="btn btn-transparent fw-semibold shadow" href="{{route('admin.users.create')}}">
                            <i class="fa-solid fa-plus"></i>
                            Crea
                        </a>
                    </div>
                </div>

                {{-- row table users --}}
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-dark table-striped shadow">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">@sortablelink('name', 'Nome', [], ['class' => 'link-orange'])</th>
                                    <th scope="col">@sortablelink('surname', 'Cognome', [], ['class' => 'link-orange'])</th>
                                    <th scope="col">@sortablelink('username', 'Nome Utente', [], ['class' => 'link-orange'])</th>
                                    <th scope="col">@sortablelink('email', 'Email', [], ['class' => 'link-orange'])</th>
                                    <th scope="col">@sortablelink('role.name', 'Ruolo', [], ['class' => 'link-orange'])</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($users) > 0)
                                    @foreach ($users as $user)    
                                        <tr>
                                            <th class="d-flex gap-2">
                                                {{-- btn show --}}
                                                <a href="{{route('admin.users.show', $user->id)}}" class="btn btn-orange shadow">
                                                    <i class="fa-sharp fa-solid fa-eye"></i>
                                                </a>

                                                {{-- btn edit --}}
                                                <a href="{{route('admin.users.edit', $user->id)}}" class="btn btn-orange shadow @if($user->username == 'admin') disabled @endif">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>

                                                {{-- btn delete --}}
                                                <div class="btn-delete">
                                                    <form action="{{route('admin.users.delete', $user->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button @if($user->username == 'admin') disabled @endif type="submit" class="btn btn-orange shadow">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </th>
                                            <th class="fw-normal">{{$user->name}}</th>
                                            <th class="fw-normal">{{$user->surname}}</th>
                                            <th class="fw-normal">{{$user->username}}</th>
                                            <th class="fw-normal">{{$user->email}}</th>
                                            <th class="fw-normal">{{$user->role->name}}</th>
                                        </tr>
                                    @endforeach

                                    @else
                                        <tr>
                                            <td colspan="50">
                                                <div class="wrapper-no-records">
                                                    <strong>Info!</strong>
                                                    Nessun record in tabella
                                                </div>
                                            </td>
                                        </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- row link page --}}
                <div class="row">
                    <div class="links-paginate col-12 d-flex justify-content-center mt-4">
                        {!! $users->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection