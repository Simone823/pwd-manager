@extends('layouts.app')

@section('title', '| Lista Ruoli')

@section('content')
    <section id="roles-index" class="pt-4">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-solid fa-list"></i>
                        Lista Ruoli
                    </h2>
                </div>

                {{-- row crea ruolo --}}
                <div class="row mb-4">
                    <div class="create-link">
                        <a class="btn btn-transparent fw-semibold shadow" href="{{route('roles.create')}}">
                            <i class="fa-solid fa-plus"></i>
                            Crea
                        </a>
                    </div>
                </div>

                {{-- row table roles --}}
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-dark table-striped shadow">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Nome</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)    
                                    <tr>
                                        <th>
                                            {{-- btn delete --}}
                                            @if ($role->name != 'Admin')
                                                <div class="btn-delete">
                                                    <form action="{{route('roles.destroy', $role->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-violet shadow">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </th>
                                        <th class="fw-normal">{{$role->name}}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- row link page --}}
                <div class="row">
                    <div class="links-paginate col-12 d-flex justify-content-center mt-4">
                        {!! $roles->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection