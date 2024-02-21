@extends('layouts.app')

@section('title', '| Lista Ruoli')

@section('content')
    <section id="admin-roles-index">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-orange fs-4 fw-bold">
                        <i class="fa-solid fa-medal me-1"></i>
                        Lista Ruoli
                    </h2>
                </div>

                {{-- row crea ruolo --}}
                <div class="row mb-4">
                    <div class="create-link">
                        <a class="btn btn-transparent fw-semibold shadow" href="{{route('admin.roles.create')}}">
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
                                    <th scope="col">@sortablelink('name', 'Nome Ruolo', [], ['class' => 'link-orange'])</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($roles) > 0)
                                    @foreach ($roles as $role)    
                                        <tr>
                                            <th class="d-flex gap-2">
                                                {{-- btn show --}}
                                                <a href="{{route('admin.roles.show', $role->id)}}" class="btn btn-orange shadow">
                                                    <i class="fa-sharp fa-solid fa-eye"></i>
                                                </a>

                                                {{-- btn edit --}}
                                                <a href="{{route('admin.roles.edit', $role->id)}}" class="btn btn-orange shadow @if($role->name == 'Admin') disabled @endif">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>

                                                {{-- btn delete --}}
                                                <div class="btn-delete">
                                                    <form action="{{route('admin.roles.delete', $role->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button @if($role->name == 'Admin') disabled @endif type="submit" class="btn btn-orange shadow">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </th>
                                            <th class="fw-normal">{{$role->name}}</th>
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
                        {!! $roles->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection