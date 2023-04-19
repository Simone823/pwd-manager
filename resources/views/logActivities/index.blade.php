@extends('layouts.app')

@section('title', '| Lista Log Attività')

@section('content')
    <section id="log-activities-index" class="pt-4">
        <div class="container">
            <div class="card bg-dark py-4 px-3 shadow">

                {{-- row title --}}
                <div class="row mb-4">
                    <h2 class="mb-0 text-violet fs-4 fw-bold">
                        <i class="fa-solid fa-list"></i>
                        Lista Log Attività
                    </h2>
                </div>

                {{-- row table log activities --}}
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-dark table-striped shadow">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">@sortablelink('action', 'Nome Azione', [], ['class' => 'link-violet'])</th>
                                    <th scope="col">@sortablelink('created_at', 'Data Azione', [], ['class' => 'link-violet'])</th>
                                    <th scope="col">@sortablelink('url', 'Url', [], ['class' => 'link-violet'])</th>
                                    <th scope="col">@sortablelink('method', 'Metodo', [], ['class' => 'link-violet'])</th>
                                    <th scope="col">@sortablelink('ip', 'Ip', [], ['class' => 'link-violet'])</th>
                                    <th scope="col">@sortablelink('agent', 'Agent', [], ['class' => 'link-violet'])</th>
                                    <th scope="col">Utente</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logActivities as $log)    
                                    <tr>
                                        <th class="d-flex gap-2">
                                            {{-- btn delete --}}
                                            <div class="btn-delete">
                                                <form action="{{route('log-activities.destroy', $log->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-violet shadow">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </th>
                                        <th class="fw-normal">{{$log->action}}</th>
                                        <th class="fw-normal">{{$log->created_at->format('d-m-Y H:i:s')}}</th>
                                        <th class="fw-normal">
                                            <a href="{{$log->url}}">{{$log->url}}</a>
                                        </th>
                                        <th class="fw-normal">{{$log->method}}</th>
                                        <th class="fw-normal">{{$log->ip}}</th>
                                        <th class="fw-normal">{{$log->agent}}</th>
                                        <th class="fw-normal">{{$log->user_id}}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- row link page --}}
                <div class="row">
                    <div class="links-paginate col-12 d-flex justify-content-center mt-4">
                        {!! $logActivities->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection