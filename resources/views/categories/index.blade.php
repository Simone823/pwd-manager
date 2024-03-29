@extends('layouts.app')

@section('title', '| Lista Categorie')

@section('content')
    <section id="categories-index">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-orange fs-4 fw-bold">
                        <i class="fa-solid fa-list"></i>
                        Lista Categorie
                    </h2>
                </div>

                {{-- actions --}}
                <div class="row mb-4">
                    <div class="col-12 d-flex flex-wrap gap-3">
                        {{-- row crea account --}}
                        @if (Auth::user()->hasPermission('categories-create'))
                            <div class="create-link">
                                <a class="btn btn-transparent fw-semibold shadow" href="{{route('categories.create')}}">
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
                                @if (Auth::user()->hasPermission('categories-delete'))
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
                                        <p onclick="deleteSelectedRecord('{{route('categories.deleteSelected')}}')" class="dropdown-item mb-0 cursor-pointer" type="button">Elimina selezionati</p>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- row table categories --}}
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-dark table-striped shadow">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">@sortablelink('category_name', 'Nome Categoria', [], ['class' => 'link-orange'])</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($categories) > 0)
                                    @foreach ($categories as $category)    
                                        <tr>
                                            <th class="d-flex gap-2">
                                                {{-- check select --}}
                                                @if (Auth::user()->hasPermission('categories-delete'))
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="category_id" name="category_id" value="{{$category->id}}" >
                                                    </div>
                                                @endif

                                                {{-- btn edit --}}
                                                @if (Auth::user()->hasPermission('categories-edit'))
                                                    <a href="{{route('categories.edit', $category->id)}}" class="btn btn-orange shadow">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                @endif

                                                {{-- btn delete --}}
                                                @if (Auth::user()->hasPermission('categories-delete'))
                                                    <div class="btn-delete">
                                                        <form action="{{route('categories.destroy', $category->id)}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-orange shadow">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </th>
                                            <th class="fw-normal">{{$category->category_name}}</th>
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
                        {!! $categories->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection