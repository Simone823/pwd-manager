@extends('layouts.app')

@section('title', '| Lista Permessi')

@section('content')
    <section id="permissions-index">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-orange fs-4 fw-bold">
                        <i class="fa-solid fa-briefcase me-1"></i>
                        Lista Permessi
                    </h2>
                </div>

                {{-- row table permissions --}}
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-dark table-striped shadow">
                            <thead>
                                <tr>
                                    <th scope="col">@sortablelink('name', 'Nome Permesso', [], ['class' => 'link-orange'])</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($permissions) > 0)
                                    @foreach ($permissions as $permission)    
                                        <tr>
                                            {{-- <th>
                                                btn delete
                                                <div class="btn-delete">
                                                    <form action="{{route('permissions.destroy', $permission->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <!-- Button trigger modal -->
                                                        <button type="submit" class="btn btn-orange shadow">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </th> --}}
                                            <th class="fw-normal">{{$permission->name}}</th>
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
                    {{-- Links paginate --}}
                    <div class="links-paginate col-12 d-flex justify-content-center mt-4">
                        {!! $permissions->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection